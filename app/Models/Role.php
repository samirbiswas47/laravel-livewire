<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['role', 'status'])]
class Role extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'role',
        'status'
    ];

    public function user(){
        return $this->hasOne(User::class);
    }

}
