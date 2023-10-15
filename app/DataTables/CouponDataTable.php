<?php

namespace App\DataTables;

use App\Models\Coupon;
use App\Models\GeneralSetting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CouponDataTable extends DataTable
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
                $editButton = "<a href='".route('admin.coupons.edit', $query->id)."' style='color: white;' class='btn btn-warning'><i class='far fa-edit mr-1'></i></a>";
                $deleteButton = "<a href='".route('admin.coupons.destroy', $query->id)."' style='color: white; margin-left: 0.5rem;' class='btn btn-danger ml-2 delete-item'><i class='fas fa-trash-alt mr-1'></i></a>";
                return $editButton.$deleteButton;
            })
            ->addColumn('discount', function ($query){
                if($query->discount_type == 'percent'){
                    return '%'.$query->discount_value;
                }else{
                    return GeneralSetting::first()->currency_icon.$query->discount_value;
                }
            })
            ->addColumn('end_date', function ($query){
                return $query->end_date.' (Duration: '.Carbon::parse($query->start_date)->diffInDays($query->end_date).' Days)';
            })
            ->addColumn('time left', function ($query){
                return ' ('.now(GeneralSetting::first()->timezone)->diffInDays($query->end_date).' Days)';
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
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Coupon $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('coupon-table')
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
            Column::make('code'),
            Column::make('discount'),
            Column::make('start_date'),
            Column::make('end_date'),
            Column::make('time left'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Coupon_' . date('YmdHis');
    }
}
