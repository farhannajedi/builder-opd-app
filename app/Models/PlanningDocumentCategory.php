<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanningDocumentCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function documents()
    {
        return $this->hasMany(PlanningDocument::class, 'category_id');
    }
}
