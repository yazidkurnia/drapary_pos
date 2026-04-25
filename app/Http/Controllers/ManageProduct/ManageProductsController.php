<?php

namespace App\Http\Controllers\ManageProduct;

use App\DataTables\ProductsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Modules\ManageProducts\Application\DTOs\ProductDTO;
use App\Modules\ManageProducts\Application\Services\ManageProductService;
use App\Modules\ManageProducts\Domain\Repositories\ManageProductRepositoryInterface;
use Illuminate\Http\Request;

class ManageProductsController extends Controller
{
    public function __construct(
        private ManageProductRepositoryInterface $productRepository,
        private ManageProductService $manageProductService
    ) {}

    public function index(ProductsDataTable $dataTable)
    {
        $brands = Brand::orderBy('brand_name')->get();
        return $dataTable->render('pages.products.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_id'     => 'required|exists:brands,id',
            'product_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
        ]);

        try {
            $this->manageProductService->store(ProductDTO::fromRequest($request));
            return response()->json(['status' => 'success', 'message' => 'Produk berhasil ditambahkan']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $product = $this->manageProductService->fetch_by_id($id);
            return response()->json(['status' => 'success', 'data' => $product]);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, string $productId)
    {
        $request->validate([
            'brand_id'     => 'required|exists:brands,id',
            'product_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
        ]);

        try {
            $this->manageProductService->update_service(ProductDTO::fromRequest($request), $productId);
            return response()->json(['status' => 'success', 'message' => 'Produk berhasil diubah']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function destroy(string $productId)
    {
        try {
            $this->manageProductService->destroy_product($productId);
            return response()->json(['status' => 'success', 'message' => 'Berhasil menghapus data']);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function byBrand(int $brandId)
    {
        $products = $this->manageProductService->fetch_products_by_brand($brandId);
        return response()->json($products);
    }
}
