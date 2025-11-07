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

    public function newsCategories()
    {
        return $this->hasMany(NewsCategories::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function galleries()
    {
        return $this->hasMany(Galleries::class);
    }

    public function activities()
    {
        return $this->hasMany(Activities::class);
    }

    public function document()
    {
        return $this->hasMany(PlanningDocument::class);
    }
}
