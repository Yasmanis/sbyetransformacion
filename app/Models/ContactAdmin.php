<?php

namespace App\Models;

use App\Services\BrevoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactAdmin extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'description'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->created_by = auth()->user()->id;
        });

        static::created(function ($obj) {
            $brevo = new BrevoService();
            $user = $obj->created_by()->first();
            $params = [
                'email' => $user->email,
                'name' => $user->full_name,
                'url' => env('APP_URL')
            ];
            $brevo->sendEmail('AVISO – contestar MENSAJE FORMULARIO CONTACTAR', 'admin.contact', $params);
        });
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
