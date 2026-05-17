<?php
namespace App\Services;

class FakeShippingService {

    protected array $provinces = [
        ['province_id'=>'34','province'=>'Aceh'],
        ['province_id'=>'1', 'province'=>'Bali'],
        ['province_id'=>'2', 'province'=>'Bangka Belitung'],
        ['province_id'=>'3', 'province'=>'Banten'],
        ['province_id'=>'4', 'province'=>'Bengkulu'],
        ['province_id'=>'5', 'province'=>'Di Yogyakarta'],
        ['province_id'=>'6', 'province'=>'Dki Jakarta'],
        ['province_id'=>'7', 'province'=>'Gorontalo'],
        ['province_id'=>'8', 'province'=>'Jambi'],
        ['province_id'=>'9', 'province'=>'Jawa Barat'],
        ['province_id'=>'10','province'=>'Jawa Tengah'],
        ['province_id'=>'11','province'=>'Jawa Timur'],
        ['province_id'=>'12','province'=>'Kalimantan Barat'],
        ['province_id'=>'13','province'=>'Kalimantan Selatan'],
        ['province_id'=>'14','province'=>'Kalimantan Tengah'],
        ['province_id'=>'15','province'=>'Kalimantan Timur'],
        ['province_id'=>'16','province'=>'Kalimantan Utara'],
        ['province_id'=>'17','province'=>'Kepulauan Riau'],
        ['province_id'=>'18','province'=>'Lampung'],
        ['province_id'=>'19','province'=>'Maluku'],
        ['province_id'=>'20','province'=>'Maluku Utara'],
        ['province_id'=>'21','province'=>'Nusa Tenggara Barat'],
        ['province_id'=>'22','province'=>'Nusa Tenggara Timur'],
        ['province_id'=>'23','province'=>'Papua'],
        ['province_id'=>'24','province'=>'Papua Barat'],
        ['province_id'=>'25','province'=>'Riau'],
        ['province_id'=>'26','province'=>'Sulawesi Barat'],
        ['province_id'=>'27','province'=>'Sulawesi Selatan'],
        ['province_id'=>'28','province'=>'Sulawesi Tengah'],
        ['province_id'=>'29','province'=>'Sulawesi Tenggara'],
        ['province_id'=>'30','province'=>'Sulawesi Utara'],
        ['province_id'=>'31','province'=>'Sumatera Barat'],
        ['province_id'=>'32','province'=>'Sumatera Selatan'],
        ['province_id'=>'33','province'=>'Sumatera Utara'],
    ];

