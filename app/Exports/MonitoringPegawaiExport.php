<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\PelaksanaTugas;
use App\Models\RealisasiKinerja;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class MonitoringPegawaiExport implements FromQuery, WithHeadings, WithEvents, WithMapping, ShouldQueue
{
    use Exportable;
    
    protected $unit, $year, $realisasi, $events;

    function __construct($unit, $year) {
        $this->unit = $unit;
        $this->year = $year;
        
        if ($this->year == null) {
            $this->year = date('Y');
        } 
        $year = $this->year;
        
        $this->realisasi = RealisasiKinerja::whereRelation('pelaksana.rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                        $query->where('tahun', $year);
                    })->get();

        $this->events = Event::whereRelation('laporanOPengawasan.objekPengawasan.rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                            $query->where('tahun', $year);
                        })->get();
    }

    // /**
    // * @return \Illuminate\Support\Collection
    // */
    public function query()
    {                  
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
            $pelaksana_tugas = PelaksanaTugas::query()->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year) {
                                        $query->where('tahun', $year);
                                })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as jam_pengawasan, pelaksana_tugas.id_rencanakerja')
                                ->leftJoinSub($bulan_objek, 't', function (JoinClause $join) {
                                    $join->on('pelaksana_tugas.id_rencanakerja', '=', 't.id_rencanakerja');
                                }); 
        } else {
            $pelaksana_tugas = PelaksanaTugas::query()->whereRelation('rencanaKerja.proyek.timKerja', function (Builder $query) use ($year, $unit) {
                                        $query->where('tahun', $year);
                                        $query->where('unitkerja', $unit);
                                })->selectRaw('*, jan+feb+mar+apr+mei+jun+jul+agu+sep+okt+nov+des as jam_pengawasan, pelaksana_tugas.id_rencanakerja')
                                ->leftJoinSub($bulan_objek, 't', function (JoinClause $join) {
                                    $join->on('pelaksana_tugas.id_rencanakerja', '=', 't.id_rencanakerja');
                                }); 
        } 
                
        return $pelaksana_tugas;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function map($row): array
    {   
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        if ($row->id_objek_pengawasan == null) {
            $objek = '';
            $bulanTarget = '';
            $statusDok = 'Belum Masuk';
            $bulanReal  = '';
            $status  = '';
            $realJam  = 0;
        } else {
            $objek = $row->nama;
            $bulanTarget = $bulan[$row->month - 1];

            if ($this->realisasi->where('id_pelaksana', $row->id_pelaksana)
                            ->where('id_laporan_objek', $row->id)->first() != null) {
                $dokumen = $this->realisasi->where('id_pelaksana', $row->id_pelaksana)
                                        ->where('id_laporan_objek', $row->id)->first();
                if ($dokumen->status == 1) {
                    $statusDok = 'Sudah Masuk';
                } elseif ($dokumen->status == 2) {
                    $statusDok = 'Dibatalkan';
                } else {
                    $statusDok = 'Tidak Selesai';
                }
            } else {
                unset($dokumen);
                $statusDok = 'Belum Masuk';
            }
            
            $bulanReal  = (isset($dokumen) && $dokumen->status == 1) ? $bulan[date("n",strtotime($dokumen->tgl_upload)) - 1] : '';

            if (isset($dokumen) && $dokumen->status == 1) {
                $targetthn = $year ?? date('Y');
                $targetbln = $targetthn.'-'.sprintf('%02d', $row->month).'-01';
                $realisasibln = date("Y-m",strtotime($dokumen->tgl_upload)).'-01';
                if ($realisasibln < $targetbln) $status = 'Lebih Cepat';
                elseif ($realisasibln == $targetbln) $status = 'Tepat Waktu';
                else $status = 'Terlambat';
            } else $status = '';
            
            $realJam = 0; 
            foreach ($this->events->where('laporan_opengawasan', $row->id)
                            ->where('id_pegawai', $row->id_pegawai) as $event) {
                $start = $event->start;
                $end = $event->end;
                $realJam += (strtotime($end) - strtotime($start)) / 60 / 60;
            }
        }

        return [
            $row->rencanaKerja->proyek->timKerja->nama,
            $row->rencanaKerja->proyek->timKerja->ketua->name,
            $row->rencanaKerja->tugas,
            $row->user->name,
            count($row->rencanaKerja->hasilKerja->masterKinerja) == 0 ? 'Belum diisi' : 
                $row->rencanaKerja->hasilKerja->masterKinerja[0]->masterKinerjaPegawai->where('pt_jabatan', $row->pt_jabatan )->first()->hasil_kerja,
            $objek,
            $bulanTarget,
            $statusDok,
            $bulanReal,
            $status,
            $row->jam_pengawasan,
            $realJam,
            $row->rencanaKerja->hasilKerja->nama_hasil_kerja,
            $row->rencanaKerja->hasilKerja->masterSubUnsur->nama_sub_unsur,
            $row->rencanaKerja->hasilKerja->masterSubUnsur->masterUnsur->nama_unsur,
            $row->rencanaKerja->proyek->timKerja->iku->iku
        ];
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
