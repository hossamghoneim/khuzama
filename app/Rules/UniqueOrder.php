<?php

namespace App\Rules;

use App\Models\Order;
use Illuminate\Contracts\Validation\Rule;

class UniqueOrder implements Rule
{
    protected $other;
    protected $update;

    /**
     * Create a new rule instance.
     *
     * @return void
     * @param $other string
     */
    public function __construct($other,$update = null)
    {
        //
        $this->other = $other;
        $this->update = $update;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        if(!$this->update){
            return Order::query()->where('client_id',$this->other )
                ->where('product_id',$value)->exists() ? false: true;
        }else{
            return Order::query()->where('client_id',$this->other )
                ->where('product_id',$value)->where('id','!=',$this->update->id)->exists() ? false: true;
        }


    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This order is already exists!.';
    }
}
