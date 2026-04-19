<?php

namespace App\Http\Controllers\ManageSize;

use App\DataTables\SizesDataTable;
use App\Http\Controllers\Controller;
use App\Modules\ManageSizes\Application\DTOs\SizeDTO;
use App\Modules\ManageSizes\Application\Services\ManageSizeService;
use App\Modules\ManageSizes\Domain\Repositories\ManageSizeRepositoryInterface;
use Illuminate\Http\Request;

class ManageSizesController extends Controller
{
    public function __construct(
        private ManageSizeRepositoryInterface $sizeRepository,
        private ManageSizeService $manageSizeService
    ) {}

    public function index(SizesDataTable $dataTable)
    {
        return $dataTable->render('pages.sizes.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'size_name' => 'required|string|max:255',
            'size_code' => 'required|string|max:50',
        ]);

        $sizeDTO = SizeDTO::fromRequest($request);

        try {
            $this->manageSizeService->store($sizeDTO);
            return response()->json([
                'status'  => 'success',
                'message' => 'Data ukuran berhasil ditambahkan',
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function edit(string $id)
    {
        try {
            $size = $this->manageSizeService->fetch_by_id($id);
            return response()->json([
                'status' => 'success',
                'data'   => $size,
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(Request $request, string $sizeId)
    {
        $request->validate([
            'size_name' => 'required|string|max:255',
            'size_code' => 'required|string|max:50',
        ]);

        $sizeDTO = SizeDTO::fromRequest($request);

        try {
            $this->manageSizeService->update_service($sizeDTO, $sizeId);
            return response()->json([
                'status'  => 'success',
                'message' => 'Data ukuran berhasil diubah',
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function destroy(string $sizeId)
    {
        try {
            $this->manageSizeService->destroy_size($sizeId);
            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil menghapus data',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
