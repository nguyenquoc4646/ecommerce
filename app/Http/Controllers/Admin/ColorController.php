<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ColorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ColorController extends Controller
{
    public function list()
    {
        $data = ColorModel::getRecord();

        return view('admin.color.list', [
            'data' => $data
        ]);
    }

    public function add()
    {
        return view('admin.color.add');
    }
    public function insert(Request $request)
    {

        $request->validate(
            [
                'colorName' => 'required|unique:brand,name',
            ],
            [
                'colorName.required' => 'Thương hiệu là bắt buộc.',
                'colorName.unique' => 'Thương hiệu đã tồn tại.',

            ]
        );

        $color = new ColorModel;
        $color->name = trim($request->colorName);
        $color->code = trim($request->codeColor);
        $color->slug = Str::slug($request->colorName);
        $color->status = trim($request->status);
        $color->created_by = Auth::user()->id;
        $color->save();
        return redirect('admin/color/list')->with('success', 'Thêm màu thành công');
    }
    public function edit($id)
    {
        $data = ColorModel::find($id);
        return view('admin.color.edit', [
            'data' => $data
        ]);
    }
    public function update($id, Request $request)
    {

        $request->validate(
            [
                'colorName' => 'required|unique:brand,name,' . $id,
            ],
            [
                'colorName.required' => 'Danh mục là bắt buộc.',
                'colorName.unique' => 'Danh mục đã tồn tại.',
            ]
        );
        $color = ColorModel::find($id);
        $color->name = trim($request->colorName);
        $color->code = trim($request->codeColor);
        $color->slug = Str::slug($request->colorName);
        $color->status = trim($request->status);
        $color->created_by = Auth::user()->id;
        $color->save();
        return redirect('admin/color/list')->with('success', 'Cập nhật màu thành công');
    }
    public function delete($id)
    {
        $color = ColorModel::find($id);
        if ($color) {
            $color->is_deleted = 1;
            $color->save();
        }
        return redirect('admin/color/list')->with('success', 'Xóa màu thành công');
    }
}
