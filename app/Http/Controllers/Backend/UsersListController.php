<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\UsersListDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\Wishlist;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class UsersListController extends Controller
{
    use ImageUploadTrait;
    public function index(UsersListDataTable $dataTable)
    {
        return $dataTable->render('admin.users-list.index');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('admin.users-list.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => ['nullable', 'image', 'max:2048'],
            'name' => ['required','string', 'max:200'],
            'username' => ['nullable', 'image', 'max:2048'],
            'phone' => ['nullable', 'phone','string'],
            'email' => ['Email', 'max:200'],
            'role' => ['required','string', 'max:6'],
            'status' => ['required', 'boolean'],
        ]);

        $user = User::findOrFail($id);
        $imagePath = $this->updateImage($request, 'image', 'uploads', $user->image);
        $alert = 'User Has Been Updated!';
        $route = 'admin.users.index';

        return $this->submitForm($request, $user, $imagePath, $alert, $route);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $orders = Order::where('user_id', $user->id)->where('order_status', '!=', 'delivered')->get();
        if($orders->isNotEmpty()){
            return response(['status' => 'error', 'message' => 'This User Has Incomplete Orders! Delete All User Orders to Delete This User.']);
        }else{
            $wishlists = Wishlist::where('user_id', $user->id)->get();
            foreach ($wishlists as $wishlist){
                $wishlist->delete();
            }
            $user->delete();
            return response(['status' => 'success', 'message' => 'User Is Deleted!']);
        }
    }

    public function changeStatus(Request $request){
        $user = User::findOrFail($request->id);
        $reviews = ProductReview::where('user_id', $user->id)->get();
        if($request->status === 'true'){
            $user->status = 'active';
            foreach ($reviews as $review){
                $review->status = 1;
                $review->save();
            }
        }else if($request->status === 'false'){
            $user->status = 'inactive';
            foreach ($reviews as $review){
                $review->status = 0;
                $review->save();
            }
        }
        $user->save();

        return response(['message' => 'Status Has Been Changed']);
    }

    public function submitForm(Request $request, $user, $imagePath, $alert, $route): \Illuminate\Http\RedirectResponse
    {
        if($imagePath != null){$user->image = $imagePath;}
        $user->name = $request->name;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->save();

        toastr()->success($alert);

        if($route != null) {
            return redirect()->route($route);
        }else{
            return redirect()->back();
        }
    }
}
