<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DiscountController extends Controller
{
    public function list()
    {
        $data = DiscountModel::getRecord();

        return view('admin.discount.list', [
            'data' => $data
        ]);
    }

    public function add()
    {
        return view('admin.discount.add');
    }
    public function insert(Request $request)
    {
        

        $request->validate(
            [
                'discountName' => 'required|unique:discount,name',
            ],
            [
                'discountName.required' => 'Tên mã giảm là bắt buộc.',
                'discountName.unique' => 'Mã giảm đã tồn tại.',

            ]
        );

        $discount = new DiscountModel;
        $discount->name = trim($request->discountName);
        $discount->type = trim($request->type);
        $discount->status = trim($request->status);
        $discount->percen_amount = trim($request->percen_amount);
        $discount->expire_date = trim($request->expire_date);
        $discount->created_by = Auth::user()->id;
        $discount->save();
        return redirect('admin/discount/list')->with('success', 'Thêm mã giảm thành công');
    }
    public function edit($id)
    {
        $data = DiscountModel::find($id);
        return view('admin.discount.edit', [
            'data' => $data
        ]);
    }
    public function update($id, Request $request)
    {

        $request->validate(
            [
                'discountName' => 'required|unique:discount,name,' . $id,
            ],
            [
                'discountName.required' => 'Danh mục là bắt buộc.',
                'discountName.unique' => 'Danh mục đã tồn tại.',
            ]
        );
        $discount = DiscountModel::find($id);
        $discount->name = trim($request->discountName);
        $discount->type = trim($request->type);
        $discount->status = trim($request->status);
        $discount->percen_amount = trim($request->percen_amount);
        $discount->expire_date = trim($request->expire_date);
        $discount->created_by = Auth::user()->id;
        $discount->save();
        return redirect('admin/discount/list')->with('success', 'Cập nhật mã giảm giá thành công');
    }
    public function delete($id)
    {
        $discount = DiscountModel::find($id);
        if ($discount) {
            $discount->is_deleted = 1;
            $discount->save();
        }
        return redirect('admin/discount/list')->with('success', 'Xóa mã giảm giá thành công');
    }
}
