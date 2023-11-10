<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CustomersListDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomersListController extends Controller
{
    public function index(CustomersListDataTable $dataTable)
    {
        return $dataTable->render('admin.customer-list.index');
    }

    public function changeStatus(Request $request){
        $user = User::findOrFail($request->id);
        $user->status = $request->status == 'true' ? 'active' : 'inactive';
        $user->save();

        return response(['message' => 'Status Has Been Changed']);
    }
}
