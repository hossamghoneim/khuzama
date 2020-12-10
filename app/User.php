<?php

namespace App;

use App\Notifications\ResetPassword;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Notifiable,
        HasRoles;

    /**
     * Set confirmation tokens table.
     *
     * @const string
     */
    const CONFIRMATION_TOKENS_TABLE = 'confirmation_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'username', 'email','email_confirmed','mobile','mobile_confirmed',
        'password','last_login','last_active',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }


    /**
     * Listen To Model Event (create-update).
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();


        self::creating(function($model){

            $model->identification_code = generateIdentificationCode();
        });

        self::created(function ($model) {

            self::generateTokens(['email','mobile'], $model->email,$model->identification_code);

        });

        self::updated(function ($model){

            if ($model->mobile != $model->getOriginal('mobile')) {

                self::generateTokens(['mobile'],null, $model->identification_code);
            }

            if ($model->email != $model->getOriginal('email')) {

                self::generateTokens(['email'],$model->email, $model->identification_code);
            }

        });

    }


    /**
     * Get the user's name.
     *
     * @param  string  $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }



    /**
     * Generate User tokens.
     *
     * @param  array  $types
     * @param  string  $email
     * @param  string  $code
     * @return void
     */
    private static function generateTokens($types,$email,$code){

        $inputs = [];

        if(in_array('email',$types)){

            $inputs['email_confirmation_token'] = str_limit(md5($email . str_random()), 25, '');
        }

        if(in_array('mobile',$types)){

            $inputs['mobile_confirmation_token'] = rand('111111','999999');
        }


        $table =  DB::table(self::CONFIRMATION_TOKENS_TABLE);

        $row =$table->where('identification_code',$code);

        if($row->exists()){

            $inputs['updated_at'] = Carbon::now();
            $row->update($inputs);

        }else{

            $inputs['identification_code'] = $code;
            $inputs['created_at'] = Carbon::now();
            $inputs['updated_at'] = Carbon::now();
            $table->insert($inputs);
        }
    }

    /**
     * Verify User Email token.
     *
     * @param  string  $email_token
     * @return boolean
     */
    public function verifyEmailToken($email_token){

        if($this->email_confirmed){
            return true;
        }

        $row = DB::table(self::CONFIRMATION_TOKENS_TABLE)
            ->where('identification_code', $this->identification_code)
            ->where('email_confirmation_token', $email_token);

        if ( $row->exists() ){

            $this->update(['email_confirmed' => 1]);

            $this->mobile_confirmed == 1 ?  $row->delete() : $row->update(['email_confirmation_token' => null]);

            return true;
        }
    }

    /**
     * Verify User Email token.
     *
     * @param  string  $mobile_token
     * @return boolean
     */
    public function verifyMobileToken($mobile_token){

        $row = DB::table(self::CONFIRMATION_TOKENS_TABLE)

            ->where('identification_code', $this->identification_code)
            ->where('mobile_confirmation_token',$mobile_token);

        if ($row->exists()){

            $this->update(['mobile_confirmed' => 1]);

            $this->email_confirmed == 1 ?  $row->delete() : $row->update(['mobile_confirmation_token' => null]);

            return true;
        }
    }

}
