<?php

namespace App\Http\Controllers\ManageBrand;

use App\DataTables\BrandsDataTable;
use App\Http\Controllers\Controller;
use App\Modules\ManageBrands\Application\DTOs\BrandDTO;
use App\Modules\ManageBrands\Application\Services\ManageBrandService;
use App\Modules\ManageBrands\Domain\Repositories\ManageBrandRepositoryInterface;
use Illuminate\Http\Request;

class ManageBrandsController extends Controller
{
    public function __construct(
        private ManageBrandRepositoryInterface $brandRepository,
        private ManageBrandService $manageBrandService
    ) {}

    public function index(BrandsDataTable $dataTable)
    {
        return $dataTable->render('pages.brands.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name'  => 'required|string|max:255',
            'brand_code'  => 'required|string|max:50',
            'description' => 'nullable|string|max:500',
        ]);

        $brandDTO = BrandDTO::fromRequest($request);

        try {
            $this->manageBrandService->store($brandDTO);
            return response()->json([
                'status'  => 'success',
                'message' => 'Data brand berhasil ditambahkan',
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
            $brand = $this->manageBrandService->fetch_by_id($id);
            return response()->json([
                'status' => 'success',
                'data'   => $brand,
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(Request $request, string $brandId)
    {
        $request->validate([
            'brand_name'  => 'required|string|max:255',
            'brand_code'  => 'required|string|max:50',
            'description' => 'nullable|string|max:500',
        ]);

        $brandDTO = BrandDTO::fromRequest($request);

        try {
            $this->manageBrandService->update_service($brandDTO, $brandId);
            return response()->json([
                'status'  => 'success',
                'message' => 'Data brand berhasil diubah',
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function destroy(string $brandId)
    {
        try {
            $this->manageBrandService->destroy_brand($brandId);
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
