<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{

    protected $fillable = ['name', 'countryId'];

    public function area()
    {
        return $this->hasMany('App\Area');
    }

    public function city()
    {
        return $this->hasMany('App\City');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

}