    protected array $cities = [
        '3'  => [
            ['city_id'=>'17', 'city_name'=>'Cilegon'],
            ['city_id'=>'53', 'city_name'=>'Lebak'],
            ['city_id'=>'368','city_name'=>'Pandeglang'],
            ['city_id'=>'455','city_name'=>'Serang'],
            ['city_id'=>'456','city_name'=>'Tangerang'],
            ['city_id'=>'457','city_name'=>'Tangerang Selatan'],
        ],
        '6'  => [
            ['city_id'=>'151','city_name'=>'Jakarta Barat'],
            ['city_id'=>'152','city_name'=>'Jakarta Pusat'],
            ['city_id'=>'153','city_name'=>'Jakarta Selatan'],
            ['city_id'=>'154','city_name'=>'Jakarta Timur'],
            ['city_id'=>'155','city_name'=>'Jakarta Utara'],
        ],
        '5'  => [
            ['city_id'=>'147','city_name'=>'Bantul'],
            ['city_id'=>'198','city_name'=>'Gunung Kidul'],
            ['city_id'=>'289','city_name'=>'Kulon Progo'],
            ['city_id'=>'435','city_name'=>'Sleman'],
            ['city_id'=>'501','city_name'=>'Yogyakarta'],
        ],
        '9'  => [
            ['city_id'=>'24','city_name'=>'Bandung'],
            ['city_id'=>'25','city_name'=>'Bandung Barat'],
            ['city_id'=>'68','city_name'=>'Bogor'],
            ['city_id'=>'142','city_name'=>'Cimahi'],
            ['city_id'=>'143','city_name'=>'Cirebon'],
            ['city_id'=>'159','city_name'=>'Depok'],
            ['city_id'=>'299','city_name'=>'Karawang'],
            ['city_id'=>'471','city_name'=>'Sukabumi'],
        ],
        '10' => [
            ['city_id'=>'127','city_name'=>'Cilacap'],
            ['city_id'=>'355','city_name'=>'Magelang'],
            ['city_id'=>'461','city_name'=>'Semarang'],
            ['city_id'=>'485','city_name'=>'Solo'],
        ],
        '11' => [
            ['city_id'=>'39','city_name'=>'Batu'],
            ['city_id'=>'50','city_name'=>'Banyuwangi'],
            ['city_id'=>'270','city_name'=>'Kediri'],
            ['city_id'=>'356','city_name'=>'Madiun'],
            ['city_id'=>'357','city_name'=>'Malang'],
            ['city_id'=>'452','city_name'=>'Sidoarjo'],
            ['city_id'=>'462','city_name'=>'Surabaya'],
        ],
        '1'  => [
            ['city_id'=>'17b','city_name'=>'Badung'],
            ['city_id'=>'163b','city_name'=>'Denpasar'],
            ['city_id'=>'193b','city_name'=>'Gianyar'],
        ],
        '18' => [
            ['city_id'=>'12l','city_name'=>'Bandar Lampung'],
            ['city_id'=>'18l','city_name'=>'Metro'],
        ],
        '25' => [
            ['city_id'=>'76r','city_name'=>'Dumai'],
            ['city_id'=>'415r','city_name'=>'Pekanbaru'],
        ],
        '33' => [
            ['city_id'=>'396s','city_name'=>'Medan'],
            ['city_id'=>'460s','city_name'=>'Pematang Siantar'],
        ],
        '31' => [
            ['city_id'=>'104sb','city_name'=>'Padang'],
            ['city_id'=>'38sb','city_name'=>'Bukittinggi'],
        ],
        '27' => [
            ['city_id'=>'110ss','city_name'=>'Makassar'],
        ],
        '15' => [
            ['city_id'=>'14kt','city_name'=>'Balikpapan'],
            ['city_id'=>'15kt','city_name'=>'Samarinda'],
        ],
    ];

