<?php

namespace App\Http\Controllers\ManageFit;

use App\DataTables\FitsDataTable;
use App\Http\Controllers\Controller;
use App\Modules\ManageFits\Application\DTOs\FitDTO;
use App\Modules\ManageFits\Application\Services\ManageFitService;
use App\Modules\ManageFits\Domain\Repositories\ManageFitRepositoryInterface;
use Illuminate\Http\Request;

class ManageFitsController extends Controller
{
    public function __construct(
        private ManageFitRepositoryInterface $fitRepository,
        private ManageFitService $manageFitService
    ) {}

    public function index(FitsDataTable $dataTable)
    {
        return $dataTable->render('pages.fits.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fit_name' => 'required|string|max:255',
            'fit_code' => 'required|string|max:50',
        ]);

        try {
            $this->manageFitService->store(FitDTO::fromRequest($request));
            return response()->json(['status' => 'success', 'message' => 'Data tipe potongan berhasil ditambahkan']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $fit = $this->manageFitService->fetch_by_id($id);
            return response()->json(['status' => 'success', 'data' => $fit]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, string $fitId)
    {
        $request->validate([
            'fit_name' => 'required|string|max:255',
            'fit_code' => 'required|string|max:50',
        ]);

        try {
            $this->manageFitService->update_service(FitDTO::fromRequest($request), $fitId);
            return response()->json(['status' => 'success', 'message' => 'Data tipe potongan berhasil diubah']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function destroy(string $fitId)
    {
        try {
            $this->manageFitService->destroy_fit($fitId);
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus data']);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }
}
