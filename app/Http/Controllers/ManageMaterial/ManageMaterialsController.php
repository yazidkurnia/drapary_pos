<?php

namespace App\Http\Controllers\ManageMaterial;

use App\DataTables\MaterialsDataTable;
use App\Http\Controllers\Controller;
use App\Modules\ManageMaterials\Application\DTOs\MaterialDTO;
use App\Modules\ManageMaterials\Application\Services\ManageMaterialService;
use App\Modules\ManageMaterials\Domain\Repositories\ManageMaterialRepositoryInterface;
use Illuminate\Http\Request;

class ManageMaterialsController extends Controller
{
    public function __construct(
        private ManageMaterialRepositoryInterface $materialRepository,
        private ManageMaterialService $manageMaterialService
    ) {}

    public function index(MaterialsDataTable $dataTable)
    {
        return $dataTable->render('pages.materials.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_name' => 'required|string|max:255',
            'material_code' => 'required|string|max:50',
        ]);

        $materialDTO = MaterialDTO::fromRequest($request);

        try {
            $this->manageMaterialService->store($materialDTO);
            return response()->json([
                'status'  => 'success',
                'message' => 'Data material berhasil ditambahkan',
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
            $material = $this->manageMaterialService->fetch_by_id($id);
            return response()->json([
                'status' => 'success',
                'data'   => $material,
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(Request $request, string $materialId)
    {
        $request->validate([
            'material_name' => 'required|string|max:255',
            'material_code' => 'required|string|max:50',
        ]);

        $materialDTO = MaterialDTO::fromRequest($request);

        try {
            $this->manageMaterialService->update_service($materialDTO, $materialId);
            return response()->json([
                'status'  => 'success',
                'message' => 'Data material berhasil diubah',
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function destroy(string $materialId)
    {
        try {
            $this->manageMaterialService->destroy_material($materialId);
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
