<?php

namespace App\DataTables;

use App\Models\NewsletterSubscriber;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class NewsletterSubscriberDataTable extends DataTable
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
                $deleteButton = "<a href='".route('admin.newsletter.destroy', $query->id)."' style='color: white;' class='btn-sm btn-danger ml-1 delete-item'><i class='fas fa-trash-alt mr-1'></i></a>";
                return $deleteButton;
            })            ->addColumn('sent_at', function ($query){
                if($query->sent_at){
                    $sent_at = '<span class="badge bg-primary text-white">'.$query->sent_at.'</span>';
                }else{
                    $sent_at = '<span class="badge bg-secondary text-white">Sending</span>';
                }
                return $sent_at;
            })
            ->addColumn('is_verified', function ($query){
                if($query->verified_at){
                    $is_verified = '<span class="badge bg-info text-white">'.$query->verified_at.'</span>';
                }else{
                    $is_verified = '<span class="badge bg-danger text-white">Not Verified</span>';
                }
                return $is_verified;
            })
            ->rawColumns(['sent_at', 'is_verified', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(NewsletterSubscriber $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('newslettersubscriber-table')
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
            Column::make('email'),
            Column::make('sent_at'),
            Column::make('is_verified'),
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
        return 'NewsletterSubscriber_' . date('YmdHis');
    }
}
