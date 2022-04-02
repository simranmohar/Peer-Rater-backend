<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