    /**
     * Kecamatan aktual per kota
     * Cilegon (17): kecamatan asli Kota Cilegon
     */
    protected array $districts = [
        '17'  => [ // Cilegon
            ['subdistrict_id'=>'1701','subdistrict_name'=>'Cibeber'],
            ['subdistrict_id'=>'1702','subdistrict_name'=>'Cilegon'],
            ['subdistrict_id'=>'1703','subdistrict_name'=>'Ciwandan'],
            ['subdistrict_id'=>'1704','subdistrict_name'=>'Grogol'],
            ['subdistrict_id'=>'1705','subdistrict_name'=>'Jombang'],
            ['subdistrict_id'=>'1706','subdistrict_name'=>'Pulomerak'],
            ['subdistrict_id'=>'1707','subdistrict_name'=>'Purwakarta'],
            ['subdistrict_id'=>'1708','subdistrict_name'=>'Citangkil'],
        ],
        '455' => [ // Serang
            ['subdistrict_id'=>'45501','subdistrict_name'=>'Cipocok Jaya'],
            ['subdistrict_id'=>'45502','subdistrict_name'=>'Curug'],
            ['subdistrict_id'=>'45503','subdistrict_name'=>'Kasemen'],
            ['subdistrict_id'=>'45504','subdistrict_name'=>'Serang'],
            ['subdistrict_id'=>'45505','subdistrict_name'=>'Taktakan'],
            ['subdistrict_id'=>'45506','subdistrict_name'=>'Walantaka'],
        ],
        '456' => [ // Tangerang
            ['subdistrict_id'=>'45601','subdistrict_name'=>'Batu Ceper'],
            ['subdistrict_id'=>'45602','subdistrict_name'=>'Cipondoh'],
            ['subdistrict_id'=>'45603','subdistrict_name'=>'Jatiuwung'],
            ['subdistrict_id'=>'45604','subdistrict_name'=>'Karawaci'],
            ['subdistrict_id'=>'45605','subdistrict_name'=>'Neglasari'],
            ['subdistrict_id'=>'45606','subdistrict_name'=>'Periuk'],
        ],
        '457' => [ // Tangerang Selatan
            ['subdistrict_id'=>'45701','subdistrict_name'=>'Ciputat'],
            ['subdistrict_id'=>'45702','subdistrict_name'=>'Ciputat Timur'],
            ['subdistrict_id'=>'45703','subdistrict_name'=>'Pamulang'],
            ['subdistrict_id'=>'45704','subdistrict_name'=>'Pondok Aren'],
            ['subdistrict_id'=>'45705','subdistrict_name'=>'Serpong'],
            ['subdistrict_id'=>'45706','subdistrict_name'=>'Serpong Utara'],
        ],
        '24'  => [ // Bandung
            ['subdistrict_id'=>'2401','subdistrict_name'=>'Antapani'],
            ['subdistrict_id'=>'2402','subdistrict_name'=>'Arcamanik'],
            ['subdistrict_id'=>'2403','subdistrict_name'=>'Bandung Kidul'],
            ['subdistrict_id'=>'2404','subdistrict_name'=>'Buahbatu'],
            ['subdistrict_id'=>'2405','subdistrict_name'=>'Coblong'],
            ['subdistrict_id'=>'2406','subdistrict_name'=>'Kiaracondong'],
            ['subdistrict_id'=>'2407','subdistrict_name'=>'Lengkong'],
            ['subdistrict_id'=>'2408','subdistrict_name'=>'Regol'],
        ],
        '462' => [ // Surabaya
            ['subdistrict_id'=>'46201','subdistrict_name'=>'Benowo'],
            ['subdistrict_id'=>'46202','subdistrict_name'=>'Dukuh Pakis'],
            ['subdistrict_id'=>'46203','subdistrict_name'=>'Genteng'],
            ['subdistrict_id'=>'46204','subdistrict_name'=>'Gubeng'],
            ['subdistrict_id'=>'46205','subdistrict_name'=>'Rungkut'],
            ['subdistrict_id'=>'46206','subdistrict_name'=>'Sawahan'],
            ['subdistrict_id'=>'46207','subdistrict_name'=>'Wonokromo'],
        ],
        '357' => [ // Malang
            ['subdistrict_id'=>'35701','subdistrict_name'=>'Blimbing'],
            ['subdistrict_id'=>'35702','subdistrict_name'=>'Kedung Kandang'],
            ['subdistrict_id'=>'35703','subdistrict_name'=>'Klojen'],
            ['subdistrict_id'=>'35704','subdistrict_name'=>'Lowok Waru'],
            ['subdistrict_id'=>'35705','subdistrict_name'=>'Sukun'],
        ],
        '163b' => [ // Denpasar
            ['subdistrict_id'=>'d101','subdistrict_name'=>'Denpasar Barat'],
            ['subdistrict_id'=>'d102','subdistrict_name'=>'Denpasar Selatan'],
            ['subdistrict_id'=>'d103','subdistrict_name'=>'Denpasar Timur'],
            ['subdistrict_id'=>'d104','subdistrict_name'=>'Denpasar Utara'],
        ],
    ];

    protected array $provinceZones = [
        '3'=>1,'6'=>1,'9'=>1,'10'=>1,'11'=>1,'5'=>1,
        '1'=>2,'2'=>2,'4'=>2,'8'=>2,'17'=>2,'18'=>2,'21'=>2,'25'=>2,'31'=>2,'32'=>2,'33'=>2,'34'=>2,
        '12'=>3,'13'=>3,'14'=>3,'15'=>3,'16'=>3,'22'=>3,
        '26'=>4,'27'=>4,'28'=>4,'29'=>4,'30'=>4,'19'=>4,'20'=>4,
        '23'=>5,'24'=>5,
    ];

    protected array $cityToProvince = [];

    public function __construct() {
        foreach ($this->cities as $provId => $kotaList) {
            foreach ($kotaList as $kota) {
                $this->cityToProvince[$kota['city_id']] = (string)$provId;
            }
        }
    }

    public function getProvinces(): array {
        $data = $this->provinces;
        usort($data, fn($a,$b) => strcmp($a['province'],$b['province']));
        return $data;
    }

    public function getCities(string $provinceId): array {
        $cities = $this->cities[$provinceId] ?? $this->generateDefaultCities($provinceId);
        usort($cities, fn($a,$b) => strcmp($a['city_name'],$b['city_name']));
        return $cities;
    }

