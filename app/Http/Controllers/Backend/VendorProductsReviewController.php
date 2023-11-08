<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductsReviewsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorProductsReviewController extends Controller
{
    public function index(VendorProductsReviewsDataTable $dataTable)
    {
        return $dataTable->render('vendor.review.index');
    }

}
