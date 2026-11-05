<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Helper;
use Session;
use App\Models\User;
use App\Models\Inquiry;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Models\ServiceOrder;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            if (!$this->user || Helper::hasRight('dashboard.view') !=  true) {
                Auth::logout();
                $request->session()->invalidate();
                session()->flash('error', 'You can not access! Login first.');
                return redirect()->route('admin');
            }
            return $next($request);
        });
    }

    public function index(){
        if (empty(Session::get('admin_language'))) {
            Session::put('admin_language', 'en');
        }
        $total_reseller = User::where('status', 1)->where('role', 4)->count();
        $total_distributor = User::where('status', 1)->where('role', 5)->count();
        $total_product = Product::where('status', 1)->count();
        $total_service = Service::where('status', 1)->count();
        if ($this->user->role == 2 || $this->user->role == 4 || $this->user->role == 5){
            $total_order = Order::where('user_id', $this->user->id)->where('status', '!=', 3)->count();
            $inquiry_request = Inquiry::where('user_id', $this->user->id)->where('status', '!=', 2)->count();
            $service_order = ServiceOrder::where('user_id', $this->user->id)->where('status', '!=', 2)->count();
            $total_sale = Order::where('user_id', $this->user->id)->where('status', '!=', 3)->sum('total_price');
        }else{
            $total_order = Order::where('status', '!=', 3)->count();
            $inquiry_request = Inquiry::where('status', '!=', 2)->count();
            $service_order = ServiceOrder::where('status', '!=', 2)->count();
            $total_sale = Order::where('status', '!=', 3)->sum('total_price');
        }
    
        return view('backend.pages.dashboard', compact('total_reseller', 'total_distributor', 'total_product', 'total_service', 'total_order', 'inquiry_request', 'service_order', 'total_sale'));
    }
}
