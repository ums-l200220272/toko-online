-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Jun 2024 pada 16.40
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `merch_toko`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart_items`
--

CREATE TABLE `cart_items` (
  `id_cart_item` int(11) NOT NULL,
  `id_product` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cart_items`
--

INSERT INTO `cart_items` (`id_cart_item`, `id_product`, `product_name`, `quantity`, `price`, `total_price`, `created_at`, `updated_at`) VALUES
(6, 2, 'NewJeans New Jeans 1st EP Album (Bluebook ver.)', 2, '273000.00', '546000.00', '2024-06-17 06:33:24', '2024-06-18 06:56:21'),
(12, 1, 'aespa - Savage 1st Mini Album (HALLUCINATION QUEST Ver.)', 2, '303000.00', '606000.00', '2024-06-17 06:53:37', '2024-06-17 06:53:43'),
(22, 8, 'AKMU - 3rd Mini Album [LOVE EPISODE]', 2, '284394.00', '568788.00', '2024-06-17 07:09:58', '2024-06-17 07:24:55'),
(23, 7, 'RIIZE - The 1st Mini Album [RIIZING] (Collect Book Ver.)', 1, '307983.00', '307983.00', '2024-06-17 07:11:19', '2024-06-17 07:11:19'),
(25, 6, 'aespa - Girls 2nd Mini Album (Real World Ver.)', 1, '237239.00', '237239.00', '2024-06-18 14:29:58', '2024-06-18 14:29:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id_customer` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `id_customer` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `shipping_method_id` int(11) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id_order_item` int(11) NOT NULL,
  `id_order` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id_payment_method` int(11) NOT NULL,
  `method_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id_product` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(45) DEFAULT NULL,
  `artist` varchar(45) NOT NULL,
  `availability` varchar(20) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pict` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id_product`, `product_name`, `description`, `category`, `artist`, `availability`, `price`, `stock`, `created_at`, `updated_at`, `pict`) VALUES
(1, 'aespa - Savage 1st Mini Album (HALLUCINATION QUEST Ver.)', '[Release date : Oct 6th, 2021]\r\n[Album Information & Contents]\r\n\r\n- 3 Versions [P.O.S, HALLUCINATION QUEST, SYNK DIVE]\r\n- Cover\r\n- Photobook\r\n- CD-R\r\n- Folded Poster\r\n- Tattoo Sticker \r\n- Lenticular Card \r\n- Photo Card \r\n- Poster (Not Available)', 'Album', 'aespa', 'ready stock', '303000.00', 20, '2024-06-16 15:52:09', '2024-06-18 07:52:52', 'aespa-album-aespa-savage-1st-mini-album-hallucination-quest-ver2.jpg'),
(2, 'NewJeans New Jeans 1st EP Album (Bluebook ver.)', '[Release date : Aug 8th, 2022]\r\n[Album Information & Contents]\r\n\r\n- 6 Versions [MINJI, HANNI, DANIELLE, HAERIN, HYEIN, NEWJEANS]\r\n- Log Book\r\n- PIN-UP Book\r\n- Phoning Manual Book\r\n- CD\r\n- ID Card\r\n- Sticker Pack\r\n- Photo Card\r\n- MINI Poster ', 'Album', 'NewJeans', 'ready stock', '273000.00', 20, '2024-06-16 15:54:13', '2024-06-18 07:53:12', 'newjeans-album-newjeans-new-jeans-1st-ep-bluebook-ver.jpg'),
(3, 'SEVENTEEN - SEVENTEENTH HEAVEN 11th Mini Album (CARAT Ver.)', '[Release date : Oct 23th, 2023]\r\n[Album Information & Contents]\r\n \r\n- 13 Versions [S.Coups / Jeonghan / Joshua / Jun / Hoshi / Wonwoo / Woozi / The8 / Mingyu / DK / Seungkwan / Vernon / Dino]\r\n- Outbox + Sleeve\r\n- Hardcover Binder / Booklet\r\n- Lyric ', 'Album', 'SEVENTEEN ', 'ready stock', '252000.00', 20, '2024-06-16 15:55:49', '2024-06-18 07:53:24', 'seventeen-album-seventeen-seventeenth-heaven-11th-mini-album-carat-ver.jpg'),
(4, 'SEVENTEEN - FACE THE SUN 4th Album (Weverse Albums ver.)', '[Release date : Jun 3rd, 2022]\r\n[Album Information & Contents]\r\n\r\n- 1 Version\r\n- Card Holder\r\n- QR Card\r\n- Photo Card\r\n- User Guide', 'Album', 'SEVENTEEN ', 'ready stock', '130000.00', 20, '2024-06-16 15:55:49', '2024-06-18 07:53:33', 'seventeen-album-seventeen-face-the-sun-4th-album-weverse-albums-ver.jpg'),
(5, 'SEVENTEEN - SEVENTEEN BEST ALBUM [17 IS RIGHT HERE] DEAR Ver.', '[Release date : April 29th, 2024]\r\n[Album Information & Contents]\r\n\r\n- Outbox\r\n- Hardcover binder 1ea ( 1 out of 13 )\r\n- Booklet 24ea\r\n- Lyric Book\r\n- CD-R\r\n- Random Photocard 4ea ( 4 out of 52 )', 'Album', 'SEVENTEEN ', 'ready stock', '286930.00', 20, '2024-06-16 15:57:04', '2024-06-18 07:53:39', 'seventeen-album-seventeen-seventeen-best-album-17-is-right-here-dear-ver.jpg'),
(6, 'aespa - Girls 2nd Mini Album (Real World Ver.)', '[Release date : Jul 8th, 2022]\r\n[Album Information & Contents]\r\n\r\n- Photo Book\r\n- CD-R\r\n- Sticker\r\n- Folded Poster\r\n- Polaroid Card\r\n- Photo Card', 'Album', 'aespa', 'ready stock', '237239.00', 20, '2024-06-16 15:57:04', '2024-06-18 07:53:50', 'aespa-album-aespa-girls-2nd-mini-album-real-world-ver.jpg'),
(7, 'RIIZE - The 1st Mini Album [RIIZING] (Collect Book Ver.)', '[Release date : September 5th, 2023]\r\n[Album Information & Contents]\r\n\r\n- 1 Version\r\n- Photobook\r\n- CD-R\r\n- Decoration Pack\r\n- Photocard Set', 'Album', 'RIIZE', 'ready stock', '307983.00', 20, '2024-06-16 15:58:08', '2024-06-18 07:54:01', 'riize-album-riize-the-1st-mini-album-riizing-collect-book-ver.jpg'),
(8, 'AKMU - 3rd Mini Album [LOVE EPISODE]', '[Release date : Jun 3rd, 2024]\r\n[Information & Contents]\r\n\r\n- Outbox\r\n- Postcard\r\n- Folded Poster\r\n- Letters\r\n- Magnet\r\n- CD', 'Album', 'AKMU', 'ready stock', '284394.00', 20, '2024-06-16 15:58:08', '2024-06-18 07:54:11', 'kpopmerch-akmu-3rd-mini-album-love-episode.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `shipping_methods`
--

CREATE TABLE `shipping_methods` (
  `id_shipping_method` int(11) NOT NULL,
  `method_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `estimated_delivery_time` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id_cart_item`),
  ADD KEY `id_product` (`id_product`);

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `shipping_method_id` (`shipping_method_id`),
  ADD KEY `payment_method_id` (`payment_method_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id_order_item`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_product` (`id_product`);

--
-- Indeks untuk tabel `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id_payment_method`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`);

--
-- Indeks untuk tabel `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`id_shipping_method`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id_cart_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id_order_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id_payment_method` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `shipping_methods`
--
ALTER TABLE `shipping_methods`
  MODIFY `id_shipping_method` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`);

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customers` (`id_customer`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`shipping_method_id`) REFERENCES `shipping_methods` (`id_shipping_method`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id_payment_method`);

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