    protected function generateDefaultCities(string $provId): array {
        $provName = collect($this->provinces)->firstWhere('province_id',$provId)['province'] ?? 'Daerah';
        return [
            ['city_id'=>$provId.'01','city_name'=>'Kota '.$provName],
            ['city_id'=>$provId.'02','city_name'=>'Kabupaten '.$provName],
        ];
    }

    /**
     * Kecamatan: pakai data asli jika tersedia, fallback generic
     */
    public function getDistricts(string $cityId): array {
        if (isset($this->districts[$cityId])) {
            $result = $this->districts[$cityId];
            usort($result, fn($a,$b) => strcmp($a['subdistrict_name'],$b['subdistrict_name']));
            return $result;
        }
        // Generic fallback — bukan nama kardinal, tapi nama yang lebih masuk akal
        $generics = ['Kota','Timur','Barat','Selatan','Utara','Tengah','Dalam','Luar'];
        $cityName = collect($this->cities)->flatten(1)->firstWhere('city_id',$cityId)['city_name'] ?? 'Daerah';
        $result = array_map(fn($n,$i) => [
            'subdistrict_id'   => $cityId.'_'.($i+1),
            'subdistrict_name' => $cityName.' '.$n,
        ], $generics, array_keys($generics));
        usort($result, fn($a,$b) => strcmp($a['subdistrict_name'],$b['subdistrict_name']));
        return $result;
    }

    protected array $courierServices = [
        'jne'      => [['service'=>'REG','desc'=>'Reguler (1-3 hari)'],['service'=>'YES','desc'=>'Yakin Esok Sampai'],['service'=>'OKE','desc'=>'Ongkos Kirim Ekonomis']],
        'jnt'      => [['service'=>'REGULER','desc'=>'J&T Reguler'],['service'=>'EXPRESS','desc'=>'J&T Express']],
        'sicepat'  => [['service'=>'BEST','desc'=>'SiCepat BEST'],['service'=>'HALU','desc'=>'Hemat Aman Lanjut'],['service'=>'GOKIL','desc'=>'Gokil Murah']],
        'anteraja' => [['service'=>'REG','desc'=>'Anteraja Reguler'],['service'=>'SAME DAY','desc'=>'Same Day Delivery']],
        'pos'      => [['service'=>'Pos Reguler','desc'=>'Pos Kilat Khusus'],['service'=>'Pos Ekspres','desc'=>'Pos Ekspres']],
        'tiki'     => [['service'=>'REG','desc'=>'TIKI Reguler'],['service'=>'ONS','desc'=>'Over Night Service'],['service'=>'ECO','desc'=>'Economy Service']],
        'ninja'    => [['service'=>'REG','desc'=>'Ninja Xpress Reguler']],
        'sap'      => [['service'=>'REG','desc'=>'SAP Reguler']],
        'lion'     => [['service'=>'REG','desc'=>'Lion Parcel Reguler']],
        'wahana'   => [['service'=>'REG','desc'=>'Wahana Reguler']],
    ];

    protected array $etdByZone = [
        1 => ['REG'=>'1-2','YES'=>'1','OKE'=>'2-3','REGULER'=>'1-2','EXPRESS'=>'1','BEST'=>'1-2','HALU'=>'2-3','GOKIL'=>'3-5','SAME DAY'=>'1','Pos Reguler'=>'2-4','Pos Ekspres'=>'1-2','ONS'=>'1','ECO'=>'4-6','default'=>'1-3'],
        2 => ['REG'=>'2-3','YES'=>'2','OKE'=>'3-5','REGULER'=>'2-3','EXPRESS'=>'2','BEST'=>'2-3','Pos Reguler'=>'3-5','Pos Ekspres'=>'2-3','ONS'=>'2','ECO'=>'6-8','default'=>'2-4'],
        3 => ['REG'=>'3-5','YES'=>'3','OKE'=>'5-7','REGULER'=>'3-5','EXPRESS'=>'3','BEST'=>'3-4','Pos Reguler'=>'5-7','Pos Ekspres'=>'3-4','ONS'=>'3','ECO'=>'7-9','default'=>'3-6'],
        4 => ['REG'=>'5-7','YES'=>'4','REGULER'=>'5-7','EXPRESS'=>'4','BEST'=>'4-6','Pos Reguler'=>'6-9','default'=>'5-8'],
        5 => ['REG'=>'7-10','REGULER'=>'7-10','EXPRESS'=>'6-8','BEST'=>'6-8','Pos Reguler'=>'9-14','default'=>'7-14'],
    ];

