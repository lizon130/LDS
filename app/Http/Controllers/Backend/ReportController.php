<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyReport;
use Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            if (!$this->user) {
                session()->flash('error', 'You can not access! Login first.');
                return redirect()->route('admin');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $date  = $request->query('date', now()->format('Y-m-d'));
        $month = $request->query('month', substr($date, 0, 7));

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $date = now()->format('Y-m-d');
        }
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = substr($date, 0, 7);
        }

        // Selected day entries (Excel sheet)
        $entries = DailyReport::whereDate('report_date', $date)
            ->orderBy('category')
            ->orderBy('id')
            ->get();

        // Distinct categories for datalist suggestions
        $categories = DailyReport::select('category')->distinct()->orderBy('category')->pluck('category');

        // Month report
        $monthStart = Carbon::parse($month . '-01')->startOfMonth();
        $monthEnd   = Carbon::parse($month . '-01')->endOfMonth();

        $monthEntries = DailyReport::whereBetween('report_date', [$monthStart, $monthEnd])->get();

        $perDay = $monthEntries->groupBy(function ($item) {
            return $item->report_date->format('Y-m-d');
        })->map(function ($rows) {
            return [
                'count'  => $rows->count(),
                'income' => $rows->sum('income'),
                'profit' => $rows->sum('profit'),
            ];
        })->sortKeysDesc();

        $perCategory = $monthEntries->groupBy('category')->map(function ($rows) {
            return [
                'count'  => $rows->count(),
                'income' => $rows->sum('income'),
                'profit' => $rows->sum('profit'),
            ];
        })->sortByDesc('income');

        return view('backend.pages.report.index', [
            'date'         => $date,
            'month'        => $month,
            'entries'      => $entries,
            'categories'   => $categories,
            'perDay'       => $perDay,
            'perCategory'  => $perCategory,
            'dayIncome'    => $entries->sum('income'),
            'dayProfit'    => $entries->sum('profit'),
            'monthIncome'  => $monthEntries->sum('income'),
            'monthProfit'  => $monthEntries->sum('profit'),
            'monthCount'   => $monthEntries->count(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_date'   => 'required|date',
            'category'      => 'required|string|max:100',
            'income'        => 'required|numeric|min:0',
            'profit_percent' => 'nullable|numeric|min:0|max:100',
            'note'          => 'nullable|string|max:255',
        ]);

        $report = new DailyReport();
        $report->report_date    = $validated['report_date'];
        $report->category       = trim($validated['category']);
        $report->income         = $validated['income'];
        $report->profit_percent = $validated['profit_percent'] ?? 0;
        $report->profit         = round($report->income * $report->profit_percent / 100, 2);
        $report->note           = $validated['note'] ?? null;
        $report->created_by     = Auth::id();
        $report->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Entry added successfully.',
            'entry' => [
                'id'            => $report->id,
                'report_date'   => $report->report_date->format('Y-m-d'),
                'category'      => $report->category,
                'income'        => (float) $report->income,
                'profit_percent' => (float) $report->profit_percent,
                'profit'        => (float) $report->profit,
                'note'          => $report->note,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $report = DailyReport::find($id);
        if (!$report) {
            return response()->json([
                'type' => 'error',
                'message' => 'Entry not found.',
            ]);
        }

        $validated = $request->validate([
            'category'      => 'required|string|max:100',
            'income'        => 'required|numeric|min:0',
            'profit_percent' => 'nullable|numeric|min:0|max:100',
            'note'          => 'nullable|string|max:255',
        ]);

        $report->category       = trim($validated['category']);
        $report->income         = $validated['income'];
        $report->profit_percent = $validated['profit_percent'] ?? 0;
        $report->profit         = round($report->income * $report->profit_percent / 100, 2);
        $report->note           = $validated['note'] ?? null;
        $report->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Entry updated successfully.',
        ]);
    }

    public function delete($id)
    {
        $report = DailyReport::find($id);
        if ($report) {
            $date = $report->report_date->format('Y-m-d');
            $report->delete();
            return response()->json(['success' => 'Entry deleted successfully.', 'date' => $date]);
        }
        return response()->json(['error' => 'Entry not found.']);
    }
}
