<?php

namespace App\Http\Controllers\ManageColor;

use App\DataTables\ColorsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Modules\ManageColors\Domain\Repositories\ManageColorRepositoryInterface;
use Illuminate\Http\Request;
use App\Modules\ManageColors\Application\DTOs\ColorDTO;
use App\Modules\ManageColors\Application\Services\ManageColorService;
use Illuminate\Support\Facades\Crypt;

class ManageColorsController extends Controller
{
    public function __construct(
        private ManageColorRepositoryInterface $colorRepository,
        private ManageColorService $manageColorService
        ) {}

    public function index(ColorsDataTable $dataTable)
    {
        return $dataTable->render('pages.colors.index');
    }

    public function create()
    {
        return view('pages.colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'color_name' => 'required|string|max:255',
            'hexa_code'  => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $colorDTO = ColorDTO::fromRequest($request);

        try {
            $this->manageColorService->store($colorDTO);
            return response()->json([
                'status' => 'success',
                'message' => 'Data warna berhasil ditambahkan'
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param int $id (manage colors id)
     * return object
     */
    public function edit(string $id)
    {
        try {
            $color = $this->manageColorService->fetch_by_id($id);
            return response()->json([
                'status' => 'success',
                'data'   => $color
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, string $colorId)
    {
        $request->validate([
            'color_name' => 'required|string|max:255',
            'hexa_code'  => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/'
        ]);

        $colorDTO = ColorDTO::fromRequest($request);

        try {
            $this->manageColorService->update_service($colorDTO, $colorId);
            return response()->json([
                'status' => 'success',
                'message' => 'Data warna berhasil ditambahkan'
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(string $colorId)
    {
        try {
            $this->manageColorService->destroy_color($colorId);

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data'
            ]);
        } catch (\Throwable $e) {
            //throw $th;
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }
}
