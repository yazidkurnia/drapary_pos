<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fit extends Model
{
    use SoftDeletes;

    protected $fillable = ['fit_name', 'fit_code'];
}
