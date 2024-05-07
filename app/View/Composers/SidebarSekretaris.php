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
        $usulanSuratSrikandiCount = UsulanSuratSrikandi::latest()->whereYear('created_at', date('Y'))->where('status', 'usulan')->count();

        $view->with(
            [
                'usulanSuratSrikandiCount' => $usulanSuratSrikandiCount
            ]
        );
    }
}
