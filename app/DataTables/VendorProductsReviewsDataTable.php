<?php

namespace App\DataTables;

use App\Models\ProductReview;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorProductsReviewsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('product', function ($query){
                $product = '<a href="'.route('product-detail.index', $query->product->slug).'">'.$query->product->name.'</a>';
                return $product;
            })
            ->addColumn('username', function ($query){
                return $query->user->name;
            })
            ->addColumn('rate', function ($query){
                $rate = '';
                for($i=0; $i<$query->rate; $i++){
                    $rate .= '<i class="fas fa-star"></i>';
                }
                return $rate;
            })
            ->addColumn('status', function ($query){
                if($query->status == 1){
                    $status = '<span class="badge bg-success text-black">Approved</span>';
                }else{
                    $status = '<span class="badge bg-danger text-black">Pending</span>';
                }
                return $status;
            })
            ->rawColumns(['product', 'rate', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductReview $model): QueryBuilder
    {
        return $model->where('vendor_id' , auth()->user()->vendor->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorproductsreviews-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('product'),
            Column::make('username'),
            Column::make('rate'),
            Column::make('review'),
            Column::make('status'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorProductsReviews_' . date('YmdHis');
    }
}
