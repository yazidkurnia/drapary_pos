<?php

namespace App\DataTables;

use App\Models\Pattern;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PatternsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                    <button type="button"
                        class="btn btn-sm btn-icon btn-warning mr-1"
                        onclick="edit(\'' . Crypt::encryptString($row->id) . '\')"
                        data-toggle="tooltip" data-placement="top" title="Edit Motif/Pola">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button type="button"
                        class="btn btn-sm btn-icon btn-danger"
                        onclick="confirmDelete(\'' . Crypt::encryptString($row->id) . '\')"
                        data-toggle="tooltip" data-placement="top" title="Hapus Motif/Pola">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                ';
            })
            ->rawColumns(['action']);
    }

    public function query(Pattern $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        $emptyHtml = '
            <div class="dt-empty-state">
                <div class="dt-empty-icon"><i class="fas fa-border-all"></i></div>
                <h5 class="dt-empty-title">Belum ada data motif/pola</h5>
                <p class="dt-empty-desc">Tambah motif/pola baru untuk memulai.</p>
            </div>
        ';

        return $this->builder()
            ->setTableId('patterns-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('patterns.index'))
            ->orderBy(1)
            ->parameters(['autoWidth' => false])
            ->selectStyleSingle()
            ->language([
                'emptyTable'        => $emptyHtml,
                'zeroRecords'       => $emptyHtml,
                'search'            => '',
                'searchPlaceholder' => 'Cari motif/pola...',
                'lengthMenu'        => 'Tampilkan _MENU_ data',
                'info'              => 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                'infoEmpty'         => 'Tidak ada data tersedia',
                'paginate'          => ['first' => '&laquo;', 'last' => '&raquo;', 'next' => '&rsaquo;', 'previous' => '&lsaquo;'],
            ])
            ->buttons([]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false),
            Column::make('pattern_name')->title('Nama Motif/Pola'),
            Column::make('pattern_code')->title('Kode'),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Patterns_' . date('YmdHis');
    }
}
