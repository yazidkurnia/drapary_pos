<?php

namespace App\Http\Controllers\ManageSleeve;

use App\DataTables\SleevesDataTable;
use App\Http\Controllers\Controller;
use App\Modules\ManageSleeves\Application\DTOs\SleeveDTO;
use App\Modules\ManageSleeves\Application\Services\ManageSleeveService;
use App\Modules\ManageSleeves\Domain\Repositories\ManageSleeveRepositoryInterface;
use Illuminate\Http\Request;

class ManageSleevesController extends Controller
{
    public function __construct(
        private ManageSleeveRepositoryInterface $sleeveRepository,
        private ManageSleeveService $manageSleeveService
    ) {}

    public function index(SleevesDataTable $dataTable)
    {
        return $dataTable->render('pages.sleeves.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sleeve_name' => 'required|string|max:255',
            'sleeve_code' => 'required|string|max:50',
        ]);

        try {
            $this->manageSleeveService->store(SleeveDTO::fromRequest($request));
            return response()->json(['status' => 'success', 'message' => 'Data tipe lengan berhasil ditambahkan']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $sleeve = $this->manageSleeveService->fetch_by_id($id);
            return response()->json(['status' => 'success', 'data' => $sleeve]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, string $sleeveId)
    {
        $request->validate([
            'sleeve_name' => 'required|string|max:255',
            'sleeve_code' => 'required|string|max:50',
        ]);

        try {
            $this->manageSleeveService->update_service(SleeveDTO::fromRequest($request), $sleeveId);
            return response()->json(['status' => 'success', 'message' => 'Data tipe lengan berhasil diubah']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function destroy(string $sleeveId)
    {
        try {
            $this->manageSleeveService->destroy_sleeve($sleeveId);
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus data']);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }
}
