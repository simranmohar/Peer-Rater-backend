<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PeerGroup;
use App\Models\Category;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'peer_group_id'
    ];

    public function peerGroup()
    {
        return $this->belongsTo(PeerGroup::class);
    }

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function ratings() {
        return $this->hasMany(Rating::class);
    }
}
