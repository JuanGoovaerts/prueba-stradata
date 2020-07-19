<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublicFigure extends Model
{
    protected $guarded = [];

    public function scopeSearch($query, $search)
    {
        //Boolean
        $query
            ->selectRaw('*, match(nombre) against(? in natural language mode) as score', [$search])
            ->whereRaw('match(nombre) against(? in natural language mode)', [$search]);
    }
}
