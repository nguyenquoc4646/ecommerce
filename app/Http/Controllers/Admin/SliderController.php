<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SliderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    public function list()
    {
        $data = SliderModel::getRecord();
        return view('admin.slider.list', [
            'data' => $data
        ]);
    }

    public function add()
    {
        return view('admin.slider.add');
    }
    public function insert(Request $request)
    {
        $slider = new SliderModel;
        if (!empty($request->file('image'))) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(20);
            $fileName = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/slider', $fileName);
            $slider->image = trim($fileName);
            $slider->save();
        }


        $slider->title = trim($request->title);
        $slider->button_name = trim($request->button_name);
        $slider->link = trim($request->link);
        $slider->status = trim($request->status);
        $slider->created_by = Auth::user()->id;
        $slider->save();
        return redirect('admin/slider/list')->with('success', 'Thêm slider thành công');
    }
    public function edit($id)
    {
        $data = SliderModel::find($id);
        return view('admin.slider.edit', [
            'data' => $data
        ]);
    }
    public function update($id, Request $request)
    {
        $slider = SliderModel::find($id);
        if (!empty($request->file('image'))) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(20);
            $fileName = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/slider', $fileName);
            $slider->image = trim($fileName);
            $slider->save();
        }

        $slider->title = trim($request->title);
        $slider->button_name = trim($request->button_name);
        $slider->link = trim($request->link);
        $slider->status = trim($request->status);
        $slider->created_by = Auth::user()->id;
        $slider->save();
        return redirect('admin/slider/list')->with('success', 'Cập nhật banner thành công');
    }
    public function delete($id)
    {
        $slider = SliderModel::find($id);
        if ($slider) {
            $slider->is_deleted = 1;
            $slider->save();
        }
        return redirect('admin/slider/list')->with('success', 'Xóa slider thành công');
    }
}
