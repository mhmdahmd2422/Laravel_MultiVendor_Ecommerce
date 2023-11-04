<?php

namespace App\DataTables;

use App\Models\FooterGridTwo;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FooterGridTwoDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('url', function ($query){
                $url = "<a href='".$query->url."'>$query->url</a>";
                return $url;
            })
            ->addColumn('status', function ($query){
                if($query->status){
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
            ->addColumn('action', function ($query){
                $editButton = "<a href='".route('admin.footer-grid-two.edit', $query->id)."' style='color: white;' class='btn-sm btn-warning'><i class='far fa-edit mr-1'></i></a>";
                $deleteButton = "<a href='".route('admin.footer-grid-two.destroy', $query->id)."' style='color: white;' class='btn-sm btn-danger ml-1 delete-item'><i class='fas fa-trash-alt mr-1'></i></a>";
                return $editButton.$deleteButton;
            })
            ->rawColumns(['url', 'status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(FooterGridTwo $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('footergridtwo-table')
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
            Column::make('name'),
            Column::make('url'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(80)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'FooterGridTwo_' . date('YmdHis');
    }
}
