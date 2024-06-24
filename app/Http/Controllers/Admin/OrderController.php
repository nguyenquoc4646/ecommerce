<?php

namespace App\Http\Controllers\admin;

use App\Events\UpdateStatusOrderSuccess;
use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Models\OrdersModel;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function list()
    {
        $data = OrdersModel::getRecord();


        return view('admin.order.list', [
            'data' => $data
        ]);
    }
    public function detail($id)
    {
        $data = OrdersModel::getSingle($id);
        // dd($data);
        return view('admin.order.detail', [
            'data' => $data
        ]);
    }

    public function order_status(Request $request)
    {
        $getOrder = OrdersModel::getSingle($request->id_order);
        if (!empty($getOrder) && !empty($request->status_order)) {
            $getOrder->status = $request->status_order;
            $getOrder->save();
            $json['status'] = true;
            $json['message'] = "Cập nhật thành công";
            UpdateStatusOrderSuccess::dispatch($getOrder);
            echo json_encode($json);
        }
    }
    public function exportOrderExel(Request $request) 
    {
        // dd($request->all());
    
        $fileName = 'listorder.xlsx';
        return Excel::download(new OrderExport,$fileName);
    }
}
