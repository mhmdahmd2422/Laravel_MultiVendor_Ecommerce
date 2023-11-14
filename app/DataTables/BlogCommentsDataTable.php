<?php

namespace App\DataTables;

use App\Models\BlogComment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BlogCommentsDataTable extends DataTable
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
                $deleteButton = "<a href='".route('admin.blog-comment.destroy', $query->id)."' style='color: white;' class='btn-sm btn-danger ml-1 delete-item'><i class='fas fa-trash-alt mr-1'></i></a>";
                $banButton = "<a href='".route('admin.blog-comment.ban', $query->user->id)."' style='color: white;' class='btn-sm btn-danger ml-1 delete-item'><i class='fas fa-ban mr-2'></i>Ban And Erase All</a>";
                return $deleteButton.$banButton;
            })
            ->addColumn('blog', function ($query){
                return '<a href="'.route('blog.index', $query->blog->slug).'">'.limitText($query->blog->title,15).'</a>';
            })
            ->addColumn('commenter', function ($query){
                return $query->user->name;
            })
            ->addColumn('comment', function ($query){
                return limitText($query->comment, 30);
            })
            ->rawColumns(['blog', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(BlogComment $model): QueryBuilder
    {
        return $model->whereHas('user', function ($query){
            $query->where('status', 'active');
        })->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('blogcomments-table')
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
            Column::make('blog'),
            Column::make('commenter'),
            Column::make('comment'),
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
        return 'BlogComments_' . date('YmdHis');
    }
}
