<?php

namespace App\DataTables;

use App\Models\AdminsList;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminsListDataTable extends DataTable
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
                $deleteButton = "<a href='".route('admin.admins-list.destroy', $query->id)."' style='color: white;' class='btn-sm btn-danger ml-1 delete-item'><i class='fas fa-trash-alt mr-1'></i></a>";
                if($query->id != 1){
                    return $deleteButton;
                }
            })
            ->addColumn('status', function ($query){
                if($query->status === 'active'){
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
                if($query->id != 1){
                    return $button;
                }
            })
            ->addColumn('user id', function ($query){
                return $query->id;
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->where('role', 'admin')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('adminslist-table')
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
            Column::make('id'),
            Column::make('user id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AdminsList_' . date('YmdHis');
    }
}
