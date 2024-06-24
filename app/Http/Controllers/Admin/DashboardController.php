<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\EvaluateModel;
use App\Models\OrderItemModel;
use App\Models\OrdersModel;
use App\Models\ProductModel;
use App\Models\Statistical;
use App\Models\SubCategoryModel;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['latestOrders'] = OrdersModel::latestOrders();
        $data['totalOrder'] = OrdersModel::totalOrder();
        $data['totalTodayOrder'] = OrdersModel::totalTodayOrder();
        $data['totalAmount'] = OrdersModel::totalAmount();
        $data['totalTodayAmount'] = OrdersModel::totalTodayAmount();
        $data['totalUser'] = User::totalUser();
        $data['totalTodayUser'] = User::totalTodayUser();
        $data['totalEvaluate'] = EvaluateModel::totalEvaluate();
        $data['totalTodayEvaluate'] = EvaluateModel::totalTodayEvaluate();
        $data['top10MostViewed'] = ProductModel::orderBy('view', 'desc')->limit(10)->get();
        $data['productAll'] = ProductModel::all()->count();
        $data['categoryAll'] = SubCategoryModel::all()->count();
        return view('admin.dashboard', $data);
    }

    public function filterRevenueDashboard(Request $request)
    {
        $dataFilter = Statistical::whereBetween('order_date', [$request->startDate, $request->endDate])->orderBy('order_date', 'asc')->get();
        foreach ($dataFilter as $key => $value) {
            $chart_data[] = array(
                'period' => $value->order_date,
                'order' => $value->total_order,
                'sales' => $value->sales,
                'profit' => $value->profit,
                'quantity' => $value->quantity
            );
        }

        echo  json_encode($chart_data);
    }

    public function filterRevenueDashboardDefault(Request $request)
    {
        $endDate = Carbon::now();

        // Get the date 30 days ago
        $startDate = $endDate->subDays(30);

        // Query the data
        $dataFilter = Statistical::whereDate('order_date', '>=', $startDate)
            ->orderBy('order_date', 'asc')
            ->get();
        foreach ($dataFilter as $key => $value) {
            $chart_data[] = array(
                'period' => $value->order_date,
                'order' => $value->total_order,
                'sales' => $value->sales,
                'profit' => $value->profit,
                'quantity' => $value->quantity
            );
        }
        return response()->json($chart_data);
    }

    public function filterOptionDate(Request $request)
    {
        // dd($request->all());
        // $endDate = Carbon::now();
        // $startDate = $endDate->subDays(30);

        // Query the data
        $startMonthCurrent = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $startMonthBefore = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $endMonthBefore = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $chart_data = [];
        $now  = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $sevenDays = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        $twoWeeks = Carbon::now('Asia/Ho_Chi_Minh')->subDays(14)->toDateString();
        $oneYear = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        if ($request->optionValue == 'sevenDays') {
            $dataFilter = Statistical::whereBetween('order_date', [$sevenDays, $now])->orderBy('order_date', 'asc')->get();
        }
        if ($request->optionValue == 'twoWeeks') {
            $dataFilter = Statistical::whereBetween('order_date', [$twoWeeks, $now])->orderBy('order_date', 'asc')->get();
        }
        if ($request->optionValue == 'oneYear') {
            $dataFilter = Statistical::whereBetween('order_date', [$oneYear, $now])->orderBy('order_date', 'asc')->get();
        }
        if ($request->optionValue == 'oneMonth') {
            $dataFilter = Statistical::whereBetween('order_date', [$startMonthBefore, $endMonthBefore])->orderBy('order_date', 'asc')->get();
        }

        if ($request->optionValue == 'currentMonth') {
            $dataFilter = Statistical::whereBetween('order_date', [$startMonthCurrent, $now])->orderBy('order_date', 'asc')->get();
        }


        foreach ($dataFilter as $key => $value) {
            $chart_data[] = array(
                'period' => $value->order_date,
                'order' => $value->total_order,
                'sales' => $value->sales,
                'profit' => $value->profit,
                'quantity' => $value->quantity
            );
        }
        return response()->json($chart_data);
    }

    public function orderDetailPdf($order_id)
    {
        $order = OrdersModel::getSingle($order_id);

        $pdf = Pdf::loadView('Pdf.order-detail', ['order' => $order]);
        // dd($pdf);
        return $pdf->download('hoadon.pdf');
    }
}
