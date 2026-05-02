<?php

namespace App\Http\Controllers\ManageProductVariant;

use App\DataTables\ProductVariantsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Material;
use App\Models\Fit;
use App\Models\Sleeve;
use App\Models\Collar;
use App\Models\Pattern;
use App\Models\Gender;
use App\Models\Unit;
use App\Modules\ManageProductVariants\Application\DTOs\ProductVariantDTO;
use App\Modules\ManageProductVariants\Application\Services\ManageProductVariantService;
use App\Modules\ManageProductVariants\Domain\Repositories\ManageProductVariantRepositoryInterface;
use Illuminate\Http\Request;

class ManageProductVariantsController extends Controller
{
    public function __construct(
        private ManageProductVariantRepositoryInterface $variantRepository,
        private ManageProductVariantService $manageVariantService
    ) {}

    public function index(ProductVariantsDataTable $dataTable)
    {
        $brands    = Brand::orderBy('brand_name')->get();
        $colors    = Color::orderBy('color_name')->get();
        $sizes     = Size::orderBy('size_name')->get();
        $materials = Material::orderBy('material_name')->get();
        $fits      = Fit::orderBy('fit_name')->get();
        $sleeves   = Sleeve::orderBy('sleeve_name')->get();
        $collars   = Collar::orderBy('collar_name')->get();
        $patterns  = Pattern::orderBy('pattern_name')->get();
        $genders   = Gender::orderBy('gender_name')->get();
        $units     = Unit::orderBy('unit_name')->get();

        return $dataTable->render('pages.product-variants.index', compact(
            'brands', 'colors', 'sizes', 'materials',
            'fits', 'sleeves', 'collars', 'patterns', 'genders', 'units'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sku'        => 'required|string|max:100',
            'price'      => 'required|numeric|min:0',
            'stock'      => 'required|integer|min:0',
            'images.*'   => 'nullable|image|max:2048',
        ]);

        try {
            $variant = $this->manageVariantService->store(ProductVariantDTO::fromRequest($request));

            if ($request->hasFile('images')) {
                $this->manageVariantService->store_images($variant, $request->file('images'));
            }

            return response()->json(['status' => 'success', 'message' => 'Varian produk berhasil ditambahkan']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $variant = $this->manageVariantService->fetch_by_id($id);
            return response()->json(['status' => 'success', 'data' => $variant]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, string $variantId)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sku'        => 'required|string|max:100',
            'price'      => 'required|numeric|min:0',
            'stock'      => 'required|integer|min:0',
            'images.*'   => 'nullable|image|max:2048',
        ]);

        try {
            $variant = $this->manageVariantService->update_service(ProductVariantDTO::fromRequest($request), $variantId);

            if ($request->hasFile('images')) {
                $this->manageVariantService->store_images($variant, $request->file('images'));
            }

            return response()->json(['status' => 'success', 'message' => 'Varian produk berhasil diubah']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function destroy(string $variantId)
    {
        try {
            $this->manageVariantService->destroy_variant($variantId);
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus data']);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function destroyImage(string $imageId)
    {
        try {
            $this->manageVariantService->destroy_image($imageId);
            return response()->json(['status' => 'success', 'message' => 'Gambar berhasil dihapus']);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }
}
