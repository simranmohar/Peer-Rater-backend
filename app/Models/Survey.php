<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PeerGroup;
use App\Models\Category;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

/**
 *
 * @OA\Schema(
 * required={"peer_group_id"},
 * @OA\Xml(name="User"),
 *
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="peer_group_id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * )
 *
 * Class Survey
 *
 */
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
