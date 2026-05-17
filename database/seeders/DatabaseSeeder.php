<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // ===== USERS =====
        DB::table('users')->insert(['name'=>'Admin BelanjaYuk','email'=>'admin@belanjayuk.com','phone'=>'081234567890','role'=>'admin','password'=>Hash::make('admin123'),'is_active'=>true,'created_at'=>now(),'updated_at'=>now()]);
        foreach([
            ['Budi Santoso','budi@example.com','082111222333'],
            ['Siti Rahayu','siti@example.com','083444555666'],
            ['Ahmad Fauzi','ahmad@example.com','085777888999'],
            ['Dewi Putri','dewi@example.com','087112233445'],
            ['Rizky Pratama','rizky@example.com','081355667788'],
            ['Maya Sari','maya@example.com','089922334455'],
            ['Hendra Wijaya','hendra@example.com','085612341234'],
            ['Rina Kusuma','rina@example.com','081278781234'],
        ] as [$n,$e,$p])
            DB::table('users')->insert(['name'=>$n,'email'=>$e,'phone'=>$p,'role'=>'user','password'=>Hash::make('user123'),'is_active'=>true,'created_at'=>now()->subDays(rand(30,180)),'updated_at'=>now()]);

        // User Arif — password arif123
        DB::table('users')->insert(['name'=>'Arif Siddik M','email'=>'arifsiddikmuharam@gmail.com','phone'=>'089514392694','role'=>'user','password'=>Hash::make('arif123'),'is_active'=>true,'created_at'=>now()->subDays(30),'updated_at'=>now()]);

        // ===== CATEGORIES =====
        foreach([
            ['Fashion Pria','fashion-pria','👔','https://images.unsplash.com/photo-1490578474895-699cd4e2cf59?w=400'],
            ['Fashion Wanita','fashion-wanita','👗','https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=400'],
            ['Elektronik','elektronik','📱','https://images.unsplash.com/photo-1498049794561-7780e7231661?w=400'],
            ['Alat Rumah Tangga','alat-rumah-tangga','🏠','https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400'],
            ['Olahraga','olahraga','⚽','https://images.unsplash.com/photo-1517649763962-0c623066013b?w=400'],
            ['Kecantikan','kecantikan','💄','https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400'],
            ['Sepatu & Tas','sepatu-tas','👟','https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400'],
            ['Mainan & Hobi','mainan-hobi','🎮','https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=400'],
        ] as $i=>[$name,$slug,$icon,$img])
            DB::table('categories')->insert(['name'=>$name,'slug'=>$slug,'icon'=>$icon,'image'=>$img,'is_active'=>true,'sort_order'=>$i,'created_at'=>now(),'updated_at'=>now()]);

        // ===== PRODUCTS — track ID yang berhasil diinsert =====
        $desc = fn($p,$m,$s,$t) => "<p><strong>{$p}</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>{$m}</p><p><strong>Spesifikasi & Fitur:</strong><br>{$s}</p><p><strong>Tips Penggunaan:</strong><br>{$t}</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>";

        $products = [
            // [cat_id, name, price, sale_price, thumb, featured, promo, stock, weight(g)]
            [1,'Kemeja Flanel Pria Premium',189000,149000,'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=500',true,true,200,300,$desc('Kemeja Flanel Pria','Bahan 100% cotton breathable, nyaman seharian','Cotton Flannel 180gsm, kancing kokoh, S-XXL','Cuci air dingin, setrika suhu sedang')],
            [1,'Celana Chino Slim Fit',249000,199000,'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=500',true,false,150,450,$desc('Celana Chino Slim','Potongan modern, bebas bergerak','Stretch cotton twill 260gsm, 4 kantong, slim fit','Cuci terpisah warna gelap')],
            [1,'Kaos Polo Pria Kasual',129000,null,'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?w=500',false,false,300,220,$desc('Kaos Polo','Semi-formal nyaman dipakai','Pique Cotton 220gsm, kerah 2 kancing, S-XXL','Cuci terbalik untuk menjaga warna')],
            [1,'Jaket Bomber Distro',359000,289000,'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=500',true,true,80,600,$desc('Jaket Bomber','Tahan angin & air ringan','Polyester Taslan outer, fleece inner, YKK zipper','Cuci tangan atau dry clean')],
            [1,'Kemeja Batik Modern',229000,189000,'https://images.unsplash.com/photo-1594938298603-c8148c4b4357?w=500',false,true,120,280,$desc('Kemeja Batik','Formal & semi-kasual','Katun prima 140gsm, motif eksklusif, M-XXL','Cuci tangan air dingin')],
            [1,'Celana Jogger Premium',199000,159000,'https://images.unsplash.com/photo-1552902865-b72c031ac5ea?w=500',false,false,200,350,$desc('Celana Jogger','Nyaman olahraga & santai','Fleece cotton 280gsm, pinggang elastis','Balik saat mencuci')],
            [1,'T-Shirt Grafis Oversize',159000,null,'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500',true,false,250,220,$desc('T-Shirt Oversize','Streetwear premium trendy','Cotton Combed 30s, sablon DTF, M-3XL','Cuci terbalik, hindari sinar matahari')],
            [1,'Sweater Knit Pria',279000,229000,'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=500',false,true,100,480,$desc('Sweater Rajut','Hangat untuk AC & dingin','Acrylic wool blend, crew neck, S-XL','Cuci tangan air dingin')],
            [1,'Celana Jeans Slim',319000,269000,'https://images.unsplash.com/photo-1542272604-787c3835535d?w=500',true,false,130,700,$desc('Jeans Slim','Denim berkualitas, elegan','Denim stretch 12oz, 5 kantong, 28-36','Cuci terbalik air dingin')],
            [1,'Kemeja Oxford Formal',289000,null,'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=500',false,false,90,280,$desc('Kemeja Oxford','Profesional sepanjang hari','Oxford Cotton 100%, button-down, putih/biru/abu','Setrika saat lembab')],
            [2,'Dress Midi Floral',279000,219000,'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=500',true,true,200,350,$desc('Dress Midi Floral','Elegan untuk berbagai acara','Chiffon premium, ritsleting tersembunyi, XS-XL','Cuci tangan lembut')],
            [2,'Blouse Wanita Elegan',189000,null,'https://images.unsplash.com/photo-1564257631407-4deb1f99d992?w=500',false,false,250,280,$desc('Blouse Satin','Kesan mewah terjangkau','Satin polyester, V-neck, lengan balloon','Cuci tangan air dingin')],
            [2,'Rok Plisket Trendy',159000,129000,'https://images.unsplash.com/photo-1583496661160-fb5218a9bfe4?w=500',true,false,180,250,$desc('Rok Plisket','Feminin & nyaman','Chiffon ringan, pinggang elastis, mini/midi','Jangan diperas')],
            [2,'Cardigan Rajut Oversize',299000,239000,'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=500',true,true,150,420,$desc('Cardigan Oversize','Hangat & trendy','Acrylic knit, 2 kantong, S-XL','Keringkan rata, jangan digantung')],
            [2,'Jumpsuit Casual Wanita',319000,259000,'https://images.unsplash.com/photo-1551803091-e20673f15770?w=500',true,true,100,380,$desc('Jumpsuit Linen','One-piece stylish','Linen blend, wide-leg, sabuk cantik','Setrika saat agak lembab')],
            [2,'Tunik Batik Wanita',199000,169000,'https://images.unsplash.com/photo-1585487000160-6ebcfceb0d03?w=500',false,false,200,300,$desc('Tunik Batik','Motif eksklusif Indonesia','Katun prima, panjang ±85cm, M-3XL','Cuci tangan, keringkan teduh')],
            [2,'Celana Kulot Wanita',219000,null,'https://images.unsplash.com/photo-1594938298603-c8148c4b4357?w=500',false,true,180,320,$desc('Kulot High-Waist','Kaki terlihat jenjang','Linen blend, high-waist, XS-XL','Cuci gentle mode')],
            [2,'Dress Wrap Flowy',259000,209000,'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=500',false,true,120,320,$desc('Dress Wrap','Flattering semua bentuk tubuh','Viscose rayon, V-neck, panjang ±105cm','Angin-anginkan segera')],
            [3,'TWS Earbuds Bluetooth',189000,159000,'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=500',true,true,50,120,$desc('TWS Earbuds BT 5.3','Bass kaya, ANC premium','BT 5.3, driver 13mm, ANC 30dB, IPX5','Charge di case saat tidak digunakan')],
            [3,'Power Bank 20000mAh',279000,null,'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=500',false,false,100,380,$desc('Power Bank 20000mAh','Isi daya smartphone 5x','22.5W fast charge, 3 port, 11 proteksi','Charge sebelum penyimpanan lama')],
            [3,'Smartwatch Fitness Pro',459000,389000,'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500',true,true,75,180,$desc('Smartwatch AMOLED','Monitor kesehatan 24 jam','1.78" AMOLED, GPS, SpO2, 5ATM, 7-14 hari','Update firmware berkala')],
            [3,'Laptop Stand Aluminium',159000,129000,'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500',false,true,150,650,$desc('Laptop Stand','Ergonomis, postur lebih baik','Aluminium 6061, 15°-45°, 10-17", foldable','Bersihkan dengan kain microfiber')],
            [3,'Wireless Mouse Silent',149000,null,'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500',false,false,200,120,$desc('Mouse Wireless','Silent click, anti lelah','2.4GHz, 800-1600 DPI, 5 tombol, 12 bulan baterai','Bersihkan sensor berkala')],
            [3,'Speaker Bluetooth 360°',289000,249000,'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500',true,false,60,400,$desc('Speaker BT Portable','Suara 360°, IPX7','20W, BT 5.0, IPX7, 12 jam, TWS mode','Bilas air tawar setelah kena air laut')],
            [3,'Charger GaN 65W',199000,169000,'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=500',false,true,120,150,$desc('Charger GaN 65W','Efisien, compact','GaN, 65W total, 2x USB-C + 1x USB-A, PD 3.0','Pastikan ventilasi cukup')],
            [3,'Ring Light LED 10"',179000,149000,'https://images.unsplash.com/photo-1587826080692-f439cd0b70da?w=500',false,true,90,600,$desc('Ring Light LED','Perfect untuk konten','10", 120 LED, 3 mode warna, 10 level kecerahan','Jangan sentuh LED langsung')],
            [4,'Blender Portable Mini',229000,189000,'https://images.unsplash.com/photo-1570222094114-d054a817e56b?w=500',true,false,80,480,$desc('Blender Portable','Buat smoothie di mana saja','25000RPM, 4000mAh USB-C, 400ml BPA-free','Cuci setelah setiap pakai')],
            [4,'Bantal Memory Foam',259000,209000,'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500',true,true,100,550,$desc('Bantal Memory Foam','Tidur lebih nyenyak','60D premium, cover bamboo, anti-bakteri, 60x40cm','Angin-anginkan tiap 2-4 minggu')],
            [4,'Rice Cooker Digital 1.8L',399000,349000,'https://images.unsplash.com/photo-1585515320310-259814833e62?w=500',false,true,60,1200,$desc('Rice Cooker Digital','8 mode memasak','1.8L, Teflon triple-layer, timer, keep warm 24j','Bersihkan setelah tiap pakai')],
            [4,'Vacuum Cleaner Cordless',279000,229000,'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500',false,false,70,750,$desc('Vacuum Cordless 2-in-1','Bersih tanpa kabel','21kPa, 35 menit, HEPA washable, 1.2kg','Kosongkan penampung setelah pakai')],
            [5,'Sepatu Running Pro',399000,319000,'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500',true,true,100,700,$desc('Sepatu Running','Anti-slip semua medan','Engineered mesh, EVA+TPU, reflective, 37-46','Keringkan alami, hindari matahari')],
            [5,'Matras Yoga 6mm',199000,null,'https://images.unsplash.com/photo-1601925228058-d4b32b22dd3f?w=500',false,false,120,850,$desc('Matras Yoga TPE','Eco-friendly, grip sempurna','TPE, 183x61cm, double non-slip, 1kg, strap','Lap setelah tiap pakai')],
            [5,'Dumbbell Set 10kg',549000,469000,'https://images.unsplash.com/photo-1590487988256-9ed24133863e?w=500',true,false,30,10500,$desc('Dumbbell Adjustable','5 level dalam 1 set','2-10kg, besi cor + karet, pin selector','Simpan di tray, jangan dijatuhkan')],
            [5,'Resistance Band Set',159000,129000,'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=500',false,true,200,300,$desc('Resistance Band 5 Level','Progresif & lengkap','5 band 5-40kg, latex natural, door anchor dll','Inspeksi sebelum pakai')],
            [6,'Serum Vitamin C 20%',129000,99000,'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500',true,true,300,50,$desc('Serum Vitamin C','Cerahkan & anti-aging','20% L-AA, HA 2%, Niacinamide 5%, pH 3.0-3.5','Pakai pagi + sunscreen')],
            [6,'Sunscreen SPF50+ 50ml',89000,69000,'https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=500',false,true,400,80,$desc('Sunscreen PA++++','Perlindungan maksimal tanpa white cast','SPF50+ PA++++, lightweight, water-resistant 80min','Reapply tiap 2 jam di luar')],
            [6,'Toner Niacinamide 10%',119000,89000,'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500',false,false,250,150,$desc('Toner Niacinamide','Pori kecil, kontrol minyak','Niacinamide 10%, Zinc PCA, HA, alcohol-free, 200ml','Pagi & malam setelah cleansing')],
            [6,'Body Lotion Whitening',99000,79000,'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500',true,true,500,300,$desc('Body Lotion Glutathione','Cerahkan kulit tubuh','Glutathione 1000mg, Vit C+E, SPF15, 250ml','Pakai segera setelah mandi')],
            [7,'Sneakers Casual Canvas',329000,259000,'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?w=500',true,true,150,750,$desc('Sneakers Casual','Versatile, cocok semua outfit','Canvas cotton, sol vulkanized, memory foam, 36-45','Bersihkan dengan sikat lembut')],
            [7,'Tas Ransel Laptop 35L',389000,null,'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500',false,false,120,900,$desc('Ransel Anti Air 35L','Organizer lengkap','900D polyester, kompartemen laptop 15.6", USB port','Bersihkan dengan kain lembab')],
            [7,'Dompet Kulit RFID',229000,189000,'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=500',false,false,150,150,$desc('Dompet Slim RFID','Data kartu aman dari skimming','Genuine leather, RFID block, 12 slot, 1.2cm','Kondisioner kulit tiap 3-6 bulan')],
            [7,'Sepatu Boots Pria',489000,399000,'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500',true,true,60,1100,$desc('Boots Leather Goodyear','Semakin indah seiring waktu','Genuine leather, Goodyear welt, side zipper, 39-45','Cedar shoe tree & wax rutin')],
            [8,'Lego Building Blocks 1000pcs',189000,159000,'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=500',true,true,80,400,$desc('Lego 1000pcs','Latih kreativitas anak','ABS food-grade, 30+ warna, kompatibel lego standar','Cuci air sabun, keringkan sempurna')],
            [8,'RC Car Off-Road 4WD',299000,249000,'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=500',false,true,60,800,$desc('RC Car 4WD','Seru semua medan','25km/h, 4WD, jangkauan 80m, 30-40 menit','Bersihkan dari tanah setelah pakai')],
            [8,'Drone Mini Selfie 1080p',599000,499000,'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=500',true,true,30,350,$desc('Drone Mini Selfie','Foto udara mudah & seru','1080p EIS, obstacle avoidance, 20-25 menit, 100m','Kalibrasi kompas sebelum terbang')],
        ];

        // Insert products dan SIMPAN id yang berhasil
        $fashionProductIds = [];   // cat 1 & 2 → perlu varian ukuran
        $sepatuProductIds  = [];   // cat 7 sepatu → varian ukuran sepatu

        foreach ($products as $i => [$cid, $name, $price, $sale, $thumb, $feat, $promo, $stock, $weight, $dsc]) {
            $id = DB::table('products')->insertGetId([
                'category_id'       => $cid,
                'name'              => $name,
                'slug'              => Str::slug($name) . '-' . ($i + 1),
                'sku'               => 'BY-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),
                'short_description' => strip_tags(substr($dsc, 0, 150)) . '...',
                'description'       => $dsc,
                'price'             => $price,
                'sale_price'        => $sale,
                'stock'             => $stock,
                'weight'            => $weight,
                'length'            => rand(10, 40),
                'width'             => rand(5, 30),
                'height'            => rand(1, 20),
                'thumbnail'         => $thumb,
                'is_active'         => true,
                'is_featured'       => $feat,
                'is_promo'          => $promo,
                'is_new'            => ($i < 20),
                'views'             => rand(200, 12000),
                'sold_count'        => rand(20, 1200),
                'created_at'        => now()->subDays(rand(0, 180)),
                'updated_at'        => now(),
            ]);

            // Kategorisasi untuk variants
            if (in_array($cid, [1, 2])) $fashionProductIds[] = $id;
            if ($cid === 7 && stripos($name, 'sepatu') !== false) $sepatuProductIds[] = $id;
            if ($cid === 7 && stripos($name, 'boots') !== false) $sepatuProductIds[] = $id;
        }

        // ===== VARIANTS — pakai ID yang BENAR =====
        // Varian ukuran pakaian (fashion)
        foreach ($fashionProductIds as $pid) {
            foreach (['S', 'M', 'L', 'XL'] as $sz) {
                DB::table('product_variants')->insert([
                    'product_id'       => $pid,
                    'name'             => 'Ukuran',
                    'value'            => $sz,
                    'price_adjustment' => $sz === 'XL' ? 15000 : 0,
                    'stock'            => rand(10, 50),
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }

        // Varian ukuran sepatu
        foreach ($sepatuProductIds as $pid) {
            foreach (['38', '39', '40', '41', '42', '43', '44'] as $uk) {
                DB::table('product_variants')->insert([
                    'product_id'       => $pid,
                    'name'             => 'Ukuran',
                    'value'            => $uk,
                    'price_adjustment' => 0,
                    'stock'            => rand(5, 20),
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }

        // ===== BANNERS =====
        foreach([
            ['Flash Sale Spesial!','Diskon hingga 70% semua produk','https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=1200','/produk?promo=1','Belanja Sekarang'],
            ['New Collection 2025','Koleksi fashion terbaru trendy & terjangkau','https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200','/produk?category=fashion-pria','Lihat Koleksi'],
            ['Gadget & Elektronik','Teknologi terkini harga bersahabat','https://images.unsplash.com/photo-1498049794561-7780e7231661?w=1200','/produk?category=elektronik','Cek Promo'],
            ['Gratis Ongkir Hari Ini!','Min. pembelian Rp 150.000','https://images.unsplash.com/photo-1607082349566-187342175400?w=1200','/produk','Mulai Belanja'],
        ] as $i=>[$t,$s,$img,$l,$b])
            DB::table('banners')->insert(['title'=>$t,'subtitle'=>$s,'image'=>$img,'link'=>$l,'button_text'=>$b,'sort_order'=>$i,'is_active'=>true,'created_at'=>now(),'updated_at'=>now()]);

        // ===== COUPONS =====
        foreach([['WELCOME10','Diskon 10%','percentage',10,0,50000,100],['HEMAT50','Hemat Rp 50.000','fixed',50000,200000,null,50],['FLASH20','Flash Sale 20%','percentage',20,100000,100000,200],['GRATIS25K','Diskon Rp 25.000','fixed',25000,100000,null,999]] as [$code,$d,$type,$val,$min,$max,$lim])
            DB::table('coupons')->insert(['code'=>$code,'description'=>$d,'type'=>$type,'value'=>$val,'min_purchase'=>$min,'max_discount'=>$max,'usage_limit'=>$lim,'is_active'=>true,'expires_at'=>now()->addMonths(6)->toDateString(),'created_at'=>now(),'updated_at'=>now()]);

        // ===== REVIEWS (minimal 2 per produk) =====
        $cmts = [
            'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.',
            'Kualitas oke, harga terjangkau. Recommended!',
            'Sudah pesan kedua kali, kualitas konsisten. Puas!',
            'Packaging rapi dan aman, produk sempurna.',
            'Sangat puas! Bahan bagus, jahitan rapi.',
            'Pengiriman cepat, produk original!',
            'Mantap, produk sesuai foto, worth it!',
            'Sudah dipakai beberapa kali masih bagus.',
            'Bahan premium, nyaman seharian!',
            'Desain bagus, kualitas jahitan rapi. Puas!',
        ];

        $allProductIds = DB::table('products')->pluck('id')->toArray();
        foreach ($allProductIds as $pid) {
            $reviewCount = rand(2, 5); // minimal 2 ulasan
            for ($r = 0; $r < $reviewCount; $r++) {
                DB::table('product_reviews')->insert([
                    'product_id'  => $pid,
                    'user_id'     => rand(2, 9),
                    'rating'      => rand(4, 5),
                    'comment'     => $cmts[array_rand($cmts)],
                    'is_approved' => true,
                    'created_at'  => now()->subDays(rand(1, 90)),
                    'updated_at'  => now(),
                ]);
            }
        }

        // ===== STORE SETTINGS =====
        foreach([
            ['store_name','BelanjaYuk!'],
            ['store_tagline','Belanja Hemat, Kualitas Terjamin'],
            ['store_email','admin@belanjayuk.com'],
            ['store_phone','021-12345678'],
            ['store_whatsapp','6289514392694'],
            ['store_address','Jl. KH. Yasin Beji No. 12, Cilegon, Banten 42414'],
            ['bank_bca','1234567890 a.n BelanjaYuk!'],
            ['bank_bni','9876543210 a.n BelanjaYuk!'],
            ['bank_mandiri','1357924680 a.n BelanjaYuk!'],
            ['shipping_origin_city','17'],
            ['meta_description','BelanjaYuk! - Toko Online Fashion & Elektronik Terpercaya.'],
        ] as [$k,$v])
            DB::table('store_settings')->insert(['key'=>$k,'value'=>$v,'created_at'=>now(),'updated_at'=>now()]);

        // Panggil OrdersSeeder
        $this->call(OrdersSeeder::class);
    }
}
