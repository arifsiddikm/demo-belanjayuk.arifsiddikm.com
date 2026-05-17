-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 17, 2026 at 02:08 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `belanjayuk`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Rumah',
  `recipient_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `label`, `recipient_name`, `phone`, `address`, `province_id`, `province_name`, `city_id`, `city_name`, `district_id`, `district_name`, `postal_code`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 10, 'Rumah', 'Arif Siddik M', '089514392694', 'Jl. KH. Yasin Beji No. 12', '3', 'Banten', '17', 'Cilegon', NULL, NULL, NULL, 1, '2026-04-19 12:07:57', '2026-05-17 12:07:57');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `image`, `link`, `button_text`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Flash Sale Spesial!', 'Diskon hingga 70% semua produk', 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=1200', '/produk?promo=1', 'Belanja Sekarang', 0, 1, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(2, 'New Collection 2025', 'Koleksi fashion terbaru trendy & terjangkau', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200', '/produk?category=fashion-pria', 'Lihat Koleksi', 1, 1, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(3, 'Gadget & Elektronik', 'Teknologi terkini harga bersahabat', 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=1200', '/produk?category=elektronik', 'Cek Promo', 2, 1, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(4, 'Gratis Ongkir Hari Ini!', 'Min. pembelian Rp 150.000', 'https://images.unsplash.com/photo-1607082349566-187342175400?w=1200', '/produk', 'Mulai Belanja', 3, 1, '2026-05-17 12:07:56', '2026-05-17 12:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `image`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Fashion Pria', 'fashion-pria', '👔', 'https://images.unsplash.com/photo-1490578474895-699cd4e2cf59?w=400', NULL, 0, 1, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(2, 'Fashion Wanita', 'fashion-wanita', '👗', 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=400', NULL, 1, 1, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(3, 'Elektronik', 'elektronik', '📱', 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=400', NULL, 2, 1, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(4, 'Alat Rumah Tangga', 'alat-rumah-tangga', '🏠', 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400', NULL, 3, 1, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(5, 'Olahraga', 'olahraga', '⚽', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=400', NULL, 4, 1, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(6, 'Kecantikan', 'kecantikan', '💄', 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400', NULL, 5, 1, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(7, 'Sepatu & Tas', 'sepatu-tas', '👟', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400', NULL, 6, 1, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(8, 'Mainan & Hobi', 'mainan-hobi', '🎮', 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=400', NULL, 7, 1, '2026-05-17 12:07:56', '2026-05-17 12:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('percentage','fixed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `value` decimal(15,2) NOT NULL,
  `min_purchase` decimal(15,2) NOT NULL DEFAULT 0.00,
  `max_discount` decimal(15,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `starts_at` date DEFAULT NULL,
  `expires_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `description`, `type`, `value`, `min_purchase`, `max_discount`, `usage_limit`, `used_count`, `is_active`, `starts_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'WELCOME10', 'Diskon 10%', 'percentage', '10.00', '0.00', '50000.00', 100, 0, 1, NULL, '2026-11-17', '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(2, 'HEMAT50', 'Hemat Rp 50.000', 'fixed', '50000.00', '200000.00', NULL, 50, 0, 1, NULL, '2026-11-17', '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(3, 'FLASH20', 'Flash Sale 20%', 'percentage', '20.00', '100000.00', '100000.00', 200, 0, 1, NULL, '2026-11-17', '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(4, 'GRATIS25K', 'Diskon Rp 25.000', 'fixed', '25000.00', '100000.00', NULL, 999, 0, 1, NULL, '2026-11-17', '2026-05-17 12:07:56', '2026-05-17 12:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_create_users_table', 1),
(5, '2024_01_01_000002_add_custom_columns_to_users', 1),
(6, '2024_01_01_000002_add_custom_columns_to_users_table', 1),
(7, '2024_01_01_000002_create_products_table', 1),
(8, '2024_01_01_000003_create_orders_table', 1),
(9, '2024_01_01_000003_create_products_table', 1),
(10, '2024_01_01_000003_create_shop_tables', 1),
(11, '2024_01_01_000004_create_orders_table', 1),
(12, '2024_01_01_000010_add_user_columns', 1),
(13, '2024_01_01_000010_users_stub', 1),
(14, '2024_01_01_000011_create_all_tables', 1),
(15, '2024_01_01_000012_create_all_shop_tables', 1),
(16, '2024_01_02_000001_add_images_to_product_reviews', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `recipient_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `courier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_service_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_cost` int(11) NOT NULL DEFAULT 0,
  `estimated_days` int(11) DEFAULT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payment_method` enum('bank_transfer','midtrans') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'midtrans',
  `payment_status` enum('pending','paid','failed','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `midtrans_transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `midtrans_snap_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `midtrans_response` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('menunggu_bayar','diproses','dikirim','diterima','selesai','dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu_bayar',
  `tracking_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancel_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `address_id`, `recipient_name`, `recipient_phone`, `recipient_address`, `province_name`, `city_name`, `district_name`, `postal_code`, `courier`, `courier_service`, `courier_service_name`, `shipping_cost`, `estimated_days`, `subtotal`, `discount`, `coupon_code`, `total`, `payment_method`, `payment_status`, `payment_proof`, `midtrans_transaction_id`, `midtrans_snap_token`, `midtrans_response`, `status`, `tracking_number`, `notes`, `cancel_reason`, `paid_at`, `shipped_at`, `delivered_at`, `completed_at`, `cancelled_at`, `created_at`, `updated_at`) VALUES
