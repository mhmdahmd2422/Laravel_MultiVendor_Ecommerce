<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\AdminProductsReviewsDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class AdminReviewsController extends Controller
{
    public function index(AdminProductsReviewsDataTable $dataTable)
    {
        return $dataTable->render('admin.review.index');
    }

    public function approveReview(string $id)
    {
        $review = ProductReview::findOrFail($id);
        $review->status = 1;
        $review->save();

        return response(['status' => 'success', 'message' => 'Review Is Approved']);
    }
}
