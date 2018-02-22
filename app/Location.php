<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    protected $fillable = ['name', 'building', 'address', 'longitude', 'latitude', 'countryId', 'regionId', 'cityId', 'areaId', 'timezone'];

    public function area() {
        return $this->belongsTo('App/Area');
    }

    public function city() {
        return $this->belongsTo('App/City');
    }

    public function region() {
        return $this->belongsTo('App/Region');
    }

    public function country() {
        return $this->belongsTo('App/Country');
    }

}
