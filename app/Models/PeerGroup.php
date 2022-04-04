<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Survey;

/**
*
* @OA\Schema(
* required={"desciption"},
* @OA\Xml(name="PeerGroup"),
*
* @OA\Property(property="peer_group_id", type="integer", readOnly="true", example="1"),
* @OA\Property(property="user_id", type="integer", readOnly="false", example="1"),
* @OA\Property(property="description", type="string", readOnly="false", example="1"),
* @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
* @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
*           @OA\Property(
*              property="users",
*              type="array",
*              collectionFormat="multi",
*              @OA\Items(
*                 ref="#/components/schemas/User",
*                 example={"The email field is required.","The email must be a valid email address."},
*              )
*           )
* )
*
* Class PeerGroup
*
*/
class PeerGroup extends Model
{
    use HasFactory;

    protected $with = ['users'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }
}
