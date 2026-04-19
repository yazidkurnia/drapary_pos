<?php

namespace App\Http\Controllers\ManageUnit;

use App\DataTables\UnitsDataTable;
use App\Http\Controllers\Controller;
use App\Modules\ManageUnits\Application\DTOs\UnitDTO;
use App\Modules\ManageUnits\Application\Services\ManageUnitService;
use App\Modules\ManageUnits\Domain\Repositories\ManageUnitRepositoryInterface;
use Illuminate\Http\Request;

class ManageUnitsController extends Controller
{
    public function __construct(
        private ManageUnitRepositoryInterface $unitRepository,
        private ManageUnitService $manageUnitService
    ) {}

    public function index(UnitsDataTable $dataTable)
    {
        return $dataTable->render('pages.units.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_name' => 'required|string|max:255',
            'unit_code' => 'required|string|max:50',
        ]);

        $unitDTO = UnitDTO::fromRequest($request);

        try {
            $this->manageUnitService->store($unitDTO);
            return response()->json([
                'status'  => 'success',
                'message' => 'Data satuan berhasil ditambahkan',
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
            $unit = $this->manageUnitService->fetch_by_id($id);
            return response()->json([
                'status' => 'success',
                'data'   => $unit,
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(Request $request, string $unitId)
    {
        $request->validate([
            'unit_name' => 'required|string|max:255',
            'unit_code' => 'required|string|max:50',
        ]);

        $unitDTO = UnitDTO::fromRequest($request);

        try {
            $this->manageUnitService->update_service($unitDTO, $unitId);
            return response()->json([
                'status'  => 'success',
                'message' => 'Data satuan berhasil diubah',
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function destroy(string $unitId)
    {
        try {
            $this->manageUnitService->destroy_unit($unitId);
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
