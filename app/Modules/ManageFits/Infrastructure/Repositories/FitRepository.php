<?php

namespace App\Modules\ManageFits\Infrastructure\Repositories;

use App\Models\Fit;
use App\Modules\ManageFits\Domain\Repositories\ManageFitRepositoryInterface;
use App\Modules\ManageFits\Application\DTOs\FitDTO;

class FitRepository implements ManageFitRepositoryInterface
{
    public function find_fit_by_name(string $fitName): ?Fit
    {
        return Fit::where('fit_name', $fitName)->first();
    }

    public function find_fit_by_code(string $fitCode): ?Fit
    {
        return Fit::where('fit_code', $fitCode)->first();
    }

    public function find_fit_by_id(int $fitId): ?Fit
    {
        return Fit::find($fitId);
    }

    public function add_new_fit(FitDTO $fitDTO): ?Fit
    {
        return Fit::create([
            'fit_name' => $fitDTO->fitName,
            'fit_code' => $fitDTO->fitCode,
        ]);
    }

    public function update_fit(FitDTO $fitDTO, int $fitId): ?Fit
    {
        $fit = Fit::find($fitId);
        $fit->fit_name = $fitDTO->fitName;
        $fit->fit_code = $fitDTO->fitCode;
        $fit->save();

        return $fit;
    }

    public function delete_fit(int $fitId): ?Fit
    {
        $fit = Fit::find($fitId);
        $fit->deleted_at = date('Y-m-d H:i:s');
        $fit->save();

        return $fit;
    }
}
