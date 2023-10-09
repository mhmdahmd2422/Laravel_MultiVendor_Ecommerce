<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FlashSaleItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index(FlashSaleItemDataTable $dataTable){
        $sale_date = FlashSale::first();
        $products = Product::where('status', 1)
            ->where('is_approved', 1)
            ->orderBy('id', 'DESC')
            ->get();
        return $dataTable->render('admin.flash-sale.index', compact('sale_date', 'products'));
    }

    public function update(Request $request){
        $request->validate([
           'end_date' => ['required', 'date'],
        ]);

        $flash_sale = FlashSale::updateOrCreate(
            ['id' => 1],
            ['end_date' => $request->end_date],
        );

        flash()->addSuccess('Flash Sale End Date Has Been Updated');
        toastr()->success('Flash Sale End Date Has Been Updated');

        return redirect()->back();
    }

    public function addToSale(Request $request){
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id', 'unique:flash_sale_items,product_id'],
            'status' => ['required', 'boolean'],
            'show_at_home' => ['required', 'boolean'],
        ],[
            'product_id.unique' => 'This Product Is Already in Flash Sale!'
        ]);

        $sale_item = FlashSaleItem::firstOrNew([
            'product_id' => $request->product_id
        ]);

        $sale_item->show_at_home = $request->show_at_home;
        $sale_item->status = $request->status;
        $sale_item->save();

        flash()->addSuccess('Product Has Been Added To Flash Sale');

        return redirect()->back();
    }

    public function destroy(string $id){
        $sale_item = FlashSaleItem::findOrFail($id);
        $sale_item->delete();

        return response(['status' => 'success', 'message' => 'Flash Sale Item Has Been Deleted Successfully!']);
    }
    public function changeStatus(Request $request)
    {
        $sale_item = FlashSaleItem::findOrFail($request->id);
        $sale_item->status = $request->status == 'true' ? 1 : 0;
        $sale_item->save();

        return response(['message' => 'Status Has Been Changed']);
    }

    public function changeShow(Request $request)
    {
        $sale_item = FlashSaleItem::findOrFail($request->id);
        $sale_item->show_at_home = $request->show_at_home == 'true' ? 1 : 0;
        $sale_item->save();

        return response(['message' => 'Show At Home Status Has Been Changed']);
    }
}
