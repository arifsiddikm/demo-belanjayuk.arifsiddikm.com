<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

/**
 * OrdersSeeder
 * Buatkan data dummy lengkap:
 * - User Arif Siddik M dengan password yang benar (arif123)
 * - 60+ dummy orders berbagai status
 *
 * Jalankan: php artisan db:seed --class=OrdersSeeder
 * Atau tambahkan di DatabaseSeeder: $this->call(OrdersSeeder::class);
 */
class OrdersSeeder extends Seeder {
    public function run(): void {
        $this->command->info('Mulai seed orders...');

        // ===== ENSURE USER ARIF ADA & PASSWORD BENAR =====
        $arif = DB::table('users')->where('email', 'arifsiddikmuharam@gmail.com')->first();
        if (!$arif) {
            $arifId = DB::table('users')->insertGetId([
                'name'       => 'Arif Siddik M',
                'email'      => 'arifsiddikmuharam@gmail.com',
                'phone'      => '089514392694',
                'role'       => 'user',
                'password'   => Hash::make('arif123'), // Password benar: arif123
                'is_active'  => true,
                'created_at' => now()->subDays(30),
                'updated_at' => now(),
            ]);
            $this->command->info("User Arif dibuat (ID: {$arifId})");
        } else {
            // Update password jika salah
            DB::table('users')->where('email', 'arifsiddikmuharam@gmail.com')->update([
                'password'   => Hash::make('arif123'),
                'name'       => 'Arif Siddik M',
                'phone'      => '089514392694',
                'updated_at' => now(),
            ]);
            $arifId = $arif->id;
            $this->command->info("User Arif diupdate (ID: {$arifId}), password: arif123");
        }

        // Pastikan alamat Arif ada
        if (!DB::table('addresses')->where('user_id', $arifId)->exists()) {
            DB::table('addresses')->insert([
                'user_id'        => $arifId,
                'label'          => 'Rumah',
                'recipient_name' => 'Arif Siddik M',
                'phone'          => '089514392694',
                'address'        => 'Jl. KH. Yasin Beji No. 12',
                'province_id'    => '3',
                'province_name'  => 'Banten',
                'city_id'        => '17',
                'city_name'      => 'Cilegon',
                'district_id'    => null,
                'district_name'  => null,
                'postal_code'    => null,
                'is_default'     => true,
                'created_at'     => now()->subDays(28),
                'updated_at'     => now(),
            ]);
        }

        // ===== AMBIL DATA YANG ADA =====
        $users    = DB::table('users')->where('role', 'user')->pluck('id')->toArray();
        $products = DB::table('products')->where('is_active', true)->get();

        if ($products->isEmpty()) {
            $this->command->error('Tidak ada produk! Jalankan DatabaseSeeder dulu.');
            return;
        }

        if (empty($users)) {
            $this->command->error('Tidak ada user!');
            return;
        }

        // Cek order number terakhir
        $lastOrderNum = DB::table('orders')
            ->where('order_number', 'like', 'BY-%')
            ->orderByDesc('id')
            ->value('order_number');
        $counter = $lastOrderNum
            ? (int)substr($lastOrderNum, 3) + 1
            : 1001;

        $couriers     = ['jne','jnt','sicepat','anteraja','pos','tiki'];
        $couriersName = ['jne'=>'JNE','jnt'=>'J&T','sicepat'=>'SiCepat','anteraja'=>'AnterAja','pos'=>'Pos Indonesia','tiki'=>'TIKI'];
        $services     = ['REG','YES','OKE','EXPRESS','REGULER','BEST'];
        $banks        = ['BCA','BNI','Mandiri'];
        $addresses    = [
            ['Jl. Merdeka No. 15', 'DKI Jakarta', 'Jakarta Pusat', 'Gambir', '10110'],
            ['Jl. Pahlawan No. 7',  'Jawa Barat',  'Bandung',       'Cicendo', '40171'],
            ['Jl. Ahmad Yani No. 33','Jawa Timur', 'Surabaya',      'Wonokromo', '60243'],
            ['Jl. Diponegoro No. 9', 'Banten',     'Cilegon',       'Ciwandan', '42414'],
            ['Jl. Sudirman No. 55',  'Jawa Tengah','Semarang',      'Semarang Tengah', '50131'],
            ['Jl. Kenanga No. 22',   'DKI Jakarta','Jakarta Selatan','Kebayoran Baru', '12120'],
            ['Jl. Gatot Subroto No. 10','Bali',    'Denpasar',      'Denpasar Selatan', '80225'],
            ['Jl. Imam Bonjol No. 3','Sumatera Utara','Medan',      'Medan Baru', '20152'],
        ];

        // ===== STATUS DISTRIBUTION =====
        // Lebih realistis: lebih banyak selesai & dikirim
        $statusDist = [
            'menunggu_bayar' => 8,
            'diproses'       => 10,
            'dikirim'        => 15,
            'diterima'       => 8,
            'selesai'        => 25,
            'dibatalkan'     => 4,
        ];

        $totalCreated = 0;

        foreach ($statusDist as $status => $count) {
            for ($i = 0; $i < $count; $i++) {
                $userId    = $users[array_rand($users)];
                $prodArr   = $products->random(rand(1, 3)); // 1-3 produk per order
                $courier   = $couriers[array_rand($couriers)];
                $service   = $services[array_rand($services)];
                $payMethod = rand(0,1) ? 'bank_transfer' : 'midtrans';
                $addrData  = $addresses[array_rand($addresses)];
                $createdAt = now()->subDays(rand(1, 90));
                $user      = DB::table('users')->find($userId);
                $orderNum  = 'BY-' . $counter++;

                // Hitung subtotal dari produk
                $subtotal = 0;
                $itemsData = [];
                foreach ($prodArr as $prod) {
                    $qty   = rand(1, 3);
                    $price = $prod->sale_price ?? $prod->price;
                    $itemsData[] = ['prod' => $prod, 'qty' => $qty, 'price' => $price, 'subtotal' => $price * $qty];
                    $subtotal += $price * $qty;
                }

                $shipping = rand(9000, 38000);
                $discount = rand(0,1) ? rand(5000, 25000) : 0;
                $total    = $subtotal + $shipping - $discount;
                $total    = max($total, $shipping); // min total = ongkir

                $orderId = DB::table('orders')->insertGetId([
                    'order_number'         => $orderNum,
                    'user_id'              => $userId,
                    'recipient_name'       => $user->name,
                    'recipient_phone'      => $user->phone ?? '08' . rand(10000000, 99999999),
                    'recipient_address'    => $addrData[0] . ', RT 0' . rand(1,9) . '/RW 0' . rand(1,9),
                    'province_name'        => $addrData[1],
                    'city_name'            => $addrData[2],
                    'district_name'        => $addrData[3],
                    'postal_code'          => $addrData[4],
                    'courier'              => $courier,
                    'courier_service'      => $service,
                    'courier_service_name' => ($couriersName[$courier] ?? strtoupper($courier)) . ' ' . $service,
                    'shipping_cost'        => $shipping,
                    'estimated_days'       => rand(1, 5),
                    'subtotal'             => $subtotal,
                    'discount'             => $discount,
                    'coupon_code'          => $discount > 0 ? 'HEMAT' . rand(10,50) : null,
                    'total'                => $total,
                    'payment_method'       => $payMethod,
                    'payment_status'       => in_array($status, ['menunggu_bayar']) ? 'pending' : 'paid',
                    'status'               => $status,
                    'notes'                => rand(0,3) === 0 ? 'Mohon packing dengan bubble wrap' : '',
                    'tracking_number'      => in_array($status, ['dikirim','diterima','selesai'])
                        ? strtoupper($courier) . rand(10000000, 99999999) : null,
                    'paid_at'              => !in_array($status, ['menunggu_bayar'])
                        ? $createdAt->copy()->addHours(rand(1,8)) : null,
                    'shipped_at'           => in_array($status, ['dikirim','diterima','selesai'])
                        ? $createdAt->copy()->addDays(1) : null,
                    'completed_at'         => $status === 'selesai'
                        ? $createdAt->copy()->addDays(rand(5,14)) : null,
                    'cancelled_at'         => $status === 'dibatalkan'
                        ? $createdAt->copy()->addHours(rand(1,6)) : null,
                    'cancel_reason'        => $status === 'dibatalkan' ? 'Stok tidak sesuai' : null,
                    'created_at'           => $createdAt,
                    'updated_at'           => now(),
                ]);

                // Order items
                foreach ($itemsData as $item) {
                    DB::table('order_items')->insert([
                        'order_id'           => $orderId,
                        'product_id'         => $item['prod']->id,
                        'product_variant_id' => null,
                        'product_name'       => $item['prod']->name,
                        'product_thumbnail'  => $item['prod']->thumbnail,
                        'variant_info'       => null,
                        'quantity'           => $item['qty'],
                        'price'              => $item['price'],
                        'subtotal'           => $item['subtotal'],
                        'created_at'         => $createdAt,
                        'updated_at'         => now(),
                    ]);
                }

                // Payment confirmation untuk bank transfer
                if ($payMethod === 'bank_transfer' && !in_array($status, ['menunggu_bayar','dibatalkan'])) {
                    DB::table('payment_confirmations')->insertOrIgnore([
                        'order_id'       => $orderId,
                        'user_id'        => $userId,
                        'bank_name'      => $banks[array_rand($banks)],
                        'account_name'   => $user->name,
                        'account_number' => '1234' . rand(100000, 999999),
                        'amount'         => $total,
                        'transfer_proof' => null,
                        'status'         => in_array($status, ['diproses']) ? 'pending' : 'approved',
                        'admin_notes'    => 'Dummy data seeder.',
                        'created_at'     => $createdAt->copy()->addHours(2),
                        'updated_at'     => now(),
                    ]);
                }

                $totalCreated++;
            }
        }

        // ===== ORDERS KHUSUS UNTUK ARIF (semua status) =====
        $arifStatuses = ['menunggu_bayar', 'diproses', 'dikirim', 'diterima', 'selesai', 'selesai', 'dibatalkan'];
        foreach ($arifStatuses as $status) {
            $prod  = $products->random();
            $price = $prod->sale_price ?? $prod->price;
            $ship  = rand(12000, 25000);
            $sub   = $price * rand(1, 2);
            $tot   = $sub + $ship;
            $cat   = now()->subDays(rand(1, 30));
            $onum  = 'BY-' . $counter++;

            $oid = DB::table('orders')->insertGetId([
                'order_number'         => $onum,
                'user_id'              => $arifId,
                'recipient_name'       => 'Arif Siddik M',
                'recipient_phone'      => '089514392694',
                'recipient_address'    => 'Jl. KH. Yasin Beji No. 12, RT 03/RW 05',
                'province_name'        => 'Banten',
                'city_name'            => 'Cilegon',
                'district_name'        => 'Ciwandan',
                'postal_code'          => '42414',
                'courier'              => 'jne',
                'courier_service'      => 'REG',
                'courier_service_name' => 'JNE REG',
                'shipping_cost'        => $ship,
                'estimated_days'       => 3,
                'subtotal'             => $sub,
                'discount'             => 0,
                'coupon_code'          => null,
                'total'                => $tot,
                'payment_method'       => rand(0,1) ? 'midtrans' : 'bank_transfer',
                'payment_status'       => $status === 'menunggu_bayar' ? 'pending' : 'paid',
                'status'               => $status,
                'notes'                => '',
                'tracking_number'      => in_array($status, ['dikirim','diterima','selesai'])
                    ? 'JNE' . rand(10000000, 99999999) : null,
                'paid_at'              => $status !== 'menunggu_bayar' ? $cat->copy()->addHours(2) : null,
                'shipped_at'           => in_array($status, ['dikirim','diterima','selesai'])
                    ? $cat->copy()->addDays(1) : null,
                'completed_at'         => $status === 'selesai' ? $cat->copy()->addDays(7) : null,
                'cancelled_at'         => $status === 'dibatalkan' ? $cat->copy()->addHours(3) : null,
                'created_at'           => $cat,
                'updated_at'           => now(),
            ]);

            DB::table('order_items')->insert([
                'order_id'          => $oid,
                'product_id'        => $prod->id,
                'product_variant_id'=> null,
                'product_name'      => $prod->name,
                'product_thumbnail' => $prod->thumbnail,
                'variant_info'      => null,
                'quantity'          => 1,
                'price'             => $price,
                'subtotal'          => $sub,
                'created_at'        => $cat,
                'updated_at'        => now(),
            ]);

            $totalCreated++;
        }

        $this->command->info("Total {$totalCreated} orders berhasil dibuat!");
        $this->command->info("Login User Demo (Arif): arifsiddikmuharam@gmail.com / arif123");
        $this->command->info("Login Admin: admin@belanjayuk.com / admin123");
    }
}
