<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BrandModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function list()
    {
        $data = BrandModel::getRecord();
        return view('admin.brand.list', compact('data'));
    }
    public function add()
    {
        return view('admin.brand.add');
    }
    public function insert(Request $request)
    {

        $request->validate(
            [
                'brandName' => 'required|unique:brand,name',
            ],
            [
                'brandName.required' => 'Thương hiệu là bắt buộc.',
                'brandName.unique' => 'Thương hiệu đã tồn tại.',

            ]
        );

        $brand = new BrandModel;
        $brand->name = trim($request->brandName);
        $brand->slug = Str::slug($request->brandName);
        $brand->status = trim($request->status);
        $brand->meta_title = trim($request->metaTitle);
        $brand->meta_description = trim($request->metaDescription);
        $brand->meta_keywords = trim($request->metaKeywords);
        $brand->created_by = Auth::user()->id;
        $brand->save();
        return redirect('admin/brand/list')->with('success', 'Thêm thương hiệu thành công');
    }
    public function edit($id)
    {
        $data = BrandModel::find($id);
        return view('admin.brand.edit', [
            'data' => $data
        ]);
    }

    public function update($id, Request $request)
    {

        $request->validate(
            [
                'brandName' => 'required|unique:brand,name,' . $id,
            ],
            [
                'brandName.required' => 'Danh mục là bắt buộc.',
                'brandName.unique' => 'Danh mục đã tồn tại.',
            ]
        );
        $brand = BrandModel::find($id);

        $brand->name = trim($request->brandName);
        $brand->slug = Str::slug($request->brandName);
        $brand->status = trim($request->status);
        $brand->meta_title = trim($request->metaTitle);
        $brand->meta_description = trim($request->metaDescription);
        $brand->meta_keywords = trim($request->metaKeywords);
        $brand->created_by = Auth::user()->id;
        $brand->save();
        return redirect('admin/brand/list')->with('success', 'Cập nhật thương hiệu thành công');
    }
    public function delete($id)
    {
        $brand = BrandModel::find($id);
        if ($brand) {
            $brand->is_deleted = 1;
            $brand->save();
        }
        return redirect('admin/brand/list')->with('success', 'Xóa thương hiệu thành công');
    }
}
