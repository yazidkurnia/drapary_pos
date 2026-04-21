<?php

namespace App\DataTables;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BrandsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('is_active', function ($row) {
                return $row->is_active
                    ? '<span class="badge badge-success">Aktif</span>'
                    : '<span class="badge badge-danger">Nonaktif</span>';
            })
            ->editColumn('description', function ($row) {
                return $row->description ?? '<span class="text-muted">-</span>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <button type="button"
                        class="btn btn-sm btn-icon btn-warning mr-1"
                        onclick="edit(\'' . Crypt::encryptString($row->id) . '\')"
                        data-toggle="tooltip" data-placement="top" title="Edit Brand">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button type="button"
                        class="btn btn-sm btn-icon btn-danger"
                        onclick="confirmDelete(\'' . Crypt::encryptString($row->id) . '\')"
                        data-toggle="tooltip" data-placement="top" title="Hapus Brand">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                ';
            })
            ->rawColumns(['action', 'is_active', 'description']);
    }

    public function query(Brand $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        $emptyHtml = '
            <div class="dt-empty-state">
                <div class="dt-empty-icon">
                    <i class="fas fa-tag"></i>
                </div>
                <h5 class="dt-empty-title">Belum ada data brand</h5>
                <p class="dt-empty-desc">Data brand yang Anda cari tidak ditemukan.<br>Coba ubah kata kunci pencarian atau tambah brand baru.</p>
            </div>
        ';

        return $this->builder()
            ->setTableId('brands-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('brands.index'))
            ->orderBy(1)
            ->parameters(['autoWidth' => false])
            ->selectStyleSingle()
            ->language([
                'emptyTable'        => $emptyHtml,
                'zeroRecords'       => $emptyHtml,
                'search'            => '',
                'searchPlaceholder' => 'Cari brand...',
                'lengthMenu'        => 'Tampilkan _MENU_ data',
                'info'              => 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                'infoEmpty'         => 'Tidak ada data tersedia',
                'paginate'          => [
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
            Column::make('brand_name')->title('Nama Brand'),
            Column::make('brand_code')->title('Kode Brand'),
            Column::make('description')->title('Deskripsi'),
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
        return 'Brands_' . date('YmdHis');
    }
}
