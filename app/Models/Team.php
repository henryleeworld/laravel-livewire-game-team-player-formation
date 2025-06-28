<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The users that belong to the team.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(['position']);
    }
}
