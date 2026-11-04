<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['permission', 'status'])]
class Permission extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'permission',
        'status'
    ];
}
