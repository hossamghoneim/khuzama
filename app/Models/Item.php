<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Bnb\Laravel\Attachments\HasAttachment;
use Spatie\Activitylog\Traits\LogsActivity;


class Item extends Model
{
    //
    use HasAttachment,
        LogsActivity;

    protected $guarded = [];

    //protected $with = ['components'];

    //protected static $logAttributes = ['name', 'text'];


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
            $model->components()->detach();
        });

    }


    public function components(){

        return $this->belongsToMany(Component::class,'items_components','item_id','component_id')->withPivot('concentration');
    }

    public function componentsSum(){

        return $this->belongsToMany(Component::class,'items_components','item_id','component_id')->sum('concentration');
    }

    public function version()
    {
        $version = Item::where([
                ['name' ,'=', $this->name ],
                ['print_code' ,'=', $this->print_code ],
            ])->get()->count() + 1;
        return "-v$version";
    }

}
