<?php

namespace App\DataTables;

use App\Models\Color;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ColorsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $deleteUrl = route('colors.destroy', $row->id);

                return '
                    <button type="button"
                        class="btn btn-sm btn-icon btn-warning mr-1"
                        onclick="edit(\'' . Crypt::encryptString($row->id) . '\')"
                        data-toggle="tooltip" data-placement="top" title="Edit Warna">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="button"
                            class="btn btn-sm btn-icon btn-danger"
                            onclick="confirmDelete(\'' . Crypt::encryptString($row->id) . '\')"
                            data-toggle="tooltip" data-placement="top" title="Hapus Warna">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                ';
            })
            ->editColumn('is_active', function ($row) {
                return $row->is_active
                    ? '<span class="badge badge-success">Aktif</span>'
                    : '<span class="badge badge-danger">Nonaktif</span>';
            })
            ->editColumn('hexa_code', function ($row) {
                return '
                    <div class="d-flex align-items-center" style="gap:10px;">
                        <span style="display:inline-block;width:34px;height:34px;background:' . $row->hexa_code . ';border-radius:7px;border:1px solid rgba(0,0,0,.1);box-shadow:0 1px 4px rgba(0,0,0,.1);flex-shrink:0;"></span>
                        <span style="font-family:monospace;font-weight:600;letter-spacing:.5px;">' . strtoupper($row->hexa_code) . '</span>
                    </div>
                ';
            })
            ->rawColumns(['action', 'is_active', 'hexa_code']);
    }

    public function query(Color $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        $emptyHtml = '
            <div class="dt-empty-state">
                <div class="dt-empty-icon">
                    <i class="fas fa-palette"></i>
                </div>
                <h5 class="dt-empty-title">Belum ada data warna</h5>
                <p class="dt-empty-desc">Data warna yang Anda cari tidak ditemukan.<br>Coba ubah kata kunci pencarian atau tambah warna baru.</p>
                <a href="' . route('colors.create') . '" class="btn btn-primary btn-sm mt-2">
                    <i class="fas fa-plus mr-1"></i> Tambah Warna
                </a>
            </div>
        ';

        return $this->builder()
            ->setTableId('colors-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('colors.index'))
            ->orderBy(1)
            ->parameters([
                'autoWidth' => false,
            ])
            ->selectStyleSingle()
            ->language([
                'emptyTable'  => $emptyHtml,
                'zeroRecords' => $emptyHtml,
                'search'      => '',
                'searchPlaceholder' => 'Cari warna...',
                'lengthMenu'  => 'Tampilkan _MENU_ data',
                'info'        => 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                'infoEmpty'   => 'Tidak ada data tersedia',
                'paginate'    => [
                    'first'    => '&laquo;',
                    'last'     => '&raquo;',
                    'next'     => '&rsaquo;',
                    'previous' => '&lsaquo;',
                ],
            ])
            ->buttons([]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->orderable(false)->searchable(false),
            Column::make('color_name')->title('Nama Warna'),
            Column::make('hexa_code')->title('Kode Hex'),
            Column::make('is_active')->title('Status'),
            Column::computed('action')
                ->title('Aksi')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Colors_' . date('YmdHis');
    }
}
