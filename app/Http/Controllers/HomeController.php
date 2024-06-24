<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\SliderModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $meta_title = 'Q-Shop';
        $meta_description = '';
        $meta_keywords = '';

        $getSlider = SliderModel::getRecordActive();
        $getRecordActiveHome = CategoryModel::getRecordActiveHome();
        $getAllProduct = ProductModel::getAllProduct();
        $getProductTrendy = ProductModel::getProductTrendy();
        // dd($getSlider);
        return view('Home', [
            'meta_title' => $meta_title,
            'getSlider' => $getSlider,
            'getRecordActiveHome'=>$getRecordActiveHome,
            'getProduct'=>$getAllProduct,
            'getProductTrendy'=>$getProductTrendy
        ]);
    }

    public function getRecentProHome(Request $request){
        if(!empty($request->category_id)){
            $getRecentProHome  = ProductModel::getProductByCategory($request->category_id);
            $getCategory = CategoryModel::find($request->category_id);
            return response()->json([
                'status'=>true,
                'success'=>view('client.product._list_recent_arrival',[
                    "getProduct"=>$getRecentProHome,
                    'getCategory'=>$getCategory
                ])->render()
            ]);
            
        }
    }
}
