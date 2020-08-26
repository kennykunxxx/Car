<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    
    public function abilities()
    {
        return $this->belongsToMany(Ability::class, 'ability_role', 'role_id', 'ability_id')->withTimeStamps();
    }

    public function assignAbility($ability)
    {
        $this->abilities()->sync($ability, false);
    }
}
