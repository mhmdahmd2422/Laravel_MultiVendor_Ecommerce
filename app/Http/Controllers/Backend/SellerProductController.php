<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SellerPendingProductDataTable;
use App\DataTables\SellerProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SellerProductController extends Controller
{
    public function index(SellerProductDataTable $dataTable){
        return $dataTable->render('admin.product.seller-product.index');
    }

    public function pendingProducts(SellerPendingProductDataTable $dataTable){
        return $dataTable->render('admin.product.seller-product.pending');
    }

    public function approveProduct(String $product_id){
        $product = Product::findOrFail($product_id);
        if($product->is_approved){
            $product->is_approved = 0;
        }else{
            $product->is_approved = 1;
        }
        $product->save();

        return response(['status' => 'success', 'message' => 'Product Approval Has Been Updated']);
    }
}
