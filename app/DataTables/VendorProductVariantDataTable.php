<?php

namespace App\DataTables;

use App\Models\ProductVariant;
use App\Models\VendorProductVariant;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorProductVariantDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query){
                $manageButton = "<a href='".route('vendor.products-variant-items.showTable', ['product_id' => $this->product_id, 'variant_id' => $query->id])."' style='color: white;  margin-right: 0.4rem;' class='btn btn-info mr-2'><i class='far fa-edit mr-1'></i>Items</a>";
                $editButton = "<a href='".route('vendor.products-variant.edit', $query->id)."' style='color: white; margin-right: 0.4rem;' class='btn btn-warning mr-1'><i class='far fa-edit mr-1'></i></a>";
                $deleteButton = "<a href='".route('vendor.products-variant.destroy', $query->id)."' style='color: white;' class='btn btn-danger ml-1 delete-item'><i class='fas fa-trash-alt mr-1'></i></a>";
                return $manageButton.$editButton.$deleteButton;
            })
            ->addColumn('status', function ($query){
                if($query->status){
                    $button = '<div class="form-check form-switch">
                          <input class="form-check-input change-checkbox" type="checkbox" role="switch" data-id="'.$query->id.'" id="flexSwitchCheckChecked" checked>
                          <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>';
                }else{
                    $button = '<div class="form-check form-switch">
                          <input class="form-check-input change-checkbox" type="checkbox" role="switch" data-id="'.$query->id.'" id="flexSwitchCheckDefault">
                          <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>';
                }
                return $button;
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariant $model): QueryBuilder
    {
        return $model->where('product_id', $this->product_id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorproductvariant-table')
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
            Column::make('id')->width(50),
            Column::make('name'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(250)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorProductVariant_' . date('YmdHis');
    }
}
