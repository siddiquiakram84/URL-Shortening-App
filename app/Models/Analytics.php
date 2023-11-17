<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'url_id', 'user_agent', 'ip_address'
    ];

    public function url()
    {
        return $this->belongsTo(Url::class);
    }
}