(1, 'BY-1001', 3, NULL, 'Siti Rahayu', '083444555666', 'Jl. Imam Bonjol No. 3, RT 08/RW 03', 'Sumatera Utara', 'Medan', 'Medan Baru', '20152', 'sicepat', 'BEST', 'SiCepat BEST', 22053, 1, '776000.00', '0.00', NULL, '798053.00', 'bank_transfer', 'pending', NULL, NULL, NULL, NULL, 'menunggu_bayar', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-26 12:07:57', '2026-05-17 12:07:57'),
(2, 'BY-1002', 4, NULL, 'Ahmad Fauzi', '085777888999', 'Jl. Ahmad Yani No. 33, RT 09/RW 06', 'Jawa Timur', 'Surabaya', 'Wonokromo', '60243', 'jne', 'EXPRESS', 'JNE EXPRESS', 12993, 2, '338000.00', '0.00', NULL, '350993.00', 'bank_transfer', 'pending', NULL, NULL, NULL, NULL, 'menunggu_bayar', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-02 12:07:57', '2026-05-17 12:07:57'),
(3, 'BY-1003', 7, NULL, 'Maya Sari', '089922334455', 'Jl. Kenanga No. 22, RT 08/RW 01', 'DKI Jakarta', 'Jakarta Selatan', 'Kebayoran Baru', '12120', 'jne', 'REGULER', 'JNE REGULER', 30292, 3, '129000.00', '0.00', NULL, '159292.00', 'bank_transfer', 'pending', NULL, NULL, NULL, NULL, 'menunggu_bayar', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-04 12:07:57', '2026-05-17 12:07:57'),
(4, 'BY-1004', 6, NULL, 'Rizky Pratama', '081355667788', 'Jl. Kenanga No. 22, RT 06/RW 03', 'DKI Jakarta', 'Jakarta Selatan', 'Kebayoran Baru', '12120', 'sicepat', 'OKE', 'SiCepat OKE', 9423, 3, '824000.00', '0.00', NULL, '833423.00', 'bank_transfer', 'pending', NULL, NULL, NULL, NULL, 'menunggu_bayar', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-15 12:07:57', '2026-05-17 12:07:57'),
(5, 'BY-1005', 8, NULL, 'Hendra Wijaya', '085612341234', 'Jl. Pahlawan No. 7, RT 01/RW 01', 'Jawa Barat', 'Bandung', 'Cicendo', '40171', 'pos', 'EXPRESS', 'Pos Indonesia EXPRESS', 11945, 2, '526000.00', '0.00', NULL, '537945.00', 'midtrans', 'pending', NULL, NULL, NULL, NULL, 'menunggu_bayar', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-07 12:07:57', '2026-05-17 12:07:57'),
(6, 'BY-1006', 5, NULL, 'Dewi Putri', '087112233445', 'Jl. Ahmad Yani No. 33, RT 01/RW 03', 'Jawa Timur', 'Surabaya', 'Wonokromo', '60243', 'jnt', 'OKE', 'J&T OKE', 31583, 4, '943000.00', '0.00', NULL, '974583.00', 'midtrans', 'pending', NULL, NULL, NULL, NULL, 'menunggu_bayar', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-05 12:07:57', '2026-05-17 12:07:57'),
(7, 'BY-1007', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. Ahmad Yani No. 33, RT 04/RW 08', 'Jawa Timur', 'Surabaya', 'Wonokromo', '60243', 'jne', 'REG', 'JNE REG', 24729, 5, '686000.00', '23594.00', 'HEMAT19', '687135.00', 'midtrans', 'pending', NULL, NULL, NULL, NULL, 'menunggu_bayar', NULL, 'Mohon packing dengan bubble wrap', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-14 12:07:57', '2026-05-17 12:07:57'),
(8, 'BY-1008', 8, NULL, 'Hendra Wijaya', '085612341234', 'Jl. Gatot Subroto No. 10, RT 05/RW 03', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'tiki', 'EXPRESS', 'TIKI EXPRESS', 30968, 2, '638000.00', '0.00', NULL, '668968.00', 'bank_transfer', 'pending', NULL, NULL, NULL, NULL, 'menunggu_bayar', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-18 12:07:57', '2026-05-17 12:07:57'),
(9, 'BY-1009', 7, NULL, 'Maya Sari', '089922334455', 'Jl. Diponegoro No. 9, RT 03/RW 05', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'anteraja', 'YES', 'AnterAja YES', 10433, 1, '1923000.00', '19885.00', 'HEMAT44', '1913548.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'diproses', NULL, '', NULL, '2026-05-07 14:07:57', NULL, NULL, NULL, NULL, '2026-05-07 12:07:57', '2026-05-17 12:07:57'),
(10, 'BY-1010', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. Merdeka No. 15, RT 05/RW 02', 'DKI Jakarta', 'Jakarta Pusat', 'Gambir', '10110', 'jnt', 'BEST', 'J&T BEST', 15021, 5, '387000.00', '0.00', NULL, '402021.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'diproses', NULL, 'Mohon packing dengan bubble wrap', NULL, '2026-03-06 20:07:57', NULL, NULL, NULL, NULL, '2026-03-06 12:07:57', '2026-05-17 12:07:57'),
(11, 'BY-1011', 7, NULL, 'Maya Sari', '089922334455', 'Jl. Sudirman No. 55, RT 06/RW 05', 'Jawa Tengah', 'Semarang', 'Semarang Tengah', '50131', 'jne', 'EXPRESS', 'JNE EXPRESS', 33340, 3, '1037000.00', '0.00', NULL, '1070340.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'diproses', NULL, '', NULL, '2026-03-03 17:07:57', NULL, NULL, NULL, NULL, '2026-03-03 12:07:57', '2026-05-17 12:07:57'),
(12, 'BY-1012', 7, NULL, 'Maya Sari', '089922334455', 'Jl. Sudirman No. 55, RT 05/RW 08', 'Jawa Tengah', 'Semarang', 'Semarang Tengah', '50131', 'jnt', 'EXPRESS', 'J&T EXPRESS', 28580, 3, '1234000.00', '12497.00', 'HEMAT38', '1250083.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'diproses', NULL, '', NULL, '2026-03-15 19:07:57', NULL, NULL, NULL, NULL, '2026-03-15 12:07:57', '2026-05-17 12:07:57'),
(13, 'BY-1013', 3, NULL, 'Siti Rahayu', '083444555666', 'Jl. Imam Bonjol No. 3, RT 04/RW 02', 'Sumatera Utara', 'Medan', 'Medan Baru', '20152', 'sicepat', 'OKE', 'SiCepat OKE', 17643, 2, '876000.00', '0.00', NULL, '893643.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'diproses', NULL, '', NULL, '2026-05-07 20:07:57', NULL, NULL, NULL, NULL, '2026-05-07 12:07:57', '2026-05-17 12:07:57'),
(14, 'BY-1014', 9, NULL, 'Rina Kusuma', '081278781234', 'Jl. Kenanga No. 22, RT 06/RW 03', 'DKI Jakarta', 'Jakarta Selatan', 'Kebayoran Baru', '12120', 'tiki', 'REG', 'TIKI REG', 12994, 1, '358000.00', '0.00', NULL, '370994.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'diproses', NULL, 'Mohon packing dengan bubble wrap', NULL, '2026-03-30 16:07:57', NULL, NULL, NULL, NULL, '2026-03-30 12:07:57', '2026-05-17 12:07:57'),
(15, 'BY-1015', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. Pahlawan No. 7, RT 04/RW 05', 'Jawa Barat', 'Bandung', 'Cicendo', '40171', 'anteraja', 'REG', 'AnterAja REG', 23420, 3, '229000.00', '0.00', NULL, '252420.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'diproses', NULL, '', NULL, '2026-05-12 14:07:57', NULL, NULL, NULL, NULL, '2026-05-12 12:07:57', '2026-05-17 12:07:57'),
(16, 'BY-1016', 6, NULL, 'Rizky Pratama', '081355667788', 'Jl. Gatot Subroto No. 10, RT 02/RW 01', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'pos', 'REG', 'Pos Indonesia REG', 34261, 2, '778000.00', '0.00', NULL, '812261.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'diproses', NULL, '', NULL, '2026-03-17 20:07:57', NULL, NULL, NULL, NULL, '2026-03-17 12:07:57', '2026-05-17 12:07:57'),
(17, 'BY-1017', 6, NULL, 'Rizky Pratama', '081355667788', 'Jl. Merdeka No. 15, RT 02/RW 04', 'DKI Jakarta', 'Jakarta Pusat', 'Gambir', '10110', 'anteraja', 'BEST', 'AnterAja BEST', 33220, 5, '1167000.00', '0.00', NULL, '1200220.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'diproses', NULL, 'Mohon packing dengan bubble wrap', NULL, '2026-05-04 16:07:57', NULL, NULL, NULL, NULL, '2026-05-04 12:07:57', '2026-05-17 12:07:57'),
(18, 'BY-1018', 3, NULL, 'Siti Rahayu', '083444555666', 'Jl. Gatot Subroto No. 10, RT 05/RW 03', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'anteraja', 'BEST', 'AnterAja BEST', 32841, 1, '874000.00', '13703.00', 'HEMAT44', '893138.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'diproses', NULL, '', NULL, '2026-02-28 17:07:57', NULL, NULL, NULL, NULL, '2026-02-28 12:07:57', '2026-05-17 12:07:57'),
(19, 'BY-1019', 5, NULL, 'Dewi Putri', '087112233445', 'Jl. Diponegoro No. 9, RT 03/RW 09', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'sicepat', 'EXPRESS', 'SiCepat EXPRESS', 22545, 4, '159000.00', '0.00', NULL, '181545.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'SICEPAT89596736', '', NULL, '2026-04-07 17:07:57', '2026-04-08 12:07:57', NULL, NULL, NULL, '2026-04-07 12:07:57', '2026-05-17 12:07:57'),
(20, 'BY-1020', 5, NULL, 'Dewi Putri', '087112233445', 'Jl. Ahmad Yani No. 33, RT 06/RW 07', 'Jawa Timur', 'Surabaya', 'Wonokromo', '60243', 'jnt', 'BEST', 'J&T BEST', 20888, 1, '1167000.00', '7456.00', 'HEMAT27', '1180432.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'JNT17777639', '', NULL, '2026-03-26 19:07:57', '2026-03-27 12:07:57', NULL, NULL, NULL, '2026-03-26 12:07:57', '2026-05-17 12:07:57'),
(21, 'BY-1021', 7, NULL, 'Maya Sari', '089922334455', 'Jl. Sudirman No. 55, RT 07/RW 02', 'Jawa Tengah', 'Semarang', 'Semarang Tengah', '50131', 'sicepat', 'OKE', 'SiCepat OKE', 36176, 1, '666000.00', '14590.00', 'HEMAT32', '687586.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'SICEPAT49116992', 'Mohon packing dengan bubble wrap', NULL, '2026-04-01 18:07:57', '2026-04-02 12:07:57', NULL, NULL, NULL, '2026-04-01 12:07:57', '2026-05-17 12:07:57'),
(22, 'BY-1022', 4, NULL, 'Ahmad Fauzi', '085777888999', 'Jl. Diponegoro No. 9, RT 04/RW 07', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'anteraja', 'OKE', 'AnterAja OKE', 22892, 1, '686000.00', '0.00', NULL, '708892.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'ANTERAJA40704022', '', NULL, '2026-02-18 15:07:57', '2026-02-19 12:07:57', NULL, NULL, NULL, '2026-02-18 12:07:57', '2026-05-17 12:07:57'),
(23, 'BY-1023', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. Merdeka No. 15, RT 02/RW 01', 'DKI Jakarta', 'Jakarta Pusat', 'Gambir', '10110', 'jnt', 'REG', 'J&T REG', 28893, 2, '1443000.00', '0.00', NULL, '1471893.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'JNT68510949', 'Mohon packing dengan bubble wrap', NULL, '2026-03-23 18:07:57', '2026-03-24 12:07:57', NULL, NULL, NULL, '2026-03-23 12:07:57', '2026-05-17 12:07:57'),
(24, 'BY-1024', 3, NULL, 'Siti Rahayu', '083444555666', 'Jl. Imam Bonjol No. 3, RT 07/RW 03', 'Sumatera Utara', 'Medan', 'Medan Baru', '20152', 'pos', 'EXPRESS', 'Pos Indonesia EXPRESS', 11584, 4, '1941000.00', '21942.00', 'HEMAT17', '1930642.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'POS59145195', '', NULL, '2026-02-18 14:07:57', '2026-02-19 12:07:57', NULL, NULL, NULL, '2026-02-18 12:07:57', '2026-05-17 12:07:57'),
(25, 'BY-1025', 9, NULL, 'Rina Kusuma', '081278781234', 'Jl. Gatot Subroto No. 10, RT 05/RW 01', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'pos', 'YES', 'Pos Indonesia YES', 17813, 5, '996000.00', '23591.00', 'HEMAT41', '990222.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'POS34397699', '', NULL, '2026-04-05 17:07:57', '2026-04-06 12:07:57', NULL, NULL, NULL, '2026-04-05 12:07:57', '2026-05-17 12:07:57'),
(26, 'BY-1026', 3, NULL, 'Siti Rahayu', '083444555666', 'Jl. Imam Bonjol No. 3, RT 07/RW 04', 'Sumatera Utara', 'Medan', 'Medan Baru', '20152', 'jne', 'EXPRESS', 'JNE EXPRESS', 15837, 4, '2193000.00', '21202.00', 'HEMAT19', '2187635.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'JNE31398503', '', NULL, '2026-03-28 14:07:57', '2026-03-29 12:07:57', NULL, NULL, NULL, '2026-03-28 12:07:57', '2026-05-17 12:07:57'),
(27, 'BY-1027', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. Diponegoro No. 9, RT 02/RW 09', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'jnt', 'BEST', 'J&T BEST', 29238, 3, '825000.00', '12509.00', 'HEMAT17', '841729.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'JNT52896694', '', NULL, '2026-04-27 15:07:57', '2026-04-28 12:07:57', NULL, NULL, NULL, '2026-04-27 12:07:57', '2026-05-17 12:07:57'),
(28, 'BY-1028', 3, NULL, 'Siti Rahayu', '083444555666', 'Jl. Gatot Subroto No. 10, RT 04/RW 03', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'sicepat', 'EXPRESS', 'SiCepat EXPRESS', 12490, 1, '138000.00', '18414.00', 'HEMAT16', '132076.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'SICEPAT22702669', 'Mohon packing dengan bubble wrap', NULL, '2026-04-12 17:07:57', '2026-04-13 12:07:57', NULL, NULL, NULL, '2026-04-12 12:07:57', '2026-05-17 12:07:57'),
(29, 'BY-1029', 3, NULL, 'Siti Rahayu', '083444555666', 'Jl. Diponegoro No. 9, RT 05/RW 04', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'sicepat', 'EXPRESS', 'SiCepat EXPRESS', 19423, 5, '387000.00', '0.00', NULL, '406423.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'SICEPAT78812038', '', NULL, '2026-04-28 14:07:57', '2026-04-29 12:07:57', NULL, NULL, NULL, '2026-04-28 12:07:57', '2026-05-17 12:07:57'),
(30, 'BY-1030', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. Gatot Subroto No. 10, RT 06/RW 08', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'sicepat', 'REGULER', 'SiCepat REGULER', 29283, 2, '149000.00', '18773.00', 'HEMAT15', '159510.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'SICEPAT52179214', '', NULL, '2026-02-26 13:07:57', '2026-02-27 12:07:57', NULL, NULL, NULL, '2026-02-26 12:07:57', '2026-05-17 12:07:57'),
(31, 'BY-1031', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. Sudirman No. 55, RT 04/RW 09', 'Jawa Tengah', 'Semarang', 'Semarang Tengah', '50131', 'tiki', 'BEST', 'TIKI BEST', 13240, 4, '2073000.00', '0.00', NULL, '2086240.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'TIKI87602832', '', NULL, '2026-02-24 13:07:57', '2026-02-25 12:07:57', NULL, NULL, NULL, '2026-02-24 12:07:57', '2026-05-17 12:07:57'),
(32, 'BY-1032', 2, NULL, 'Budi Santoso', '082111222333', 'Jl. Pahlawan No. 7, RT 08/RW 08', 'Jawa Barat', 'Bandung', 'Cicendo', '40171', 'tiki', 'OKE', 'TIKI OKE', 21651, 1, '827000.00', '16697.00', 'HEMAT21', '831954.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'TIKI45129238', '', NULL, '2026-04-12 16:07:57', '2026-04-13 12:07:57', NULL, NULL, NULL, '2026-04-12 12:07:57', '2026-05-17 12:07:57'),
(33, 'BY-1033', 5, NULL, 'Dewi Putri', '087112233445', 'Jl. Gatot Subroto No. 10, RT 02/RW 04', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'tiki', 'EXPRESS', 'TIKI EXPRESS', 15710, 5, '498000.00', '0.00', NULL, '513710.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'TIKI17145224', '', NULL, '2026-04-25 16:07:57', '2026-04-26 12:07:57', NULL, NULL, NULL, '2026-04-25 12:07:57', '2026-05-17 12:07:57'),
(34, 'BY-1034', 4, NULL, 'Ahmad Fauzi', '085777888999', 'Jl. Imam Bonjol No. 3, RT 05/RW 09', 'Sumatera Utara', 'Medan', 'Medan Baru', '20152', 'pos', 'OKE', 'Pos Indonesia OKE', 32286, 1, '158000.00', '0.00', NULL, '190286.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'diterima', 'POS69810544', '', NULL, '2026-04-25 14:07:57', '2026-04-26 12:07:57', NULL, NULL, NULL, '2026-04-25 12:07:57', '2026-05-17 12:07:57'),
(35, 'BY-1035', 8, NULL, 'Hendra Wijaya', '085612341234', 'Jl. Kenanga No. 22, RT 05/RW 07', 'DKI Jakarta', 'Jakarta Selatan', 'Kebayoran Baru', '12120', 'jne', 'OKE', 'JNE OKE', 28972, 3, '497000.00', '0.00', NULL, '525972.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'diterima', 'JNE73824887', '', NULL, '2026-03-21 18:07:57', '2026-03-22 12:07:57', NULL, NULL, NULL, '2026-03-21 12:07:57', '2026-05-17 12:07:57'),
(36, 'BY-1036', 8, NULL, 'Hendra Wijaya', '085612341234', 'Jl. Gatot Subroto No. 10, RT 04/RW 05', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'jne', 'OKE', 'JNE OKE', 26471, 5, '1006000.00', '23211.00', 'HEMAT43', '1009260.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'diterima', 'JNE91333861', '', NULL, '2026-03-10 16:07:57', '2026-03-11 12:07:57', NULL, NULL, NULL, '2026-03-10 12:07:57', '2026-05-17 12:07:57'),
(37, 'BY-1037', 4, NULL, 'Ahmad Fauzi', '085777888999', 'Jl. Gatot Subroto No. 10, RT 04/RW 06', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'jne', 'REG', 'JNE REG', 34893, 5, '1065000.00', '0.00', NULL, '1099893.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'diterima', 'JNE90465652', 'Mohon packing dengan bubble wrap', NULL, '2026-04-08 19:07:57', '2026-04-09 12:07:57', NULL, NULL, NULL, '2026-04-08 12:07:57', '2026-05-17 12:07:57'),
(38, 'BY-1038', 4, NULL, 'Ahmad Fauzi', '085777888999', 'Jl. Pahlawan No. 7, RT 07/RW 06', 'Jawa Barat', 'Bandung', 'Cicendo', '40171', 'pos', 'REG', 'Pos Indonesia REG', 13571, 3, '507000.00', '0.00', NULL, '520571.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'diterima', 'POS19900892', 'Mohon packing dengan bubble wrap', NULL, '2026-05-02 18:07:57', '2026-05-03 12:07:57', NULL, NULL, NULL, '2026-05-02 12:07:57', '2026-05-17 12:07:57'),
(39, 'BY-1039', 3, NULL, 'Siti Rahayu', '083444555666', 'Jl. Imam Bonjol No. 3, RT 06/RW 07', 'Sumatera Utara', 'Medan', 'Medan Baru', '20152', 'anteraja', 'REG', 'AnterAja REG', 22877, 2, '1155000.00', '10294.00', 'HEMAT47', '1167583.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'diterima', 'ANTERAJA17664800', '', NULL, '2026-03-25 16:07:57', '2026-03-26 12:07:57', NULL, NULL, NULL, '2026-03-25 12:07:57', '2026-05-17 12:07:57'),
(40, 'BY-1040', 6, NULL, 'Rizky Pratama', '081355667788', 'Jl. Gatot Subroto No. 10, RT 03/RW 07', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'tiki', 'REGULER', 'TIKI REGULER', 17842, 5, '1085000.00', '0.00', NULL, '1102842.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'diterima', 'TIKI14767626', 'Mohon packing dengan bubble wrap', NULL, '2026-05-05 15:07:57', '2026-05-06 12:07:57', NULL, NULL, NULL, '2026-05-05 12:07:57', '2026-05-17 12:07:57'),
(41, 'BY-1041', 6, NULL, 'Rizky Pratama', '081355667788', 'Jl. Gatot Subroto No. 10, RT 05/RW 08', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'tiki', 'REG', 'TIKI REG', 15796, 4, '1016000.00', '15669.00', 'HEMAT45', '1016127.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'diterima', 'TIKI75100019', '', NULL, '2026-03-28 13:07:57', '2026-03-29 12:07:57', NULL, NULL, NULL, '2026-03-28 12:07:57', '2026-05-17 12:07:57'),
(42, 'BY-1042', 9, NULL, 'Rina Kusuma', '081278781234', 'Jl. Merdeka No. 15, RT 04/RW 04', 'DKI Jakarta', 'Jakarta Pusat', 'Gambir', '10110', 'tiki', 'REGULER', 'TIKI REGULER', 34335, 4, '946000.00', '0.00', NULL, '980335.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'TIKI23929703', 'Mohon packing dengan bubble wrap', NULL, '2026-03-24 20:07:57', '2026-03-25 12:07:57', NULL, '2026-04-02 12:07:57', NULL, '2026-03-24 12:07:57', '2026-05-17 12:07:57'),
(43, 'BY-1043', 3, NULL, 'Siti Rahayu', '083444555666', 'Jl. Ahmad Yani No. 33, RT 04/RW 01', 'Jawa Timur', 'Surabaya', 'Wonokromo', '60243', 'anteraja', 'YES', 'AnterAja YES', 9624, 1, '1134000.00', '0.00', NULL, '1143624.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'ANTERAJA91879775', 'Mohon packing dengan bubble wrap', NULL, '2026-03-11 13:07:57', '2026-03-12 12:07:57', NULL, '2026-03-24 12:07:57', NULL, '2026-03-11 12:07:57', '2026-05-17 12:07:57'),
(44, 'BY-1044', 6, NULL, 'Rizky Pratama', '081355667788', 'Jl. Sudirman No. 55, RT 07/RW 02', 'Jawa Tengah', 'Semarang', 'Semarang Tengah', '50131', 'tiki', 'REGULER', 'TIKI REGULER', 32117, 3, '1434000.00', '8638.00', 'HEMAT22', '1457479.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'TIKI40993271', '', NULL, '2026-04-23 13:07:57', '2026-04-24 12:07:57', NULL, '2026-04-30 12:07:57', NULL, '2026-04-23 12:07:57', '2026-05-17 12:07:57'),
(45, 'BY-1045', 5, NULL, 'Dewi Putri', '087112233445', 'Jl. Sudirman No. 55, RT 05/RW 04', 'Jawa Tengah', 'Semarang', 'Semarang Tengah', '50131', 'anteraja', 'REG', 'AnterAja REG', 13912, 3, '1476000.00', '0.00', NULL, '1489912.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'ANTERAJA61678906', 'Mohon packing dengan bubble wrap', NULL, '2026-04-25 18:07:57', '2026-04-26 12:07:57', NULL, '2026-05-09 12:07:57', NULL, '2026-04-25 12:07:57', '2026-05-17 12:07:57'),
(46, 'BY-1046', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. Kenanga No. 22, RT 09/RW 01', 'DKI Jakarta', 'Jakarta Selatan', 'Kebayoran Baru', '12120', 'sicepat', 'REG', 'SiCepat REG', 28812, 1, '1305000.00', '16851.00', 'HEMAT44', '1316961.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'SICEPAT19437767', '', NULL, '2026-03-15 13:07:57', '2026-03-16 12:07:57', NULL, '2026-03-25 12:07:57', NULL, '2026-03-15 12:07:57', '2026-05-17 12:07:57'),
(47, 'BY-1047', 6, NULL, 'Rizky Pratama', '081355667788', 'Jl. Gatot Subroto No. 10, RT 05/RW 09', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'sicepat', 'REG', 'SiCepat REG', 37881, 4, '1047000.00', '24596.00', 'HEMAT33', '1060285.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'SICEPAT89748876', '', NULL, '2026-03-07 19:07:57', '2026-03-08 12:07:57', NULL, '2026-03-13 12:07:57', NULL, '2026-03-07 12:07:57', '2026-05-17 12:07:57'),
(48, 'BY-1048', 3, NULL, 'Siti Rahayu', '083444555666', 'Jl. Sudirman No. 55, RT 04/RW 02', 'Jawa Tengah', 'Semarang', 'Semarang Tengah', '50131', 'sicepat', 'REG', 'SiCepat REG', 27091, 3, '1047000.00', '0.00', NULL, '1074091.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'SICEPAT40516173', '', NULL, '2026-03-04 18:07:57', '2026-03-05 12:07:57', NULL, '2026-03-14 12:07:57', NULL, '2026-03-04 12:07:57', '2026-05-17 12:07:57'),
(49, 'BY-1049', 2, NULL, 'Budi Santoso', '082111222333', 'Jl. Diponegoro No. 9, RT 01/RW 04', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'jnt', 'OKE', 'J&T OKE', 13925, 4, '2533000.00', '11134.00', 'HEMAT45', '2535791.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'JNT44374751', 'Mohon packing dengan bubble wrap', NULL, '2026-05-09 18:07:57', '2026-05-10 12:07:57', NULL, '2026-05-19 12:07:57', NULL, '2026-05-09 12:07:57', '2026-05-17 12:07:57'),
(50, 'BY-1050', 6, NULL, 'Rizky Pratama', '081355667788', 'Jl. Pahlawan No. 7, RT 06/RW 03', 'Jawa Barat', 'Bandung', 'Cicendo', '40171', 'jne', 'OKE', 'JNE OKE', 21472, 5, '526000.00', '0.00', NULL, '547472.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'JNE62693632', '', NULL, '2026-03-31 15:07:57', '2026-04-01 12:07:57', NULL, '2026-04-06 12:07:57', NULL, '2026-03-31 12:07:57', '2026-05-17 12:07:57'),
(51, 'BY-1051', 8, NULL, 'Hendra Wijaya', '085612341234', 'Jl. Imam Bonjol No. 3, RT 01/RW 02', 'Sumatera Utara', 'Medan', 'Medan Baru', '20152', 'pos', 'REGULER', 'Pos Indonesia REGULER', 28500, 3, '1551000.00', '0.00', NULL, '1579500.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'POS68130425', '', NULL, '2026-04-15 18:07:57', '2026-04-16 12:07:57', NULL, '2026-04-28 12:07:57', NULL, '2026-04-15 12:07:57', '2026-05-17 12:07:57'),
(52, 'BY-1052', 5, NULL, 'Dewi Putri', '087112233445', 'Jl. Kenanga No. 22, RT 05/RW 02', 'DKI Jakarta', 'Jakarta Selatan', 'Kebayoran Baru', '12120', 'sicepat', 'REGULER', 'SiCepat REGULER', 12059, 2, '1524000.00', '5850.00', 'HEMAT18', '1530209.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'SICEPAT22502847', 'Mohon packing dengan bubble wrap', NULL, '2026-04-02 15:07:57', '2026-04-03 12:07:57', NULL, '2026-04-07 12:07:57', NULL, '2026-04-02 12:07:57', '2026-05-17 12:07:57'),
(53, 'BY-1053', 8, NULL, 'Hendra Wijaya', '085612341234', 'Jl. Ahmad Yani No. 33, RT 01/RW 05', 'Jawa Timur', 'Surabaya', 'Wonokromo', '60243', 'jne', 'REGULER', 'JNE REGULER', 12352, 3, '1873000.00', '9568.00', 'HEMAT29', '1875784.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'JNE70406952', '', NULL, '2026-05-03 15:07:57', '2026-05-04 12:07:57', NULL, '2026-05-16 12:07:57', NULL, '2026-05-03 12:07:57', '2026-05-17 12:07:57'),
(54, 'BY-1054', 7, NULL, 'Maya Sari', '089922334455', 'Jl. Diponegoro No. 9, RT 05/RW 03', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'sicepat', 'EXPRESS', 'SiCepat EXPRESS', 29996, 1, '1935000.00', '0.00', NULL, '1964996.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'SICEPAT14670839', '', NULL, '2026-05-15 15:07:57', '2026-05-16 12:07:57', NULL, '2026-05-27 12:07:57', NULL, '2026-05-15 12:07:57', '2026-05-17 12:07:57'),
(55, 'BY-1055', 9, NULL, 'Rina Kusuma', '081278781234', 'Jl. Diponegoro No. 9, RT 06/RW 07', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'jne', 'EXPRESS', 'JNE EXPRESS', 14407, 1, '378000.00', '19265.00', 'HEMAT11', '373142.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'JNE40327104', 'Mohon packing dengan bubble wrap', NULL, '2026-03-23 18:07:57', '2026-03-24 12:07:57', NULL, '2026-03-31 12:07:57', NULL, '2026-03-23 12:07:57', '2026-05-17 12:07:57'),
(56, 'BY-1056', 4, NULL, 'Ahmad Fauzi', '085777888999', 'Jl. Kenanga No. 22, RT 09/RW 03', 'DKI Jakarta', 'Jakarta Selatan', 'Kebayoran Baru', '12120', 'jne', 'YES', 'JNE YES', 22620, 4, '816000.00', '0.00', NULL, '838620.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'JNE12226632', '', NULL, '2026-02-28 15:07:57', '2026-03-01 12:07:57', NULL, '2026-03-14 12:07:57', NULL, '2026-02-28 12:07:57', '2026-05-17 12:07:57'),
(57, 'BY-1057', 7, NULL, 'Maya Sari', '089922334455', 'Jl. Diponegoro No. 9, RT 05/RW 03', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'jnt', 'EXPRESS', 'J&T EXPRESS', 10976, 4, '1106000.00', '0.00', NULL, '1116976.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'JNT35797202', '', NULL, '2026-02-18 19:07:57', '2026-02-19 12:07:57', NULL, '2026-03-01 12:07:57', NULL, '2026-02-18 12:07:57', '2026-05-17 12:07:57'),
(58, 'BY-1058', 3, NULL, 'Siti Rahayu', '083444555666', 'Jl. Gatot Subroto No. 10, RT 09/RW 03', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'jnt', 'YES', 'J&T YES', 15907, 1, '1053000.00', '0.00', NULL, '1068907.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'JNT98189966', '', NULL, '2026-04-22 16:07:57', '2026-04-23 12:07:57', NULL, '2026-05-01 12:07:57', NULL, '2026-04-22 12:07:57', '2026-05-17 12:07:57'),
(59, 'BY-1059', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. Diponegoro No. 9, RT 09/RW 08', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'tiki', 'BEST', 'TIKI BEST', 13595, 3, '804000.00', '0.00', NULL, '817595.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'TIKI19833483', '', NULL, '2026-02-24 13:07:57', '2026-02-25 12:07:57', NULL, '2026-03-05 12:07:57', NULL, '2026-02-24 12:07:57', '2026-05-17 12:07:57'),
(60, 'BY-1060', 8, NULL, 'Hendra Wijaya', '085612341234', 'Jl. Kenanga No. 22, RT 09/RW 01', 'DKI Jakarta', 'Jakarta Selatan', 'Kebayoran Baru', '12120', 'jne', 'OKE', 'JNE OKE', 29527, 2, '2054000.00', '11695.00', 'HEMAT23', '2071832.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'JNE97052768', 'Mohon packing dengan bubble wrap', NULL, '2026-03-18 16:07:57', '2026-03-19 12:07:57', NULL, '2026-03-30 12:07:57', NULL, '2026-03-18 12:07:57', '2026-05-17 12:07:57'),
(61, 'BY-1061', 4, NULL, 'Ahmad Fauzi', '085777888999', 'Jl. Diponegoro No. 9, RT 04/RW 07', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'jne', 'REGULER', 'JNE REGULER', 22254, 4, '1407000.00', '13257.00', 'HEMAT44', '1415997.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'JNE12766320', '', NULL, '2026-04-03 14:07:57', '2026-04-04 12:07:57', NULL, '2026-04-08 12:07:57', NULL, '2026-04-03 12:07:57', '2026-05-17 12:07:57'),
(62, 'BY-1062', 9, NULL, 'Rina Kusuma', '081278781234', 'Jl. Diponegoro No. 9, RT 05/RW 07', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'anteraja', 'REG', 'AnterAja REG', 34878, 1, '447000.00', '0.00', NULL, '481878.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'ANTERAJA80981048', '', NULL, '2026-02-24 17:07:57', '2026-02-25 12:07:57', NULL, '2026-03-07 12:07:57', NULL, '2026-02-24 12:07:57', '2026-05-17 12:07:57'),
(63, 'BY-1063', 3, NULL, 'Siti Rahayu', '083444555666', 'Jl. Pahlawan No. 7, RT 09/RW 09', 'Jawa Barat', 'Bandung', 'Cicendo', '40171', 'pos', 'BEST', 'Pos Indonesia BEST', 21905, 2, '935000.00', '0.00', NULL, '956905.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'POS92490469', '', NULL, '2026-05-01 20:07:57', '2026-05-02 12:07:57', NULL, '2026-05-08 12:07:57', NULL, '2026-05-01 12:07:57', '2026-05-17 12:07:57'),
(64, 'BY-1064', 7, NULL, 'Maya Sari', '089922334455', 'Jl. Merdeka No. 15, RT 04/RW 06', 'DKI Jakarta', 'Jakarta Pusat', 'Gambir', '10110', 'anteraja', 'REGULER', 'AnterAja REGULER', 23351, 5, '777000.00', '15773.00', 'HEMAT42', '784578.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'ANTERAJA79458974', '', NULL, '2026-05-15 18:07:57', '2026-05-16 12:07:57', NULL, '2026-05-25 12:07:57', NULL, '2026-05-15 12:07:57', '2026-05-17 12:07:57'),
(65, 'BY-1065', 9, NULL, 'Rina Kusuma', '081278781234', 'Jl. Gatot Subroto No. 10, RT 02/RW 03', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'sicepat', 'OKE', 'SiCepat OKE', 35007, 1, '477000.00', '9934.00', 'HEMAT25', '502073.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'SICEPAT21608721', '', NULL, '2026-02-23 14:07:57', '2026-02-24 12:07:57', NULL, '2026-03-01 12:07:57', NULL, '2026-02-23 12:07:57', '2026-05-17 12:07:57'),
(66, 'BY-1066', 8, NULL, 'Hendra Wijaya', '085612341234', 'Jl. Kenanga No. 22, RT 03/RW 01', 'DKI Jakarta', 'Jakarta Selatan', 'Kebayoran Baru', '12120', 'jne', 'YES', 'JNE YES', 18757, 5, '1194000.00', '16346.00', 'HEMAT24', '1196411.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'JNE73946479', '', NULL, '2026-03-18 15:07:57', '2026-03-19 12:07:57', NULL, '2026-03-24 12:07:57', NULL, '2026-03-18 12:07:57', '2026-05-17 12:07:57'),
(67, 'BY-1067', 5, NULL, 'Dewi Putri', '087112233445', 'Jl. Diponegoro No. 9, RT 09/RW 05', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'anteraja', 'BEST', 'AnterAja BEST', 22857, 4, '1167000.00', '8741.00', 'HEMAT30', '1181116.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'dibatalkan', NULL, '', 'Stok tidak sesuai', '2026-04-16 14:07:57', NULL, NULL, NULL, '2026-04-16 15:07:57', '2026-04-16 12:07:57', '2026-05-17 12:07:57'),
(68, 'BY-1068', 5, NULL, 'Dewi Putri', '087112233445', 'Jl. Diponegoro No. 9, RT 02/RW 05', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'sicepat', 'EXPRESS', 'SiCepat EXPRESS', 33946, 2, '1023000.00', '15340.00', 'HEMAT30', '1041606.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'dibatalkan', NULL, 'Mohon packing dengan bubble wrap', 'Stok tidak sesuai', '2026-03-14 14:07:57', NULL, NULL, NULL, '2026-03-14 16:07:57', '2026-03-14 12:07:57', '2026-05-17 12:07:57'),
(69, 'BY-1069', 3, NULL, 'Siti Rahayu', '083444555666', 'Jl. Sudirman No. 55, RT 06/RW 01', 'Jawa Tengah', 'Semarang', 'Semarang Tengah', '50131', 'anteraja', 'OKE', 'AnterAja OKE', 13228, 2, '1682000.00', '0.00', NULL, '1695228.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'dibatalkan', NULL, '', 'Stok tidak sesuai', '2026-04-14 13:07:57', NULL, NULL, NULL, '2026-04-14 16:07:57', '2026-04-14 12:07:57', '2026-05-17 12:07:57'),
(70, 'BY-1070', 3, NULL, 'Siti Rahayu', '083444555666', 'Jl. Gatot Subroto No. 10, RT 09/RW 09', 'Bali', 'Denpasar', 'Denpasar Selatan', '80225', 'anteraja', 'YES', 'AnterAja YES', 24292, 1, '189000.00', '21228.00', 'HEMAT49', '192064.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'dibatalkan', NULL, '', 'Stok tidak sesuai', '2026-05-13 15:07:57', NULL, NULL, NULL, '2026-05-13 15:07:57', '2026-05-13 12:07:57', '2026-05-17 12:07:57'),
(71, 'BY-1071', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. KH. Yasin Beji No. 12, RT 03/RW 05', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'jne', 'REG', 'JNE REG', 19530, 3, '249000.00', '0.00', NULL, '268530.00', 'bank_transfer', 'pending', NULL, NULL, NULL, NULL, 'menunggu_bayar', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-19 12:07:57', '2026-05-17 12:07:57'),
(72, 'BY-1072', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. KH. Yasin Beji No. 12, RT 03/RW 05', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'jne', 'REG', 'JNE REG', 20802, 3, '99000.00', '0.00', NULL, '119802.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'diproses', NULL, '', NULL, '2026-04-26 14:07:57', NULL, NULL, NULL, NULL, '2026-04-26 12:07:57', '2026-05-17 12:07:57'),
(73, 'BY-1073', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. KH. Yasin Beji No. 12, RT 03/RW 05', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'jne', 'REG', 'JNE REG', 19984, 3, '189000.00', '0.00', NULL, '208984.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'dikirim', 'JNE22544219', '', NULL, '2026-04-23 14:07:57', '2026-04-24 12:07:57', NULL, NULL, NULL, '2026-04-23 12:07:57', '2026-05-17 12:07:57'),
(74, 'BY-1074', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. KH. Yasin Beji No. 12, RT 03/RW 05', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'jne', 'REG', 'JNE REG', 14137, 3, '469000.00', '0.00', NULL, '483137.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'diterima', 'JNE98541113', '', NULL, '2026-05-11 14:07:57', '2026-05-12 12:07:57', NULL, NULL, NULL, '2026-05-11 12:07:57', '2026-05-17 12:07:57'),
(75, 'BY-1075', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. KH. Yasin Beji No. 12, RT 03/RW 05', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'jne', 'REG', 'JNE REG', 15092, 3, '338000.00', '0.00', NULL, '353092.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'JNE11028729', '', NULL, '2026-04-17 14:07:57', '2026-04-18 12:07:57', NULL, '2026-04-24 12:07:57', NULL, '2026-04-17 12:07:57', '2026-05-17 12:07:57'),
(76, 'BY-1076', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. KH. Yasin Beji No. 12, RT 03/RW 05', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'jne', 'REG', 'JNE REG', 19557, 3, '399000.00', '0.00', NULL, '418557.00', 'midtrans', 'paid', NULL, NULL, NULL, NULL, 'selesai', 'JNE25944766', '', NULL, '2026-04-23 14:07:57', '2026-04-24 12:07:57', NULL, '2026-04-30 12:07:57', NULL, '2026-04-23 12:07:57', '2026-05-17 12:07:57'),
(77, 'BY-1077', 10, NULL, 'Arif Siddik M', '089514392694', 'Jl. KH. Yasin Beji No. 12, RT 03/RW 05', 'Banten', 'Cilegon', 'Ciwandan', '42414', 'jne', 'REG', 'JNE REG', 17024, 3, '129000.00', '0.00', NULL, '146024.00', 'bank_transfer', 'paid', NULL, NULL, NULL, NULL, 'dibatalkan', NULL, '', NULL, '2026-04-27 14:07:57', NULL, NULL, NULL, '2026-04-27 15:07:57', '2026-04-27 12:07:57', '2026-05-17 12:07:57');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variant_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_variant_id`, `product_name`, `product_thumbnail`, `variant_info`, `quantity`, `price`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 5, NULL, 'Kemeja Batik Modern', 'https://images.unsplash.com/photo-1594938298603-c8148c4b4357?w=500', NULL, 2, '189000.00', '378000.00', '2026-03-26 12:07:57', '2026-05-17 12:07:57'),
(2, 1, 32, NULL, 'Matras Yoga 6mm', 'https://images.unsplash.com/photo-1601925228058-d4b32b22dd3f?w=500', NULL, 2, '199000.00', '398000.00', '2026-03-26 12:07:57', '2026-05-17 12:07:57'),
(3, 2, 25, NULL, 'Charger GaN 65W', 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=500', NULL, 2, '169000.00', '338000.00', '2026-03-02 12:07:57', '2026-05-17 12:07:57'),
(4, 3, 13, NULL, 'Rok Plisket Trendy', 'https://images.unsplash.com/photo-1583496661160-fb5218a9bfe4?w=500', NULL, 1, '129000.00', '129000.00', '2026-04-04 12:07:57', '2026-05-17 12:07:57'),
(5, 4, 25, NULL, 'Charger GaN 65W', 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=500', NULL, 2, '169000.00', '338000.00', '2026-04-15 12:07:57', '2026-05-17 12:07:57'),
(6, 4, 35, NULL, 'Serum Vitamin C 20%', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500', NULL, 3, '99000.00', '297000.00', '2026-04-15 12:07:57', '2026-05-17 12:07:57'),
(7, 4, 41, NULL, 'Dompet Kulit RFID', 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=500', NULL, 1, '189000.00', '189000.00', '2026-04-15 12:07:57', '2026-05-17 12:07:57'),
(8, 5, 2, NULL, 'Celana Chino Slim Fit', 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=500', NULL, 1, '199000.00', '199000.00', '2026-05-07 12:07:57', '2026-05-17 12:07:57'),
(9, 5, 34, NULL, 'Resistance Band Set', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=500', NULL, 1, '129000.00', '129000.00', '2026-05-07 12:07:57', '2026-05-17 12:07:57'),
(10, 5, 35, NULL, 'Serum Vitamin C 20%', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500', NULL, 2, '99000.00', '198000.00', '2026-05-07 12:07:57', '2026-05-17 12:07:57'),
(11, 6, 3, NULL, 'Kaos Polo Pria Kasual', 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?w=500', NULL, 3, '129000.00', '387000.00', '2026-05-05 12:07:57', '2026-05-17 12:07:57'),
(12, 6, 22, NULL, 'Laptop Stand Aluminium', 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500', NULL, 3, '129000.00', '387000.00', '2026-05-05 12:07:57', '2026-05-17 12:07:57'),
(13, 6, 25, NULL, 'Charger GaN 65W', 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=500', NULL, 1, '169000.00', '169000.00', '2026-05-05 12:07:57', '2026-05-17 12:07:57'),
(14, 7, 10, NULL, 'Kemeja Oxford Formal', 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=500', NULL, 1, '289000.00', '289000.00', '2026-04-14 12:07:57', '2026-05-17 12:07:57'),
(15, 7, 32, NULL, 'Matras Yoga 6mm', 'https://images.unsplash.com/photo-1601925228058-d4b32b22dd3f?w=500', NULL, 1, '199000.00', '199000.00', '2026-04-14 12:07:57', '2026-05-17 12:07:57'),
(16, 7, 35, NULL, 'Serum Vitamin C 20%', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500', NULL, 2, '99000.00', '198000.00', '2026-04-14 12:07:57', '2026-05-17 12:07:57'),
(17, 8, 31, NULL, 'Sepatu Running Pro', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500', NULL, 2, '319000.00', '638000.00', '2026-02-18 12:07:57', '2026-05-17 12:07:57'),
(18, 9, 18, NULL, 'Dress Wrap Flowy', 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=500', NULL, 2, '209000.00', '418000.00', '2026-05-07 12:07:57', '2026-05-17 12:07:57'),
(19, 9, 33, NULL, 'Dumbbell Set 10kg', 'https://images.unsplash.com/photo-1590487988256-9ed24133863e?w=500', NULL, 2, '469000.00', '938000.00', '2026-05-07 12:07:57', '2026-05-17 12:07:57'),
(20, 9, 41, NULL, 'Dompet Kulit RFID', 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=500', NULL, 3, '189000.00', '567000.00', '2026-05-07 12:07:57', '2026-05-17 12:07:57'),
(21, 10, 34, NULL, 'Resistance Band Set', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=500', NULL, 3, '129000.00', '387000.00', '2026-03-06 12:07:57', '2026-05-17 12:07:57'),
(22, 11, 14, NULL, 'Cardigan Rajut Oversize', 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=500', NULL, 1, '239000.00', '239000.00', '2026-03-03 12:07:57', '2026-05-17 12:07:57'),
(23, 11, 42, NULL, 'Sepatu Boots Pria', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500', NULL, 2, '399000.00', '798000.00', '2026-03-03 12:07:57', '2026-05-17 12:07:57'),
(24, 12, 12, NULL, 'Blouse Wanita Elegan', 'https://images.unsplash.com/photo-1564257631407-4deb1f99d992?w=500', NULL, 2, '189000.00', '378000.00', '2026-03-15 12:07:57', '2026-05-17 12:07:57'),
(25, 12, 17, NULL, 'Celana Kulot Wanita', 'https://images.unsplash.com/photo-1594938298603-c8148c4b4357?w=500', NULL, 3, '219000.00', '657000.00', '2026-03-15 12:07:57', '2026-05-17 12:07:57'),
(26, 12, 32, NULL, 'Matras Yoga 6mm', 'https://images.unsplash.com/photo-1601925228058-d4b32b22dd3f?w=500', NULL, 1, '199000.00', '199000.00', '2026-03-15 12:07:57', '2026-05-17 12:07:57'),
(27, 13, 14, NULL, 'Cardigan Rajut Oversize', 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=500', NULL, 3, '239000.00', '717000.00', '2026-05-07 12:07:57', '2026-05-17 12:07:57'),
(28, 13, 19, NULL, 'TWS Earbuds Bluetooth', 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=500', NULL, 1, '159000.00', '159000.00', '2026-05-07 12:07:57', '2026-05-17 12:07:57'),
(29, 14, 22, NULL, 'Laptop Stand Aluminium', 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500', NULL, 1, '129000.00', '129000.00', '2026-03-30 12:07:57', '2026-05-17 12:07:57'),
(30, 14, 30, NULL, 'Vacuum Cleaner Cordless', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500', NULL, 1, '229000.00', '229000.00', '2026-03-30 12:07:57', '2026-05-17 12:07:57'),
(31, 15, 8, NULL, 'Sweater Knit Pria', 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=500', NULL, 1, '229000.00', '229000.00', '2026-05-12 12:07:57', '2026-05-17 12:07:57'),
(32, 16, 21, NULL, 'Smartwatch Fitness Pro', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500', NULL, 2, '389000.00', '778000.00', '2026-03-17 12:07:57', '2026-05-17 12:07:57'),
(33, 17, 21, NULL, 'Smartwatch Fitness Pro', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500', NULL, 3, '389000.00', '1167000.00', '2026-05-04 12:07:57', '2026-05-17 12:07:57'),
(34, 18, 15, NULL, 'Jumpsuit Casual Wanita', 'https://images.unsplash.com/photo-1551803091-e20673f15770?w=500', NULL, 1, '259000.00', '259000.00', '2026-02-28 12:07:57', '2026-05-17 12:07:57'),
(35, 18, 38, NULL, 'Body Lotion Whitening', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500', NULL, 3, '79000.00', '237000.00', '2026-02-28 12:07:57', '2026-05-17 12:07:57'),
(36, 18, 41, NULL, 'Dompet Kulit RFID', 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=500', NULL, 2, '189000.00', '378000.00', '2026-02-28 12:07:57', '2026-05-17 12:07:57'),
(37, 19, 19, NULL, 'TWS Earbuds Bluetooth', 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=500', NULL, 1, '159000.00', '159000.00', '2026-04-07 12:07:57', '2026-05-17 12:07:57'),
(38, 20, 40, NULL, 'Tas Ransel Laptop 35L', 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500', NULL, 3, '389000.00', '1167000.00', '2026-03-26 12:07:57', '2026-05-17 12:07:57'),
(39, 21, 6, NULL, 'Celana Jogger Premium', 'https://images.unsplash.com/photo-1552902865-b72c031ac5ea?w=500', NULL, 1, '159000.00', '159000.00', '2026-04-01 12:07:57', '2026-05-17 12:07:57'),
(40, 21, 16, NULL, 'Tunik Batik Wanita', 'https://images.unsplash.com/photo-1585487000160-6ebcfceb0d03?w=500', NULL, 3, '169000.00', '507000.00', '2026-04-01 12:07:57', '2026-05-17 12:07:57'),
(41, 22, 7, NULL, 'T-Shirt Grafis Oversize', 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500', NULL, 2, '159000.00', '318000.00', '2026-02-18 12:07:57', '2026-05-17 12:07:57'),
(42, 22, 17, NULL, 'Celana Kulot Wanita', 'https://images.unsplash.com/photo-1594938298603-c8148c4b4357?w=500', NULL, 1, '219000.00', '219000.00', '2026-02-18 12:07:57', '2026-05-17 12:07:57'),
(43, 22, 23, NULL, 'Wireless Mouse Silent', 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500', NULL, 1, '149000.00', '149000.00', '2026-02-18 12:07:57', '2026-05-17 12:07:57'),
(44, 23, 19, NULL, 'TWS Earbuds Bluetooth', 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=500', NULL, 3, '159000.00', '477000.00', '2026-03-23 12:07:57', '2026-05-17 12:07:57'),
(45, 23, 27, NULL, 'Blender Portable Mini', 'https://images.unsplash.com/photo-1570222094114-d054a817e56b?w=500', NULL, 3, '189000.00', '567000.00', '2026-03-23 12:07:57', '2026-05-17 12:07:57'),
(46, 23, 42, NULL, 'Sepatu Boots Pria', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500', NULL, 1, '399000.00', '399000.00', '2026-03-23 12:07:57', '2026-05-17 12:07:57'),
(47, 24, 12, NULL, 'Blouse Wanita Elegan', 'https://images.unsplash.com/photo-1564257631407-4deb1f99d992?w=500', NULL, 3, '189000.00', '567000.00', '2026-02-18 12:07:57', '2026-05-17 12:07:57'),
(48, 24, 32, NULL, 'Matras Yoga 6mm', 'https://images.unsplash.com/photo-1601925228058-d4b32b22dd3f?w=500', NULL, 3, '199000.00', '597000.00', '2026-02-18 12:07:57', '2026-05-17 12:07:57'),
(49, 24, 39, NULL, 'Sneakers Casual Canvas', 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?w=500', NULL, 3, '259000.00', '777000.00', '2026-02-18 12:07:57', '2026-05-17 12:07:57'),
(50, 25, 24, NULL, 'Speaker Bluetooth 360°', 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500', NULL, 2, '249000.00', '498000.00', '2026-04-05 12:07:57', '2026-05-17 12:07:57'),
(51, 25, 44, NULL, 'RC Car Off-Road 4WD', 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=500', NULL, 2, '249000.00', '498000.00', '2026-04-05 12:07:57', '2026-05-17 12:07:57'),
(52, 26, 18, NULL, 'Dress Wrap Flowy', 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=500', NULL, 3, '209000.00', '627000.00', '2026-03-28 12:07:57', '2026-05-17 12:07:57'),
(53, 26, 19, NULL, 'TWS Earbuds Bluetooth', 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=500', NULL, 1, '159000.00', '159000.00', '2026-03-28 12:07:57', '2026-05-17 12:07:57'),
(54, 26, 33, NULL, 'Dumbbell Set 10kg', 'https://images.unsplash.com/photo-1590487988256-9ed24133863e?w=500', NULL, 3, '469000.00', '1407000.00', '2026-03-28 12:07:57', '2026-05-17 12:07:57'),
(55, 27, 16, NULL, 'Tunik Batik Wanita', 'https://images.unsplash.com/photo-1585487000160-6ebcfceb0d03?w=500', NULL, 3, '169000.00', '507000.00', '2026-04-27 12:07:57', '2026-05-17 12:07:57'),
(56, 27, 19, NULL, 'TWS Earbuds Bluetooth', 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=500', NULL, 2, '159000.00', '318000.00', '2026-04-27 12:07:57', '2026-05-17 12:07:57'),
(57, 28, 36, NULL, 'Sunscreen SPF50+ 50ml', 'https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=500', NULL, 2, '69000.00', '138000.00', '2026-04-12 12:07:57', '2026-05-17 12:07:57'),
(58, 29, 3, NULL, 'Kaos Polo Pria Kasual', 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?w=500', NULL, 3, '129000.00', '387000.00', '2026-04-28 12:07:57', '2026-05-17 12:07:57'),
(59, 30, 26, NULL, 'Ring Light LED 10\"', 'https://images.unsplash.com/photo-1587826080692-f439cd0b70da?w=500', NULL, 1, '149000.00', '149000.00', '2026-02-26 12:07:57', '2026-05-17 12:07:57'),
(60, 31, 9, NULL, 'Celana Jeans Slim', 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=500', NULL, 3, '269000.00', '807000.00', '2026-02-24 12:07:57', '2026-05-17 12:07:57'),
(61, 31, 35, NULL, 'Serum Vitamin C 20%', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500', NULL, 1, '99000.00', '99000.00', '2026-02-24 12:07:57', '2026-05-17 12:07:57'),
(62, 31, 40, NULL, 'Tas Ransel Laptop 35L', 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500', NULL, 3, '389000.00', '1167000.00', '2026-02-24 12:07:57', '2026-05-17 12:07:57'),
(63, 32, 6, NULL, 'Celana Jogger Premium', 'https://images.unsplash.com/photo-1552902865-b72c031ac5ea?w=500', NULL, 1, '159000.00', '159000.00', '2026-04-12 12:07:57', '2026-05-17 12:07:57'),
(64, 32, 32, NULL, 'Matras Yoga 6mm', 'https://images.unsplash.com/photo-1601925228058-d4b32b22dd3f?w=500', NULL, 1, '199000.00', '199000.00', '2026-04-12 12:07:57', '2026-05-17 12:07:57'),
(65, 32, 33, NULL, 'Dumbbell Set 10kg', 'https://images.unsplash.com/photo-1590487988256-9ed24133863e?w=500', NULL, 1, '469000.00', '469000.00', '2026-04-12 12:07:57', '2026-05-17 12:07:57'),
(66, 33, 44, NULL, 'RC Car Off-Road 4WD', 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=500', NULL, 2, '249000.00', '498000.00', '2026-04-25 12:07:57', '2026-05-17 12:07:57'),
(67, 34, 38, NULL, 'Body Lotion Whitening', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500', NULL, 2, '79000.00', '158000.00', '2026-04-25 12:07:57', '2026-05-17 12:07:57'),
(68, 35, 14, NULL, 'Cardigan Rajut Oversize', 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=500', NULL, 1, '239000.00', '239000.00', '2026-03-21 12:07:57', '2026-05-17 12:07:57'),
(69, 35, 34, NULL, 'Resistance Band Set', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=500', NULL, 2, '129000.00', '258000.00', '2026-03-21 12:07:57', '2026-05-17 12:07:57'),
(70, 36, 24, NULL, 'Speaker Bluetooth 360°', 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500', NULL, 3, '249000.00', '747000.00', '2026-03-10 12:07:57', '2026-05-17 12:07:57'),
(71, 36, 39, NULL, 'Sneakers Casual Canvas', 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?w=500', NULL, 1, '259000.00', '259000.00', '2026-03-10 12:07:57', '2026-05-17 12:07:57'),
(72, 37, 5, NULL, 'Kemeja Batik Modern', 'https://images.unsplash.com/photo-1594938298603-c8148c4b4357?w=500', NULL, 2, '189000.00', '378000.00', '2026-04-08 12:07:57', '2026-05-17 12:07:57'),
(73, 37, 21, NULL, 'Smartwatch Fitness Pro', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500', NULL, 1, '389000.00', '389000.00', '2026-04-08 12:07:57', '2026-05-17 12:07:57'),
(74, 37, 26, NULL, 'Ring Light LED 10\"', 'https://images.unsplash.com/photo-1587826080692-f439cd0b70da?w=500', NULL, 2, '149000.00', '298000.00', '2026-04-08 12:07:57', '2026-05-17 12:07:57'),
(75, 38, 16, NULL, 'Tunik Batik Wanita', 'https://images.unsplash.com/photo-1585487000160-6ebcfceb0d03?w=500', NULL, 3, '169000.00', '507000.00', '2026-05-02 12:07:57', '2026-05-17 12:07:57'),
(76, 39, 11, NULL, 'Dress Midi Floral', 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=500', NULL, 2, '219000.00', '438000.00', '2026-03-25 12:07:57', '2026-05-17 12:07:57'),
(77, 39, 14, NULL, 'Cardigan Rajut Oversize', 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=500', NULL, 3, '239000.00', '717000.00', '2026-03-25 12:07:57', '2026-05-17 12:07:57'),
(78, 40, 1, NULL, 'Kemeja Flanel Pria Premium', 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=500', NULL, 2, '149000.00', '298000.00', '2026-05-05 12:07:57', '2026-05-17 12:07:57'),
(79, 40, 4, NULL, 'Jaket Bomber Distro', 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=500', NULL, 1, '289000.00', '289000.00', '2026-05-05 12:07:57', '2026-05-17 12:07:57'),
(80, 40, 24, NULL, 'Speaker Bluetooth 360°', 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500', NULL, 2, '249000.00', '498000.00', '2026-05-05 12:07:57', '2026-05-17 12:07:57'),
(81, 41, 39, NULL, 'Sneakers Casual Canvas', 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?w=500', NULL, 2, '259000.00', '518000.00', '2026-03-28 12:07:57', '2026-05-17 12:07:57'),
(82, 41, 44, NULL, 'RC Car Off-Road 4WD', 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=500', NULL, 2, '249000.00', '498000.00', '2026-03-28 12:07:57', '2026-05-17 12:07:57'),
(83, 42, 15, NULL, 'Jumpsuit Casual Wanita', 'https://images.unsplash.com/photo-1551803091-e20673f15770?w=500', NULL, 1, '259000.00', '259000.00', '2026-03-24 12:07:57', '2026-05-17 12:07:57'),
(84, 42, 30, NULL, 'Vacuum Cleaner Cordless', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500', NULL, 3, '229000.00', '687000.00', '2026-03-24 12:07:57', '2026-05-17 12:07:57'),
(85, 43, 3, NULL, 'Kaos Polo Pria Kasual', 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?w=500', NULL, 1, '129000.00', '129000.00', '2026-03-11 12:07:57', '2026-05-17 12:07:57'),
(86, 43, 5, NULL, 'Kemeja Batik Modern', 'https://images.unsplash.com/photo-1594938298603-c8148c4b4357?w=500', NULL, 2, '189000.00', '378000.00', '2026-03-11 12:07:57', '2026-05-17 12:07:57'),
(87, 43, 28, NULL, 'Bantal Memory Foam', 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500', NULL, 3, '209000.00', '627000.00', '2026-03-11 12:07:57', '2026-05-17 12:07:57'),
(88, 44, 3, NULL, 'Kaos Polo Pria Kasual', 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?w=500', NULL, 3, '129000.00', '387000.00', '2026-04-23 12:07:57', '2026-05-17 12:07:57'),
(89, 44, 29, NULL, 'Rice Cooker Digital 1.8L', 'https://images.unsplash.com/photo-1585515320310-259814833e62?w=500', NULL, 3, '349000.00', '1047000.00', '2026-04-23 12:07:57', '2026-05-17 12:07:57'),
(90, 45, 21, NULL, 'Smartwatch Fitness Pro', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500', NULL, 2, '389000.00', '778000.00', '2026-04-25 12:07:57', '2026-05-17 12:07:57'),
(91, 45, 29, NULL, 'Rice Cooker Digital 1.8L', 'https://images.unsplash.com/photo-1585515320310-259814833e62?w=500', NULL, 2, '349000.00', '698000.00', '2026-04-25 12:07:57', '2026-05-17 12:07:57'),
(92, 46, 25, NULL, 'Charger GaN 65W', 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=500', NULL, 3, '169000.00', '507000.00', '2026-03-15 12:07:57', '2026-05-17 12:07:57'),
(93, 46, 42, NULL, 'Sepatu Boots Pria', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500', NULL, 2, '399000.00', '798000.00', '2026-03-15 12:07:57', '2026-05-17 12:07:57'),
(94, 47, 29, NULL, 'Rice Cooker Digital 1.8L', 'https://images.unsplash.com/photo-1585515320310-259814833e62?w=500', NULL, 3, '349000.00', '1047000.00', '2026-03-07 12:07:57', '2026-05-17 12:07:57'),
(95, 48, 29, NULL, 'Rice Cooker Digital 1.8L', 'https://images.unsplash.com/photo-1585515320310-259814833e62?w=500', NULL, 3, '349000.00', '1047000.00', '2026-03-04 12:07:57', '2026-05-17 12:07:57'),
(96, 49, 10, NULL, 'Kemeja Oxford Formal', 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=500', NULL, 3, '289000.00', '867000.00', '2026-05-09 12:07:57', '2026-05-17 12:07:57'),
(97, 49, 25, NULL, 'Charger GaN 65W', 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=500', NULL, 1, '169000.00', '169000.00', '2026-05-09 12:07:57', '2026-05-17 12:07:57'),
(98, 49, 45, NULL, 'Drone Mini Selfie 1080p', 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=500', NULL, 3, '499000.00', '1497000.00', '2026-05-09 12:07:57', '2026-05-17 12:07:57'),
(99, 50, 8, NULL, 'Sweater Knit Pria', 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=500', NULL, 1, '229000.00', '229000.00', '2026-03-31 12:07:57', '2026-05-17 12:07:57'),
(100, 50, 35, NULL, 'Serum Vitamin C 20%', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500', NULL, 3, '99000.00', '297000.00', '2026-03-31 12:07:57', '2026-05-17 12:07:57'),
(101, 51, 4, NULL, 'Jaket Bomber Distro', 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=500', NULL, 3, '289000.00', '867000.00', '2026-04-15 12:07:57', '2026-05-17 12:07:57'),
(102, 51, 19, NULL, 'TWS Earbuds Bluetooth', 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=500', NULL, 3, '159000.00', '477000.00', '2026-04-15 12:07:57', '2026-05-17 12:07:57'),
(103, 51, 36, NULL, 'Sunscreen SPF50+ 50ml', 'https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=500', NULL, 3, '69000.00', '207000.00', '2026-04-15 12:07:57', '2026-05-17 12:07:57'),
(104, 52, 17, NULL, 'Celana Kulot Wanita', 'https://images.unsplash.com/photo-1594938298603-c8148c4b4357?w=500', NULL, 1, '219000.00', '219000.00', '2026-04-02 12:07:57', '2026-05-17 12:07:57'),
(105, 52, 20, NULL, 'Power Bank 20000mAh', 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=500', NULL, 2, '279000.00', '558000.00', '2026-04-02 12:07:57', '2026-05-17 12:07:57'),
(106, 52, 24, NULL, 'Speaker Bluetooth 360°', 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500', NULL, 3, '249000.00', '747000.00', '2026-04-02 12:07:57', '2026-05-17 12:07:57'),
(107, 53, 3, NULL, 'Kaos Polo Pria Kasual', 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?w=500', NULL, 2, '129000.00', '258000.00', '2026-05-03 12:07:57', '2026-05-17 12:07:57'),
(108, 53, 18, NULL, 'Dress Wrap Flowy', 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=500', NULL, 2, '209000.00', '418000.00', '2026-05-03 12:07:57', '2026-05-17 12:07:57'),
(109, 53, 42, NULL, 'Sepatu Boots Pria', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500', NULL, 3, '399000.00', '1197000.00', '2026-05-03 12:07:57', '2026-05-17 12:07:57'),
(110, 54, 32, NULL, 'Matras Yoga 6mm', 'https://images.unsplash.com/photo-1601925228058-d4b32b22dd3f?w=500', NULL, 1, '199000.00', '199000.00', '2026-05-15 12:07:57', '2026-05-17 12:07:57'),
(111, 54, 33, NULL, 'Dumbbell Set 10kg', 'https://images.unsplash.com/photo-1590487988256-9ed24133863e?w=500', NULL, 2, '469000.00', '938000.00', '2026-05-15 12:07:57', '2026-05-17 12:07:57'),
(112, 54, 42, NULL, 'Sepatu Boots Pria', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500', NULL, 2, '399000.00', '798000.00', '2026-05-15 12:07:57', '2026-05-17 12:07:57'),
(113, 55, 12, NULL, 'Blouse Wanita Elegan', 'https://images.unsplash.com/photo-1564257631407-4deb1f99d992?w=500', NULL, 2, '189000.00', '378000.00', '2026-03-23 12:07:57', '2026-05-17 12:07:57'),
(114, 56, 27, NULL, 'Blender Portable Mini', 'https://images.unsplash.com/photo-1570222094114-d054a817e56b?w=500', NULL, 3, '189000.00', '567000.00', '2026-02-28 12:07:57', '2026-05-17 12:07:57'),
(115, 56, 44, NULL, 'RC Car Off-Road 4WD', 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=500', NULL, 1, '249000.00', '249000.00', '2026-02-28 12:07:57', '2026-05-17 12:07:57'),
(116, 57, 19, NULL, 'TWS Earbuds Bluetooth', 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=500', NULL, 1, '159000.00', '159000.00', '2026-02-18 12:07:57', '2026-05-17 12:07:57'),
(117, 57, 20, NULL, 'Power Bank 20000mAh', 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=500', NULL, 2, '279000.00', '558000.00', '2026-02-18 12:07:57', '2026-05-17 12:07:57'),
(118, 57, 40, NULL, 'Tas Ransel Laptop 35L', 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500', NULL, 1, '389000.00', '389000.00', '2026-02-18 12:07:57', '2026-05-17 12:07:57'),
(119, 58, 12, NULL, 'Blouse Wanita Elegan', 'https://images.unsplash.com/photo-1564257631407-4deb1f99d992?w=500', NULL, 1, '189000.00', '189000.00', '2026-04-22 12:07:57', '2026-05-17 12:07:57'),
(120, 58, 22, NULL, 'Laptop Stand Aluminium', 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500', NULL, 3, '129000.00', '387000.00', '2026-04-22 12:07:57', '2026-05-17 12:07:57'),
(121, 58, 43, NULL, 'Lego Building Blocks 1000pcs', 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=500', NULL, 3, '159000.00', '477000.00', '2026-04-22 12:07:57', '2026-05-17 12:07:57'),
(122, 59, 27, NULL, 'Blender Portable Mini', 'https://images.unsplash.com/photo-1570222094114-d054a817e56b?w=500', NULL, 3, '189000.00', '567000.00', '2026-02-24 12:07:57', '2026-05-17 12:07:57'),
(123, 59, 38, NULL, 'Body Lotion Whitening', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500', NULL, 3, '79000.00', '237000.00', '2026-02-24 12:07:57', '2026-05-17 12:07:57'),
(124, 60, 4, NULL, 'Jaket Bomber Distro', 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=500', NULL, 3, '289000.00', '867000.00', '2026-03-18 12:07:57', '2026-05-17 12:07:57'),
(125, 60, 12, NULL, 'Blouse Wanita Elegan', 'https://images.unsplash.com/photo-1564257631407-4deb1f99d992?w=500', NULL, 1, '189000.00', '189000.00', '2026-03-18 12:07:57', '2026-05-17 12:07:57'),
(126, 60, 45, NULL, 'Drone Mini Selfie 1080p', 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=500', NULL, 2, '499000.00', '998000.00', '2026-03-18 12:07:57', '2026-05-17 12:07:57'),
(127, 61, 33, NULL, 'Dumbbell Set 10kg', 'https://images.unsplash.com/photo-1590487988256-9ed24133863e?w=500', NULL, 3, '469000.00', '1407000.00', '2026-04-03 12:07:57', '2026-05-17 12:07:57'),
(128, 62, 1, NULL, 'Kemeja Flanel Pria Premium', 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=500', NULL, 3, '149000.00', '447000.00', '2026-02-24 12:07:57', '2026-05-17 12:07:57'),
(129, 63, 11, NULL, 'Dress Midi Floral', 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=500', NULL, 1, '219000.00', '219000.00', '2026-05-01 12:07:57', '2026-05-17 12:07:57'),
(130, 63, 23, NULL, 'Wireless Mouse Silent', 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500', NULL, 2, '149000.00', '298000.00', '2026-05-01 12:07:57', '2026-05-17 12:07:57'),
(131, 63, 28, NULL, 'Bantal Memory Foam', 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500', NULL, 2, '209000.00', '418000.00', '2026-05-01 12:07:57', '2026-05-17 12:07:57'),
(132, 64, 39, NULL, 'Sneakers Casual Canvas', 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?w=500', NULL, 3, '259000.00', '777000.00', '2026-05-15 12:07:57', '2026-05-17 12:07:57'),
(133, 65, 19, NULL, 'TWS Earbuds Bluetooth', 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=500', NULL, 3, '159000.00', '477000.00', '2026-02-23 12:07:57', '2026-05-17 12:07:57'),
(134, 66, 14, NULL, 'Cardigan Rajut Oversize', 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=500', NULL, 3, '239000.00', '717000.00', '2026-03-18 12:07:57', '2026-05-17 12:07:57'),
(135, 66, 19, NULL, 'TWS Earbuds Bluetooth', 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=500', NULL, 3, '159000.00', '477000.00', '2026-03-18 12:07:57', '2026-05-17 12:07:57'),
(136, 67, 21, NULL, 'Smartwatch Fitness Pro', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500', NULL, 3, '389000.00', '1167000.00', '2026-04-16 12:07:57', '2026-05-17 12:07:57'),
(137, 68, 7, NULL, 'T-Shirt Grafis Oversize', 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500', NULL, 1, '159000.00', '159000.00', '2026-03-14 12:07:57', '2026-05-17 12:07:57'),
(138, 68, 17, NULL, 'Celana Kulot Wanita', 'https://images.unsplash.com/photo-1594938298603-c8148c4b4357?w=500', NULL, 3, '219000.00', '657000.00', '2026-03-14 12:07:57', '2026-05-17 12:07:57'),
(139, 68, 36, NULL, 'Sunscreen SPF50+ 50ml', 'https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=500', NULL, 3, '69000.00', '207000.00', '2026-03-14 12:07:57', '2026-05-17 12:07:57'),
(140, 69, 30, NULL, 'Vacuum Cleaner Cordless', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500', NULL, 3, '229000.00', '687000.00', '2026-04-14 12:07:57', '2026-05-17 12:07:57'),
(141, 69, 39, NULL, 'Sneakers Casual Canvas', 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?w=500', NULL, 2, '259000.00', '518000.00', '2026-04-14 12:07:57', '2026-05-17 12:07:57'),
(142, 69, 43, NULL, 'Lego Building Blocks 1000pcs', 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=500', NULL, 3, '159000.00', '477000.00', '2026-04-14 12:07:57', '2026-05-17 12:07:57'),
(143, 70, 41, NULL, 'Dompet Kulit RFID', 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=500', NULL, 1, '189000.00', '189000.00', '2026-05-13 12:07:57', '2026-05-17 12:07:57'),
(144, 71, 24, NULL, 'Speaker Bluetooth 360°', 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500', NULL, 1, '249000.00', '249000.00', '2026-04-19 12:07:57', '2026-05-17 12:07:57'),
(145, 72, 35, NULL, 'Serum Vitamin C 20%', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500', NULL, 1, '99000.00', '99000.00', '2026-04-26 12:07:57', '2026-05-17 12:07:57'),
(146, 73, 27, NULL, 'Blender Portable Mini', 'https://images.unsplash.com/photo-1570222094114-d054a817e56b?w=500', NULL, 1, '189000.00', '189000.00', '2026-04-23 12:07:57', '2026-05-17 12:07:57'),
(147, 74, 33, NULL, 'Dumbbell Set 10kg', 'https://images.unsplash.com/photo-1590487988256-9ed24133863e?w=500', NULL, 1, '469000.00', '469000.00', '2026-05-11 12:07:57', '2026-05-17 12:07:57'),
(148, 75, 16, NULL, 'Tunik Batik Wanita', 'https://images.unsplash.com/photo-1585487000160-6ebcfceb0d03?w=500', NULL, 1, '169000.00', '338000.00', '2026-04-17 12:07:57', '2026-05-17 12:07:57'),
(149, 76, 42, NULL, 'Sepatu Boots Pria', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500', NULL, 1, '399000.00', '399000.00', '2026-04-23 12:07:57', '2026-05-17 12:07:57'),
(150, 77, 13, NULL, 'Rok Plisket Trendy', 'https://images.unsplash.com/photo-1583496661160-fb5218a9bfe4?w=500', NULL, 1, '129000.00', '129000.00', '2026-04-27 12:07:57', '2026-05-17 12:07:57');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_confirmations`
--

CREATE TABLE `payment_confirmations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `transfer_proof` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_confirmations`
--

INSERT INTO `payment_confirmations` (`id`, `order_id`, `user_id`, `bank_name`, `account_name`, `account_number`, `amount`, `transfer_proof`, `status`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 9, 7, 'BCA', 'Maya Sari', '1234753706', '1913548.00', '', 'pending', 'Dummy data seeder.', '2026-05-07 14:07:57', '2026-05-17 12:07:57'),
(2, 10, 10, 'Mandiri', 'Arif Siddik M', '1234808153', '402021.00', '', 'pending', 'Dummy data seeder.', '2026-03-06 14:07:57', '2026-05-17 12:07:57'),
(3, 12, 7, 'BNI', 'Maya Sari', '1234357527', '1250083.00', '', 'pending', 'Dummy data seeder.', '2026-03-15 14:07:57', '2026-05-17 12:07:57'),
(4, 14, 9, 'BNI', 'Rina Kusuma', '1234694363', '370994.00', '', 'pending', 'Dummy data seeder.', '2026-03-30 14:07:57', '2026-05-17 12:07:57'),
(5, 16, 6, 'Mandiri', 'Rizky Pratama', '1234568092', '812261.00', '', 'pending', 'Dummy data seeder.', '2026-03-17 14:07:57', '2026-05-17 12:07:57'),
(6, 17, 6, 'BNI', 'Rizky Pratama', '1234582153', '1200220.00', '', 'pending', 'Dummy data seeder.', '2026-05-04 14:07:57', '2026-05-17 12:07:57'),
(7, 19, 5, 'BNI', 'Dewi Putri', '1234381093', '181545.00', '', 'approved', 'Dummy data seeder.', '2026-04-07 14:07:57', '2026-05-17 12:07:57'),
(8, 20, 5, 'Mandiri', 'Dewi Putri', '1234238522', '1180432.00', '', 'approved', 'Dummy data seeder.', '2026-03-26 14:07:57', '2026-05-17 12:07:57'),
(9, 24, 3, 'BNI', 'Siti Rahayu', '1234638846', '1930642.00', '', 'approved', 'Dummy data seeder.', '2026-02-18 14:07:57', '2026-05-17 12:07:57'),
(10, 25, 9, 'BCA', 'Rina Kusuma', '1234778942', '990222.00', '', 'approved', 'Dummy data seeder.', '2026-04-05 14:07:57', '2026-05-17 12:07:57'),
(11, 31, 10, 'BCA', 'Arif Siddik M', '1234716575', '2086240.00', '', 'approved', 'Dummy data seeder.', '2026-02-24 14:07:57', '2026-05-17 12:07:57'),
(12, 32, 2, 'Mandiri', 'Budi Santoso', '1234357934', '831954.00', '', 'approved', 'Dummy data seeder.', '2026-04-12 14:07:57', '2026-05-17 12:07:57'),
(13, 33, 5, 'BCA', 'Dewi Putri', '1234195131', '513710.00', '', 'approved', 'Dummy data seeder.', '2026-04-25 14:07:57', '2026-05-17 12:07:57'),
(14, 35, 8, 'BCA', 'Hendra Wijaya', '1234150226', '525972.00', '', 'approved', 'Dummy data seeder.', '2026-03-21 14:07:57', '2026-05-17 12:07:57'),
(15, 36, 8, 'BNI', 'Hendra Wijaya', '1234844146', '1009260.00', '', 'approved', 'Dummy data seeder.', '2026-03-10 14:07:57', '2026-05-17 12:07:57'),
(16, 37, 4, 'BCA', 'Ahmad Fauzi', '1234761390', '1099893.00', '', 'approved', 'Dummy data seeder.', '2026-04-08 14:07:57', '2026-05-17 12:07:57'),
(17, 39, 3, 'BCA', 'Siti Rahayu', '1234204357', '1167583.00', '', 'approved', 'Dummy data seeder.', '2026-03-25 14:07:57', '2026-05-17 12:07:57'),
(18, 42, 9, 'Mandiri', 'Rina Kusuma', '1234601308', '980335.00', '', 'approved', 'Dummy data seeder.', '2026-03-24 14:07:57', '2026-05-17 12:07:57'),
(19, 43, 3, 'Mandiri', 'Siti Rahayu', '1234325201', '1143624.00', '', 'approved', 'Dummy data seeder.', '2026-03-11 14:07:57', '2026-05-17 12:07:57'),
(20, 45, 5, 'Mandiri', 'Dewi Putri', '1234329652', '1489912.00', '', 'approved', 'Dummy data seeder.', '2026-04-25 14:07:57', '2026-05-17 12:07:57'),
(21, 46, 10, 'Mandiri', 'Arif Siddik M', '1234169127', '1316961.00', '', 'approved', 'Dummy data seeder.', '2026-03-15 14:07:57', '2026-05-17 12:07:57'),
(22, 47, 6, 'BCA', 'Rizky Pratama', '1234770060', '1060285.00', '', 'approved', 'Dummy data seeder.', '2026-03-07 14:07:57', '2026-05-17 12:07:57'),
(23, 49, 2, 'BNI', 'Budi Santoso', '1234646867', '2535791.00', '', 'approved', 'Dummy data seeder.', '2026-05-09 14:07:57', '2026-05-17 12:07:57'),
(24, 50, 6, 'BCA', 'Rizky Pratama', '1234592289', '547472.00', '', 'approved', 'Dummy data seeder.', '2026-03-31 14:07:57', '2026-05-17 12:07:57'),
(25, 52, 5, 'Mandiri', 'Dewi Putri', '1234772440', '1530209.00', '', 'approved', 'Dummy data seeder.', '2026-04-02 14:07:57', '2026-05-17 12:07:57'),
(26, 55, 9, 'BCA', 'Rina Kusuma', '1234789903', '373142.00', '', 'approved', 'Dummy data seeder.', '2026-03-23 14:07:57', '2026-05-17 12:07:57'),
(27, 57, 7, 'BCA', 'Maya Sari', '1234886350', '1116976.00', '', 'approved', 'Dummy data seeder.', '2026-02-18 14:07:57', '2026-05-17 12:07:57'),
(28, 59, 10, 'BCA', 'Arif Siddik M', '1234716402', '817595.00', '', 'approved', 'Dummy data seeder.', '2026-02-24 14:07:57', '2026-05-17 12:07:57'),
(29, 64, 7, 'Mandiri', 'Maya Sari', '1234924923', '784578.00', '', 'approved', 'Dummy data seeder.', '2026-05-15 14:07:57', '2026-05-17 12:07:57'),
(30, 65, 9, 'BCA', 'Rina Kusuma', '1234574512', '502073.00', '', 'approved', 'Dummy data seeder.', '2026-02-23 14:07:57', '2026-05-17 12:07:57');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `sale_price` decimal(15,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `weight` decimal(8,2) NOT NULL DEFAULT 0.00,
  `length` decimal(8,2) DEFAULT NULL,
  `width` decimal(8,2) DEFAULT NULL,
  `height` decimal(8,2) DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_promo` tinyint(1) NOT NULL DEFAULT 0,
  `is_new` tinyint(1) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `sold_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `sku`, `short_description`, `description`, `price`, `sale_price`, `stock`, `weight`, `length`, `width`, `height`, `thumbnail`, `is_active`, `is_featured`, `is_promo`, `is_new`, `views`, `sold_count`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kemeja Flanel Pria Premium', 'kemeja-flanel-pria-premium-1', 'BY-00001', 'Kemeja Flanel Pria merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehar...', '<p><strong>Kemeja Flanel Pria</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Bahan 100% cotton breathable, nyaman seharian</p><p><strong>Spesifikasi & Fitur:</strong><br>Cotton Flannel 180gsm, kancing kokoh, S-XXL</p><p><strong>Tips Penggunaan:</strong><br>Cuci air dingin, setrika suhu sedang</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '189000.00', '149000.00', 200, '300.00', '26.00', '30.00', '17.00', 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=500', 1, 1, 1, 1, 3140, 657, '2026-03-01 12:07:56', '2026-05-17 12:07:56'),
(2, 1, 'Celana Chino Slim Fit', 'celana-chino-slim-fit-2', 'BY-00002', 'Celana Chino Slim merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari...', '<p><strong>Celana Chino Slim</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Potongan modern, bebas bergerak</p><p><strong>Spesifikasi & Fitur:</strong><br>Stretch cotton twill 260gsm, 4 kantong, slim fit</p><p><strong>Tips Penggunaan:</strong><br>Cuci terpisah warna gelap</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '249000.00', '199000.00', 150, '450.00', '28.00', '10.00', '9.00', 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=500', 1, 1, 0, 1, 11685, 740, '2026-04-12 12:07:56', '2026-05-17 12:07:56'),
(3, 1, 'Kaos Polo Pria Kasual', 'kaos-polo-pria-kasual-3', 'BY-00003', 'Kaos Polo merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. D...', '<p><strong>Kaos Polo</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Semi-formal nyaman dipakai</p><p><strong>Spesifikasi & Fitur:</strong><br>Pique Cotton 220gsm, kerah 2 kancing, S-XXL</p><p><strong>Tips Penggunaan:</strong><br>Cuci terbalik untuk menjaga warna</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '129000.00', NULL, 300, '220.00', '26.00', '8.00', '20.00', 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?w=500', 1, 0, 0, 1, 11246, 1176, '2025-12-16 12:07:56', '2026-05-17 12:07:56'),
(4, 1, 'Jaket Bomber Distro', 'jaket-bomber-distro-4', 'BY-00004', 'Jaket Bomber merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari...', '<p><strong>Jaket Bomber</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Tahan angin & air ringan</p><p><strong>Spesifikasi & Fitur:</strong><br>Polyester Taslan outer, fleece inner, YKK zipper</p><p><strong>Tips Penggunaan:</strong><br>Cuci tangan atau dry clean</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '359000.00', '289000.00', 80, '600.00', '39.00', '14.00', '14.00', 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=500', 1, 1, 1, 1, 8324, 798, '2025-12-26 12:07:56', '2026-05-17 12:07:56'),
(5, 1, 'Kemeja Batik Modern', 'kemeja-batik-modern-5', 'BY-00005', 'Kemeja Batik merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari...', '<p><strong>Kemeja Batik</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Formal & semi-kasual</p><p><strong>Spesifikasi & Fitur:</strong><br>Katun prima 140gsm, motif eksklusif, M-XXL</p><p><strong>Tips Penggunaan:</strong><br>Cuci tangan air dingin</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '229000.00', '189000.00', 120, '280.00', '22.00', '9.00', '11.00', 'https://images.unsplash.com/photo-1594938298603-c8148c4b4357?w=500', 1, 0, 1, 1, 3802, 965, '2026-01-27 12:07:56', '2026-05-17 12:07:56'),
(6, 1, 'Celana Jogger Premium', 'celana-jogger-premium-6', 'BY-00006', 'Celana Jogger merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-har...', '<p><strong>Celana Jogger</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Nyaman olahraga & santai</p><p><strong>Spesifikasi & Fitur:</strong><br>Fleece cotton 280gsm, pinggang elastis</p><p><strong>Tips Penggunaan:</strong><br>Balik saat mencuci</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '199000.00', '159000.00', 200, '350.00', '33.00', '7.00', '11.00', 'https://images.unsplash.com/photo-1552902865-b72c031ac5ea?w=500', 1, 0, 0, 1, 3854, 1145, '2026-04-12 12:07:56', '2026-05-17 12:07:56'),
(7, 1, 'T-Shirt Grafis Oversize', 't-shirt-grafis-oversize-7', 'BY-00007', 'T-Shirt Oversize merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-...', '<p><strong>T-Shirt Oversize</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Streetwear premium trendy</p><p><strong>Spesifikasi & Fitur:</strong><br>Cotton Combed 30s, sablon DTF, M-3XL</p><p><strong>Tips Penggunaan:</strong><br>Cuci terbalik, hindari sinar matahari</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '159000.00', NULL, 250, '220.00', '39.00', '13.00', '1.00', 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500', 1, 1, 0, 1, 4301, 368, '2026-02-02 12:07:56', '2026-05-17 12:07:56'),
(8, 1, 'Sweater Knit Pria', 'sweater-knit-pria-8', 'BY-00008', 'Sweater Rajut merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-har...', '<p><strong>Sweater Rajut</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Hangat untuk AC & dingin</p><p><strong>Spesifikasi & Fitur:</strong><br>Acrylic wool blend, crew neck, S-XL</p><p><strong>Tips Penggunaan:</strong><br>Cuci tangan air dingin</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '279000.00', '229000.00', 100, '480.00', '17.00', '19.00', '4.00', 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=500', 1, 0, 1, 1, 5537, 25, '2026-01-14 12:07:56', '2026-05-17 12:07:56'),
(9, 1, 'Celana Jeans Slim', 'celana-jeans-slim-9', 'BY-00009', 'Jeans Slim merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. ...', '<p><strong>Jeans Slim</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Denim berkualitas, elegan</p><p><strong>Spesifikasi & Fitur:</strong><br>Denim stretch 12oz, 5 kantong, 28-36</p><p><strong>Tips Penggunaan:</strong><br>Cuci terbalik air dingin</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '319000.00', '269000.00', 130, '700.00', '20.00', '13.00', '10.00', 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=500', 1, 1, 0, 1, 9349, 446, '2026-05-16 12:07:56', '2026-05-17 12:07:56'),
(10, 1, 'Kemeja Oxford Formal', 'kemeja-oxford-formal-10', 'BY-00010', 'Kemeja Oxford merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-har...', '<p><strong>Kemeja Oxford</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Profesional sepanjang hari</p><p><strong>Spesifikasi & Fitur:</strong><br>Oxford Cotton 100%, button-down, putih/biru/abu</p><p><strong>Tips Penggunaan:</strong><br>Setrika saat lembab</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '289000.00', NULL, 90, '280.00', '27.00', '13.00', '15.00', 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=500', 1, 0, 0, 1, 5838, 937, '2025-12-02 12:07:56', '2026-05-17 12:07:56'),
(11, 2, 'Dress Midi Floral', 'dress-midi-floral-11', 'BY-00011', 'Dress Midi Floral merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari...', '<p><strong>Dress Midi Floral</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Elegan untuk berbagai acara</p><p><strong>Spesifikasi & Fitur:</strong><br>Chiffon premium, ritsleting tersembunyi, XS-XL</p><p><strong>Tips Penggunaan:</strong><br>Cuci tangan lembut</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '279000.00', '219000.00', 200, '350.00', '26.00', '28.00', '4.00', 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=500', 1, 1, 1, 1, 11236, 239, '2026-02-26 12:07:56', '2026-05-17 12:07:56'),
(12, 2, 'Blouse Wanita Elegan', 'blouse-wanita-elegan-12', 'BY-00012', 'Blouse Satin merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari...', '<p><strong>Blouse Satin</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Kesan mewah terjangkau</p><p><strong>Spesifikasi & Fitur:</strong><br>Satin polyester, V-neck, lengan balloon</p><p><strong>Tips Penggunaan:</strong><br>Cuci tangan air dingin</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '189000.00', NULL, 250, '280.00', '19.00', '16.00', '18.00', 'https://images.unsplash.com/photo-1564257631407-4deb1f99d992?w=500', 1, 0, 0, 1, 9887, 938, '2026-02-07 12:07:56', '2026-05-17 12:07:56'),
(13, 2, 'Rok Plisket Trendy', 'rok-plisket-trendy-13', 'BY-00013', 'Rok Plisket merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari....', '<p><strong>Rok Plisket</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Feminin & nyaman</p><p><strong>Spesifikasi & Fitur:</strong><br>Chiffon ringan, pinggang elastis, mini/midi</p><p><strong>Tips Penggunaan:</strong><br>Jangan diperas</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '159000.00', '129000.00', 180, '250.00', '22.00', '10.00', '18.00', 'https://images.unsplash.com/photo-1583496661160-fb5218a9bfe4?w=500', 1, 1, 0, 1, 3477, 197, '2025-12-08 12:07:56', '2026-05-17 12:07:56'),
(14, 2, 'Cardigan Rajut Oversize', 'cardigan-rajut-oversize-14', 'BY-00014', 'Cardigan Oversize merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari...', '<p><strong>Cardigan Oversize</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Hangat & trendy</p><p><strong>Spesifikasi & Fitur:</strong><br>Acrylic knit, 2 kantong, S-XL</p><p><strong>Tips Penggunaan:</strong><br>Keringkan rata, jangan digantung</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '299000.00', '239000.00', 150, '420.00', '31.00', '11.00', '9.00', 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=500', 1, 1, 1, 1, 7865, 81, '2026-03-14 12:07:56', '2026-05-17 12:07:56'),
(15, 2, 'Jumpsuit Casual Wanita', 'jumpsuit-casual-wanita-15', 'BY-00015', 'Jumpsuit Linen merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-ha...', '<p><strong>Jumpsuit Linen</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>One-piece stylish</p><p><strong>Spesifikasi & Fitur:</strong><br>Linen blend, wide-leg, sabuk cantik</p><p><strong>Tips Penggunaan:</strong><br>Setrika saat agak lembab</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '319000.00', '259000.00', 100, '380.00', '36.00', '20.00', '6.00', 'https://images.unsplash.com/photo-1551803091-e20673f15770?w=500', 1, 1, 1, 1, 5149, 444, '2025-12-26 12:07:56', '2026-05-17 12:07:56'),
(16, 2, 'Tunik Batik Wanita', 'tunik-batik-wanita-16', 'BY-00016', 'Tunik Batik merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari....', '<p><strong>Tunik Batik</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Motif eksklusif Indonesia</p><p><strong>Spesifikasi & Fitur:</strong><br>Katun prima, panjang ±85cm, M-3XL</p><p><strong>Tips Penggunaan:</strong><br>Cuci tangan, keringkan teduh</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '199000.00', '169000.00', 200, '300.00', '35.00', '20.00', '14.00', 'https://images.unsplash.com/photo-1585487000160-6ebcfceb0d03?w=500', 1, 0, 0, 1, 10405, 165, '2026-04-24 12:07:56', '2026-05-17 12:07:56'),
(17, 2, 'Celana Kulot Wanita', 'celana-kulot-wanita-17', 'BY-00017', 'Kulot High-Waist merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-...', '<p><strong>Kulot High-Waist</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Kaki terlihat jenjang</p><p><strong>Spesifikasi & Fitur:</strong><br>Linen blend, high-waist, XS-XL</p><p><strong>Tips Penggunaan:</strong><br>Cuci gentle mode</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '219000.00', NULL, 180, '320.00', '33.00', '9.00', '15.00', 'https://images.unsplash.com/photo-1594938298603-c8148c4b4357?w=500', 1, 0, 1, 1, 3555, 273, '2026-04-11 12:07:56', '2026-05-17 12:07:56'),
(18, 2, 'Dress Wrap Flowy', 'dress-wrap-flowy-18', 'BY-00018', 'Dress Wrap merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. ...', '<p><strong>Dress Wrap</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Flattering semua bentuk tubuh</p><p><strong>Spesifikasi & Fitur:</strong><br>Viscose rayon, V-neck, panjang ±105cm</p><p><strong>Tips Penggunaan:</strong><br>Angin-anginkan segera</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '259000.00', '209000.00', 120, '320.00', '24.00', '20.00', '15.00', 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=500', 1, 0, 1, 1, 4043, 900, '2026-04-26 12:07:56', '2026-05-17 12:07:56'),
(19, 3, 'TWS Earbuds Bluetooth', 'tws-earbuds-bluetooth-19', 'BY-00019', 'TWS Earbuds BT 5.3 merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehar...', '<p><strong>TWS Earbuds BT 5.3</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Bass kaya, ANC premium</p><p><strong>Spesifikasi & Fitur:</strong><br>BT 5.3, driver 13mm, ANC 30dB, IPX5</p><p><strong>Tips Penggunaan:</strong><br>Charge di case saat tidak digunakan</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '189000.00', '159000.00', 50, '120.00', '14.00', '27.00', '17.00', 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=500', 1, 1, 1, 1, 8564, 696, '2026-04-21 12:07:56', '2026-05-17 12:07:56'),
(20, 3, 'Power Bank 20000mAh', 'power-bank-20000mah-20', 'BY-00020', 'Power Bank 20000mAh merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna seha...', '<p><strong>Power Bank 20000mAh</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Isi daya smartphone 5x</p><p><strong>Spesifikasi & Fitur:</strong><br>22.5W fast charge, 3 port, 11 proteksi</p><p><strong>Tips Penggunaan:</strong><br>Charge sebelum penyimpanan lama</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '279000.00', NULL, 100, '380.00', '17.00', '24.00', '17.00', 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=500', 1, 0, 0, 1, 2728, 757, '2026-02-25 12:07:56', '2026-05-17 12:07:56'),
(21, 3, 'Smartwatch Fitness Pro', 'smartwatch-fitness-pro-21', 'BY-00021', 'Smartwatch AMOLED merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari...', '<p><strong>Smartwatch AMOLED</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Monitor kesehatan 24 jam</p><p><strong>Spesifikasi & Fitur:</strong><br>1.78\" AMOLED, GPS, SpO2, 5ATM, 7-14 hari</p><p><strong>Tips Penggunaan:</strong><br>Update firmware berkala</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '459000.00', '389000.00', 75, '180.00', '26.00', '7.00', '1.00', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500', 1, 1, 1, 0, 6799, 1016, '2026-01-28 12:07:56', '2026-05-17 12:07:56'),
(22, 3, 'Laptop Stand Aluminium', 'laptop-stand-aluminium-22', 'BY-00022', 'Laptop Stand merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari...', '<p><strong>Laptop Stand</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Ergonomis, postur lebih baik</p><p><strong>Spesifikasi & Fitur:</strong><br>Aluminium 6061, 15°-45°, 10-17\", foldable</p><p><strong>Tips Penggunaan:</strong><br>Bersihkan dengan kain microfiber</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '159000.00', '129000.00', 150, '650.00', '39.00', '19.00', '14.00', 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500', 1, 0, 1, 0, 2164, 715, '2025-12-22 12:07:56', '2026-05-17 12:07:56'),
(23, 3, 'Wireless Mouse Silent', 'wireless-mouse-silent-23', 'BY-00023', 'Mouse Wireless merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-ha...', '<p><strong>Mouse Wireless</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Silent click, anti lelah</p><p><strong>Spesifikasi & Fitur:</strong><br>2.4GHz, 800-1600 DPI, 5 tombol, 12 bulan baterai</p><p><strong>Tips Penggunaan:</strong><br>Bersihkan sensor berkala</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '149000.00', NULL, 200, '120.00', '10.00', '25.00', '15.00', 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500', 1, 0, 0, 0, 5158, 194, '2025-11-28 12:07:56', '2026-05-17 12:07:56'),
(24, 3, 'Speaker Bluetooth 360°', 'speaker-bluetooth-360-24', 'BY-00024', 'Speaker BT Portable merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna seha...', '<p><strong>Speaker BT Portable</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Suara 360°, IPX7</p><p><strong>Spesifikasi & Fitur:</strong><br>20W, BT 5.0, IPX7, 12 jam, TWS mode</p><p><strong>Tips Penggunaan:</strong><br>Bilas air tawar setelah kena air laut</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '289000.00', '249000.00', 60, '400.00', '12.00', '26.00', '3.00', 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500', 1, 1, 0, 0, 10336, 265, '2025-12-07 12:07:56', '2026-05-17 12:07:56'),
(25, 3, 'Charger GaN 65W', 'charger-gan-65w-25', 'BY-00025', 'Charger GaN 65W merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-h...', '<p><strong>Charger GaN 65W</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Efisien, compact</p><p><strong>Spesifikasi & Fitur:</strong><br>GaN, 65W total, 2x USB-C + 1x USB-A, PD 3.0</p><p><strong>Tips Penggunaan:</strong><br>Pastikan ventilasi cukup</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '199000.00', '169000.00', 120, '150.00', '27.00', '13.00', '7.00', 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=500', 1, 0, 1, 0, 6946, 88, '2026-01-09 12:07:56', '2026-05-17 12:07:56'),
(26, 3, 'Ring Light LED 10\"', 'ring-light-led-10-26', 'BY-00026', 'Ring Light LED merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-ha...', '<p><strong>Ring Light LED</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Perfect untuk konten</p><p><strong>Spesifikasi & Fitur:</strong><br>10\", 120 LED, 3 mode warna, 10 level kecerahan</p><p><strong>Tips Penggunaan:</strong><br>Jangan sentuh LED langsung</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '179000.00', '149000.00', 90, '600.00', '13.00', '9.00', '11.00', 'https://images.unsplash.com/photo-1587826080692-f439cd0b70da?w=500', 1, 0, 1, 0, 6453, 534, '2026-02-07 12:07:56', '2026-05-17 12:07:56'),
(27, 4, 'Blender Portable Mini', 'blender-portable-mini-27', 'BY-00027', 'Blender Portable merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-...', '<p><strong>Blender Portable</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Buat smoothie di mana saja</p><p><strong>Spesifikasi & Fitur:</strong><br>25000RPM, 4000mAh USB-C, 400ml BPA-free</p><p><strong>Tips Penggunaan:</strong><br>Cuci setelah setiap pakai</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '229000.00', '189000.00', 80, '480.00', '32.00', '19.00', '14.00', 'https://images.unsplash.com/photo-1570222094114-d054a817e56b?w=500', 1, 1, 0, 0, 10742, 908, '2026-02-20 12:07:56', '2026-05-17 12:07:56'),
(28, 4, 'Bantal Memory Foam', 'bantal-memory-foam-28', 'BY-00028', 'Bantal Memory Foam merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehar...', '<p><strong>Bantal Memory Foam</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Tidur lebih nyenyak</p><p><strong>Spesifikasi & Fitur:</strong><br>60D premium, cover bamboo, anti-bakteri, 60x40cm</p><p><strong>Tips Penggunaan:</strong><br>Angin-anginkan tiap 2-4 minggu</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '259000.00', '209000.00', 100, '550.00', '10.00', '22.00', '5.00', 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500', 1, 1, 1, 0, 2806, 880, '2025-12-23 12:07:56', '2026-05-17 12:07:56'),
(29, 4, 'Rice Cooker Digital 1.8L', 'rice-cooker-digital-18l-29', 'BY-00029', 'Rice Cooker Digital merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna seha...', '<p><strong>Rice Cooker Digital</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>8 mode memasak</p><p><strong>Spesifikasi & Fitur:</strong><br>1.8L, Teflon triple-layer, timer, keep warm 24j</p><p><strong>Tips Penggunaan:</strong><br>Bersihkan setelah tiap pakai</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '399000.00', '349000.00', 60, '1200.00', '11.00', '7.00', '12.00', 'https://images.unsplash.com/photo-1585515320310-259814833e62?w=500', 1, 0, 1, 0, 889, 1182, '2026-04-16 12:07:56', '2026-05-17 12:07:56'),
(30, 4, 'Vacuum Cleaner Cordless', 'vacuum-cleaner-cordless-30', 'BY-00030', 'Vacuum Cordless 2-in-1 merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna s...', '<p><strong>Vacuum Cordless 2-in-1</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Bersih tanpa kabel</p><p><strong>Spesifikasi & Fitur:</strong><br>21kPa, 35 menit, HEPA washable, 1.2kg</p><p><strong>Tips Penggunaan:</strong><br>Kosongkan penampung setelah pakai</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '279000.00', '229000.00', 70, '750.00', '34.00', '24.00', '15.00', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500', 1, 0, 0, 0, 6857, 90, '2026-02-13 12:07:56', '2026-05-17 12:07:56'),
(31, 5, 'Sepatu Running Pro', 'sepatu-running-pro-31', 'BY-00031', 'Sepatu Running merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-ha...', '<p><strong>Sepatu Running</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Anti-slip semua medan</p><p><strong>Spesifikasi & Fitur:</strong><br>Engineered mesh, EVA+TPU, reflective, 37-46</p><p><strong>Tips Penggunaan:</strong><br>Keringkan alami, hindari matahari</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '399000.00', '319000.00', 100, '700.00', '24.00', '29.00', '2.00', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500', 1, 1, 1, 0, 6418, 525, '2026-01-18 12:07:56', '2026-05-17 12:07:56'),
(32, 5, 'Matras Yoga 6mm', 'matras-yoga-6mm-32', 'BY-00032', 'Matras Yoga TPE merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-h...', '<p><strong>Matras Yoga TPE</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Eco-friendly, grip sempurna</p><p><strong>Spesifikasi & Fitur:</strong><br>TPE, 183x61cm, double non-slip, 1kg, strap</p><p><strong>Tips Penggunaan:</strong><br>Lap setelah tiap pakai</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '199000.00', NULL, 120, '850.00', '35.00', '12.00', '9.00', 'https://images.unsplash.com/photo-1601925228058-d4b32b22dd3f?w=500', 1, 0, 0, 0, 6179, 428, '2026-01-29 12:07:56', '2026-05-17 12:07:56'),
(33, 5, 'Dumbbell Set 10kg', 'dumbbell-set-10kg-33', 'BY-00033', 'Dumbbell Adjustable merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna seha...', '<p><strong>Dumbbell Adjustable</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>5 level dalam 1 set</p><p><strong>Spesifikasi & Fitur:</strong><br>2-10kg, besi cor + karet, pin selector</p><p><strong>Tips Penggunaan:</strong><br>Simpan di tray, jangan dijatuhkan</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '549000.00', '469000.00', 30, '10500.00', '12.00', '27.00', '1.00', 'https://images.unsplash.com/photo-1590487988256-9ed24133863e?w=500', 1, 1, 0, 0, 7812, 495, '2026-03-25 12:07:56', '2026-05-17 12:07:56'),
(34, 5, 'Resistance Band Set', 'resistance-band-set-34', 'BY-00034', 'Resistance Band 5 Level merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna ...', '<p><strong>Resistance Band 5 Level</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Progresif & lengkap</p><p><strong>Spesifikasi & Fitur:</strong><br>5 band 5-40kg, latex natural, door anchor dll</p><p><strong>Tips Penggunaan:</strong><br>Inspeksi sebelum pakai</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '159000.00', '129000.00', 200, '300.00', '38.00', '12.00', '19.00', 'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=500', 1, 0, 1, 0, 6293, 303, '2026-03-19 12:07:56', '2026-05-17 12:07:56'),
(35, 6, 'Serum Vitamin C 20%', 'serum-vitamin-c-20-35', 'BY-00035', 'Serum Vitamin C merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-h...', '<p><strong>Serum Vitamin C</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Cerahkan & anti-aging</p><p><strong>Spesifikasi & Fitur:</strong><br>20% L-AA, HA 2%, Niacinamide 5%, pH 3.0-3.5</p><p><strong>Tips Penggunaan:</strong><br>Pakai pagi + sunscreen</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '129000.00', '99000.00', 300, '50.00', '20.00', '11.00', '14.00', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500', 1, 1, 1, 0, 6687, 381, '2025-12-30 12:07:56', '2026-05-17 12:07:56'),
(36, 6, 'Sunscreen SPF50+ 50ml', 'sunscreen-spf50-50ml-36', 'BY-00036', 'Sunscreen PA++++ merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-...', '<p><strong>Sunscreen PA++++</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Perlindungan maksimal tanpa white cast</p><p><strong>Spesifikasi & Fitur:</strong><br>SPF50+ PA++++, lightweight, water-resistant 80min</p><p><strong>Tips Penggunaan:</strong><br>Reapply tiap 2 jam di luar</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '89000.00', '69000.00', 400, '80.00', '33.00', '23.00', '19.00', 'https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?w=500', 1, 0, 1, 0, 9504, 612, '2026-03-17 12:07:56', '2026-05-17 12:07:56'),
(37, 6, 'Toner Niacinamide 10%', 'toner-niacinamide-10-37', 'BY-00037', 'Toner Niacinamide merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari...', '<p><strong>Toner Niacinamide</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Pori kecil, kontrol minyak</p><p><strong>Spesifikasi & Fitur:</strong><br>Niacinamide 10%, Zinc PCA, HA, alcohol-free, 200ml</p><p><strong>Tips Penggunaan:</strong><br>Pagi & malam setelah cleansing</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '119000.00', '89000.00', 250, '150.00', '38.00', '30.00', '8.00', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500', 1, 0, 0, 0, 7430, 723, '2026-01-16 12:07:56', '2026-05-17 12:07:56'),
(38, 6, 'Body Lotion Whitening', 'body-lotion-whitening-38', 'BY-00038', 'Body Lotion Glutathione merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna ...', '<p><strong>Body Lotion Glutathione</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Cerahkan kulit tubuh</p><p><strong>Spesifikasi & Fitur:</strong><br>Glutathione 1000mg, Vit C+E, SPF15, 250ml</p><p><strong>Tips Penggunaan:</strong><br>Pakai segera setelah mandi</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '99000.00', '79000.00', 500, '300.00', '31.00', '21.00', '10.00', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500', 1, 1, 1, 0, 9948, 997, '2026-04-11 12:07:56', '2026-05-17 12:07:56'),
(39, 7, 'Sneakers Casual Canvas', 'sneakers-casual-canvas-39', 'BY-00039', 'Sneakers Casual merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-h...', '<p><strong>Sneakers Casual</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Versatile, cocok semua outfit</p><p><strong>Spesifikasi & Fitur:</strong><br>Canvas cotton, sol vulkanized, memory foam, 36-45</p><p><strong>Tips Penggunaan:</strong><br>Bersihkan dengan sikat lembut</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '329000.00', '259000.00', 150, '750.00', '33.00', '24.00', '14.00', 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?w=500', 1, 1, 1, 0, 4653, 576, '2026-04-24 12:07:56', '2026-05-17 12:07:56'),
(40, 7, 'Tas Ransel Laptop 35L', 'tas-ransel-laptop-35l-40', 'BY-00040', 'Ransel Anti Air 35L merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna seha...', '<p><strong>Ransel Anti Air 35L</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Organizer lengkap</p><p><strong>Spesifikasi & Fitur:</strong><br>900D polyester, kompartemen laptop 15.6\", USB port</p><p><strong>Tips Penggunaan:</strong><br>Bersihkan dengan kain lembab</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '389000.00', NULL, 120, '900.00', '19.00', '9.00', '1.00', 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500', 1, 0, 0, 0, 6668, 830, '2026-03-27 12:07:56', '2026-05-17 12:07:56'),
(41, 7, 'Dompet Kulit RFID', 'dompet-kulit-rfid-41', 'BY-00041', 'Dompet Slim RFID merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-...', '<p><strong>Dompet Slim RFID</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Data kartu aman dari skimming</p><p><strong>Spesifikasi & Fitur:</strong><br>Genuine leather, RFID block, 12 slot, 1.2cm</p><p><strong>Tips Penggunaan:</strong><br>Kondisioner kulit tiap 3-6 bulan</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '229000.00', '189000.00', 150, '150.00', '20.00', '15.00', '11.00', 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=500', 1, 0, 0, 0, 7683, 1127, '2026-04-08 12:07:56', '2026-05-17 12:07:56'),
(42, 7, 'Sepatu Boots Pria', 'sepatu-boots-pria-42', 'BY-00042', 'Boots Leather Goodyear merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna s...', '<p><strong>Boots Leather Goodyear</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Semakin indah seiring waktu</p><p><strong>Spesifikasi & Fitur:</strong><br>Genuine leather, Goodyear welt, side zipper, 39-45</p><p><strong>Tips Penggunaan:</strong><br>Cedar shoe tree & wax rutin</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '489000.00', '399000.00', 60, '1100.00', '17.00', '10.00', '13.00', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500', 1, 1, 1, 0, 322, 1000, '2026-01-23 12:07:56', '2026-05-17 12:07:56'),
(43, 8, 'Lego Building Blocks 1000pcs', 'lego-building-blocks-1000pcs-43', 'BY-00043', 'Lego 1000pcs merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari...', '<p><strong>Lego 1000pcs</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Latih kreativitas anak</p><p><strong>Spesifikasi & Fitur:</strong><br>ABS food-grade, 30+ warna, kompatibel lego standar</p><p><strong>Tips Penggunaan:</strong><br>Cuci air sabun, keringkan sempurna</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '189000.00', '159000.00', 80, '400.00', '35.00', '16.00', '11.00', 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=500', 1, 1, 1, 0, 1707, 836, '2026-01-01 12:07:56', '2026-05-17 12:07:56'),
(44, 8, 'RC Car Off-Road 4WD', 'rc-car-off-road-4wd-44', 'BY-00044', 'RC Car 4WD merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. ...', '<p><strong>RC Car 4WD</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Seru semua medan</p><p><strong>Spesifikasi & Fitur:</strong><br>25km/h, 4WD, jangkauan 80m, 30-40 menit</p><p><strong>Tips Penggunaan:</strong><br>Bersihkan dari tanah setelah pakai</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '299000.00', '249000.00', 60, '800.00', '28.00', '5.00', '6.00', 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=500', 1, 0, 1, 0, 2295, 837, '2026-04-22 12:07:56', '2026-05-17 12:07:56'),
(45, 8, 'Drone Mini Selfie 1080p', 'drone-mini-selfie-1080p-45', 'BY-00045', 'Drone Mini Selfie merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari...', '<p><strong>Drone Mini Selfie</strong> merupakan produk pilihan terbaik yang dirancang dengan mempertimbangkan kenyamanan dan kebutuhan pengguna sehari-hari. Dibuat menggunakan bahan premium berkualitas tinggi yang telah melewati serangkaian uji kualitas ketat sebelum sampai ke tangan Anda. Setiap detail dikerjakan dengan presisi tinggi.</p><p><strong>Manfaat & Keunggulan:</strong><br>Foto udara mudah & seru</p><p><strong>Spesifikasi & Fitur:</strong><br>1080p EIS, obstacle avoidance, 20-25 menit, 100m</p><p><strong>Tips Penggunaan:</strong><br>Kalibrasi kompas sebelum terbang</p><p>Produk ini telah dipercaya ribuan pelanggan setia kami. Garansi kepuasan 100%!</p>', '599000.00', '499000.00', 30, '350.00', '33.00', '29.00', '4.00', 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=500', 1, 1, 1, 0, 9273, 945, '2026-04-07 12:07:56', '2026-05-17 12:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT 5,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `product_id`, `user_id`, `order_id`, `rating`, `comment`, `image`, `images`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 1, 5, NULL, 4, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-04-06 12:07:56', '2026-05-17 12:07:56'),
(2, 1, 8, NULL, 4, 'Pengiriman cepat, produk original!', NULL, NULL, 1, '2026-04-29 12:07:56', '2026-05-17 12:07:56'),
(3, 1, 5, NULL, 4, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-05-09 12:07:56', '2026-05-17 12:07:56'),
(4, 2, 9, NULL, 4, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-02-17 12:07:56', '2026-05-17 12:07:56'),
(5, 2, 2, NULL, 4, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-03-13 12:07:56', '2026-05-17 12:07:56'),
(6, 2, 7, NULL, 5, 'Pengiriman cepat, produk original!', NULL, NULL, 1, '2026-03-29 12:07:56', '2026-05-17 12:07:56'),
(7, 3, 6, NULL, 5, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-02-18 12:07:56', '2026-05-17 12:07:56'),
(8, 3, 2, NULL, 5, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-05-11 12:07:56', '2026-05-17 12:07:56'),
(9, 3, 8, NULL, 5, 'Sangat puas! Bahan bagus, jahitan rapi.', NULL, NULL, 1, '2026-04-14 12:07:56', '2026-05-17 12:07:56'),
(10, 3, 5, NULL, 5, 'Packaging rapi dan aman, produk sempurna.', NULL, NULL, 1, '2026-05-11 12:07:56', '2026-05-17 12:07:56'),
(11, 4, 7, NULL, 4, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-03-20 12:07:56', '2026-05-17 12:07:56'),
(12, 4, 7, NULL, 5, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-05-12 12:07:56', '2026-05-17 12:07:56'),
(13, 5, 4, NULL, 4, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-04-02 12:07:56', '2026-05-17 12:07:56'),
(14, 5, 8, NULL, 4, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-04-01 12:07:56', '2026-05-17 12:07:56'),
(15, 5, 6, NULL, 5, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-04-09 12:07:56', '2026-05-17 12:07:56'),
(16, 6, 6, NULL, 4, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-04-16 12:07:56', '2026-05-17 12:07:56'),
(17, 6, 2, NULL, 4, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-04-24 12:07:56', '2026-05-17 12:07:56'),
(18, 6, 8, NULL, 5, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-03-15 12:07:56', '2026-05-17 12:07:56'),
(19, 6, 7, NULL, 5, 'Pengiriman cepat, produk original!', NULL, NULL, 1, '2026-03-16 12:07:56', '2026-05-17 12:07:56'),
(20, 6, 9, NULL, 5, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-04-06 12:07:56', '2026-05-17 12:07:56'),
(21, 7, 6, NULL, 4, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-04-13 12:07:56', '2026-05-17 12:07:56'),
(22, 7, 8, NULL, 4, 'Sudah dipakai beberapa kali masih bagus.', NULL, NULL, 1, '2026-03-10 12:07:56', '2026-05-17 12:07:56'),
(23, 7, 7, NULL, 4, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-04-18 12:07:56', '2026-05-17 12:07:56'),
(24, 7, 3, NULL, 5, 'Packaging rapi dan aman, produk sempurna.', NULL, NULL, 1, '2026-04-29 12:07:56', '2026-05-17 12:07:56'),
(25, 7, 8, NULL, 4, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-04-21 12:07:56', '2026-05-17 12:07:56'),
(26, 8, 2, NULL, 5, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-03-19 12:07:56', '2026-05-17 12:07:56'),
(27, 8, 2, NULL, 5, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-05-02 12:07:56', '2026-05-17 12:07:56'),
(28, 8, 7, NULL, 4, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-04-02 12:07:56', '2026-05-17 12:07:56'),
(29, 9, 7, NULL, 5, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-02-25 12:07:56', '2026-05-17 12:07:56'),
(30, 9, 2, NULL, 5, 'Packaging rapi dan aman, produk sempurna.', NULL, NULL, 1, '2026-04-21 12:07:56', '2026-05-17 12:07:56'),
(31, 9, 4, NULL, 4, 'Pengiriman cepat, produk original!', NULL, NULL, 1, '2026-03-27 12:07:56', '2026-05-17 12:07:56'),
(32, 10, 7, NULL, 5, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-04-15 12:07:56', '2026-05-17 12:07:56'),
(33, 10, 7, NULL, 5, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-02-28 12:07:56', '2026-05-17 12:07:56'),
(34, 10, 6, NULL, 5, 'Sudah dipakai beberapa kali masih bagus.', NULL, NULL, 1, '2026-03-11 12:07:56', '2026-05-17 12:07:56'),
(35, 10, 3, NULL, 4, 'Desain bagus, kualitas jahitan rapi. Puas!', NULL, NULL, 1, '2026-05-04 12:07:56', '2026-05-17 12:07:56'),
(36, 10, 7, NULL, 4, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-05-09 12:07:56', '2026-05-17 12:07:56'),
(37, 11, 4, NULL, 4, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-05-10 12:07:56', '2026-05-17 12:07:56'),
(38, 11, 5, NULL, 5, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-04-19 12:07:56', '2026-05-17 12:07:56'),
(39, 11, 2, NULL, 4, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-02-16 12:07:56', '2026-05-17 12:07:56'),
(40, 11, 8, NULL, 4, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-04-12 12:07:56', '2026-05-17 12:07:56'),
(41, 12, 8, NULL, 5, 'Packaging rapi dan aman, produk sempurna.', NULL, NULL, 1, '2026-02-20 12:07:56', '2026-05-17 12:07:56'),
(42, 12, 6, NULL, 4, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-02-21 12:07:56', '2026-05-17 12:07:56'),
(43, 12, 8, NULL, 5, 'Sangat puas! Bahan bagus, jahitan rapi.', NULL, NULL, 1, '2026-05-01 12:07:56', '2026-05-17 12:07:56'),
(44, 12, 3, NULL, 4, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-03-13 12:07:56', '2026-05-17 12:07:56'),
(45, 12, 2, NULL, 5, 'Packaging rapi dan aman, produk sempurna.', NULL, NULL, 1, '2026-03-31 12:07:56', '2026-05-17 12:07:56'),
(46, 13, 7, NULL, 4, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-05-14 12:07:56', '2026-05-17 12:07:56'),
(47, 13, 8, NULL, 4, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-04-07 12:07:56', '2026-05-17 12:07:56'),
(48, 14, 8, NULL, 5, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-05-06 12:07:56', '2026-05-17 12:07:56'),
(49, 14, 2, NULL, 5, 'Sangat puas! Bahan bagus, jahitan rapi.', NULL, NULL, 1, '2026-04-13 12:07:56', '2026-05-17 12:07:56'),
(50, 14, 8, NULL, 5, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-03-31 12:07:56', '2026-05-17 12:07:56'),
(51, 14, 6, NULL, 5, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-02-26 12:07:56', '2026-05-17 12:07:56'),
(52, 14, 4, NULL, 4, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-05-10 12:07:56', '2026-05-17 12:07:56'),
(53, 15, 9, NULL, 5, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-05-02 12:07:56', '2026-05-17 12:07:56'),
(54, 15, 7, NULL, 5, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-03-01 12:07:56', '2026-05-17 12:07:56'),
(55, 15, 5, NULL, 4, 'Sudah dipakai beberapa kali masih bagus.', NULL, NULL, 1, '2026-05-07 12:07:56', '2026-05-17 12:07:56'),
(56, 15, 2, NULL, 5, 'Sangat puas! Bahan bagus, jahitan rapi.', NULL, NULL, 1, '2026-04-08 12:07:56', '2026-05-17 12:07:56'),
(57, 15, 6, NULL, 4, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-04-27 12:07:56', '2026-05-17 12:07:56'),
(58, 16, 9, NULL, 4, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-03-19 12:07:56', '2026-05-17 12:07:56'),
(59, 16, 4, NULL, 5, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-04-21 12:07:56', '2026-05-17 12:07:56'),
(60, 17, 8, NULL, 5, 'Pengiriman cepat, produk original!', NULL, NULL, 1, '2026-03-01 12:07:56', '2026-05-17 12:07:56'),
(61, 17, 4, NULL, 5, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-05-12 12:07:56', '2026-05-17 12:07:56'),
(62, 17, 5, NULL, 5, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-03-15 12:07:56', '2026-05-17 12:07:56'),
(63, 17, 4, NULL, 5, 'Sudah dipakai beberapa kali masih bagus.', NULL, NULL, 1, '2026-03-18 12:07:56', '2026-05-17 12:07:56'),
(64, 17, 6, NULL, 5, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-05-06 12:07:56', '2026-05-17 12:07:56'),
(65, 18, 2, NULL, 4, 'Sudah dipakai beberapa kali masih bagus.', NULL, NULL, 1, '2026-02-21 12:07:56', '2026-05-17 12:07:56'),
(66, 18, 7, NULL, 4, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-05-15 12:07:56', '2026-05-17 12:07:56'),
(67, 18, 9, NULL, 4, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-04-11 12:07:56', '2026-05-17 12:07:56'),
(68, 18, 9, NULL, 5, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-04-29 12:07:56', '2026-05-17 12:07:56'),
(69, 19, 7, NULL, 4, 'Desain bagus, kualitas jahitan rapi. Puas!', NULL, NULL, 1, '2026-04-08 12:07:56', '2026-05-17 12:07:56'),
(70, 19, 9, NULL, 5, 'Sangat puas! Bahan bagus, jahitan rapi.', NULL, NULL, 1, '2026-03-21 12:07:56', '2026-05-17 12:07:56'),
(71, 19, 8, NULL, 5, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-02-21 12:07:56', '2026-05-17 12:07:56'),
(72, 20, 6, NULL, 4, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-03-27 12:07:56', '2026-05-17 12:07:56'),
(73, 20, 8, NULL, 4, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-03-16 12:07:56', '2026-05-17 12:07:56'),
(74, 21, 4, NULL, 4, 'Desain bagus, kualitas jahitan rapi. Puas!', NULL, NULL, 1, '2026-02-21 12:07:56', '2026-05-17 12:07:56'),
(75, 21, 9, NULL, 5, 'Sangat puas! Bahan bagus, jahitan rapi.', NULL, NULL, 1, '2026-04-23 12:07:56', '2026-05-17 12:07:56'),
(76, 21, 8, NULL, 5, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-03-25 12:07:56', '2026-05-17 12:07:56'),
(77, 21, 6, NULL, 5, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-05-05 12:07:56', '2026-05-17 12:07:56'),
(78, 21, 3, NULL, 4, 'Pengiriman cepat, produk original!', NULL, NULL, 1, '2026-04-06 12:07:56', '2026-05-17 12:07:56'),
(79, 22, 5, NULL, 5, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-02-19 12:07:56', '2026-05-17 12:07:56'),
(80, 22, 4, NULL, 4, 'Packaging rapi dan aman, produk sempurna.', NULL, NULL, 1, '2026-04-10 12:07:56', '2026-05-17 12:07:56'),
(81, 23, 5, NULL, 5, 'Desain bagus, kualitas jahitan rapi. Puas!', NULL, NULL, 1, '2026-04-06 12:07:56', '2026-05-17 12:07:56'),
(82, 23, 2, NULL, 5, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-03-31 12:07:56', '2026-05-17 12:07:56'),
(83, 23, 3, NULL, 5, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-04-01 12:07:56', '2026-05-17 12:07:56'),
(84, 23, 3, NULL, 4, 'Pengiriman cepat, produk original!', NULL, NULL, 1, '2026-02-18 12:07:56', '2026-05-17 12:07:56'),
(85, 24, 3, NULL, 5, 'Desain bagus, kualitas jahitan rapi. Puas!', NULL, NULL, 1, '2026-05-03 12:07:56', '2026-05-17 12:07:56'),
(86, 24, 8, NULL, 4, 'Sudah dipakai beberapa kali masih bagus.', NULL, NULL, 1, '2026-02-24 12:07:56', '2026-05-17 12:07:56'),
(87, 24, 4, NULL, 4, 'Sudah dipakai beberapa kali masih bagus.', NULL, NULL, 1, '2026-03-21 12:07:56', '2026-05-17 12:07:56'),
(88, 24, 5, NULL, 5, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-05-06 12:07:56', '2026-05-17 12:07:56'),
(89, 24, 7, NULL, 5, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-03-22 12:07:56', '2026-05-17 12:07:56'),
(90, 25, 2, NULL, 5, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-05-11 12:07:56', '2026-05-17 12:07:56'),
(91, 25, 5, NULL, 4, 'Packaging rapi dan aman, produk sempurna.', NULL, NULL, 1, '2026-04-23 12:07:56', '2026-05-17 12:07:56'),
(92, 25, 2, NULL, 4, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-03-19 12:07:56', '2026-05-17 12:07:56'),
(93, 25, 7, NULL, 5, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-04-05 12:07:56', '2026-05-17 12:07:56'),
(94, 26, 4, NULL, 4, 'Desain bagus, kualitas jahitan rapi. Puas!', NULL, NULL, 1, '2026-05-01 12:07:56', '2026-05-17 12:07:56'),
(95, 26, 5, NULL, 5, 'Sangat puas! Bahan bagus, jahitan rapi.', NULL, NULL, 1, '2026-05-07 12:07:56', '2026-05-17 12:07:56'),
(96, 26, 5, NULL, 4, 'Sangat puas! Bahan bagus, jahitan rapi.', NULL, NULL, 1, '2026-03-21 12:07:56', '2026-05-17 12:07:56'),
(97, 26, 7, NULL, 4, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-04-09 12:07:56', '2026-05-17 12:07:56'),
(98, 26, 6, NULL, 5, 'Desain bagus, kualitas jahitan rapi. Puas!', NULL, NULL, 1, '2026-03-13 12:07:56', '2026-05-17 12:07:56'),
(99, 27, 6, NULL, 4, 'Desain bagus, kualitas jahitan rapi. Puas!', NULL, NULL, 1, '2026-03-09 12:07:56', '2026-05-17 12:07:56'),
(100, 27, 8, NULL, 5, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-04-02 12:07:56', '2026-05-17 12:07:56'),
(101, 27, 2, NULL, 5, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-02-25 12:07:56', '2026-05-17 12:07:56'),
(102, 27, 8, NULL, 4, 'Packaging rapi dan aman, produk sempurna.', NULL, NULL, 1, '2026-03-03 12:07:56', '2026-05-17 12:07:56'),
(103, 27, 4, NULL, 4, 'Packaging rapi dan aman, produk sempurna.', NULL, NULL, 1, '2026-04-16 12:07:56', '2026-05-17 12:07:56'),
(104, 28, 2, NULL, 5, 'Packaging rapi dan aman, produk sempurna.', NULL, NULL, 1, '2026-05-13 12:07:56', '2026-05-17 12:07:56'),
(105, 28, 6, NULL, 4, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-03-10 12:07:56', '2026-05-17 12:07:56'),
(106, 29, 8, NULL, 4, 'Pengiriman cepat, produk original!', NULL, NULL, 1, '2026-03-05 12:07:56', '2026-05-17 12:07:56'),
(107, 29, 2, NULL, 5, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-03-06 12:07:56', '2026-05-17 12:07:56'),
(108, 29, 9, NULL, 5, 'Desain bagus, kualitas jahitan rapi. Puas!', NULL, NULL, 1, '2026-02-16 12:07:56', '2026-05-17 12:07:56'),
(109, 29, 3, NULL, 5, 'Pengiriman cepat, produk original!', NULL, NULL, 1, '2026-05-06 12:07:56', '2026-05-17 12:07:56'),
(110, 30, 8, NULL, 4, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-05-03 12:07:56', '2026-05-17 12:07:56'),
(111, 30, 2, NULL, 5, 'Packaging rapi dan aman, produk sempurna.', NULL, NULL, 1, '2026-04-26 12:07:56', '2026-05-17 12:07:56'),
(112, 30, 6, NULL, 4, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-03-14 12:07:56', '2026-05-17 12:07:56'),
(113, 31, 8, NULL, 4, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-03-14 12:07:56', '2026-05-17 12:07:56'),
(114, 31, 8, NULL, 4, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-03-03 12:07:56', '2026-05-17 12:07:56'),
(115, 32, 6, NULL, 5, 'Sudah dipakai beberapa kali masih bagus.', NULL, NULL, 1, '2026-03-13 12:07:56', '2026-05-17 12:07:56'),
(116, 32, 6, NULL, 5, 'Packaging rapi dan aman, produk sempurna.', NULL, NULL, 1, '2026-04-12 12:07:56', '2026-05-17 12:07:56'),
(117, 32, 9, NULL, 4, 'Desain bagus, kualitas jahitan rapi. Puas!', NULL, NULL, 1, '2026-03-23 12:07:56', '2026-05-17 12:07:56'),
(118, 32, 6, NULL, 4, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-03-23 12:07:56', '2026-05-17 12:07:56'),
(119, 32, 7, NULL, 5, 'Sangat puas! Bahan bagus, jahitan rapi.', NULL, NULL, 1, '2026-04-29 12:07:56', '2026-05-17 12:07:56'),
(120, 33, 2, NULL, 5, 'Sangat puas! Bahan bagus, jahitan rapi.', NULL, NULL, 1, '2026-03-30 12:07:56', '2026-05-17 12:07:56'),
(121, 33, 3, NULL, 5, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-03-28 12:07:56', '2026-05-17 12:07:56'),
(122, 34, 8, NULL, 5, 'Desain bagus, kualitas jahitan rapi. Puas!', NULL, NULL, 1, '2026-03-21 12:07:56', '2026-05-17 12:07:56'),
(123, 34, 2, NULL, 4, 'Pengiriman cepat, produk original!', NULL, NULL, 1, '2026-03-01 12:07:56', '2026-05-17 12:07:56'),
(124, 34, 5, NULL, 5, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-04-14 12:07:56', '2026-05-17 12:07:56'),
(125, 35, 7, NULL, 5, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-02-18 12:07:56', '2026-05-17 12:07:56'),
(126, 35, 6, NULL, 5, 'Sudah dipakai beberapa kali masih bagus.', NULL, NULL, 1, '2026-03-14 12:07:56', '2026-05-17 12:07:56'),
(127, 36, 3, NULL, 4, 'Sudah dipakai beberapa kali masih bagus.', NULL, NULL, 1, '2026-04-14 12:07:56', '2026-05-17 12:07:56'),
(128, 36, 8, NULL, 5, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-03-04 12:07:56', '2026-05-17 12:07:56'),
(129, 36, 2, NULL, 5, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-03-12 12:07:56', '2026-05-17 12:07:56'),
(130, 36, 2, NULL, 5, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-05-03 12:07:56', '2026-05-17 12:07:56'),
(131, 37, 2, NULL, 4, 'Pengiriman cepat, produk original!', NULL, NULL, 1, '2026-03-02 12:07:56', '2026-05-17 12:07:56'),
(132, 37, 3, NULL, 5, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-03-01 12:07:56', '2026-05-17 12:07:56'),
(133, 37, 3, NULL, 4, 'Kualitas oke, harga terjangkau. Recommended!', NULL, NULL, 1, '2026-04-24 12:07:56', '2026-05-17 12:07:56'),
(134, 38, 9, NULL, 4, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-02-19 12:07:56', '2026-05-17 12:07:56'),
(135, 38, 9, NULL, 5, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-04-16 12:07:56', '2026-05-17 12:07:56'),
(136, 38, 6, NULL, 4, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-03-22 12:07:56', '2026-05-17 12:07:56'),
(137, 39, 6, NULL, 4, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-05-02 12:07:56', '2026-05-17 12:07:56'),
(138, 39, 6, NULL, 5, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-03-21 12:07:56', '2026-05-17 12:07:56'),
(139, 39, 2, NULL, 4, 'Packaging rapi dan aman, produk sempurna.', NULL, NULL, 1, '2026-04-15 12:07:56', '2026-05-17 12:07:56'),
(140, 40, 9, NULL, 4, 'Pengiriman cepat, produk original!', NULL, NULL, 1, '2026-04-02 12:07:56', '2026-05-17 12:07:56'),
(141, 40, 9, NULL, 4, 'Sudah dipakai beberapa kali masih bagus.', NULL, NULL, 1, '2026-05-04 12:07:56', '2026-05-17 12:07:56'),
(142, 40, 8, NULL, 4, 'Sudah dipakai beberapa kali masih bagus.', NULL, NULL, 1, '2026-02-23 12:07:56', '2026-05-17 12:07:56'),
(143, 40, 8, NULL, 5, 'Sangat puas! Bahan bagus, jahitan rapi.', NULL, NULL, 1, '2026-02-22 12:07:56', '2026-05-17 12:07:56'),
(144, 41, 4, NULL, 5, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-03-17 12:07:56', '2026-05-17 12:07:56'),
(145, 41, 7, NULL, 5, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-04-25 12:07:56', '2026-05-17 12:07:56'),
(146, 41, 9, NULL, 4, 'Sangat puas! Bahan bagus, jahitan rapi.', NULL, NULL, 1, '2026-05-13 12:07:56', '2026-05-17 12:07:56'),
(147, 41, 5, NULL, 4, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-05-10 12:07:56', '2026-05-17 12:07:56'),
(148, 42, 5, NULL, 5, 'Desain bagus, kualitas jahitan rapi. Puas!', NULL, NULL, 1, '2026-04-02 12:07:56', '2026-05-17 12:07:56'),
(149, 42, 4, NULL, 4, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-04-20 12:07:56', '2026-05-17 12:07:56'),
(150, 42, 3, NULL, 4, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-02-28 12:07:56', '2026-05-17 12:07:56'),
(151, 42, 2, NULL, 5, 'Packaging rapi dan aman, produk sempurna.', NULL, NULL, 1, '2026-03-24 12:07:56', '2026-05-17 12:07:56'),
(152, 43, 4, NULL, 4, 'Sangat puas! Bahan bagus, jahitan rapi.', NULL, NULL, 1, '2026-03-08 12:07:56', '2026-05-17 12:07:56'),
(153, 43, 4, NULL, 4, 'Sudah dipakai beberapa kali masih bagus.', NULL, NULL, 1, '2026-04-26 12:07:56', '2026-05-17 12:07:56'),
(154, 43, 7, NULL, 5, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-03-11 12:07:56', '2026-05-17 12:07:56'),
(155, 43, 7, NULL, 5, 'Sudah dipakai beberapa kali masih bagus.', NULL, NULL, 1, '2026-03-30 12:07:56', '2026-05-17 12:07:56'),
(156, 43, 7, NULL, 4, 'Pengiriman cepat, produk original!', NULL, NULL, 1, '2026-03-29 12:07:56', '2026-05-17 12:07:56'),
(157, 44, 2, NULL, 4, 'Sangat puas! Bahan bagus, jahitan rapi.', NULL, NULL, 1, '2026-03-07 12:07:56', '2026-05-17 12:07:56'),
(158, 44, 8, NULL, 4, 'Produk bagus sesuai deskripsi! Sangat puas, pasti bakal beli lagi.', NULL, NULL, 1, '2026-03-22 12:07:56', '2026-05-17 12:07:56'),
(159, 44, 8, NULL, 5, 'Mantap, produk sesuai foto, worth it!', NULL, NULL, 1, '2026-03-25 12:07:56', '2026-05-17 12:07:56'),
(160, 45, 7, NULL, 4, 'Bahan premium, nyaman seharian!', NULL, NULL, 1, '2026-05-07 12:07:56', '2026-05-17 12:07:56'),
(161, 45, 3, NULL, 4, 'Sudah pesan kedua kali, kualitas konsisten. Puas!', NULL, NULL, 1, '2026-03-14 12:07:56', '2026-05-17 12:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_adjustment` decimal(15,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `name`, `value`, `price_adjustment`, `stock`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ukuran', 'S', '0.00', 15, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(2, 1, 'Ukuran', 'M', '0.00', 47, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(3, 1, 'Ukuran', 'L', '0.00', 15, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(4, 1, 'Ukuran', 'XL', '15000.00', 19, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(5, 2, 'Ukuran', 'S', '0.00', 39, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(6, 2, 'Ukuran', 'M', '0.00', 34, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(7, 2, 'Ukuran', 'L', '0.00', 49, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(8, 2, 'Ukuran', 'XL', '15000.00', 42, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(9, 3, 'Ukuran', 'S', '0.00', 32, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(10, 3, 'Ukuran', 'M', '0.00', 10, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(11, 3, 'Ukuran', 'L', '0.00', 40, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(12, 3, 'Ukuran', 'XL', '15000.00', 21, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(13, 4, 'Ukuran', 'S', '0.00', 36, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(14, 4, 'Ukuran', 'M', '0.00', 25, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(15, 4, 'Ukuran', 'L', '0.00', 34, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(16, 4, 'Ukuran', 'XL', '15000.00', 39, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(17, 5, 'Ukuran', 'S', '0.00', 15, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(18, 5, 'Ukuran', 'M', '0.00', 26, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(19, 5, 'Ukuran', 'L', '0.00', 17, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(20, 5, 'Ukuran', 'XL', '15000.00', 37, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(21, 6, 'Ukuran', 'S', '0.00', 44, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(22, 6, 'Ukuran', 'M', '0.00', 22, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(23, 6, 'Ukuran', 'L', '0.00', 43, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(24, 6, 'Ukuran', 'XL', '15000.00', 40, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(25, 7, 'Ukuran', 'S', '0.00', 29, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(26, 7, 'Ukuran', 'M', '0.00', 26, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(27, 7, 'Ukuran', 'L', '0.00', 28, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(28, 7, 'Ukuran', 'XL', '15000.00', 11, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(29, 8, 'Ukuran', 'S', '0.00', 13, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(30, 8, 'Ukuran', 'M', '0.00', 37, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(31, 8, 'Ukuran', 'L', '0.00', 36, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(32, 8, 'Ukuran', 'XL', '15000.00', 30, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(33, 9, 'Ukuran', 'S', '0.00', 42, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(34, 9, 'Ukuran', 'M', '0.00', 19, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(35, 9, 'Ukuran', 'L', '0.00', 43, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(36, 9, 'Ukuran', 'XL', '15000.00', 12, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(37, 10, 'Ukuran', 'S', '0.00', 28, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(38, 10, 'Ukuran', 'M', '0.00', 26, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(39, 10, 'Ukuran', 'L', '0.00', 41, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(40, 10, 'Ukuran', 'XL', '15000.00', 40, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(41, 11, 'Ukuran', 'S', '0.00', 26, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(42, 11, 'Ukuran', 'M', '0.00', 26, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(43, 11, 'Ukuran', 'L', '0.00', 38, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(44, 11, 'Ukuran', 'XL', '15000.00', 16, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(45, 12, 'Ukuran', 'S', '0.00', 45, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(46, 12, 'Ukuran', 'M', '0.00', 48, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(47, 12, 'Ukuran', 'L', '0.00', 31, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(48, 12, 'Ukuran', 'XL', '15000.00', 16, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(49, 13, 'Ukuran', 'S', '0.00', 50, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(50, 13, 'Ukuran', 'M', '0.00', 46, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(51, 13, 'Ukuran', 'L', '0.00', 14, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(52, 13, 'Ukuran', 'XL', '15000.00', 48, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(53, 14, 'Ukuran', 'S', '0.00', 32, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(54, 14, 'Ukuran', 'M', '0.00', 48, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(55, 14, 'Ukuran', 'L', '0.00', 16, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(56, 14, 'Ukuran', 'XL', '15000.00', 42, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(57, 15, 'Ukuran', 'S', '0.00', 47, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(58, 15, 'Ukuran', 'M', '0.00', 18, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(59, 15, 'Ukuran', 'L', '0.00', 17, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(60, 15, 'Ukuran', 'XL', '15000.00', 23, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(61, 16, 'Ukuran', 'S', '0.00', 38, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(62, 16, 'Ukuran', 'M', '0.00', 29, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(63, 16, 'Ukuran', 'L', '0.00', 42, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(64, 16, 'Ukuran', 'XL', '15000.00', 43, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(65, 17, 'Ukuran', 'S', '0.00', 37, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(66, 17, 'Ukuran', 'M', '0.00', 24, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(67, 17, 'Ukuran', 'L', '0.00', 45, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(68, 17, 'Ukuran', 'XL', '15000.00', 29, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(69, 18, 'Ukuran', 'S', '0.00', 25, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(70, 18, 'Ukuran', 'M', '0.00', 30, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(71, 18, 'Ukuran', 'L', '0.00', 50, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(72, 18, 'Ukuran', 'XL', '15000.00', 36, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(73, 42, 'Ukuran', '38', '0.00', 12, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(74, 42, 'Ukuran', '39', '0.00', 6, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(75, 42, 'Ukuran', '40', '0.00', 14, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(76, 42, 'Ukuran', '41', '0.00', 6, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(77, 42, 'Ukuran', '42', '0.00', 7, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(78, 42, 'Ukuran', '43', '0.00', 7, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(79, 42, 'Ukuran', '44', '0.00', 11, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(80, 42, 'Ukuran', '38', '0.00', 19, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(81, 42, 'Ukuran', '39', '0.00', 17, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(82, 42, 'Ukuran', '40', '0.00', 18, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(83, 42, 'Ukuran', '41', '0.00', 20, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(84, 42, 'Ukuran', '42', '0.00', 14, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(85, 42, 'Ukuran', '43', '0.00', 11, '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(86, 42, 'Ukuran', '44', '0.00', 5, '2026-05-17 12:07:56', '2026-05-17 12:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_settings`
--

CREATE TABLE `store_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_settings`
--

INSERT INTO `store_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'store_name', 'BelanjaYuk!', '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(2, 'store_tagline', 'Belanja Hemat, Kualitas Terjamin', '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(3, 'store_email', 'admin@belanjayuk.com', '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(4, 'store_phone', '021-12345678', '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(5, 'store_whatsapp', '6289514392694', '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(6, 'store_address', 'Jl. KH. Yasin Beji No. 12, Cilegon, Banten 42414', '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(7, 'bank_bca', '1234567890 a.n BelanjaYuk!', '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(8, 'bank_bni', '9876543210 a.n BelanjaYuk!', '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(9, 'bank_mandiri', '1357924680 a.n BelanjaYuk!', '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(10, 'shipping_origin_city', '17', '2026-05-17 12:07:56', '2026-05-17 12:07:56'),
(11, 'meta_description', 'BelanjaYuk! - Toko Online Fashion & Elektronik Terpercaya.', '2026-05-17 12:07:56', '2026-05-17 12:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `avatar`, `role`, `is_active`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin BelanjaYuk', 'admin@belanjayuk.com', '081234567890', NULL, 'admin', 1, NULL, '$2y$12$q7/3qOCvq9sea0InQRH9L.SvQy5vbUz5J6lu0p8HAkvGwhCULWH9y', NULL, '2026-05-17 12:07:53', '2026-05-17 12:07:53'),
(2, 'Budi Santoso', 'budi@example.com', '082111222333', NULL, 'user', 1, NULL, '$2y$12$dbp.Pfx0EHxAmABk9HwzuOhEi.k.fDShyRZ/8gAttzWJPKl.C3PAO', NULL, '2026-01-21 12:07:53', '2026-05-17 12:07:53'),
(3, 'Siti Rahayu', 'siti@example.com', '083444555666', NULL, 'user', 1, NULL, '$2y$12$/IdUZdS9lg7.jn1GIpNd1OegA5UymPDoiQ8HPUwRi4YEsOHWfHRsW', NULL, '2026-03-11 12:07:54', '2026-05-17 12:07:54'),
(4, 'Ahmad Fauzi', 'ahmad@example.com', '085777888999', NULL, 'user', 1, NULL, '$2y$12$DPgZgfYRLXulCJGwD6q8Q.cX.buYaJAyKLABw1H1NGMhKNYGO1a.G', NULL, '2025-12-20 12:07:54', '2026-05-17 12:07:54'),
(5, 'Dewi Putri', 'dewi@example.com', '087112233445', NULL, 'user', 1, NULL, '$2y$12$cQAidyAvPl8wIHIKfVPUTe0Qtx1LTnbAPxeh.H/67gc7KuCkVFTFK', NULL, '2025-12-09 12:07:54', '2026-05-17 12:07:54'),
(6, 'Rizky Pratama', 'rizky@example.com', '081355667788', NULL, 'user', 1, NULL, '$2y$12$LlLyGU9eDgtuRYnUQHJyXuR1fbyoIyXOb/OSRBhOvpDB8f0OWQw9m', NULL, '2026-02-21 12:07:55', '2026-05-17 12:07:55'),
(7, 'Maya Sari', 'maya@example.com', '089922334455', NULL, 'user', 1, NULL, '$2y$12$.ilL537G6jk5r7fQGVDVaOVRMjxXdo5GYXdzvgzHV2K7GcJYoFsPa', NULL, '2026-03-24 12:07:55', '2026-05-17 12:07:55'),
(8, 'Hendra Wijaya', 'hendra@example.com', '085612341234', NULL, 'user', 1, NULL, '$2y$12$Idd7vzD2rTBay25RwgeWP.6/rXLdaAU02qM.V3o6TmVmqp7fmpDWW', NULL, '2026-02-14 12:07:55', '2026-05-17 12:07:55'),
(9, 'Rina Kusuma', 'rina@example.com', '081278781234', NULL, 'user', 1, NULL, '$2y$12$LuTBpVidJpCtnnnSJTyiEO9WjZPHR9OzCr5GbvCmcm0iakkmKYQRK', NULL, '2026-02-09 12:07:56', '2026-05-17 12:07:56'),
(10, 'Arif Siddik M', 'arifsiddikmuharam@gmail.com', '089514392694', NULL, 'user', 1, NULL, '$2y$12$GPDp5iKmH.nd/u.w0L8ZpefYWToEY/mBVAr.YjgNNn4I4IfEzwdPW', NULL, '2026-04-17 12:07:56', '2026-05-17 12:07:57');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_product_variant_id_foreign` (`product_variant_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_address_id_foreign` (`address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_product_variant_id_foreign` (`product_variant_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_confirmations`
--
ALTER TABLE `payment_confirmations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_confirmations_order_id_foreign` (`order_id`),
  ADD KEY `payment_confirmations_user_id_foreign` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_reviews_product_id_foreign` (`product_id`),
  ADD KEY `product_reviews_user_id_foreign` (`user_id`),
  ADD KEY `product_reviews_order_id_foreign` (`order_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `store_settings`
--
ALTER TABLE `store_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_settings_key_unique` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `payment_confirmations`
--
ALTER TABLE `payment_confirmations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `store_settings`
--
ALTER TABLE `store_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_variant_id_foreign` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payment_confirmations`
--
ALTER TABLE `payment_confirmations`
  ADD CONSTRAINT `payment_confirmations_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_confirmations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
