<?php

namespace App\Http\Controllers\ManageGender;

use App\DataTables\GendersDataTable;
use App\Http\Controllers\Controller;
use App\Modules\ManageGenders\Application\DTOs\GenderDTO;
use App\Modules\ManageGenders\Application\Services\ManageGenderService;
use App\Modules\ManageGenders\Domain\Repositories\ManageGenderRepositoryInterface;
use Illuminate\Http\Request;

class ManageGendersController extends Controller
{
    public function __construct(
        private ManageGenderRepositoryInterface $genderRepository,
        private ManageGenderService $manageGenderService
    ) {}

    public function index(GendersDataTable $dataTable)
    {
        return $dataTable->render('pages.genders.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gender_name' => 'required|string|max:255',
            'gender_code' => 'required|string|max:50',
        ]);

        try {
            $this->manageGenderService->store(GenderDTO::fromRequest($request));
            return response()->json(['status' => 'success', 'message' => 'Data jenis kelamin berhasil ditambahkan']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $gender = $this->manageGenderService->fetch_by_id($id);
            return response()->json(['status' => 'success', 'data' => $gender]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, string $genderId)
    {
        $request->validate([
            'gender_name' => 'required|string|max:255',
            'gender_code' => 'required|string|max:50',
        ]);

        try {
            $this->manageGenderService->update_service(GenderDTO::fromRequest($request), $genderId);
            return response()->json(['status' => 'success', 'message' => 'Data jenis kelamin berhasil diubah']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function destroy(string $genderId)
    {
        try {
            $this->manageGenderService->destroy_gender($genderId);
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus data']);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }
}
