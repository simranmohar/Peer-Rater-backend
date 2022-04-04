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
 * @OA\Property(property="description", type="string", readOnly="false", example="1"),
 * @OA\Property(property="peer_group_id", type="integer", readOnly="false", example="1"),
 * @OA\Property(property="survey_id", type="integer", readOnly="false", example="1"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * )
 *
 * Class Category
 *
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'peer_group_id'
    ];

    public function survey() {
        return $this->belongsTo(Survey::class);
    }
}