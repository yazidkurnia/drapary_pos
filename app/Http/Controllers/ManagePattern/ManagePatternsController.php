<?php

namespace App\Http\Controllers\ManagePattern;

use App\DataTables\PatternsDataTable;
use App\Http\Controllers\Controller;
use App\Modules\ManagePatterns\Application\DTOs\PatternDTO;
use App\Modules\ManagePatterns\Application\Services\ManagePatternService;
use App\Modules\ManagePatterns\Domain\Repositories\ManagePatternRepositoryInterface;
use Illuminate\Http\Request;

class ManagePatternsController extends Controller
{
    public function __construct(
        private ManagePatternRepositoryInterface $patternRepository,
        private ManagePatternService $managePatternService
    ) {}

    public function index(PatternsDataTable $dataTable)
    {
        return $dataTable->render('pages.patterns.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pattern_name' => 'required|string|max:255',
            'pattern_code' => 'required|string|max:50',
        ]);

        try {
            $this->managePatternService->store(PatternDTO::fromRequest($request));
            return response()->json(['status' => 'success', 'message' => 'Data motif/pola berhasil ditambahkan']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $pattern = $this->managePatternService->fetch_by_id($id);
            return response()->json(['status' => 'success', 'data' => $pattern]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, string $patternId)
    {
        $request->validate([
            'pattern_name' => 'required|string|max:255',
            'pattern_code' => 'required|string|max:50',
        ]);

        try {
            $this->managePatternService->update_service(PatternDTO::fromRequest($request), $patternId);
            return response()->json(['status' => 'success', 'message' => 'Data motif/pola berhasil diubah']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function destroy(string $patternId)
    {
        try {
            $this->managePatternService->destroy_pattern($patternId);
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus data']);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }
}
