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
        $year = date('Y');
        $timKerjaPenyusunanCount =TimKerja::with('ketua', 'iku')->whereIn('status', [0,1])->where('tahun', $year)->get()->count();


        $view->with(
            [
                'timKerjaPenyusunanCount' => $timKerjaPenyusunanCount
            ]
        );
    }
}
