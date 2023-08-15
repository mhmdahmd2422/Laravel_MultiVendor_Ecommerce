<?php

namespace App\DataTables;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SliderDataTable extends DataTable
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
                $editButton = "<a href='".route('admin.slider.edit', $query->id)."' style='color: white;' class='btn-sm btn-warning'><i class='far fa-edit mr-1'></i></a>";
//                $deleteButton = "<form action='".route('admin.slider.destroy', $query->id)."'>".method('delete')."<button type='submit' class='btn-sm btn-danger ml-1'></button><i class='fas fa-trash-alt mr-1'></i></form>";
                $deleteButton = "<a href='".route('admin.slider.destroy', $query->id)."' style='color: white;' class='btn-sm btn-danger ml-1 delete-item'><i class='fas fa-trash-alt mr-1'></i></a>";
                return $editButton.$deleteButton;
            })
            ->addColumn('banner', function ($query){
                return $image = "<img style='height: 5rem; width: 5rem;' src='".asset($query->banner)."'></img>";
            })
            ->addColumn('status', function ($query){
                $active = "<span class='badge badge-success'>Active</span>";
                $inactive = "<span class='badge badge-danger'>In-Active</span>";
                if($query->status){
                    return $active;
                }else{
                    return $inactive;
                }
            })
            ->addColumn('serial', function ($query){
                return $serial = "<span class='badge badge-secondary'>$query->serial</span>";
            })

            ->rawColumns(['banner', 'action', 'status', 'serial'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Slider $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('slider-table')
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
            Column::make('banner')->width(100),
            Column::make('title'),
            Column::make('serial'),
            Column::make('status'),
//            Column::make('created_at'),
//            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Slider_' . date('YmdHis');
    }
}
