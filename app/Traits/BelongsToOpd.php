<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToOpd
{
    /**
     * Boot trait ini secara otomatis oleh Laravel.
     */
    protected static function bootBelongsToOpd()
    {
        // 1. FILTERING: Otomatis membatasi data yang muncul di Web Anak (PUPR, PKK, dll)
        $slug = getenv('APP_ID');
        if ($slug) {
            static::addGlobalScope('filterOPD', function (Builder $builder) use ($slug) {
                // Mencari data yang memiliki relasi ke OPD dengan slug dari .env
                $builder->whereHas('opd', function ($query) use ($slug) {
                    $query->where('slug', $slug);
                });
            });
        }

        // 2. AUTO-ASSIGN: Isi kolom opd_id otomatis saat Admin simpan data di Filament
        static::creating(function ($model) {
            if (auth()->check() && auth()->user()->opd_id) {
                $model->opd_id = auth()->user()->opd_id;
            }
        });
    }

    /**
     * Relasi standar ke Model OPD
     */
    public function opd()
    {
        return $this->belongsTo(\App\Models\Opd::class, 'opd_id');
    }
}
