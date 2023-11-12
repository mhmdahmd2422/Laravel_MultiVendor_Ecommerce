<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\AdminsListDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class AdminListController extends Controller
{
    public function index(AdminsListDataTable $dataTable)
    {
        return $dataTable->render('admin.admin-list.index');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $products = Product::where('vendor_id', $user->id)->get();
        $orders = Order::where('order_status', '!=', 'delivered')->get();
        if($user->id != 1){
            if($products->isNotEmpty()){
                return response(['status' => 'error', 'message' => 'This Admin Has Registered Products! Delete All Admin Products to Delete This Admin Or Ban the Admin Instead.']);
            }else if($orders->isNotEmpty()){
                return response(['status' => 'error', 'message' => 'This User Has Incomplete Orders! Delete All User Orders to Delete This User.']);
            }else{
                $wishlists = Wishlist::where('user_id', $user->id)->get();
                foreach ($wishlists as $wishlist){
                    $wishlist->delete();
                }
                $user->delete();
                return response(['status' => 'success', 'message' => 'User Is Deleted!']);
            }
        }else{
            return response(['status' => 'error', 'message' => 'Cannot Delete Super Admin']);
        }
    }

    public function changeStatus(Request $request){
        $user = User::findOrFail($request->id);
        $products = Product::where('vendor_id', $user->vendor->id)->get();
        if($request->status === 'true'){
            $user->status = 'active';
            foreach ($products as $product){
                $product->status = 1;
                $product->save();
            }
        }else if($request->status === 'false'){
            $user->status = 'inactive';
            foreach ($products as $product){
                $product->status = 0;
                $product->save();
            }
        }
        $user->save();

        return response(['message' => 'Status Has Been Changed']);
    }
}
