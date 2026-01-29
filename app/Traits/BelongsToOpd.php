<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToOpd
{
    /**
     * Boot trait ini secara otomatis oleh Laravel.
     */
    protected static function bootBelongsToOpd()
    {
        // jangan jalan di model opd
        if ((new static)->getTable() === 'opds') {
            return;
        }

        // Otomatis membatasi data yang muncul di Web child (PUPR, PKK, dll)
        $slug = getenv('APP_ID');
        if ($slug) {
            static::addGlobalScope('filterOPD', function (Builder $builder) use ($slug) {
                // Mencari data yang memiliki relasi ke OPD dengan slug dari .env
                $builder->whereHas('opd', function ($query) use ($slug) {
                    $query->where('slug', $slug);
                });
            });
        }

        // Isi kolom opd_id otomatis saat Admin simpan data di halaman admin
        static::creating(function ($model) {
            if (auth::check() && auth::user()->opd_id) {
                $model->opd_id = auth::user()->opd_id;
            }
        });
    }

    /**
     * Relasi standar ke Model OPD
     */
    public function opd()
    {
        // return $this->belongsTo(\App\Models\Opd::class, 'opd_id');
    }
}
