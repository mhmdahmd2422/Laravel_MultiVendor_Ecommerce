<?php

namespace App\DataTables;

use App\Models\Order;
use App\Models\VendorOrder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorOrderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('customer username', function ($query){
                return $query->user->username;
            })
            ->addColumn('date', function ($query){
                return date('Y-m-d', strtotime($query->created_at));
            })
            ->addColumn('product_quantity', function ($query){
                return $query->product_quantity.' Items';
            })
            ->addColumn('order total', function ($query){
                return $query->currency_icon.$query->total;
            })
            ->addColumn('payment_method', function ($query){
                if($query->payment_status === 0){
                    return ucfirst($query->payment_method).' (Pending)';
                }else{
                    return ucfirst($query->payment_method).' (Completed)';
                }
            })
            ->addColumn('order_status', function ($query){
                if($query->order_status === 'pending'){
                    return '<span class="badge bg-secondary text-white">Pending</span>';
                }elseif($query->order_status == 'processed_and_ready_to_ship'){
                    return '<span class="badge bg-info text-dark">Processed</span>';
                }elseif($query->order_status == 'dropped_off'){
                    return '<span class="badge bg-light text-dark">Dropped Off</span>';
                }elseif($query->order_status == 'shipped'){
                    return '<span class="badge bg-primary text-light">Shipped</span>';
                }elseif($query->order_status == 'out_for_delivery'){
                    return '<span class="badge bg-dark text-white">Out For Delivery</span>';
                }elseif($query->order_status == 'delivered'){
                    return '<span class="badge bg-success">Delivered</span>';
                }elseif($query->order_status == 'canceled'){
                    return '<span class="badge bg-danger">Canceled</span>';
                }
            })
            ->addColumn('action', function($query){
                $showButton = "<a href='".route('vendor.orders.show', $query->id)."' style='color: white;' class='btn btn-primary'><i class='far fa-eye mr-1'></i></a>";
                return $showButton;
            })
            ->rawColumns(['action', 'order_status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model::whereHas('products', function($query){
            $query->where('vendor_id', Auth::user()->vendor->id);
        })->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendororder-table')
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
            Column::make('invoice_id'),
            Column::make('customer username'),
            Column::make('date')->width(80),
            Column::make('product_quantity'),
            Column::make('order total'),
            Column::make('order_status'),
            Column::make('payment_method'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(160)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorOrder_' . date('YmdHis');
    }
}
