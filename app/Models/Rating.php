<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Survey;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient_id',
        'category_id',
        'peer_group_id',
        'survey_id',
        'rating'
    ];

    public function survey() {
        return $this->belongsTo(Survey::class);
    }
}
