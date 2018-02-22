<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $fillable = ['name'];

    public function area()
    {
        return $this->hasMany('App\Area');
    }

    public function city()
    {
        return $this->hasMany('App\City');
    }

    public function region()
    {
        return $this->belongsTo('App\Region');
    }

}
