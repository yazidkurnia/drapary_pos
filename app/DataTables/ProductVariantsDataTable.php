<?php

namespace App\DataTables;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductVariantsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('brand_name', fn($row) => $row->product->brand->brand_name ?? '-')
            ->addColumn('product_name', fn($row) => $row->product->product_name ?? '-')
            ->addColumn('variant_info', function ($row) {
                $parts = [];
                if ($row->color)   $parts[] = '<span class="badge badge-light border">' . e($row->color->color_name) . '</span>';
                if ($row->material)$parts[] = '<span class="badge badge-light border">' . e($row->material->material_name) . '</span>';
                if ($row->fit)     $parts[] = '<span class="badge badge-light border">' . e($row->fit->fit_name) . '</span>';
                if ($row->sleeve)  $parts[] = '<span class="badge badge-light border">' . e($row->sleeve->sleeve_name) . '</span>';
                if ($row->collar)  $parts[] = '<span class="badge badge-light border">' . e($row->collar->collar_name) . '</span>';
                if ($row->pattern) $parts[] = '<span class="badge badge-light border">' . e($row->pattern->pattern_name) . '</span>';
                if ($row->gender)  $parts[] = '<span class="badge badge-light border">' . e($row->gender->gender_name) . '</span>';
                /* Ukuran tersedia */
                foreach ($row->sizeStocks as $ss) {
                    $stockClass = $ss->stock > 0 ? 'primary' : 'secondary';
                    $parts[] = '<span class="badge badge-' . $stockClass . ' border" title="Stok: ' . $ss->stock . '">'
                             . e($ss->size->size_name) . '</span>';
                }
                return $parts ? implode(' ', $parts) : '<span class="text-muted">-</span>';
            })
            ->addColumn('price_formatted', fn($row) => 'Rp ' . number_format($row->price, 0, ',', '.'))
            ->addColumn('stock_badge', function ($row) {
                $total = $row->sizeStocks->sum('stock');
                $class = $total > 10 ? 'success' : ($total > 0 ? 'warning' : 'danger');
                $label = $total > 0
                    ? $total . ' <small style="font-size:.68rem;">(' . $row->sizeStocks->count() . ' ukuran)</small>'
                    : '0';
                return '<span class="badge badge-' . $class . '">' . $label . '</span>';
            })
            ->addColumn('images_preview', function ($row) {
                $encId   = Crypt::encryptString($row->id);
                $primary = $row->images->firstWhere('is_primary', 1) ?? $row->images->first();
                $count   = $row->images->count();

                if (!$primary) {
                    return '<div class="text-center">
                        <span class="text-muted" style="font-size:11px;"><i class="fas fa-image"></i><br>Tidak ada</span>
                    </div>';
                }

                $url = Storage::url($primary->image_path);
                $badge = $count > 1
                    ? '<span class="badge badge-secondary" style="font-size:9px;">+' . ($count - 1) . '</span>'
                    : '';

                return '
                    <div class="text-center" style="cursor:pointer;" onclick="viewImages(\'' . $encId . '\')" title="Klik untuk lihat semua gambar">
                        <img src="' . e($url) . '"
                             style="width:52px;height:52px;object-fit:cover;border-radius:5px;border:1px solid #dee2e6;display:block;margin:0 auto 3px;"
                             alt="">
                        ' . $badge . '
                    </div>';
            })
            ->addColumn('action', function ($row) {
                $encId = Crypt::encryptString($row->id);
                return '
                    <button type="button"
                        class="btn btn-sm btn-icon btn-warning mr-1"
                        onclick="edit(\'' . $encId . '\')"
                        data-toggle="tooltip" data-placement="top" title="Edit Varian">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button type="button"
                        class="btn btn-sm btn-icon btn-danger"
                        onclick="confirmDelete(\'' . $encId . '\')"
                        data-toggle="tooltip" data-placement="top" title="Hapus Varian">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                ';
            })
            ->rawColumns(['action', 'variant_info', 'stock_badge', 'images_preview']);
    }

    public function query(ProductVariant $model): QueryBuilder
    {
        return $model->newQuery()->with([
            'product.brand', 'color', 'material',
            'fit', 'sleeve', 'collar', 'pattern', 'gender', 'unit',
            'images', 'sizeStocks.size',
        ]);
    }

    public function html(): HtmlBuilder
    {
        $emptyHtml = '
            <div class="dt-empty-state">
                <div class="dt-empty-icon"><i class="fas fa-tags"></i></div>
                <h5 class="dt-empty-title">Belum ada data varian produk</h5>
                <p class="dt-empty-desc">Tambah varian produk baru untuk memulai.</p>
            </div>
        ';

        return $this->builder()
            ->setTableId('product-variants-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('product-variants.index'))
            ->orderBy(1)
            ->parameters(['autoWidth' => false])
            ->selectStyleSingle()
            ->language([
                'emptyTable'        => $emptyHtml,
                'zeroRecords'       => $emptyHtml,
                'search'            => '',
                'searchPlaceholder' => 'Cari varian...',
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
            Column::make('images_preview')->title('Gambar')->orderable(false)->searchable(false)->addClass('text-center'),
            Column::make('brand_name')->title('Brand')->orderable(false)->searchable(false),
            Column::make('product_name')->title('Produk')->orderable(false)->searchable(false),
            Column::make('sku')->title('SKU'),
            Column::make('variant_info')->title('Parameter Varian')->orderable(false)->searchable(false),
            Column::make('price_formatted')->title('Harga')->orderable(false)->searchable(false),
            Column::make('stock_badge')->title('Stok')->orderable(false)->searchable(false),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'ProductVariants_' . date('YmdHis');
    }
}