    public function calculateCost(string $origin, string $destination, int $weightGram, string $courier): array {
        $courier  = strtolower($courier);
        $services = $this->courierServices[$courier] ?? $this->courierServices['jne'];
        $zone     = $this->detectZone($destination);
        $weightKg = max(1, $weightGram / 1000);
        $bases    = [1=>9000,2=>14000,3=>22000,4=>32000,5=>48000];
        $base     = $bases[$zone] ?? 14000;
        $result   = [];
        foreach ($services as $i => $svc) {
            $isExpress = in_array(strtoupper($svc['service']),['YES','EXPRESS','SAME DAY','ONS','POS EKSPRES']);
            $multi = $isExpress ? 1.35 : ($i===0 ? 1.0 : ($i===1 ? 0.88 : 0.75));
            $price = (int)(ceil((($base + (($weightKg - 1) * 3000)) * $multi) / 500) * 500);
            $etd   = $this->etdByZone[$zone][$svc['service']] ?? $this->etdByZone[$zone]['default'] ?? '2-5';
            $result[] = ['service'=>$svc['service'],'description'=>$svc['desc'],'cost'=>[['value'=>$price,'etd'=>(string)$etd,'note'=>'']]];
        }
        return $result;
    }

    protected function detectZone(string $destination): int {
        if (isset($this->provinceZones[$destination])) return $this->provinceZones[$destination];
        if (isset($this->cityToProvince[$destination])) return $this->provinceZones[$this->cityToProvince[$destination]] ?? 2;
        foreach ([3,2,1] as $len) {
            $p = substr($destination,0,$len);
            if (isset($this->provinceZones[$p])) return $this->provinceZones[$p];
        }
        return 2;
    }

    public function trackWaybill(string $awb, string $courier): array {
        $cn   = strtoupper($courier);
        $now  = now();
        $hubs = ['DC Cakung - Jakarta Timur','Hub Kemayoran - Jakarta Pusat','DC Bekasi','Hub Cilincing - Jakarta Utara'];
        $hub  = $hubs[abs(crc32($awb)) % count($hubs)];
        return [
            'waybill_number' => $awb,
            'courier'        => $cn,
            'status'         => 'DELIVERED',
            'manifest'       => [
                ['date'=>$now->format('Y-m-d'),                      'time'=>$now->format('H:i'),            'description'=>"Paket diterima oleh penerima. Terima kasih berbelanja di BelanjaYuk!"],
                ['date'=>$now->copy()->subHours(3)->format('Y-m-d'),  'time'=>$now->copy()->subHours(3)->format('H:i'), 'description'=>"Paket sedang diantarkan oleh kurir {$cn}"],
                ['date'=>$now->copy()->subHours(5)->format('Y-m-d'),  'time'=>$now->copy()->subHours(5)->format('H:i'), 'description'=>"Paket keluar dari {$hub} menuju area pengiriman"],
                ['date'=>$now->copy()->subDay()->format('Y-m-d'),     'time'=>'23:47',                        'description'=>"📦 Paket lagi proses di DC Cakung — sebentar lagi deh!"],
                ['date'=>$now->copy()->subDay()->format('Y-m-d'),     'time'=>'19:30',                        'description'=>"Paket tiba di {$hub}. Sedang dalam proses sortir"],
                ['date'=>$now->copy()->subDays(2)->format('Y-m-d'),   'time'=>'14:22',                        'description'=>"Paket berangkat dari Hub Cilegon - Banten menuju hub tujuan [{$cn}]"],
                ['date'=>$now->copy()->subDays(2)->format('Y-m-d'),   'time'=>'09:10',                        'description'=>"Paket diterima di Hub Cilegon - Banten dan sedang diproses"],
                ['date'=>$now->copy()->subDays(3)->format('Y-m-d'),   'time'=>'10:05',                        'description'=>"Paket dijemput oleh kurir {$cn} dari pengirim [AWB: {$awb}]"],
            ],
        ];
    }
}
