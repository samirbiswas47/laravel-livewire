<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['menu', 'status'])]

class Menu extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'menu',
        'status'
    ];
}
