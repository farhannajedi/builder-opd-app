<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'description',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function config()
    {
        return $this->hasOne(OpdConfigs::class);
    }
}
