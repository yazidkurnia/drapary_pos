<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sleeve extends Model
{
    use SoftDeletes;

    protected $fillable = ['sleeve_name', 'sleeve_code'];
}
