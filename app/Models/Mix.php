<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Bnb\Laravel\Attachments\HasAttachment;


class Mix extends Model
{
    //
    use HasAttachment,
        LogsActivity;

    protected $guarded = [];


    /**
     * Listen To Model Event (create-update).
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::deleting(function($model){

            $model->attachments->each->delete();
            $model->items()->detach();
        });

    }

    public function items(){

        return $this->belongsToMany(Item::class,'mixes_items','mix_id','item_id')->withPivot(['percentage']);
    }


}
