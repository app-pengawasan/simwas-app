<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\TimKerja;


class SidebarAdmin
{

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $id_pegawai = auth()->user()->id;
        $timKerjaPenyusunanCount = TimKerja::with('ketua', 'iku')->where('id_ketua', $id_pegawai)->where('status', 2)->where('tahun', date('Y'))->get()->count();


        $view->with(
            [
                'timKerjaPenyusunanCount' => $timKerjaPenyusunanCount
            ]
        );
    }
}
