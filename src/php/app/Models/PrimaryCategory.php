<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimaryCategory extends Model
{
    public function secondaryCategories(){
        return $this->hasMany(SecondaryCategory::class);
    }
    use HasFactory;
}
