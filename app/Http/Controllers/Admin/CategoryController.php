<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function list()
    {
        $data = CategoryModel::query()->where('is_deleted', 0)->latest('id')->paginate(10);

        return view('admin.category.list', compact('data'));
    }
    public function add()
    {
        return view('admin.category.add');
    }
    public function insert(Request $request)
    {
        // dd($request->all());


        $request->validate(
            [
                'categoryName' => 'required|unique:category,name',
            ],
            [
                'categoryName.required' => 'Danh mục là bắt buộc.',
                'categoryName.unique' => 'Danh mục đã tồn tại.',

            ]
        );

        $category = new CategoryModel;
        if (!empty($request->file('image'))) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(20);
            $fileName = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/category', $fileName);
            $category->image = trim($fileName);
            // $category->save();
        }
        $category->button_name = $request->button_name;
        $category->is_home = !empty($request->is_home) ? 1 : 0;
        $category->name = trim($request->categoryName);
        $category->slug = Str::slug($request->categoryName);
        $category->status = trim($request->status);
        $category->meta_title = trim($request->metaTitle);
        $category->meta_description = trim($request->metaDescription);
        $category->meta_keywords = trim($request->metaKeywords);
        $category->created_by = Auth::user()->id;
        $category->save();
        return redirect('admin/category/list')->with('success', 'Thêm danh mục thành công');
    }

    public function edit($id)
    {
        $data = CategoryModel::find($id);
        return view('admin.category.edit', [
            'data' => $data
        ]);
    }

    public function update($id, Request $request)
    {
        $request->validate(
            [
                'categoryName' => 'required|unique:category,name,' . $id,
            ],
            [
                'categoryName.required' => 'Danh mục là bắt buộc.',
                'categoryName.unique' => 'Danh mục đã tồn tại.',
            ]
        );
        $category = CategoryModel::find($id);

        if (!empty($request->file('image'))) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $randomStr = Str::random(20);
            $fileName = strtolower($randomStr) . '.' . $ext;
            $file->move('upload/category', $fileName);
            $category->image = trim($fileName);
            $category->save();
        }
        $category->button_name = $request->button_name;
        $category->is_home = !empty($request->is_home) ? 1 : 0;
        $category->name = trim($request->categoryName);
        $category->slug = Str::slug($request->categoryName);
        $category->status = trim($request->status);
        $category->meta_title = trim($request->metaTitle);
        $category->meta_description = trim($request->metaDescription);
        $category->meta_keywords = trim($request->metaKeywords);
        $category->created_by = Auth::user()->id;
        $category->save();
        return redirect('admin/category/list')->with('success', 'Cập nhật danh mục thành công');
    }
    public function delete($id)
    {
        $category = CategoryModel::find($id);
        if ($category) {
            $category->is_deleted = 1;
            $category->save();
        }
        return redirect('admin/category/list')->with('success', 'Xóa danh mục thành công');
    }
}
