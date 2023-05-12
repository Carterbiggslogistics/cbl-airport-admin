<?php

namespace App;

use App\Traits\Deviceable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Rider extends Authenticatable implements JWTSubject
{
    use SoftDeletes, Notifiable, Deviceable;

    // protected $guarded = ['password'];
    protected $hidden = ['password'];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'email' => $this->email,
            'fullname' => $this->fullname
        ];
    }

    public function getFullnameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    } //end method getFullNameAttribute

    public function setFullnameAttribute($fullname)
    {
        $nameArray = explode(' ', \preg_replace('/\\s+/', ' ', trim($fullname)));

        if (count($nameArray) < 2) {
            throw new \Exception('The fullname field must have a first and last name');
        }

        $this->firstName = $nameArray[0];
        $this->lastName = $nameArray[1];
    } //end method setFullnameAttribute

    public function sampleRequests()
    {
        return $this->hasMany(Order::class, 'rider_id');
    } //end method sampleRequests

    public function packRequests()
    {
        return $this->hasMany(PackRequest::class, 'rider_id');
    } //end method packRequests
}//end class Rider
