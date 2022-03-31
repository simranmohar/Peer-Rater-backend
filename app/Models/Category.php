<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Survey;

class Category extends Model
{
    use HasFactory;

    public function survey() {
        return $this->belongsTo(Survey::class);
    }
}