<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShippingController extends Controller
{
    public function list()
    {
        $data = ShippingModel::getRecord();

        return view('admin.shipping.list', [
            'data' => $data
        ]);
    }

    public function add()
    {
        return view('admin.shipping.add');
    }
    public function insert(Request $request)
    {


        $request->validate(
            [
                'shippingName' => 'required|unique:shipping,name',
            ],
            [
                'shippingName.required' => 'Tên phí vận chuyển là bắt buộc.',
                'shippingName.unique' => 'Phí vận chuyển đã tồn tại.',

            ]
        );

        $shipping = new ShippingModel;
        $shipping->name = trim($request->shippingName);
        $shipping->price = trim($request->price);
        $shipping->status = trim($request->status);
        $shipping->created_by = Auth::user()->id;
        $shipping->save();
        return redirect('admin/shipping/list')->with('success', 'Thêm phí vận chuyển thành công');
    }
    public function edit($id)
    {
        $data = ShippingModel::find($id);
        return view('admin.shipping.edit', [
            'data' => $data
        ]);
    }
    public function update($id, Request $request)
    {

        $request->validate(
            [
                'shippingName' => 'required|unique:shipping,name,' . $id,
            ],
            [
                'shippingName.required' => 'phí vận chuyển là bắt buộc.',
                'shippingName.unique' => 'phí vận chuyển đã tồn tại.',
            ]
        );
        $shipping = ShippingModel::find($id);
        $shipping->name = trim($request->shippingName);
        $shipping->price = trim($request->price);
        $shipping->status = trim($request->status);
        $shipping->created_by = Auth::user()->id;
        $shipping->save();
        return redirect('admin/shipping/list')->with('success', 'Cập nhật phí vận chuyển thành công');
    }
    public function delete($id)
    {
        $shipping = ShippingModel::find($id);
        if ($shipping) {
            $shipping->is_deleted = 1;
            $shipping->save();
        }
        return redirect('admin/shipping/list')->with('success', 'Xóa phí vận chuyển thành công');
    }
}
