<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\PelaksanaTugas;
use App\Models\RealisasiKinerja;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;

class MonitoringPegawaiExport implements FromCollection, WithHeadings, WithEvents
{
    protected $unit, $year;

    function __construct($unit, $year) {
            $this->unit = $unit;
            $this->year = $year;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                       
        if ($this->unit == null || $this->unit == "undefined") {
            if (auth()->user()->unit_kerja == '8010') $this->unit = '8000';
            else $this->unit = auth()->user()->unit_kerja;
        } else {
            if (auth()->user()->unit_kerja != '8010' && auth()->user()->unit_kerja != '8000' && $this->unit != auth()->user()->unit_kerja)
                return redirect()->to('/');
        }

        if ($this->year == null) {
            $this->year = date('Y');
        } 

        $unit = $this->unit;
        $year = $this->year;

        $bulan_objek = DB::table('laporan_objek_pengawasans as t1')
                            ->join('objek_pengawasans as t2', 't1.id_objek_pengawasan', '=', 't2.id_opengawasan')
                            ->selectRaw('t1.id, t1.id_objek_pengawasan, t1.month, t1.status, t2.*')
                            ->where('status', 1);

        if ($this->unit == '8000') {
            $pelaksana_tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                                        $query->where('tahun', $year);
                                })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as jam_pengawasan, pelaksana_tugas.id_rencanakerja')
                                ->leftJoinSub($bulan_objek, 't', function (JoinClause $join) {
                                    $join->on('pelaksana_tugas.id_rencanakerja', '=', 't.id_rencanakerja');
                                })->get(); 
        } else {
            $pelaksana_tugas = PelaksanaTugas::whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year, $unit) {
                                        $query->where('tahun', $year);
                                        $query->where('unitkerja', $unit);
                                })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as jam_pengawasan, pelaksana_tugas.id_rencanakerja')
                                ->leftJoinSub($bulan_objek, 't', function (JoinClause $join) {
                                    $join->on('pelaksana_tugas.id_rencanakerja', '=', 't.id_rencanakerja');
                                })->get(); 
        } 

        $realisasi = RealisasiKinerja::whereRelation('pelaksana.rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                                            $query->where('tahun', $year);
                                        })->get();

        $events = Event::whereRelation('laporanOPengawasan.objekPengawasan.rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                            $query->where('tahun', $year);
                        })->get();
                        
        $data = collect([]);

        foreach ($pelaksana_tugas as $pelaksana) {
            $row    = array(); 
            $row['tim']  = $pelaksana->rencanaKerja->proyek->timKerja->nama;
            $row['pjk']  = $pelaksana->rencanaKerja->proyek->timKerja->ketua->name;
            $row['tugas']  = $pelaksana->rencanaKerja->tugas;
            $row['nama']  = $pelaksana->user->name;
            $row['output']  = count($pelaksana->rencanaKerja->hasilKerja->masterKinerja) == 0 ? 'Belum diisi' : 
                            $pelaksana->rencanaKerja->hasilKerja->masterKinerja[0]->masterKinerjaPegawai->where('pt_jabatan', $pelaksana->pt_jabatan )->first()->hasil_kerja;

            if ($pelaksana->id_objek_pengawasan == null) { //jika tugas belum ditentukan laporannya
                $row['objek']  = '';
                $row['bulanTarget']  = '';
                $row['statusDok']  = 'Belum Masuk';
                $row['bulanReal']  = '';
                $row['status']  = '';
                $row['rencanaJam']  = $pelaksana->jam_pengawasan;
                $row['realJam']  = 0;
            } else {
                $row['objek']  = $pelaksana->nama;
                $row['bulanTarget']  = $bulan[$pelaksana->month - 1];

                if ($realisasi->where('id_pelaksana', $pelaksana->id_pelaksana)
                                ->where('id_laporan_objek', $pelaksana->id)->first() != null) {
                    $dokumen = $realisasi->where('id_pelaksana', $pelaksana->id_pelaksana)
                                            ->where('id_laporan_objek', $pelaksana->id)->first();
                    if ($dokumen->status == 1) {
                        $row['statusDok'] = 'Sudah Masuk';
                    } elseif ($dokumen->status == 2) {
                        $row['statusDok'] = 'Dibatalkan';
                    } else {
                        $row['statusDok'] = 'Tidak Selesai';
                    }
                } else {
                    unset($dokumen);
                    $row['statusDok'] = 'Belum Masuk';
                }

                $row['bulanReal'] = (isset($dokumen) && $dokumen->status == 1) ? $bulan[date("n",strtotime($dokumen->tgl_upload)) - 1] : '';

                if (isset($dokumen) && $dokumen->status == 1) {
                    $targetthn = $year ?? date('Y');
                    $targetbln = $targetthn.'-'.sprintf('%02d', $pelaksana->month).'-01';
                    $realisasibln = date("Y-m",strtotime($dokumen->tgl_upload)).'-01';
                    if ($realisasibln < $targetbln) $row['status'] = 'Lebih Cepat';
                    elseif ($realisasibln == $targetbln) $row['status'] = 'Tepat Waktu';
                    else $row['status'] = 'Terlambat';
                } else $row['status'] = '';

                $row['rencanaJam'] = $pelaksana->jam_pengawasan;

                $total_jam = 0; 
                foreach ($events->where('laporan_opengawasan', $pelaksana->id)
                                ->where('id_pegawai', $pelaksana->id_pegawai) as $event) {
                    $start = $event->start;
                    $end = $event->end;
                    $total_jam += (strtotime($end) - strtotime($start)) / 60 / 60;
                }
                $row['realJam'] = $total_jam;
            }

            $row['hasilTim'] = $pelaksana->rencanaKerja->hasilKerja->nama_hasil_kerja;
            $row['subunsur'] = $pelaksana->rencanaKerja->hasilKerja->masterSubUnsur->nama_sub_unsur;
            $row['unsur'] = $pelaksana->rencanaKerja->hasilKerja->masterSubUnsur->masterUnsur->nama_unsur;
            $row['iku'] = $pelaksana->rencanaKerja->proyek->timKerja->iku->iku;
            $data->push($row);
        } 

        return $data;
    }

    public function headings(): array
    {
        return ['Tim', 'PJK', 'Tugas', 'Nama Pegawai', 'Output Kinerja Individu', 'Objek Pengawasan',
                'Target Bulan Kinerja', 'Status Dokumen', 'Realisasi Bulan', 'Status', 
                'Rencana Jam Kerja', 'Realisasi Jam Kerja', 'Hasil Kerja Tim', 'Sub Unsur',
                'Unsur', 'IKU'];
    }

    public function registerEvents(): array
    {
        return [
            //resize kolom
            AfterSheet::class    => function(AfterSheet $event) {
                foreach ($event->sheet->getColumnIterator() as $column) {
                    $event->sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true); 
                }
            }
        ];
    }
}
