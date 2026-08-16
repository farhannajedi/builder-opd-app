<?php

namespace App\Models;

use App\Models\Activities;
use App\Models\Announcement;
use App\Models\Galleries;
use App\Models\News;
use App\Models\NewsCategories;
use App\Models\OpdConfigs;
use App\Models\Page;
use App\Models\PlanningDocument;
use App\Models\Profil;
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

    public function planningDocumentCategory()
    {
        return $this->hasMany(PlanningDocumentCategory::class);
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

    public function announcement()
    {
        return $this->hasMany(Announcement::class);
    }

    public function profil()
    {
        return $this->hasMany(Profil::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function menu()
    {
        return $this->hasMany(PageMenu::class);
    }

    // ditulis di filament
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
