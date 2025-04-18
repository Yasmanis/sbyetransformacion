<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $fillable = ['contact_id', 'name', 'path'];

    public $timestamps = false;

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
