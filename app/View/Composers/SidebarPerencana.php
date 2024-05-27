<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\UsulanSuratSrikandi;
use App\Models\TargetIkuUnitKerja;



class SidebarPerencana
{

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $year = date('Y');
        $targetIkuUnitKerjaCount = TargetIkuUnitKerja::latest()->whereYear('created_at', $year)->where('status', 1)->count();
        $realisasiIkuUnitKerjaCount = TargetIkuUnitKerja::latest()->whereYear('created_at', $year)->where('status', 2)->count();
        $evaluasiIkuUnitKerjaCount = TargetIkuUnitKerja::latest()->whereYear('created_at', $year)->where('status', 3)->count();

        $view->with(
            [
                'targetIkuUnitKerjaCount' => $targetIkuUnitKerjaCount,
                'realisasiIkuUnitKerjaCount' => $realisasiIkuUnitKerjaCount,
                'evaluasiIkuUnitKerjaCount' => $evaluasiIkuUnitKerjaCount
            ]
        );
    }
}
