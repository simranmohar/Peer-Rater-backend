<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Survey;

/**
 *
 * @OA\Schema(
 *
 * required={"recipient_id"},
 * required={"category_id"},
 * required={"peer_group_id"},
 * required={"survey_id"},
 * required={"rating"},
 * @OA\Xml(name="User"),
 *
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="writer_id", type="integer", readOnly="false", example="1"),
 * @OA\Property(property="recipient_id", type="integer", readOnly="false", example="1"),
 * @OA\Property(property="category_id", type="integer", readOnly="false", example="1"),
 * @OA\Property(property="peer_group_id", type="integer", readOnly="false", example="1"),
 * @OA\Property(property="survey_id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="rating", type="string", readOnly="false", format="string", description="User rating content", example="100"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * )
 *
 * Class Rating
 *
 */
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
