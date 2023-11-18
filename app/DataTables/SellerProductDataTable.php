<?php

namespace App\DataTables;

use App\Models\Product;
use App\Models\SellerProduct;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SellerProductDataTable extends DataTable
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
                $editButton = "<a href='".route('admin.product.edit', $query->id)."' style='color: white;' class='btn btn-warning'><i class='far fa-edit mr-1'></i></a>";
                $deleteButton = "<a href='".route('admin.product.destroy', $query->id)."' style='color: white;' class='btn btn-danger ml-1 delete-item'><i class='fas fa-times-circle'></i></a>";
                $moreButton = '<div class="btn-group dropleft">
                      <button type="button" class="btn btn-primary ml-1 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-wrench"></i>
                      </button>
                      <div class="dropdown-menu dropleft" x-placement="left-start" style="position: absolute; transform: translate3d(-2px, 0px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item has-icon" href="'.route('admin.products-image-gallery.showTable', $query->id).'"><i class="far fa-images"></i> Image Gallery</a>
                        <a class="dropdown-item has-icon" href="'.route('admin.products-variant.showTable', $query->id).'"><i class="far fa-file"></i> Product Variants</a>
                      </div>
                    </div>';
                return $editButton.$deleteButton.$moreButton;
            })
            ->addColumn('approve', function ($query){
                if($query->is_approved == 0){
                    $approveButton = "<a href='".route('admin.seller-products.approve', $query->id)."' style='color: white;' class='btn btn-primary approve-item'><i class='fas fa-times-circle' style='margin-right: 1rem'></i>Approve</a>";
                }else{
                    $approveButton = "<span style='color: white;' class='badge bg-success'>Approved</span>";
                }
                return $approveButton;
            })
            ->addColumn('thumbnail', function ($query){
                return $image = "<img style='height: 5rem; width: 5rem;' src='".asset($query->thumb_image)."'></img>";
            })
            ->addColumn('admin status', function ($query){
                if($query->admin_status){
                    $button = "<label class='custom-switch'>
                          <input type='checkbox' name='custom-switch-checkbox' checked data-id='".$query->id."' class='custom-switch-input change-checkbox'>
                          <span class='custom-switch-indicator'></span>
                        </label>";
                }else{
                    $button = "<label class='custom-switch'>
                          <input type='checkbox' name='custom-switch-checkbox' data-id='".$query->id."' class='custom-switch-input change-checkbox'>
                          <span class='custom-switch-indicator'></span>
                        </label>";
                }
                return $button;
            })
            ->addColumn('status', function ($query){
                if($query->status == 1){
                    $status = '<i class="badge badge-success">Active</i>';
                }else{
                    $status = '<i class="badge badge-success">AInactive</i>';
                }
                return $status;
            })
            ->addColumn('listing', function ($query){
                switch($query->list_type){
                    case 'new_arrival':
                        return '<i class="badge badge-success">New Arrival</i>';
                        break;
                    case 'featured_product':
                        return '<i class="badge badge-warning">Featured Product</i>';
                        break;
                    case 'top_product':
                        return '<i class="badge badge-info">Top Product</i>';
                        break;
                    case 'best_product':
                        return '<i class="badge badge-danger">Best Product</i>';
                        break;
                    default:
                        return '<i class="badge badge-dark">None</i>';
                        break;
                }
            })
            ->addColumn('vendor name', function ($query){
                return $query->vendor->user->name;
            })
            ->addColumn('vendor username', function ($query){
                return $query->vendor->user->username? : 'Not Provided';
            })
            ->rawColumns(['thumbnail', 'action', 'status', 'listing', 'approve', 'admin status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->where('vendor_id', '!=', Auth::user()->vendor->id)->where('is_approved', 1)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('sellerproduct-table')
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
            Column::make('id')->width(30),
            Column::make('thumbnail')->width(100),
            Column::make('name'),
            Column::make('vendor name'),
            Column::make('vendor username'),
            Column::make('price'),
            Column::make('listing'),
            Column::make('status'),
            Column::computed('admin status'),
            Column::make('approve'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SellerProduct_' . date('YmdHis');
    }
}
