<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['parent_id', 'name', 'photo', 'dob', 'gender'])]
class Child extends Model
{
    use HasFactory;

    /**
     * Get the parent user that owns the child.
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}
