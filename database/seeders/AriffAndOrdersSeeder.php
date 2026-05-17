<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Jalankan seeder ini SETELAH DatabaseSeeder:
 * php artisan db:seed --class=AriffAndOrdersSeeder
 *
 * Atau tambahkan ke DatabaseSeeder::run():
 * $this->call(AriffAndOrdersSeeder::class);
 */
class AriffAndOrdersSeeder extends Seeder {
    public function run(): void {

        // ===== USER ARIF =====
        $arifId = DB::table('users')->insertGetId([
            'name'       => 'Arif Siddik M',
            'email'      => 'arifsiddikmuharam@gmail.com',
            'phone'      => '089514392694',
            'role'       => 'user',
            'password'   => Hash::make('arif123'),
            'is_active'  => true,
            'created_at' => now()->subDays(30),
            'updated_at' => now(),
        ]);

        // Alamat Arif - Banten, Cilegon (kecamatan & kode pos kosong per request)
        DB::table('addresses')->insert([
            'user_id'        => $arifId,
            'label'          => 'Rumah',
            'recipient_name' => 'Arif Siddik M',
            'phone'          => '089514392694',
            'address'        => '',  // diisi user nanti via form
            'province_id'    => '3',  // Banten
            'province_name'  => 'Banten',
            'city_id'        => '17', // Cilegon
            'city_name'      => 'Kota Cilegon',
            'district_id'    => null,   // kosong per request
            'district_name'  => null,
            'postal_code'    => null,   // kosong per request
            'is_default'     => true,
            'created_at'     => now()->subDays(28),
            'updated_at'     => now(),
        ]);

        // ===== DUMMY ORDERS UNTUK SEMUA USER =====
        $allUsers = DB::table('users')->where('role', 'user')->pluck('id')->toArray();
        $products = DB::table('products')->where('is_active', true)->get();
        if ($products->isEmpty()) return;

        $statuses = [
            'menunggu_bayar' => 4,
            'diproses'       => 6,
            'dikirim'        => 8,
            'diterima'       => 5,
            'selesai'        => 10,
            'dibatalkan'     => 3,
        ];

        $couriers = ['jne','jnt','sicepat','anteraja','pos','tiki'];
        $services = ['REG','YES','OKE','EXPRESS','REGULER'];
        $banks    = ['BCA','BNI','Mandiri'];

        $orderNum = DB::table('orders')->max(DB::raw("CAST(SUBSTRING(order_number, 4) AS UNSIGNED)")) ?? 1000;
        $orderNum++;

        foreach ($statuses as $status => $count) {
            for ($i = 0; $i < $count; $i++) {
                $userId   = $allUsers[array_rand($allUsers)];
                $product  = $products[array_rand($products->toArray())];
                $courier  = $couriers[array_rand($couriers)];
                $service  = $services[array_rand($services)];
                $qty      = rand(1, 3);
                $price    = $product->sale_price ?? $product->price;
                $shipping = rand(9000, 38000);
                $subtotal = $price * $qty;
                $total    = $subtotal + $shipping;
                $payMethod = rand(0,1) ? 'bank_transfer' : 'midtrans';
                $createdAt = now()->subDays(rand(1, 75));
                $user      = DB::table('users')->find($userId);
                $orderNumber = 'BY-' . $orderNum++;

                $orderId = DB::table('orders')->insertGetId([
                    'order_number'        => $orderNumber,
                    'user_id'             => $userId,
                    'recipient_name'      => $user->name,
                    'recipient_phone'     => $user->phone ?? '081234567890',
                    'recipient_address'   => 'Jl. Contoh Alamat No. ' . rand(1,200) . ', RT 0' . rand(1,9) . '/RW 0' . rand(1,9),
                    'province_name'       => ['DKI Jakarta','Jawa Barat','Jawa Timur','Banten','Jawa Tengah'][rand(0,4)],
                    'city_name'           => ['Jakarta Pusat','Bandung','Surabaya','Cilegon','Semarang'][rand(0,4)],
                    'district_name'       => 'Kecamatan ' . ['Gambir','Menteng','Senen','Cikaret','Bungur'][rand(0,4)],
                    'postal_code'         => rand(10000, 99999),
                    'courier'             => $courier,
                    'courier_service'     => $service,
                    'courier_service_name'=> strtoupper($courier) . ' ' . $service,
                    'shipping_cost'       => $shipping,
                    'estimated_days'      => rand(1, 5),
                    'subtotal'            => $subtotal,
                    'discount'            => 0,
                    'coupon_code'         => null,
                    'total'               => $total,
                    'payment_method'      => $payMethod,
                    'payment_status'      => $status === 'menunggu_bayar' ? 'pending' : 'paid',
                    'status'              => $status,
                    'notes'               => '',
                    'tracking_number'     => in_array($status, ['dikirim','diterima','selesai'])
                        ? strtoupper($courier) . rand(10000000, 99999999) : null,
                    'paid_at'             => !in_array($status, ['menunggu_bayar'])
                        ? $createdAt->copy()->addHours(rand(1,8)) : null,
                    'shipped_at'          => in_array($status, ['dikirim','diterima','selesai'])
                        ? $createdAt->copy()->addDays(1) : null,
                    'completed_at'        => $status === 'selesai'
                        ? $createdAt->copy()->addDays(rand(5,14)) : null,
                    'cancelled_at'        => $status === 'dibatalkan'
                        ? $createdAt->copy()->addHours(rand(1,6)) : null,
                    'created_at'          => $createdAt,
                    'updated_at'          => now(),
                ]);

                DB::table('order_items')->insert([
                    'order_id'           => $orderId,
                    'product_id'         => $product->id,
                    'product_variant_id' => null,
                    'product_name'       => $product->name,
                    'product_thumbnail'  => $product->thumbnail,
                    'variant_info'       => null,
                    'quantity'           => $qty,
                    'price'              => $price,
                    'subtotal'           => $subtotal,
                    'created_at'         => $createdAt,
                    'updated_at'         => now(),
                ]);

                // Payment confirmation untuk bank transfer yang sudah bayar
                if ($payMethod === 'bank_transfer' && !in_array($status, ['menunggu_bayar','dibatalkan'])) {
                    DB::table('payment_confirmations')->insert([
                        'order_id'       => $orderId,
                        'user_id'        => $userId,
                        'bank_name'      => $banks[array_rand($banks)],
                        'account_name'   => $user->name,
                        'account_number' => '1234' . rand(100000, 999999),
                        'amount'         => $total,
                        'transfer_proof' => null,
                        'status'         => $status === 'diproses' ? 'pending' : 'approved',
                        'admin_notes'    => 'Dummy data seeder.',
                        'created_at'     => $createdAt->copy()->addHours(2),
                        'updated_at'     => now(),
                    ]);
                }
            }
        }

        // Beberapa order khusus untuk Arif
        $arifProducts = $products->random(min(5, $products->count()));
        $arifStatuses = ['selesai','dikirim','menunggu_bayar','diproses','diterima'];
        foreach ($arifStatuses as $idx => $stat) {
            $prod  = $arifProducts[$idx % $arifProducts->count()];
            $price = $prod->sale_price ?? $prod->price;
            $ship  = rand(12000, 25000);
            $sub   = $price * 1;
            $tot   = $sub + $ship;
            $cat   = now()->subDays(rand(1,30));
            $onum  = 'BY-' . $orderNum++;

            $oid = DB::table('orders')->insertGetId([
                'order_number'        => $onum,
                'user_id'             => $arifId,
                'recipient_name'      => 'Arif Siddik M',
                'recipient_phone'     => '089514392694',
                'recipient_address'   => 'Jl. KH. Yasin Beji No. 12',
                'province_name'       => 'Banten',
                'city_name'           => 'Kota Cilegon',
                'district_name'       => null,
                'postal_code'         => null,
                'courier'             => 'jne',
                'courier_service'     => 'REG',
                'courier_service_name'=> 'JNE REG',
                'shipping_cost'       => $ship,
                'estimated_days'      => 3,
                'subtotal'            => $sub,
                'discount'            => 0,
                'coupon_code'         => null,
                'total'               => $tot,
                'payment_method'      => 'midtrans',
                'payment_status'      => $stat === 'menunggu_bayar' ? 'pending' : 'paid',
                'status'              => $stat,
                'notes'               => '',
                'tracking_number'     => in_array($stat, ['dikirim','diterima','selesai']) ? 'JNE' . rand(10000000,99999999) : null,
                'paid_at'             => $stat !== 'menunggu_bayar' ? $cat->copy()->addHours(2) : null,
                'shipped_at'          => in_array($stat, ['dikirim','diterima','selesai']) ? $cat->copy()->addDays(1) : null,
                'completed_at'        => $stat === 'selesai' ? $cat->copy()->addDays(7) : null,
                'cancelled_at'        => null,
                'created_at'          => $cat,
                'updated_at'          => now(),
            ]);

            DB::table('order_items')->insert([
                'order_id'           => $oid,
                'product_id'         => $prod->id,
                'product_variant_id' => null,
                'product_name'       => $prod->name,
                'product_thumbnail'  => $prod->thumbnail,
                'variant_info'       => null,
                'quantity'           => 1,
                'price'              => $price,
                'subtotal'           => $sub,
                'created_at'         => $cat,
                'updated_at'         => now(),
            ]);
        }

        $this->command->info('AriffAndOrdersSeeder: Berhasil! User Arif + ' . (array_sum($statuses) + count($arifStatuses)) . ' orders dummy.');
    }
}
