<?php

namespace App\Models;

use App\Models\Activities;
use App\Models\Galleries;
use App\Models\News;
use App\Models\NewsCategories;
use App\Models\OpdConfigs;
use App\Models\PlanningDocument;
use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();

        if ($user->opd_id !== null) {
            $query->where('opd_id', $user->opd_id);
        }

        return $query;
    }
}
