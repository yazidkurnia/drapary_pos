<?php

namespace App\Http\Controllers\ManageCollar;

use App\DataTables\CollarsDataTable;
use App\Http\Controllers\Controller;
use App\Modules\ManageCollars\Application\DTOs\CollarDTO;
use App\Modules\ManageCollars\Application\Services\ManageCollarService;
use App\Modules\ManageCollars\Domain\Repositories\ManageCollarRepositoryInterface;
use Illuminate\Http\Request;

class ManageCollarsController extends Controller
{
    public function __construct(
        private ManageCollarRepositoryInterface $collarRepository,
        private ManageCollarService $manageCollarService
    ) {}

    public function index(CollarsDataTable $dataTable)
    {
        return $dataTable->render('pages.collars.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'collar_name' => 'required|string|max:255',
            'collar_code' => 'required|string|max:50',
        ]);

        try {
            $this->manageCollarService->store(CollarDTO::fromRequest($request));
            return response()->json(['status' => 'success', 'message' => 'Data tipe leher berhasil ditambahkan']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $collar = $this->manageCollarService->fetch_by_id($id);
            return response()->json(['status' => 'success', 'data' => $collar]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, string $collarId)
    {
        $request->validate([
            'collar_name' => 'required|string|max:255',
            'collar_code' => 'required|string|max:50',
        ]);

        try {
            $this->manageCollarService->update_service(CollarDTO::fromRequest($request), $collarId);
            return response()->json(['status' => 'success', 'message' => 'Data tipe leher berhasil diubah']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function destroy(string $collarId)
    {
        try {
            $this->manageCollarService->destroy_collar($collarId);
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus data']);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }
}
