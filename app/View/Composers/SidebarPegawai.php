<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\NormaHasil;
use App\Models\TimKerja;

class SidebarPegawai
{

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $id_pegawai = auth()->user()->id;
        $id_unitkerja = auth()->user()->unit_kerja;

        // Usulan Norma Hasil Ketua
        $usulanNormaHasilCountSidebar = NormaHasil::with('normaHasilAccepted')->where('user_id', $id_pegawai)->where('status_norma_hasil', 'diperiksa')->whereYear('created_at', date('Y'))->count();

        // Penyusunan Tim Kerja
        $timKerjaPenyusunanCountSidebar = TimKerja::with('ketua', 'iku')->where('id_ketua', $id_pegawai)->whereIn('status', [0,1,2,3])->where('tahun', '2024')->get()->count();

        // Persetujuan Tim Kerja
        $timKerjaPersetujuanCountSidebar = TimKerja::with('ketua', 'iku')->where('unitkerja', $id_unitkerja)
        ->where('status', 5)
        ->where('tahun', date('Y'))
        ->count();

        $view->with(
            [
                'usulanNormaHasilCountSidebar' => $usulanNormaHasilCountSidebar,
                'timKerjaPenyusunanCountSidebar' => $timKerjaPenyusunanCountSidebar,
                'timKerjaPersetujuanCountSidebar' => $timKerjaPersetujuanCountSidebar
            ]
        );
    }
}
