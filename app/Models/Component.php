<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Component extends Model
{
    use LogsActivity;
    //
    protected $guarded  = [];

    /*
    public function getConcentrationAttribute($attributes)
    {
        return $this->pivot->concentration;
    }

    protected $appends = ['concentration'];*/



    /**
     * The shops that belong to the product.
     */
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

}
