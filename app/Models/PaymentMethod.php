<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'users_payment_methods';

    protected $fillable = ['name', 'number', 'defeat', 'predetermined', 'billing_information_id'];

    protected $casts = [
        'predetermined' => 'boolean'
    ];

    protected $appends = ['expired'];

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

    public function getExpiredAttribute()
    {
        $date = Carbon::createFromFormat('d/m/Y', sprintf('01/%s', $this->defeat));
        return $date->lt(Carbon::now());
    }

    public function changePredetermined()
    {
        if ($this->predetermined) {
            $object = PaymentMethod::where('predetermined', true)->where('id', '!=', $this->id)->first();
            if ($object) {
                $object->predetermined = false;
                $object->save();
            }
        }
    }
}
