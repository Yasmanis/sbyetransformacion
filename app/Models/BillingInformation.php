<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingInformation extends Model
{
    use HasFactory;

    protected $table = 'users_billing_information';

    protected $fillable = ['name', 'surname', 'nif_cif', 'road', 'address', 'postal_code', 'province', 'country_id', 'predetermined'];

    protected $appends = ['country_str', 'full_name'];

    protected $casts = [
        'predetermined' => 'boolean'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->user_id = auth()->user()->id;
        });
        static::created(function ($obj) {
            $obj->changePredetermined();
        });
        static::updated(function ($obj) {
            $obj->changePredetermined();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function getCountryStrAttribute()
    {
        return $this->country->name;
    }

    public function getFullNameAttribute()
    {
        return sprintf('%s %s', $this->name, $this->surname);
    }

    public function changePredetermined()
    {
        if ($this->predetermined) {
            $object = BillingInformation::where('predetermined', true)->where('id', '!=', $this->id)->first();
            if ($object) {
                $object->predetermined = false;
                $object->save();
            }
        }
    }
}