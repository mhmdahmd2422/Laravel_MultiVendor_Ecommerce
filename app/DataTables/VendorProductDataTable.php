<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorProductDataTable extends DataTable
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
                $editButton = "<a href='".route('vendor.products.edit', $query->id)."' style='color: white;' class='btn btn-warning'><i class='far fa-edit mr-1'></i></a>";
                $deleteButton = "<a href='".route('vendor.products.destroy', $query->id)."' style='color: white; margin-left: 0.5rem;' class='btn btn-danger ml-2 delete-item'><i class='fas fa-trash-alt mr-1'></i></a>";
                $moreButton = '<!-- Default dropleft button -->
                        <div class="btn-group dropleft" style="margin-left: 0.2rem;">
                          <button type="button" class="btn btn-primary ml-1 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-wrench"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="'.route('vendor.products-image-gallery.showTable', $query->id).'"><i class="far fa-images" style="margin-right: 0.4rem;"></i> Image Gallery</a>
                            <a class="dropdown-item" href="'.route('vendor.products-variant.showTable', $query->id).'"><i class="far fa-file" style="margin-right: 0.5rem; margin-left: 0.2rem;"></i> Product Variants</a>
                          </div>
                        </div>';
                return $editButton.$deleteButton.$moreButton;
            })
            ->addColumn('thumbnail', function ($query){
                return $image = "<img style='height: 5rem; width: 5rem;' src='".asset($query->thumb_image)."'></img>";
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
            ->addColumn('listing', function ($query){
                switch($query->list_type){
                    case 'new_arrival':
                        return '<i class="badge bg-success">New Arrival</i>';
                        break;
                    case 'featured_product':
                        return '<i class="badge bg-warning">Featured Product</i>';
                        break;
                    case 'top_product':
                        return '<i class="badge bg-info">Top Product</i>';
                        break;
                    case 'best_product':
                        return '<i class="badge bg-danger">Best Product</i>';
                        break;
                    default:
                        return '<i class="badge bg-dark">None</i>';
                        break;
                }
            })

            ->rawColumns(['thumbnail', 'action', 'status', 'listing'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->where('vendor_id', Auth::user()->vendor->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorproduct-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::make('id')->width(30),
            Column::make('thumbnail')->width(100),
            Column::make('name'),
            Column::make('price'),
            Column::make('listing'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorProduct_' . date('YmdHis');
    }
}
