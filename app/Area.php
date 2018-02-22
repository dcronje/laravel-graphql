<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    protected $fillable = ['name', 'countryId', 'regionId', 'cityId'];

    public function city()
    {
        return $this->belongsTo('App\City');
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
