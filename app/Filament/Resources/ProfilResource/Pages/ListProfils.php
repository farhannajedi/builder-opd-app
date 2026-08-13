<?php

namespace App\Filament\Resources\ProfilResource\Pages;

use App\Filament\Resources\ProfilResource;
use App\Models\Profil;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListProfils extends ListRecords
{
    protected static string $resource = ProfilResource::class;

    public function mount(): void
    {
        parent::mount();

        $user = Auth::user();

        // Jika user adalah Admin OPD dan data profilnya sudah dibuat,
        // langsung alihkan ke halaman Edit profil milik OPD tersebut
        if ($user && $user->opd_id) {
            $profil = Profil::where('opd_id', $user->opd_id)->first();

            if ($profil) {
                $this->redirect(ProfilResource::getUrl('edit', ['record' => $profil->id]));
            }
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Profil Instansi'),
        ];
    }
}
