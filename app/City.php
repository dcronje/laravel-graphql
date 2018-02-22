<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $fillable = ['name', 'countryId', 'regionId'];

    public function area()
    {
        return $this->hasMany('App\Area');
    }

    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

}
