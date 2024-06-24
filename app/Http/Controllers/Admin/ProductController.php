<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\ColorModel;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use App\Models\SubCategoryModel;
use App\Models\ProductColorModel;
use App\Models\ProductSizeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function list()
    {
        $data = ProductModel::getRecord();
        return view('admin.product.list', [
            'data' => $data
        ]);
    }
    public function add()
    {
        return view('admin.product.add');
    }

    public function insert(Request $request)
    {
        $product = new ProductModel;

        $product->title = trim($request->title);
        $product->created_by = Auth::user()->id;
        $product->save();


        $slug = Str::slug(trim($request->title));

        // kiểm tra xem slug đã tồn tại trên database hay chưa
        $checkSlug = ProductModel::checkSlug($slug);
        if (empty($checkSlug)) {
            $product->slug = $slug;
            $product->save();
        } else {
            $newSlug = $slug . '-' . $product->id;
            $product->slug = $newSlug;
            $product->save();
        }
        return redirect('admin/product/edit/' . $product->id);
    }

    public function edit($id)
    {
        $product = ProductModel::find($id);
        $color = ColorModel::getColor();
        $category = CategoryModel::getRecordActive();
        $brand = BrandModel::getRecordActive();
        $subCategory = SubCategoryModel::getSubByCateId($product->category_id);

        if (!empty($product)) {
            $data['product'] = $product;
            return view('admin.product.edit', [
                'data' => $data['product'],
                'category' => $category,
                'brand' => $brand,
                'color' => $color,
                'subCategory' => $subCategory
            ]);
        }
    }

    public function update($id, Request $request)
    {
      
        $product = ProductModel::find($id);

        if (!empty($product)) {
            $product->title = trim($request->title);
            $product->sku = trim($request->sku);
            $product->category_id = trim($request->category);
            $product->sub_category_id = trim($request->subCategory);
            $product->brand_id = trim($request->brand);
            $product->price = trim($request->price);
            $product->old_price = trim($request->oldPrice);
            $product->title = trim($request->title);
            $product->short_description = trim($request->short_description);
            $product->description = trim($request->description);
            $product->additional_description = trim($request->additional_description);
            $product->shipping_return = trim($request->shipping_return);
            $product->status = trim($request->status);
            $product->slug= Str::slug(trim($request->title));
            $product->is_trendy = !empty($request->is_trendy) ? 1 : 0;
            $product->save();
            ProductColorModel::DeleteRecord($product->id);
            if (!empty($request->color_id)) {
                foreach ($request->color_id as $item) {
                    $color = new ProductColorModel;
                    $color->color_id = $item;
                    $color->product_id = $product->id;
                    $color->save();
                }
            }
            ProductSizeModel::DeleteRecord($product->id);
            if (!empty($request->size)) {
                foreach ($request->size as $item) {
                    if (!empty($item['name'])) {
                        $saveSize = new ProductSizeModel;
                        $saveSize->name = $item['name'];
                        $saveSize->amount = $item['amount'];
                        $saveSize->price = !empty($item['price']) ? $item['price'] : 0;
                        $saveSize->product_id = $product->id;
                        $saveSize->save();
                    }
                }
            }
            if (!empty($request->file('image'))) {
                foreach ($request->file('image') as $value) {
                    if ($value->isValid()) {
                        $ext = $value->getClientOriginalExtension();
                        $randomStr = $product->id . Str::random(20);
                        $filename = strtolower($randomStr) . '.' . $ext;
                        $value->move('upload/product', $filename);

                        $imageUpload = new ProductImageModel;
                        $imageUpload->image_name = $filename;
                        $imageUpload->image_extention = $ext;
                        $imageUpload->product_id = $product->id;
                        $imageUpload->save();
                    }
                }
            }
            return redirect()->back()->with('success', 'Cập nhật sản phẩm thành công');
        }
    }
    public function delete($id)
    {
        $product = ProductModel::find($id);
        if ($product) {
            $product->is_deleted = 1;
            $product->save();
        }
        return redirect('admin/product/list')->with('success', 'Xóa danh sản phẩm thành công');
    }

    public function delete_image($id){
        $image = ProductImageModel::find($id);
        if(!empty($image->getImage())){
            unlink('upload/product/'.$image->image_name);
        }
        $image->delete();
        return redirect()->back()->with('success','Xóa ảnh thành công');

    }

    public function product_image_sortable(Request $request){

       if(!empty($request->image_id)){
        $i=1;
        
        foreach($request->image_id as $idImage){
            $image = ProductImageModel::find($idImage);
            $image->order_by = $i;
            $image->save();
            $i++;
        }
       }
       $json['success'] = true;
       echo json_encode($json);
    }
}
