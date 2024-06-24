<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategoryModel;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function list()
    {
        $data = SubCategoryModel::getRecord();
        return view('admin.SubCategory.list', ['data' => $data]);
    }
    public function add()
    {
        $categories = CategoryModel::all();
        return view('admin.SubCategory.add', [
            'categories' => $categories
        ]);
    }
    public function insert(Request $request)
    {

        $request->validate(
            [
                'categoryName' => 'required|unique:category,name',
            ],
            [
                'categoryName.required' => 'Danh mục phụ là bắt buộc.',
                'categoryName.unique' => 'Danh mục phụ đã tồn tại.',

            ]
        );

        $SubCategoryModel = new SubCategoryModel;
        $SubCategoryModel->id_category = $request->category_id;
        $SubCategoryModel->name = trim($request->categoryName);
        $SubCategoryModel->slug = Str::slug($request->categoryName);
        $SubCategoryModel->status = trim($request->status);
        $SubCategoryModel->meta_title = trim($request->metaTitle);
        $SubCategoryModel->meta_description = trim($request->metaDescription);
        $SubCategoryModel->meta_keywords = trim($request->metaKeywords);
        $SubCategoryModel->created_by = Auth::user()->id;
        $SubCategoryModel->save();
        return redirect('admin/sub_category/list')->with('success', 'Thêm danh mục phụ thành công');
    }

    public function edit($id)
    {
        $categories = CategoryModel::all();
        $data = SubCategoryModel::find($id);

        return view('admin.SubCategory.edit', [
            'data' => $data,
            'categories' => $categories
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
        $subCategory = SubCategoryModel::find($id);
        $subCategory->name = trim($request->categoryName);
        $subCategory->id_category = trim($request->category_id);
        $subCategory->slug = Str::slug($request->categoryName);
        $subCategory->status = trim($request->status);
        $subCategory->meta_title = trim($request->metaTitle);
        $subCategory->meta_description = trim($request->metaDescription);
        $subCategory->meta_keywords = trim($request->metaKeywords);
        $subCategory->created_by = Auth::user()->id;
        $subCategory->save();
        return redirect('admin/sub_category/list')->with('success', 'Cập nhật danh mục phụ thành công');
    }
    public function delete($id)
    {
        $subCategory = SubCategoryModel::find($id);
        if ($subCategory) {
            $subCategory->is_deleted = 1;
            $subCategory->save();
        }
        return redirect('admin/sub_category/list')->with('success', 'Xóa danh mục phụ thành công');
    }

    public function get_sub_category(Request $request){
        $id = $request->id;
        $get_sub_category = SubCategoryModel::getSubByCateId($id);
        $html='';
      
        foreach($get_sub_category as $key => $value){
            $html .= ' <option value="'.$value->id.'">'.$value->name.'</option>';
        }
        $json['html'] = $html;
        echo json_encode($json);
    }
}
