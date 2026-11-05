@extends('backend.layout.app')
@section('title', 'Report Management | ' . (Helper::getSettings('application_name') ?? 'LDS'))
@section('content')
<style>
    .sheet-wrap {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border: 1px solid #c9cdd4;
        border-radius: 4px;
        background: #fff;
    }
    .report-sheet {
        border-collapse: collapse;
        width: 100%;
        min-width: 860px;
        font-size: 14px;
        font-family: "Segoe UI", Calibri, sans-serif;
    }
    .report-sheet th, .report-sheet td {
        border: 1px solid #d4d7dc;
        padding: 0;
        vertical-align: middle;
    }
    .report-sheet thead th {
        background: #217346;
        color: #fff;
        font-weight: 600;
        padding: 9px 10px;
        text-align: center;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 2;
    }
    .report-sheet .row-num {
        background: #f1f3f5;
        color: #6c757d;
        text-align: center;
        width: 42px;
        font-size: 12px;
    }
    .sheet-input {
        border: none;
        width: 100%;
        height: 100%;
        min-height: 40px;
        padding: 6px 10px;
        background: transparent;
        outline: none;
        border-radius: 0;
    }
    .sheet-input:focus {
        background: #fff8e1;
        box-shadow: inset 0 0 0 2px #f0a800;
    }
    .sheet-input::placeholder { color: #adb5bd; font-size: 13px; }
    .num-cell { text-align: right; font-variant-numeric: tabular-nums; }
    input.sheet-input.num-cell { text-align: right; }
    .profit-cell {
        text-align: right;
        font-weight: 600;
        color: #217346;
        font-variant-numeric: tabular-nums;
        padding: 6px 10px;
        background: #f4faf6;
        min-width: 110px;
        white-space: nowrap;
    }
    .report-sheet tbody tr:hover td { background: #f8f9fa; }
    .report-sheet tbody tr:hover .profit-cell { background: #eaf6ef; }
    .report-sheet tbody tr:hover .row-num { background: #e9ecef; }
    .totals-row td {
        background: #eef1f4 !important;
        font-weight: 700;
        border-top: 2px solid #217346 !important;
        padding: 9px 10px;
        white-space: nowrap;
    }
    .del-btn {
        border: none;
        background: transparent;
        color: #dc3545;
        width: 100%;
        min-height: 40px;
        cursor: pointer;
    }
    .del-btn:hover { background: #fde8e8; }
    .save-row-btn { border-radius: 0; min-height: 40px; }
    .nr-save { flex: 1; }
    .nr-remove { width: 44px; min-width: 44px; }
    .nr-remove:hover { background: #fde8e8; }
    .add-row-btn {
        border: none;
        background: transparent;
        width: 100%;
        min-height: 40px;
        cursor: pointer;
        color: #198754;
    }
    .add-row-btn:hover { background: #e6f4ec; border-radius: 2px; }
    .stat-card { border-radius: 10px; color: #fff; padding: 14px 18px; }
    .stat-card .label { font-size: 12px; opacity: .85; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .stat-card .value { font-size: 22px; font-weight: 700; }
    .mini-bar { height: 6px; border-radius: 4px; background: #e9ecef; overflow: hidden; min-width: 70px; }
    .mini-bar > div { height: 100%; background: #217346; }
    @keyframes rowFlash {
        0% { background-color: #d1f4e0; }
        100% { background-color: transparent; }
    }
    .flash-row td { animation: rowFlash 1.2s ease-out; }
    .tr-removing { opacity: 0; transform: translateX(30px); transition: all .3s ease; }
    @media (max-width: 767.98px) {
        .report-sheet { font-size: 13px; min-width: 720px; }
        .sheet-input { min-height: 44px; padding: 6px 8px; }
        .stat-card .value { font-size: 19px; }
        .stat-card { padding: 12px 14px; }
        h4.m-0 { font-size: 18px; }
    }
</style>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-2 mb-3 flex-wrap gap-2">
        <h4 class="m-0"><i class="fa-solid fa-file-invoice-dollar text-success"></i> Report Management</h4>
        <div class="d-flex gap-2 flex-wrap">
            <input type="date" id="sheetDate" class="form-control" value="{{ $date }}">
            <input type="month" id="reportMonth" class="form-control" value="{{ $month }}">
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-lg-3">
            <div class="stat-card bg-primary shadow-sm">
                <div class="label">Day Income</div>
                <div class="value" id="cardDayIncome" data-val="{{ $dayIncome }}">৳ {{ number_format($dayIncome, 2) }}</div>
                <div class="label mt-1" id="cardDayLabel">{{ Carbon\Carbon::parse($date)->format('d M Y') }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card bg-success shadow-sm">
                <div class="label">Day Profit</div>
                <div class="value" id="cardDayProfit" data-val="{{ $dayProfit }}">৳ {{ number_format($dayProfit, 2) }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card bg-dark shadow-sm">
                <div class="label">Month Income</div>
                <div class="value" id="cardMonthIncome" data-val="{{ $monthIncome }}">৳ {{ number_format($monthIncome, 2) }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card bg-warning shadow-sm">
                <div class="label">Month Profit (<span id="cardMonthCount">{{ $monthCount }}</span> entries)</div>
                <div class="value" id="cardMonthProfit" data-val="{{ $monthProfit }}">৳ {{ number_format($monthProfit, 2) }}</div>
            </div>
        </div>
    </div>

    {{-- Daily Sheet (Excel style) --}}
    <div class="card my-2">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-1">
            <h5 class="m-0">Daily Sheet — <span id="sheetDateLabel">{{ Carbon\Carbon::parse($date)->format('d M, Y (l)') }}</span></h5>
            <span class="text-muted small d-none d-md-inline"><i class="fa-solid fa-plus text-success"></i> chaple notun row • Enter = save • Cell e click kore edit • ↑↓ navigate</span>
        </div>
        <div class="card-body">
            <div class="sheet-wrap">
                <table class="report-sheet" id="sheetTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Section</th>
                            <th style="width:150px">Income (৳)</th>
                            <th style="width:110px">Profit %</th>
                            <th>Profit (৳) <small class="fw-normal opacity-75">(auto)</small></th>
                            <th>Note</th>
                            <th style="width:64px"></th>
                        </tr>
                    </thead>
                    <tbody id="sheetBody">
                        @forelse ($entries as $entry)
                            <tr data-id="{{ $entry->id }}">
                                <td class="row-num">{{ $loop->iteration }}</td>
                                <td>
                                    <input type="text" class="sheet-input cell-edit" data-field="category" list="categoryList" value="{{ $entry->category }}">
                                </td>
                                <td class="num-cell">
                                    <input type="number" step="0.01" min="0" class="sheet-input num-cell cell-edit" data-field="income" value="{{ $entry->income }}">
                                </td>
                                <td class="num-cell">
                                    <input type="number" step="0.01" min="0" max="100" class="sheet-input num-cell cell-edit" data-field="profit_percent" value="{{ $entry->profit_percent }}">
                                </td>
                                <td class="profit-cell" data-profit>৳ {{ number_format($entry->profit, 2) }}</td>
                                <td>
                                    <input type="text" class="sheet-input cell-edit" data-field="note" value="{{ $entry->note }}">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="del-btn del-entry" data-id="{{ $entry->id }}" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row"><td colspan="7" class="text-center text-muted" style="padding:14px">Ei din er kono entry nei — nicher row theke add korun</td></tr>
                        @endforelse

                        {{-- New entry blank rows (+ dile aro ashbe) --}}
                        <tr class="entry-new-row">
                            <td class="row-num">
                                <button type="button" class="add-row-btn" title="Notun row add korun"><i class="fa-solid fa-plus text-success"></i></button>
                            </td>
                            <td><input type="text" class="sheet-input nr-category" list="categoryList" placeholder="Section (e.g. Photocopy)" autocomplete="off"></td>
                            <td class="num-cell"><input type="number" class="sheet-input num-cell nr-income" step="0.01" min="0" placeholder="0.00" inputmode="decimal"></td>
                            <td class="num-cell"><input type="number" class="sheet-input num-cell nr-percent" step="0.01" min="0" max="100" placeholder="0" inputmode="decimal"></td>
                            <td class="profit-cell nr-profit">৳ 0.00</td>
                            <td><input type="text" class="sheet-input nr-note" placeholder="Note (optional)"></td>
                            <td class="text-center d-flex">
                                <button type="button" class="nr-save btn btn-success save-row-btn px-2" title="Save (Enter)"><i class="fa-solid fa-check"></i></button>
                                <button type="button" class="nr-remove del-btn" title="Row bad din"><i class="fa-solid fa-xmark text-secondary"></i></button>
                            </td>
                        </tr>

                        {{-- Totals row --}}
                        <tr class="totals-row">
                            <td class="row-num" style="background:#e2e6ea"><i class="fa-solid fa-sigma"></i></td>
                            <td>Total</td>
                            <td class="num-cell" id="totalIncome">৳ {{ number_format($dayIncome, 2) }}</td>
                            <td></td>
                            <td class="num-cell text-success" id="totalProfit">৳ {{ number_format($dayProfit, 2) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <datalist id="categoryList">
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}"></option>
                @endforeach
                <option value="Photocopy"></option>
                <option value="Stationary"></option>
                <option value="Printing"></option>
                <option value="Lamination"></option>
                <option value="Binding"></option>
                <option value="Scan"></option>
            </datalist>
        </div>
    </div>

    {{-- Monthly Report --}}
    <div class="row g-3 my-2">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header"><h5 class="m-0">Monthly Report — {{ Carbon\Carbon::parse($month . '-01')->format('F Y') }}</h5></div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Date</th>
                                <th class="text-center">Entries</th>
                                <th class="text-end">Income (৳)</th>
                                <th class="text-end">Profit (৳)</th>
                            </tr>
                        </thead>
                        <tbody id="monthDayBody">
                            @forelse ($perDay as $day => $row)
                                <tr style="cursor:pointer" class="load-day" data-date="{{ $day }}">
                                    <td>{{ Carbon\Carbon::parse($day)->format('d M, Y (l)') }}</td>
                                    <td class="text-center"><span class="badge bg-secondary">{{ $row['count'] }}</span></td>
                                    <td class="text-end day-income">{{ number_format($row['income'], 2) }}</td>
                                    <td class="text-end text-success fw-semibold day-profit">{{ number_format($row['profit'], 2) }}</td>
                                </tr>
                            @empty
                                <tr class="month-empty"><td colspan="4" class="text-center text-muted py-4">Ei mash e kono entry nei</td></tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-success fw-bold">
                            <tr>
                                <td>Total</td>
                                <td class="text-center" id="monthTotalCount">{{ $monthCount }}</td>
                                <td class="text-end" id="monthTotalIncome">{{ number_format($monthIncome, 2) }}</td>
                                <td class="text-end" id="monthTotalProfit">{{ number_format($monthProfit, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header"><h5 class="m-0">Section-wise (Month)</h5></div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Section</th>
                                <th class="text-center">Entries</th>
                                <th class="text-end">Income (৳)</th>
                                <th class="text-end">Profit (৳)</th>
                                <th style="width:80px">Share</th>
                            </tr>
                        </thead>
                        <tbody id="monthCatBody">
                            @forelse ($perCategory as $cat => $row)
                                <tr>
                                    <td class="fw-semibold">{{ $cat }}</td>
                                    <td class="text-center"><span class="badge bg-secondary">{{ $row['count'] }}</span></td>
                                    <td class="text-end">{{ number_format($row['income'], 2) }}</td>
                                    <td class="text-end text-success fw-semibold">{{ number_format($row['profit'], 2) }}</td>
                                    <td>
                                        <div class="mini-bar" title="{{ $monthIncome > 0 ? round($row['income'] / $monthIncome * 100, 1) : 0 }}%">
                                            <div style="width: {{ $monthIncome > 0 ? min(100, round($row['income'] / $monthIncome * 100)) : 0 }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">Kono data nei</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('footer')
<script type="text/javascript">
    var REPORT_URLS = {
        store: "{{ route('admin.report.store') }}",
        delete: "{{ url('admin/report/delete') }}",
        page: "{{ route('admin.report') }}",
    };
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var CURRENT_DATE = '{{ $date }}';

    // Server-rendered baseline for month totals
    var BASE_DAY = { income: {{ $dayIncome }}, profit: {{ $dayProfit }} };
    var BASE_MONTH = { income: {{ $monthIncome }}, profit: {{ $monthProfit }}, count: {{ $monthCount }} };

    // ---------- Navigation ----------
    $('#sheetDate').on('change', function () {
        window.location = REPORT_URLS.page + '?date=' + this.value + '&month=' + $('#reportMonth').val();
    });
    $('#reportMonth').on('change', function () {
        window.location = REPORT_URLS.page + '?date=' + $('#sheetDate').val() + '&month=' + this.value;
    });
    $(document).on('click', '.load-day', function () {
        window.location = REPORT_URLS.page + '?date=' + $(this).data('date') + '&month=' + $('#reportMonth').val();
    });

    // ---------- Helpers ----------
    function fmt(n) {
        return '৳ ' + (parseFloat(n) || 0).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
    function showToast(type, msg) {
        toastr.options = { positionClass: 'toast-bottom-right', timeOut: 2000 };
        toastr[type](msg);
    }

    // ---------- Live totals + cards + monthly table ----------
    function recalcAll() {
        var dayIncome = 0, dayProfit = 0, count = 0;

        $('#sheetBody tr[data-id]').each(function () {
            var income = parseFloat($(this).find('[data-field="income"]').val()) || 0;
            var percent = parseFloat($(this).find('[data-field="profit_percent"]').val()) || 0;
            dayIncome += income;
            dayProfit += income * percent / 100;
            count++;
        });

        $('#totalIncome').text(fmt(dayIncome));
        $('#totalProfit').text(fmt(dayProfit));
        $('#cardDayIncome').attr('data-val', dayIncome).text(fmt(dayIncome));
        $('#cardDayProfit').attr('data-val', dayProfit).text(fmt(dayProfit));

        // Month = baseline month + (current day change from baseline day)
        var dIncome = dayIncome - BASE_DAY.income;
        var dProfit = dayProfit - BASE_DAY.profit;
        var mIncome = BASE_MONTH.income + dIncome;
        var mProfit = BASE_MONTH.profit + dProfit;

        $('#cardMonthIncome').attr('data-val', mIncome).text(fmt(mIncome));
        $('#cardMonthProfit').attr('data-val', mProfit).text(fmt(mProfit));
        $('#monthTotalIncome').text(mIncome.toLocaleString('en-US', { minimumFractionDigits: 2 }));
        $('#monthTotalProfit').text(mProfit.toLocaleString('en-US', { minimumFractionDigits: 2 }));

        updateMonthDayRow(dayIncome, dayProfit, count);
    }

    function updateMonthDayRow(dayIncome, dayProfit, count) {
        var $row = $('#monthDayBody tr.load-day[data-date="' + CURRENT_DATE + '"]');
        if ($row.length) {
            $row.find('.badge').text(count);
            $row.find('.day-income').text(dayIncome.toLocaleString('en-US', { minimumFractionDigits: 2 }));
            $row.find('.day-profit').text(dayProfit.toLocaleString('en-US', { minimumFractionDigits: 2 }));
        } else if (count > 0) {
            $('.month-empty').remove();
            var d = new Date(CURRENT_DATE + 'T00:00:00');
            var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
            var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            var label = ('0' + d.getDate()).slice(-2) + ' ' + months[d.getMonth()] + ', ' + d.getFullYear() + ' (' + days[d.getDay()] + ')';
            $('#monthDayBody').prepend(
                '<tr style="cursor:pointer" class="load-day flash-row" data-date="' + CURRENT_DATE + '">' +
                '<td>' + label + '</td>' +
                '<td class="text-center"><span class="badge bg-secondary">' + count + '</span></td>' +
                '<td class="text-end day-income">' + dayIncome.toLocaleString('en-US', { minimumFractionDigits: 2 }) + '</td>' +
                '<td class="text-end text-success fw-semibold day-profit">' + dayProfit.toLocaleString('en-US', { minimumFractionDigits: 2 }) + '</td>' +
                '</tr>'
            );
        }
        // month entry count badge + total
        $('#cardMonthCount').text(recalcMonthCount());
        $('#monthTotalCount').text(recalcMonthCount());
    }

    function recalcMonthCount() {
        var total = 0;
        $('#monthDayBody .badge').each(function () { total += parseInt($(this).text()) || 0; });
        return total;
    }

    function renumberRows() {
        var i = 0;
        $('#sheetBody tr[data-id] .row-num').each(function () {
            $(this).text(++i);
        });
    }

    // ---------- New entry rows (multiple, + diye aro add hoy) ----------
    function createNewRow() {
        return $(
            '<tr class="entry-new-row">' +
            '<td class="row-num"><button type="button" class="add-row-btn" title="Notun row add korun"><i class="fa-solid fa-plus text-success"></i></button></td>' +
            '<td><input type="text" class="sheet-input nr-category" list="categoryList" placeholder="Section (e.g. Photocopy)" autocomplete="off"></td>' +
            '<td class="num-cell"><input type="number" class="sheet-input num-cell nr-income" step="0.01" min="0" placeholder="0.00" inputmode="decimal"></td>' +
            '<td class="num-cell"><input type="number" class="sheet-input num-cell nr-percent" step="0.01" min="0" max="100" placeholder="0" inputmode="decimal"></td>' +
            '<td class="profit-cell nr-profit">৳ 0.00</td>' +
            '<td><input type="text" class="sheet-input nr-note" placeholder="Note (optional)"></td>' +
            '<td class="text-center d-flex">' +
            '<button type="button" class="nr-save btn btn-success save-row-btn px-2" title="Save (Enter)"><i class="fa-solid fa-check"></i></button>' +
            '<button type="button" class="nr-remove del-btn" title="Row bad din"><i class="fa-solid fa-xmark text-secondary"></i></button>' +
            '</td></tr>'
        );
    }

    function ensureBlankRow() {
        if ($('.entry-new-row').length === 0) {
            $('#sheetBody .totals-row').before(createNewRow());
        }
    }

    // + button: arekta blank row add korun
    $(document).on('click', '.add-row-btn', function () {
        var $newRow = createNewRow();
        $('.entry-new-row').last().after($newRow);
        $newRow.find('.nr-category').focus();
    });

    // blank row er ✗ button: row bad din (shesh blank row o jete parbe, + abar ante parben)
    $(document).on('click', '.nr-remove', function () {
        $(this).closest('tr').remove();
    });

    // blank row e live profit preview
    $(document).on('input', '.nr-income, .nr-percent', function () {
        var $tr = $(this).closest('tr');
        var income = parseFloat($tr.find('.nr-income').val()) || 0;
        var percent = parseFloat($tr.find('.nr-percent').val()) || 0;
        $tr.find('.nr-profit').text(fmt(income * percent / 100));
    });

    // ---------- Save new entry (instant, no reload) ----------
    function saveNewEntry($tr) {
        var category = $tr.find('.nr-category').val().trim();
        var income = $tr.find('.nr-income').val();

        if (!category) { showToast('warning', 'Section name din'); $tr.find('.nr-category').focus(); return; }
        if (income === '' || isNaN(income)) { showToast('warning', 'Income amount din'); $tr.find('.nr-income').focus(); return; }

        var $btn = $tr.find('.nr-save');
        $btn.prop('disabled', true);
        $.ajax({
            url: REPORT_URLS.store,
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                report_date: CURRENT_DATE,
                category: category,
                income: income,
                profit_percent: $tr.find('.nr-percent').val() || 0,
                note: $tr.find('.nr-note').val(),
            },
            success: function (res) {
                $btn.prop('disabled', false);
                if (res.type === 'success' && res.entry) {
                    $tr.remove();
                    addRowToSheet(res.entry);
                    ensureBlankRow();
                    recalcAll();
                    showToast('success', 'Added: ' + res.entry.category + ' — ' + fmt(res.entry.profit) + ' profit');
                    var $lastBlank = $('.entry-new-row').last();
                    if ($lastBlank.length) { $lastBlank.find('.nr-category').val(''); }
                    $('.entry-new-row').last().find('.nr-category').focus();
                } else {
                    showToast('error', res.message || 'Error');
                }
            },
            error: function (xhr) {
                $btn.prop('disabled', false);
                var msg = 'Error saving entry';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                showToast('error', msg);
            }
        });
    }

    function addRowToSheet(e) {
        $('.empty-row').remove();
        var $tr = $('<tr data-id="' + e.id + '">');
        $tr.append($('<td class="row-num">').text(''));
        $tr.append(
            $('<td>').append(
                $('<input>', { type: 'text', class: 'sheet-input cell-edit', 'data-field': 'category', list: 'categoryList', value: e.category })
            )
        );
        $tr.append(
            $('<td class="num-cell">').append(
                $('<input>', { type: 'number', class: 'sheet-input num-cell cell-edit', 'data-field': 'income', step: '0.01', min: '0', value: e.income })
            )
        );
        $tr.append(
            $('<td class="num-cell">').append(
                $('<input>', { type: 'number', class: 'sheet-input num-cell cell-edit', 'data-field': 'profit_percent', step: '0.01', min: '0', max: '100', value: e.profit_percent })
            )
        );
        $tr.append($('<td class="profit-cell" data-profit>').text(fmt(e.profit)));
        $tr.append(
            $('<td>').append(
                $('<input>', { type: 'text', class: 'sheet-input cell-edit', 'data-field': 'note', value: e.note || '' })
            )
        );
        $tr.append(
            $('<td class="text-center">').append(
                $('<button>', { type: 'button', class: 'del-btn del-entry', 'data-id': e.id, title: 'Delete' }).html('<i class="fa-solid fa-trash"></i>')
            )
        );
        $tr.addClass('flash-row');
        // saved rows stack above the blank rows
        var $firstBlank = $('.entry-new-row').first();
        if ($firstBlank.length) {
            $firstBlank.before($tr);
        } else {
            $('#sheetBody .totals-row').before($tr);
        }
        renumberRows();
    }

    $(document).on('click', '.nr-save', function () {
        saveNewEntry($(this).closest('tr'));
    });
    $(document).on('keydown', '.entry-new-row input', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); saveNewEntry($(this).closest('tr')); }
    });

    // ---------- Inline edit: live profit + auto save on blur/Enter ----------
    function recalcRowProfit($tr) {
        var income = parseFloat($tr.find('[data-field="income"]').val()) || 0;
        var percent = parseFloat($tr.find('[data-field="profit_percent"]').val()) || 0;
        $tr.find('[data-profit]').text(fmt(income * percent / 100));
        recalcAll();
    }

    $(document).on('input', '.report-sheet [data-field="income"], .report-sheet [data-field="profit_percent"]', function () {
        recalcRowProfit($(this).closest('tr'));
    });

    function saveRow($tr) {
        var id = $tr.data('id');
        var data = { _token: CSRF_TOKEN };
        $tr.find('.cell-edit').each(function () {
            data[$(this).data('field')] = $(this).val();
        });
        $.ajax({
            url: REPORT_URLS.page + '/update/' + id,
            type: 'POST',
            data: data,
            success: function (res) {
                if (res.type === 'success') {
                    recalcRowProfit($tr);
                    showToast('success', 'Saved');
                } else {
                    showToast('error', res.message || 'Error');
                }
            },
            error: function (xhr) {
                var msg = 'Error updating';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                showToast('error', msg);
            }
        });
    }

    // Save on Enter or when clicking outside the input (Excel behaviour)
    $(document).on('keydown', '.cell-edit', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $(this).trigger('change');
            $(this).blur();
        }
    });
    $(document).on('change', '.cell-edit', function () {
        saveRow($(this).closest('tr'));
    });

    // Excel-style arrow key navigation (up/down same column)
    $(document).on('keydown', '.sheet-input', function (e) {
        if (e.key !== 'ArrowDown' && e.key !== 'ArrowUp') return;
        var field = $(this).data('field');
        if (!field) return;
        e.preventDefault();
        var $tr = $(this).closest('tr');
        var $target = (e.key === 'ArrowDown') ? $tr.nextAll('tr[data-id]').first() : $tr.prevAll('tr[data-id]').first();
        if ($target.length) {
            $target.find('[data-field="' + field + '"]').focus();
        }
    });

    // ---------- Delete (instant, no reload) ----------
    $(document).on('click', '.del-entry', function () {
        var id = $(this).data('id');
        var $tr = $(this).closest('tr');
        Swal.fire({
            title: 'Delete entry?',
            text: $tr.find('[data-field="category"]').val() + ' — ei entry ta muchhe jabe!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: REPORT_URLS.delete + '/' + id,
                    type: 'GET',
                    success: function (res) {
                        if (res.success) {
                            // remove row with animation
                            $tr.addClass('tr-removing');
                            setTimeout(function () {
                                $tr.remove();
                                if ($('#sheetBody tr[data-id]').length === 0) {
                                    $('.entry-new-row').first().before('<tr class="empty-row"><td colspan="7" class="text-center text-muted" style="padding:14px">Ei din er kono entry nei — nicher row theke add korun</td></tr>');
                                }
                                renumberRows();
                                // if day now empty in monthly table, remove that day row
                                if (res.date && $('#sheetBody tr[data-id]').length === 0) {
                                    $('#monthDayBody tr.load-day[data-date="' + res.date + '"]').remove();
                                }
                                recalcAll();
                            }, 280);
                            showToast('success', res.success);
                        } else {
                            showToast('error', res.error || 'Error');
                        }
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection
