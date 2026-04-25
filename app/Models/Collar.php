<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collar extends Model
{
    use SoftDeletes;

    protected $fillable = ['collar_name', 'collar_code'];
}
