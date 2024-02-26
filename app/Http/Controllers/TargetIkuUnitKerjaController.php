<?php

namespace App\Http\Controllers;

use App\Models\TargetIkuUnitKerja;
use App\Models\RealisasiIkuUnitKerja;
use App\Http\Requests\StoreTargetIkuUnitKerjaRequest;
use App\Http\Requests\UpdateTargetIkuUnitKerjaRequest;
use App\Models\ObjekIkuUnitKerja;

class TargetIkuUnitKerjaController extends Controller
{
    protected $kabupaten = [
        'BPS RI',
'BPS PROVINSI ACEH',
'BPS KABUPATEN SIMEULUE',
'BPS KABUPATEN ACEH SINGKIL',
'BPS KABUPATEN ACEH SELATAN',
'BPS KABUPATEN ACEH TENGGARA',
'BPS KABUPATEN ACEH TIMUR',
'BPS KABUPATEN ACEH TENGAH',
'BPS KABUPATEN ACEH BARAT',
'BPS KABUPATEN ACEH BESAR',
'BPS KABUPATEN PIDIE',
'BPS KABUPATEN BIREUEN',
'BPS KABUPATEN ACEH UTARA',
'BPS KABUPATEN ACEH BARAT DAYA',
'BPS KABUPATEN GAYO LUES',
'BPS KABUPATEN ACEH TAMIANG',
'BPS KABUPATEN NAGAN RAYA',
'BPS KABUPATEN ACEH JAYA',
'BPS KABUPATEN BENER MERIAH',
'BPS KABUPATEN PIDIE JAYA',
'BPS KOTA BANDA ACEH',
'BPS KOTA SABANG',
'BPS KOTA LANGSA',
'BPS KOTA LHOKSEUMAWE',
'BPS KOTA SUBULUSSALAM',
'BPS PROVINSI SUMATERA UTARA',
'BPS KABUPATEN NIAS',
'BPS KABUPATEN MANDAILING NATAL',
'BPS KABUPATEN TAPANULI SELATAN',
'BPS KABUPATEN TAPANULI TENGAH',
'BPS KABUPATEN TAPANULI UTARA',
'BPS KABUPATEN TOBA',
'BPS KABUPATEN LABUHAN BATU',
'BPS KABUPATEN ASAHAN',
'BPS KABUPATEN SIMALUNGUN',
'BPS KABUPATEN DAIRI',
'BPS KABUPATEN KARO',
'BPS KABUPATEN DELI SERDANG',
'BPS KABUPATEN LANGKAT',
'BPS KABUPATEN NIAS SELATAN',
'BPS KABUPATEN HUMBANG HASUNDUTAN',
'BPS KABUPATEN PAKPAK BHARAT',
'BPS KABUPATEN SAMOSIR',
'BPS KABUPATEN SERDANG BEDAGAI',
'BPS KABUPATEN BATU BARA',
'BPS KABUPATEN PADANG LAWAS UTARA',
'BPS KABUPATEN PADANG LAWAS',
'BPS KABUPATEN LABUHAN BATU SELATAN',
'BPS KABUPATEN LABUHAN BATU UTARA',
'BPS KABUPATEN NIAS UTARA',
'BPS KABUPATEN NIAS BARAT',
'BPS KOTA SIBOLGA',
'BPS KOTA TANJUNG BALAI',
'BPS KOTA PEMATANG SIANTAR',
'BPS KOTA TEBING TINGGI',
'BPS KOTA MEDAN',
'BPS KOTA BINJAI',
'BPS KOTA PADANGSIDIMPUAN',
'BPS KOTA GUNUNGSITOLI',
'BPS PROVINSI SUMATERA BARAT',
'BPS KABUPATEN KEPULAUAN MENTAWAI',
'BPS KABUPATEN PESISIR SELATAN',
'BPS KABUPATEN SOLOK',
'BPS KABUPATEN SIJUNJUNG',
'BPS KABUPATEN TANAH DATAR',
'BPS KABUPATEN PADANG PARIAMAN',
'BPS KABUPATEN AGAM',
'BPS KABUPATEN LIMA PULUH KOTA',
'BPS KABUPATEN PASAMAN',
'BPS KABUPATEN SOLOK SELATAN',
'BPS KABUPATEN DHARMASRAYA',
'BPS KABUPATEN PASAMAN BARAT',
'BPS KOTA PADANG',
'BPS KOTA SOLOK',
'BPS KOTA SAWAH LUNTO',
'BPS KOTA PADANG PANJANG',
'BPS KOTA BUKITTINGGI',
'BPS KOTA PAYAKUMBUH',
'BPS KOTA PARIAMAN',
'BPS PROVINSI RIAU',
'BPS KABUPATEN KUANTAN SINGINGI',
'BPS KABUPATEN INDRAGIRI HULU',
'BPS KABUPATEN INDRAGIRI HILIR',
'BPS KABUPATEN PELALAWAN',
'BPS KABUPATEN SIAK',
'BPS KABUPATEN KAMPAR',
'BPS KABUPATEN ROKAN HULU',
'BPS KABUPATEN BENGKALIS',
'BPS KABUPATEN ROKAN HILIR',
'BPS KABUPATEN KEPULAUAN MERANTI',
'BPS KOTA PEKANBARU',
'BPS KOTA DUMAI',
'BPS PROVINSI JAMBI',
'BPS KABUPATEN KERINCI',
'BPS KABUPATEN MERANGIN',
'BPS KABUPATEN SAROLANGUN',
'BPS KABUPATEN BATANG HARI',
'BPS KABUPATEN MUARO JAMBI',
'BPS KABUPATEN TANJUNG JABUNG TIMUR',
'BPS KABUPATEN TANJUNG JABUNG BARAT',
'BPS KABUPATEN TEBO',
'BPS KABUPATEN BUNGO',
'BPS KOTA JAMBI',
'BPS KOTA SUNGAI PENUH',
'BPS PROVINSI SUMATERA SELATAN',
'BPS KABUPATEN OGAN KOMERING ULU',
'BPS KABUPATEN OGAN KOMERING ILIR',
'BPS KABUPATEN MUARA ENIM',
'BPS KABUPATEN LAHAT',
'BPS KABUPATEN MUSI RAWAS',
'BPS KABUPATEN MUSI BANYUASIN',
'BPS KABUPATEN BANYU ASIN',
'BPS KABUPATEN OGAN KOMERING ULU SELATAN',
'BPS KABUPATEN OGAN KOMERING ULU TIMUR',
'BPS KABUPATEN OGAN ILIR',
'BPS KABUPATEN EMPAT LAWANG',
'BPS KABUPATEN PENUKAL ABAB LEMATANG ILIR',
'BPS KABUPATEN MUSI RAWAS UTARA',
'BPS KOTA PALEMBANG',
'BPS KOTA PRABUMULIH',
'BPS KOTA PAGAR ALAM',
'BPS KOTA LUBUKLINGGAU',
'BPS PROVINSI BENGKULU',
'BPS KABUPATEN BENGKULU SELATAN',
'BPS KABUPATEN REJANG LEBONG',
'BPS KABUPATEN BENGKULU UTARA',
'BPS KABUPATEN KAUR',
'BPS KABUPATEN SELUMA',
'BPS KABUPATEN MUKOMUKO',
'BPS KABUPATEN LEBONG',
'BPS KABUPATEN KEPAHIANG',
'BPS KABUPATEN BENGKULU TENGAH',
'BPS KOTA BENGKULU',
'BPS PROVINSI LAMPUNG',
'BPS KABUPATEN LAMPUNG BARAT',
'BPS KABUPATEN TANGGAMUS',
'BPS KABUPATEN LAMPUNG SELATAN',
'BPS KABUPATEN LAMPUNG TIMUR',
'BPS KABUPATEN LAMPUNG TENGAH',
'BPS KABUPATEN LAMPUNG UTARA',
'BPS KABUPATEN WAY KANAN',
'BPS KABUPATEN TULANGBAWANG',
'BPS KABUPATEN PESAWARAN',
'BPS KABUPATEN PRINGSEWU',
'BPS KABUPATEN MESUJI',
'BPS KABUPATEN TULANG BAWANG BARAT',
'BPS KABUPATEN PESISIR BARAT',
'BPS KOTA BANDAR LAMPUNG',
'BPS KOTA METRO',
'BPS PROVINSI KEP. BANGKA BELITUNG',
'BPS KABUPATEN BANGKA',
'BPS KABUPATEN BELITUNG',
'BPS KABUPATEN BANGKA BARAT',
'BPS KABUPATEN BANGKA TENGAH',
'BPS KABUPATEN BANGKA SELATAN',
'BPS KABUPATEN BELITUNG TIMUR',
'BPS KOTA PANGKAL PINANG',
'BPS PROVINSI KEP. RIAU',
'BPS KABUPATEN KARIMUN',
'BPS KABUPATEN BINTAN',
'BPS KABUPATEN NATUNA',
'BPS KABUPATEN LINGGA',
'BPS KABUPATEN KEPULAUAN ANAMBAS',
'BPS KOTA BATAM',
'BPS KOTA TANJUNG PINANG',
'BPS PROVINSI DKI JAKARTA',
'BPS KABUPATEN KEPULAUAN SERIBU',
'BPS KOTA JAKARTA SELATAN',
'BPS KOTA JAKARTA TIMUR',
'BPS KOTA JAKARTA PUSAT',
'BPS KOTA JAKARTA BARAT',
'BPS KOTA JAKARTA UTARA',
'BPS PROVINSI JAWA BARAT',
'BPS KABUPATEN BOGOR',
'BPS KABUPATEN SUKABUMI',
'BPS KABUPATEN CIANJUR',
'BPS KABUPATEN BANDUNG',
'BPS KABUPATEN GARUT',
'BPS KABUPATEN TASIKMALAYA',
'BPS KABUPATEN CIAMIS',
'BPS KABUPATEN KUNINGAN',
'BPS KABUPATEN CIREBON',
'BPS KABUPATEN MAJALENGKA',
'BPS KABUPATEN SUMEDANG',
'BPS KABUPATEN INDRAMAYU',
'BPS KABUPATEN SUBANG',
'BPS KABUPATEN PURWAKARTA',
'BPS KABUPATEN KARAWANG',
'BPS KABUPATEN BEKASI',
'BPS KABUPATEN BANDUNG BARAT',
'BPS KABUPATEN PANGANDARAN',
'BPS KOTA BOGOR',
'BPS KABUPATEN SUKABUMI',
'BPS KOTA BANDUNG',
'BPS KOTA CIREBON',
'BPS KOTA BEKASI',
'BPS KOTA DEPOK',
'BPS KOTA CIMAHI',
'BPS KOTA TASIKMALAYA',
'BPS KOTA BANJAR',
'BPS PROVINSI JAWA TENGAH',
'BPS KABUPATEN CILACAP',
'BPS KABUPATEN BANYUMAS',
'BPS KABUPATEN PURBALINGGA',
'BPS KABUPATEN BANJARNEGARA',
'BPS KABUPATEN KEBUMEN',
'BPS KABUPATEN PURWOREJO',
'BPS KABUPATEN WONOSOBO',
'BPS KABUPATEN MAGELANG',
'BPS KABUPATEN BOYOLALI',
'BPS KABUPATEN KLATEN',
'BPS KABUPATEN SUKOHARJO',
'BPS KABUPATEN WONOGIRI',
'BPS KABUPATEN KARANGANYAR',
'BPS KABUPATEN SRAGEN',
'BPS KABUPATEN GROBOGAN',
'BPS KABUPATEN BLORA',
'BPS KABUPATEN REMBANG',
'BPS KABUPATEN PATI',
'BPS KABUPATEN KUDUS',
'BPS KABUPATEN JEPARA',
'BPS KABUPATEN DEMAK',
'BPS KABUPATEN SEMARANG',
'BPS KABUPATEN TEMANGGUNG',
'BPS KABUPATEN KENDAL',
'BPS KABUPATEN BATANG',
'BPS KABUPATEN PEKALONGAN',
'BPS KABUPATEN PEMALANG',
'BPS KABUPATEN TEGAL',
'BPS KABUPATEN BREBES',
'BPS KOTA MAGELANG',
'BPS KOTA SURAKARTA',
'BPS KOTA SALATIGA',
'BPS KOTA SEMARANG',
'BPS KOTA PEKALONGAN',
'BPS KOTA TEGAL',
'BPS PROVINSI DI YOGYAKARTA',
'BPS KABUPATEN KULON PROGO',
'BPS KABUPATEN BANTUL',
'BPS KABUPATEN GUNUNG KIDUL',
'BPS KABUPATEN SLEMAN',
'BPS KOTA YOGYAKARTA',
'BPS PROVINSI JAWA TIMUR',
'BPS KABUPATEN PACITAN',
'BPS KABUPATEN PONOROGO',
'BPS KABUPATEN TRENGGALEK',
'BPS KABUPATEN TULUNGAGUNG',
'BPS KABUPATEN BLITAR',
'BPS KABUPATEN KEDIRI',
'BPS KABUPATEN MALANG',
'BPS KABUPATEN LUMAJANG',
'BPS KABUPATEN JEMBER',
'BPS KABUPATEN BANYUWANGI',
'BPS KABUPATEN BONDOWOSO',
'BPS KABUPATEN SITUBONDO',
'BPS KABUPATEN PROBOLINGGO',
'BPS KABUPATEN PASURUAN',
'BPS KABUPATEN SIDOARJO',
'BPS KABUPATEN MOJOKERTO',
'BPS KABUPATEN JOMBANG',
'BPS KABUPATEN NGANJUK',
'BPS KABUPATEN MADIUN',
'BPS KABUPATEN MAGETAN',
'BPS KABUPATEN NGAWI',
'BPS KABUPATEN BOJONEGORO',
'BPS KABUPATEN TUBAN',
'BPS KABUPATEN LAMONGAN',
'BPS KABUPATEN GRESIK',
'BPS KABUPATEN BANGKALAN',
'BPS KABUPATEN SAMPANG',
'BPS KABUPATEN PAMEKASAN',
'BPS KABUPATEN SUMENEP',
'BPS KOTA KEDIRI',
'BPS KOTA BLITAR',
'BPS KOTA MALANG',
'BPS KOTA PROBOLINGGO',
'BPS KOTA PASURUAN',
'BPS KOTA MOJOKERTO',
'BPS KOTA MADIUN',
'BPS KOTA SURABAYA',
'BPS KOTA BATU',
'BPS PROVINSI BANTEN',
'BPS KABUPATEN PANDEGLANG',
'BPS KABUPATEN LEBAK',
'BPS KABUPATEN TANGERANG',
'BPS KABUPATEN SERANG',
'BPS KOTA TANGERANG',
'BPS KOTA CILEGON',
'BPS KOTA SERANG',
'BPS KOTA TANGERANG SELATAN',
'BPS PROVINSI BALI',
'BPS KABUPATEN JEMBRANA',
'BPS KABUPATEN TABANAN',
'BPS KABUPATEN BADUNG',
'BPS KABUPATEN GIANYAR',
'BPS KABUPATEN KLUNGKUNG',
'BPS KABUPATEN BANGLI',
'BPS KABUPATEN KARANG ASEM',
'BPS KABUPATEN BULELENG',
'BPS KOTA DENPASAR',
'BPS PROVINSI NUSA TENGGARA BARAT',
'BPS KABUPATEN LOMBOK BARAT',
'BPS KABUPATEN LOMBOK TENGAH',
'BPS KABUPATEN LOMBOK TIMUR',
'BPS KABUPATEN SUMBAWA',
'BPS KABUPATEN DOMPU',
'BPS KABUPATEN BIMA',
'BPS KABUPATEN SUMBAWA BARAT',
'BPS KABUPATEN LOMBOK UTARA',
'BPS KOTA MATARAM',
'BPS KOTA BIMA',
'BPS PROVINSI NUSA TENGGARA TIMUR',
'BPS KABUPATEN SUMBA BARAT',
'BPS KABUPATEN SUMBA TIMUR',
'BPS KABUPATEN KUPANG',
'BPS KABUPATEN TIMOR TENGAH SELATAN',
'BPS KABUPATEN TIMOR TENGAH UTARA',
'BPS KABUPATEN BELU',
'BPS KABUPATEN ALOR',
'BPS KABUPATEN LEMBATA',
'BPS KABUPATEN FLORES TIMUR',
'BPS KABUPATEN SIKKA',
'BPS KABUPATEN ENDE',
'BPS KABUPATEN NGADA',
'BPS KABUPATEN MANGGARAI',
'BPS KABUPATEN ROTE NDAO',
'BPS KABUPATEN MANGGARAI BARAT',
'BPS KABUPATEN SUMBA TENGAH',
'BPS KABUPATEN SUMBA BARAT DAYA',
'BPS KABUPATEN NAGEKEO',
'BPS KABUPATEN MANGGARAI TIMUR',
'BPS KABUPATEN SABU RAIJUA',
'BPS KABUPATEN MALAKA',
'BPS KOTA KUPANG',
'BPS PROVINSI KALIMANTAN BARAT',
'BPS KABUPATEN SAMBAS',
'BPS KABUPATEN BENGKAYANG',
'BPS KABUPATEN LANDAK',
'BPS KABUPATEN MEMPAWAH',
'BPS KABUPATEN SANGGAU',
'BPS KABUPATEN KETAPANG',
'BPS KABUPATEN SINTANG',
'BPS KABUPATEN KAPUAS HULU',
'BPS KABUPATEN SEKADAU',
'BPS KABUPATEN MELAWI',
'BPS KABUPATEN KAYONG UTARA',
'BPS KABUPATEN KUBU RAYA',
'BPS KOTA PONTIANAK',
'BPS KOTA SINGKAWANG',
'BPS PROVINSI KALIMANTAN TENGAH',
'BPS KABUPATEN KOTAWARINGIN BARAT',
'BPS KABUPATEN KOTAWARINGIN TIMUR',
'BPS KABUPATEN KAPUAS',
'BPS KABUPATEN BARITO SELATAN',
'BPS KABUPATEN BARITO UTARA',
'BPS KABUPATEN SUKAMARA',
'BPS KABUPATEN LAMANDAU',
'BPS KABUPATEN SERUYAN',
'BPS KABUPATEN KATINGAN',
'BPS KABUPATEN PULANG PISAU',
'BPS KABUPATEN GUNUNG MAS',
'BPS KABUPATEN BARITO TIMUR',
'BPS KABUPATEN MURUNG RAYA',
'BPS KOTA PALANGKA RAYA',
'BPS PROVINSI KALIMANTAN SELATAN',
'BPS KABUPATEN TANAH LAUT',
'BPS KABUPATEN KOTA BARU',
'BPS KABUPATEN BANJAR',
'BPS KABUPATEN BARITO KUALA',
'BPS KABUPATEN TAPIN',
'BPS KABUPATEN HULU SUNGAI SELATAN',
'BPS KABUPATEN HULU SUNGAI TENGAH',
'BPS KABUPATEN HULU SUNGAI UTARA',
'BPS KABUPATEN TABALONG',
'BPS KABUPATEN TANAH BUMBU',
'BPS KABUPATEN BALANGAN',
'BPS KOTA BANJARMASIN',
'BPS KOTA BANJAR BARU',
'BPS PROVINSI KALIMANTAN TIMUR',
'BPS KABUPATEN PASER',
'BPS KABUPATEN KUTAI BARAT',
'BPS KABUPATEN KUTAI KARTANEGARA',
'BPS KABUPATEN KUTAI TIMUR',
'BPS KABUPATEN BERAU',
'BPS KABUPATEN PENAJAM PASER UTARA',
'BPS KABUPATEN MAHAKAM ULU',
'BPS KOTA BALIKPAPAN',
'BPS KOTA SAMARINDA',
'BPS KOTA BONTANG',
'BPS PROVINSI KALIMANTAN UTARA',
'BPS KABUPATEN MALINAU',
'BPS KABUPATEN BULUNGAN',
'BPS KABUPATEN TANA TIDUNG',
'BPS KABUPATEN NUNUKAN',
'BPS KOTA TARAKAN',
'BPS PROVINSI SULAWESI UTARA',
'BPS KABUPATEN BOLAANG MONGONDOW',
'BPS KABUPATEN MINAHASA',
'BPS KABUPATEN KEPULAUAN SANGIHE',
'BPS KABUPATEN KEPULAUAN TALAUD',
'BPS KABUPATEN MINAHASA SELATAN',
'BPS KABUPATEN MINAHASA UTARA',
'BPS KABUPATEN BOLAANG MONGONDOW UTARA',
'BPS KABUPATEN SIAU TAGULANDANG BIARO',
'BPS KABUPATEN MINAHASA TENGGARA',
'BPS KABUPATEN BOLAANG MONGONDOW SELATAN',
'BPS KABUPATEN BOLAANG MONGONDOW TIMUR',
'BPS KOTA MANADO',
'BPS KOTA BITUNG',
'BPS KOTA TOMOHON',
'BPS KOTA KOTAMOBAGU',
'BPS PROVINSI SULAWESI TENGAH',
'BPS KABUPATEN BANGGAI KEPULAUAN',
'BPS KABUPATEN BANGGAI',
'BPS KABUPATEN MOROWALI',
'BPS KABUPATEN POSO',
'BPS KABUPATEN DONGGALA',
'BPS KABUPATEN TOLI-TOLI',
'BPS KABUPATEN BUOL',
'BPS KABUPATEN PARIGI MOUTONG',
'BPS KABUPATEN TOJO UNA-UNA',
'BPS KABUPATEN SIGI',
'BPS KABUPATEN BANGGAI LAUT',
'BPS KABUPATEN MOROWALI UTARA',
'BPS KOTA PALU',
'BPS PROVINSI SULAWESI SELATAN',
'BPS KABUPATEN KEPULAUAN SELAYAR',
'BPS KABUPATEN BULUKUMBA',
'BPS KABUPATEN BANTAENG',
'BPS KABUPATEN JENEPONTO',
'BPS KABUPATEN TAKALAR',
'BPS KABUPATEN GOWA',
'BPS KABUPATEN SINJAI',
'BPS KABUPATEN MAROS',
'BPS KABUPATEN PANGKAJENE DAN KEPULAUAN',
'BPS KABUPATEN BARRU',
'BPS KABUPATEN BONE',
'BPS KABUPATEN SOPPENG',
'BPS KABUPATEN WAJO',
'BPS KABUPATEN SIDENRENG RAPPANG',
'BPS KABUPATEN PINRANG',
'BPS KABUPATEN ENREKANG',
'BPS KABUPATEN LUWU',
'BPS KABUPATEN TANA TORAJA',
'BPS KABUPATEN LUWU UTARA',
'BPS KABUPATEN LUWU TIMUR',
'BPS KABUPATEN TORAJA UTARA',
'BPS KOTA MAKASSAR',
'BPS KOTA PAREPARE',
'BPS KOTA PALOPO',
'BPS PROVINSI SULAWESI TENGGARA',
'BPS KABUPATEN BUTON',
'BPS KABUPATEN MUNA',
'BPS KABUPATEN KONAWE',
'BPS KABUPATEN KOLAKA',
'BPS KABUPATEN KONAWE SELATAN',
'BPS KABUPATEN BOMBANA',
'BPS KABUPATEN WAKATOBI',
'BPS KABUPATEN KOLAKA UTARA',
'BPS KABUPATEN BUTON UTARA',
'BPS KABUPATEN KONAWE UTARA',
'BPS KABUPATEN KOLAKA TIMUR',
'BPS KABUPATEN KONAWE KEPULAUAN',
'BPS KABUPATEN MUNA BARAT',
'BPS KABUPATEN BUTON TENGAH',
'BPS KABUPATEN BUTON SELATAN',
'BPS KOTA KENDARI',
'BPS KOTA BAUBAU',
'BPS PROVINSI GORONTALO',
'BPS KABUPATEN BOALEMO',
'BPS KABUPATEN GORONTALO',
'BPS KABUPATEN POHUWATO',
'BPS KABUPATEN BONE BOLANGO',
'BPS KABUPATEN GORONTALO UTARA',
'BPS KOTA GORONTALO',
'BPS PROVINSI SULAWESI BARAT',
'BPS KABUPATEN MAJENE',
'BPS KABUPATEN POLEWALI MANDAR',
'BPS KABUPATEN MAMASA',
'BPS KABUPATEN MAMUJU',
'BPS KABUPATEN MAMUJU UTARA',
'BPS KABUPATEN MAMUJU TENGAH',
'BPS PROVINSI MALUKU',
'BPS KABUPATEN MALUKU TENGGARA BARAT',
'BPS KABUPATEN MALUKU TENGGARA',
'BPS KABUPATEN MALUKU TENGAH',
'BPS KABUPATEN BURU',
'BPS KABUPATEN KEPULAUAN ARU',
'BPS KABUPATEN SERAM BAGIAN BARAT',
'BPS KABUPATEN SERAM BAGIAN TIMUR',
'BPS KABUPATEN MALUKU BARAT DAYA',
'BPS KABUPATEN BURU SELATAN',
'BPS KOTA AMBON',
'BPS KOTA TUAL',
'BPS PROVINSI MALUKU UTARA',
'BPS KABUPATEN HALMAHERA BARAT',
'BPS KABUPATEN HALMAHERA TENGAH',
'BPS KABUPATEN KEPULAUAN SULA',
'BPS KABUPATEN HALMAHERA SELATAN',
'BPS KABUPATEN HALMAHERA UTARA',
'BPS KABUPATEN HALMAHERA TIMUR',
'BPS KABUPATEN PULAU MOROTAI',
'BPS KABUPATEN PULAU TALIABU',
'BPS KOTA TERNATE',
'BPS KOTA TIDORE KEPULAUAN',
'BPS PROVINSI PAPUA BARAT',
'BPS KABUPATEN FAKFAK',
'BPS KABUPATEN KAIMANA',
'BPS KABUPATEN TELUK WONDAMA',
'BPS KABUPATEN TELUK BINTUNI',
'BPS KABUPATEN MANOKWARI',
'BPS KABUPATEN SORONG SELATAN',
'BPS KABUPATEN SORONG',
'BPS KABUPATEN RAJA AMPAT',
'BPS KABUPATEN TAMBRAUW',
'BPS KABUPATEN MAYBRAT',
'BPS KABUPATEN MANOKWARI SELATAN',
'BPS KABUPATEN PEGUNUNGAN ARFAK',
'BPS KOTA SORONG',
'BPS PROVINSI PAPUA',
'BPS KABUPATEN MERAUKE',
'BPS KABUPATEN JAYAWIJAYA',
'BPS KABUPATEN JAYAPURA',
'BPS KABUPATEN NABIRE',
'BPS KABUPATEN KEPULAUAN YAPEN',
'BPS KABUPATEN BIAK NUMFOR',
'BPS KABUPATEN PANIAI',
'BPS KABUPATEN PUNCAK JAYA',
'BPS KABUPATEN MIMIKA',
'BPS KABUPATEN BOVEN DIGOEL',
'BPS KABUPATEN MAPPI',
'BPS KABUPATEN ASMAT',
'BPS KABUPATEN YAHUKIMO',
'BPS KABUPATEN PEGUNUNGAN BINTANG',
'BPS KABUPATEN TOLIKARA',
'BPS KABUPATEN SARMI',
'BPS KABUPATEN KEEROM',
'BPS KABUPATEN WAROPEN',
'BPS KABUPATEN SUPIORI',
'BPS KABUPATEN MAMBERAMO RAYA',
'BPS KABUPATEN NDUGA',
'BPS KABUPATEN LANNY JAYA',
'BPS KABUPATEN MAMBERAMO TENGAH',
'BPS KABUPATEN YALIMO',
'BPS KABUPATEN PUNCAK',
'BPS KABUPATEN DOGIYAI',
'BPS KABUPATEN INTAN JAYA',
'BPS KABUPATEN DEIYAI',
'BPS KOTA JAYAPURA',

    ];
    protected $colorBadge = [
        '1' => 'secondary',
        '2' => 'warning',
        '3' => 'info',
        '4' => 'success',
    ];

