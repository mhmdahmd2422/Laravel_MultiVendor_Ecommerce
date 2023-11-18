<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorRequestsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class AdminVendorRequestController extends Controller
{
    public function index(VendorRequestsDataTable $dataTable)
    {
        return $dataTable->render('admin.vendor-request.index');
    }

    public function show(string $id)
    {
        $vendor = Vendor::findorFail($id);

        return view('admin.vendor-request.show', compact('vendor'));
    }

    public function destroy(string $id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return response(['status' => 'success', 'message' => 'Vendor Request Is Deleted!']);
    }

    public function approve(Request $request)
    {
        if($request->has('approve')){
            $vendor = Vendor::findOrFail($request->approve);
            $vendor->is_approved = 1;
            $vendor->save();
            $this->changeUserRoleToVendor($vendor);

            return response([
                'status' => 'success',
                'message' => 'Vendor is Approved!',
                'page' => route('admin.vendor-request.index')
            ]);
        }else if($request->has('activate')){
            $vendor = Vendor::findOrFail($request->activate);
            $vendor->is_approved = 1;
            $vendor->status = 1;
            $vendor->save();
            $this->changeUserRoleToVendor($vendor);

            return response([
                'status' => 'success',
                'message' => 'Vendor is Approved and Activated!',
                'page' => route('admin.vendor-request.index')
            ]);
        }else{
            return response([
                'status' => 'error',
                'message' => 'Something Went Wrong',
                'redirect' => redirect()->route('admin.vendor-request.index')
            ]);
        }
    }

    public function changeUserRoleToVendor(Vendor $vendor)
    {
        $user = \App\Models\User::findOrfail($vendor->user_id);
        $user->role = 'vendor';
        $user->save();
    }
}
