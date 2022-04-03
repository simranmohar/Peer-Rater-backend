<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Survey;

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