    protected $status = [
        '1' => 'Penyusunan Target',
        '2' => 'Penyusunan Realisasi',
        '3' => 'Penyusunan Evaluasi',
        '4' => 'Selesai',
    ];
    protected $unitKerja = [
        '8000'    => 'Inspektorat Utama',
        '8010'    => 'Bagian Umum Inspektorat Utama',
        '8100'    => 'Inspektorat Wilayah I',
        '8200'    => 'Inspektorat Wilayah II',
        '8300'    => 'Inspektorat Wilayah III',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('perencana');
        $targetIkuUnitKerja = TargetIkuUnitKerja::all();
        // dd($targetIkuUnitKerja);
        return view('perencana.target-iku.index', [
            'type_menu' => 'iku-unit-kerja',
            'targetIkuUnitKerja' => $targetIkuUnitKerja,
            'status' => $this->status,
            'colorBadge' => $this->colorBadge,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('perencana');

        return view('perencana.target-iku.create', [
            'type_menu' => 'iku-unit-kerja',
            'kabupaten' => $this->kabupaten,
            'unitKerja' => $this->unitKerja,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTargetIkuUnitKerjaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTargetIkuUnitKerjaRequest $request)
    {
        // create
        // dd($request->all());
        TargetIkuUnitKerja::create([
            'unit_kerja' => $request->input('unit-kerja'),
            'jumlah_objek' => $request->input('jumlah-objek'),
            'nama_kegiatan' => $request->input('nama-kegiatan'),
            'status' => '1',
            'user_id' => auth()->user()->id,
        ]);
        $jumlahObjek = $request->input('jumlah-objek');
        for ($i = 1; $i <= $jumlahObjek; $i++) {
            $satuan = $request->input('satuan-row' . $i);
            $nilaiY = $request->input('nilai-y-row' . $i);
            $target_triwulan_1 = $request->input('triwulan1-row' . $i);
            $target_triwulan_2 = $request->input('triwulan2-row' . $i);
            $target_triwulan_3 = $request->input('triwulan3-row' . $i);
            $target_triwulan_4 = $request->input('triwulan4-row' . $i);
            $status = '1';
            $user_id = auth()->user()->id;
            $id_target = TargetIkuUnitKerja::latest()->first()->id;
            ObjekIkuUnitKerja::create([
                'id' => (string) \Symfony\Component\Uid\Ulid::generate(),
                'satuan' => $satuan,
                'id_target' => $id_target,
                'nilai_y_target' => $nilaiY ?? 0,
                'target_triwulan_1' => $target_triwulan_1 ?? 0,
                'target_triwulan_2' => $target_triwulan_2 ?? 0,
                'target_triwulan_3' => $target_triwulan_3 ?? 0,
                'target_triwulan_4' => $target_triwulan_4 ?? 0,
                'status' => $status,
                'user_id' => $user_id,
            ]);

        }
        return redirect()->route('target-iku-unit-kerja.index')->with('status', 'Berhasil Menambahkan UTarget IKU Unit Kerja')
            ->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TargetIkuUnitKerja  $targetIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function show(TargetIkuUnitKerja $targetIkuUnitKerja)
    {
        // dd($targetIkuUnitKerja);
        $this->authorize('perencana');

        $objekIkuUnitKerja = objekIkuUnitKerja::where('id_target', $targetIkuUnitKerja->id)->get();
        // dd($objekIkuUnitKerja);
        return view('perencana.target-iku.show', [
            'type_menu' => 'iku-unit-kerja',
            'kabupaten' => $this->kabupaten,
            'unitKerja' => $this->unitKerja,
            'targetIkuUnitKerja' => $targetIkuUnitKerja,
            'objekIkuUnitKerja' => $objekIkuUnitKerja,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TargetIkuUnitKerja  $targetIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function edit(TargetIkuUnitKerja $targetIkuUnitKerja)
    {
        // dd($targetIkuUnitKerja);
        $this->authorize('perencana');

        $objekIkuUnitKerja = objekIkuUnitKerja::where('id_target', $targetIkuUnitKerja->id)->get();
        // dd($objekIkuUnitKerja);
        return view('perencana.target-iku.edit', [
            'type_menu' => 'iku-unit-kerja',
            'kabupaten' => $this->kabupaten,
            'unitKerja' => $this->unitKerja,
            'targetIkuUnitKerja' => $targetIkuUnitKerja,
            'objekIkuUnitKerja' => $objekIkuUnitKerja,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTargetIkuUnitKerjaRequest  $request
     * @param  \App\Models\TargetIkuUnitKerja  $targetIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTargetIkuUnitKerjaRequest $request, TargetIkuUnitKerja $targetIkuUnitKerja)
    {
        // dd($request->all());
        TargetIkuUnitKerja::where('id', $targetIkuUnitKerja->id)
            ->update([
                'unit_kerja' => $request->input('unit-kerja'),
                'jumlah_objek' => $request->input('jumlah-objek'),
                'nama_kegiatan' => $request->input('nama-kegiatan'),
                'status' => '1',
                'user_id' => auth()->user()->id,
            ]);
        $jumlahObjek = $request->input('jumlah-objek');
        for ($i = 1; $i <= $jumlahObjek; $i++) {
            $satuan = $request->input('satuan-row' . $i);
            $nilaiY = $request->input('nilai-y-row' . $i);
            $target_triwulan_1 = $request->input('triwulan1-row' . $i);
            $target_triwulan_2 = $request->input('triwulan2-row' . $i);
            $target_triwulan_3 = $request->input('triwulan3-row' . $i);
            $target_triwulan_4 = $request->input('triwulan4-row' . $i);
            $status = '1';
            $user_id = auth()->user()->id;
            $id_target = $targetIkuUnitKerja->id;
            $objekIkuUnitKerja = ObjekIkuUnitKerja::updateOrCreate(
                ['id_target' => $id_target],
                [
                    'satuan' => $satuan,
                    'nilai_y_target' => $nilaiY ?? 0,
                    'target_triwulan_1' => $target_triwulan_1 ?? 0,
                    'target_triwulan_2' => $target_triwulan_2 ?? 0,
                    'target_triwulan_3' => $target_triwulan_3 ?? 0,
                    'target_triwulan_4' => $target_triwulan_4 ?? 0,
                    'status' => $status,
                    'user_id' => $user_id,
                ]
            );

        }
        return redirect()->route('target-iku-unit-kerja.index')->with('status', 'Berhasil Mengubah Target IKU Unit Kerja')
            ->with('alert-type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TargetIkuUnitKerja  $targetIkuUnitKerja
     * @return \Illuminate\Http\Response
     */
    public function destroy(TargetIkuUnitKerja $targetIkuUnitKerja)
    {
        // delete
        $targetIkuUnitKerja->delete();
    }

    public function editStatus($id)
    {
        // dd($targetIkuUnitKerja);

        $status = request()->input('status');
        $targetIkuUnitKerja = TargetIkuUnitKerja::find($id);
        $realisasiIkuUnitKerja = RealisasiIkuUnitKerja::where('id_target_iku_unit_kerja', $id)->first();

        if ($status == 2) {
            TargetIkuUnitKerja::where('id', $targetIkuUnitKerja->id)
        ->update([
            'status' => $status,
        ]);
            return redirect()->route('target-iku-unit-kerja.index')->with('status', 'Berhasil Mengirim ke Realisasi')
            ->with('alert-type', 'success');
        }
        else if ($status == 3) {
            if($realisasiIkuUnitKerja == null) {
                return redirect()->route('realisasi-iku-unit-kerja.index')->with('status', 'Realisasi IKU Unit Kerja Belum Diisi')
                ->with('alert-type', 'danger');
            } else{
                TargetIkuUnitKerja::where('id', $targetIkuUnitKerja->id)
        ->update([
            'status' => $status,
        ]);
            return redirect()->route('realisasi-iku-unit-kerja.index')->with('status', 'Berhasil Mengirim ke Evaluasi')
            ->with('alert-type', 'success');
            }
        }

    }
}
