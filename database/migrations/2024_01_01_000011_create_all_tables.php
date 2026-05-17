<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {

        if (!Schema::hasTable('categories'))
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('icon')->nullable();
                $table->string('image')->nullable();
                $table->text('description')->nullable();
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

        if (!Schema::hasTable('products'))
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('sku')->unique()->nullable();
                $table->text('short_description')->nullable();
                $table->longText('description')->nullable();
                $table->decimal('price', 15, 2);
                $table->decimal('sale_price', 15, 2)->nullable();
                $table->integer('stock')->default(0);
                $table->decimal('weight', 8, 2)->default(0);
                $table->decimal('length', 8, 2)->nullable();
                $table->decimal('width', 8, 2)->nullable();
                $table->decimal('height', 8, 2)->nullable();
                $table->string('thumbnail')->nullable();
                $table->boolean('is_active')->default(true);
                $table->boolean('is_featured')->default(false);
                $table->boolean('is_promo')->default(false);
                $table->boolean('is_new')->default(false);
                $table->integer('views')->default(0);
                $table->integer('sold_count')->default(0);
                $table->timestamps();
            });

        if (!Schema::hasTable('product_images'))
            Schema::create('product_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->string('image');
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });

        if (!Schema::hasTable('product_variants'))
            Schema::create('product_variants', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->string('name');
                $table->string('value');
                $table->decimal('price_adjustment', 15, 2)->default(0);
                $table->integer('stock')->default(0);
                $table->timestamps();
            });

        if (!Schema::hasTable('coupons'))
            Schema::create('coupons', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('description')->nullable();
                $table->enum('type', ['percentage','fixed'])->default('fixed');
                $table->decimal('value', 15, 2);
                $table->decimal('min_purchase', 15, 2)->default(0);
                $table->decimal('max_discount', 15, 2)->nullable();
                $table->integer('usage_limit')->nullable();
                $table->integer('used_count')->default(0);
                $table->boolean('is_active')->default(true);
                $table->date('starts_at')->nullable();
                $table->date('expires_at')->nullable();
                $table->timestamps();
            });

        if (!Schema::hasTable('banners'))
            Schema::create('banners', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('subtitle')->nullable();
                $table->string('image');
                $table->string('link')->nullable();
                $table->string('button_text')->nullable();
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

        if (!Schema::hasTable('addresses'))
            Schema::create('addresses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('label')->default('Rumah');
                $table->string('recipient_name');
                $table->string('phone');
                $table->text('address');
                $table->string('province_id');
                $table->string('province_name');
                $table->string('city_id');
                $table->string('city_name');
                $table->string('district_id')->nullable();
                $table->string('district_name')->nullable();
                $table->string('postal_code')->nullable();
                $table->boolean('is_default')->default(false);
                $table->timestamps();
            });

        if (!Schema::hasTable('carts'))
            Schema::create('carts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_variant_id')->nullable()
                    ->constrained('product_variants')->onDelete('set null');
                $table->integer('quantity')->default(1);
                $table->timestamps();
            });

        if (!Schema::hasTable('orders'))
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_number')->unique();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('address_id')->nullable()->constrained()->onDelete('set null');
                $table->string('recipient_name');
                $table->string('recipient_phone');
                $table->text('recipient_address');
                $table->string('province_name');
                $table->string('city_name');
                $table->string('district_name')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('courier');
                $table->string('courier_service');
                $table->string('courier_service_name')->nullable();
                $table->integer('shipping_cost')->default(0);
                $table->integer('estimated_days')->nullable();
                $table->decimal('subtotal', 15, 2)->default(0);
                $table->decimal('discount', 15, 2)->default(0);
                $table->string('coupon_code')->nullable();
                $table->decimal('total', 15, 2)->default(0);
                $table->enum('payment_method', ['bank_transfer','midtrans'])->default('midtrans');
                $table->enum('payment_status', ['pending','paid','failed','expired'])->default('pending');
                $table->string('payment_proof')->nullable();
                $table->string('midtrans_transaction_id')->nullable();
                $table->string('midtrans_snap_token')->nullable();
                $table->text('midtrans_response')->nullable();
                $table->enum('status', ['menunggu_bayar','diproses','dikirim','diterima','selesai','dibatalkan'])
                    ->default('menunggu_bayar');
                $table->string('tracking_number')->nullable();
                $table->text('notes')->nullable();
                $table->text('cancel_reason')->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->timestamp('shipped_at')->nullable();
                $table->timestamp('delivered_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->timestamp('cancelled_at')->nullable();
                $table->timestamps();
            });

        // product_reviews SETELAH orders — FK order_id aman
        if (!Schema::hasTable('product_reviews'))
            Schema::create('product_reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->unsignedBigInteger('order_id')->nullable();
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
                $table->tinyInteger('rating')->default(5);
                $table->text('comment')->nullable();
                $table->string('image')->nullable();
                $table->boolean('is_approved')->default(true);
                $table->timestamps();
            });

        if (!Schema::hasTable('order_items'))
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_variant_id')->nullable()
                    ->constrained('product_variants')->onDelete('set null');
                $table->string('product_name');
                $table->string('product_thumbnail')->nullable();
                $table->string('variant_info')->nullable();
                $table->integer('quantity');
                $table->decimal('price', 15, 2);
                $table->decimal('subtotal', 15, 2);
                $table->timestamps();
            });

        if (!Schema::hasTable('payment_confirmations'))
            Schema::create('payment_confirmations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('bank_name');
                $table->string('account_name');
                $table->string('account_number');
                $table->decimal('amount', 15, 2);
                $table->string('transfer_proof');
                $table->enum('status', ['pending','approved','rejected'])->default('pending');
                $table->text('admin_notes')->nullable();
                $table->timestamps();
            });

        if (!Schema::hasTable('wishlists'))
            Schema::create('wishlists', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->unique(['user_id','product_id']);
                $table->timestamps();
            });

        if (!Schema::hasTable('store_settings'))
            Schema::create('store_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
    }

    public function down(): void {
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('payment_confirmations');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('product_reviews');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('store_settings');
    }
};
