<?php

namespace App\DataTables;

use App\Models\Vendor;
use App\Models\VendorRequest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorRequestsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($query){
                $showButton = "<a href='".route('admin.vendor-request.show', $query->id)."' style='color: white;' class='btn btn-primary'><i class='far fa-eye mr-1'></i></a>";
                $deleteButton = "<a href='".route('admin.vendor-request.destroy', $query->id)."' style='color: white; margin-left: 0.5rem;' class='btn btn-danger ml-2 delete-item'><i class='fas fa-trash-alt mr-1'></i></a>";
                return $showButton.$deleteButton;
            })
            ->addColumn('username', function ($query){
                return $query->user->name;
            })
            ->addColumn('shop name', function ($query){
                return $query->name;
            })
            ->addColumn('shop email', function ($query){
                return $query->email;
            })
            ->addColumn('approval', function ($query){
                if($query->is_approved === 0){
                    return '<span class="badge bg-info text-white">Pending</span>';
                }
            })
            ->rawColumns(['approval', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Vendor $model): QueryBuilder
    {
        return $model->where('is_approved', 0)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorrequests-table')
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
            Column::make('username'),
            Column::make('shop name'),
            Column::make('shop email'),
            Column::make('approval'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorRequests_' . date('YmdHis');
    }
}
