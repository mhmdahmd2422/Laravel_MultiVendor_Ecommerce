<?php

namespace App\DataTables;

use App\Models\ProductVariantItem;
use App\Models\VendorProductVariantItem;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorProductVariantItemDataTable extends DataTable
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
                $editButton = "<a href='".route('vendor.product-variant-items.edit', $query->id)."' style='color: white; margin-right: 0.4rem;' class='btn btn-warning mr-1'><i class='fas fa-edit mr-1'></i></a>";
                $deleteButton = "<a href='".route('vendor.product-variant-items.destroy', $query->id)."' style='color: white;' class='btn btn-danger ml-1 delete-item'><i class='fas fa-trash-alt mr-1'></i></a>";
                 return $editButton.$deleteButton;
            })            ->addColumn('variant type', function ($query){
                return $query->variant->name;
            })
            ->addColumn('is default', function ($query){
                if($query->is_default == 1){
                    return '<i class="badge bg-success">Yes</i>';
                }else{
                    return '<i class="badge bg-dark">No</i>';
                }
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
            ->rawColumns(['status', 'action', 'is default'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariantItem $model): QueryBuilder
    {
        return $model->where('variant_id', request()->variant_id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorproductvariantitem-table')
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
            Column::make('id')->width('30'),
            Column::make('variant type'),
            Column::make('name'),
            Column::make('price'),
            Column::make('is default'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(130)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorProductVariantItem_' . date('YmdHis');
    }
}
