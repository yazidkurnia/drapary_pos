<?php

namespace App\Modules\ManageProductVariants\Application\Services;

use App\Models\ProductVariant;
use App\Models\ProductVariantImage;
use App\Modules\ManageProductVariants\Application\DTOs\ProductVariantDTO;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Modules\ManageProductVariants\Domain\Repositories\ManageProductVariantRepositoryInterface;
use App\Modules\ManageProductVariants\Domain\Usecases\CreateManageProductVariantUsecase;
use App\Modules\ManageProductVariants\Domain\Usecases\UpdateManageProductVariantUsecase;
use Illuminate\Support\Facades\Crypt;

class ManageProductVariantService
{
    public function __construct(
        private CreateManageProductVariantUsecase $createVariantUsecase,
        private UpdateManageProductVariantUsecase $updateVariantUsecase,
        private ManageProductVariantRepositoryInterface $variantRepository
    ) {}

    public function store(ProductVariantDTO $dto): ProductVariant
    {
        if ($this->variantRepository->find_variant_by_sku($dto->sku)) {
            throw new \InvalidArgumentException('SKU telah digunakan!');
        }

        return $this->createVariantUsecase->store($dto);
    }

    public function fetch_by_id(string $variantId): ProductVariant
    {
        $id = (int) Crypt::decryptString($variantId);

        if ($id == 0) {
            throw new \InvalidArgumentException('Varian yang dipilih tidak valid!');
        }

        $variant = $this->variantRepository->find_variant_by_id($id);

        if (empty($variant)) {
            throw new \InvalidArgumentException('Data varian tidak ditemukan!');
        }

        $variant->load(['product.brand', 'color', 'size', 'material', 'fit', 'sleeve', 'collar', 'pattern', 'gender', 'unit', 'images']);
        $variant->mvid = Crypt::encryptString($variant->id);

        $variant->images->each(function ($img) {
            $img->encrypted_id  = Crypt::encryptString($img->id);
            $img->url           = Storage::url($img->image_path);
        });

        return $variant;
    }

    public function update_service(ProductVariantDTO $dto, string $variantId): ProductVariant
    {
        $id = (int) Crypt::decryptString($variantId);

        $variant = $this->variantRepository->find_variant_by_id($id);

        if (empty($variant)) {
            throw new \InvalidArgumentException('Data varian tidak ditemukan!');
        }

        $existing = $this->variantRepository->find_variant_by_sku($dto->sku);
        if ($existing && $existing->id !== $id) {
            throw new \InvalidArgumentException('SKU telah digunakan!');
        }

        return $this->updateVariantUsecase->update_usecase($dto, $id);
    }

    /** @param UploadedFile[] $images */
    public function store_images(ProductVariant $variant, array $images): void
    {
        $sortOrder = $variant->images()->max('sort_order') ?? -1;

        foreach ($images as $image) {
            $path = $image->store("product-variants/{$variant->id}", 'public');
            ProductVariantImage::create([
                'product_variant_id' => $variant->id,
                'image_path'         => $path,
                'sort_order'         => ++$sortOrder,
                'is_primary'         => $sortOrder === 0,
            ]);
        }
    }

    public function destroy_image(string $encryptedImageId): void
    {
        $id    = (int) Crypt::decryptString($encryptedImageId);
        $image = ProductVariantImage::findOrFail($id);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();
    }

    public function destroy_variant(string $variantId): ProductVariant
    {
        $id = (int) Crypt::decryptString($variantId);

        $variant = $this->variantRepository->find_variant_by_id($id);

        if (empty($variant)) {
            throw new \InvalidArgumentException('Data varian tidak ditemukan!');
        }

        return $this->variantRepository->delete_variant($id);
    }
}
