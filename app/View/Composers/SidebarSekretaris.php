<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\UsulanSuratSrikandi;


class SidebarSekretaris
{

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        if(auth()->user()->is_sekma) {
            $usulanSuratSrikandiCount = UsulanSuratSrikandi::latest()->whereYear('created_at', date('Y'))->where('status', 'usulan')->count();
        } else
        {
            $usulanSuratSrikandiCount = UsulanSuratSrikandi::latest()->whereYear('created_at', date('Y'))->where('status', 'usulan')->where('pejabat_penanda_tangan', auth()->user()->unit_kerja)->count();
        }

        $view->with(
            [
                'usulanSuratSrikandiCount' => $usulanSuratSrikandiCount
            ]
        );
    }
}
