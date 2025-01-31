-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 31 Jan 2025 pada 09.35
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `compro`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(26, 'user1', 'password1', 'user1@example.com', '2025-01-27 15:41:56'),
(27, 'user2', 'password2', 'user2@example.com', '2025-01-27 15:41:56'),
(28, 'user3', 'password3', 'user3@example.com', '2025-01-27 15:41:56'),
(29, 'user4', 'password4', 'user4@example.com', '2025-01-27 15:41:56'),
(31, 'user6', 'password6', 'user6@example.com', '2025-01-27 15:41:56'),
(32, 'user7', 'password7', 'user7@example.com', '2025-01-27 15:41:56'),
(33, 'user8', 'password8', 'user8@example.com', '2025-01-27 15:41:56'),
(34, 'user9', 'password9', 'user9@example.com', '2025-01-27 15:41:56'),
(35, 'user10', 'password10', 'user10@example.com', '2025-01-27 15:41:56'),
(36, 'user11', 'password11', 'user11@example.com', '2025-01-27 15:41:56'),
(37, 'user12', 'password12', 'user12@example.com', '2025-01-27 15:41:56'),
(38, 'user13', 'password13', 'user13@example.com', '2025-01-27 15:41:56'),
(39, 'user14', 'password14', 'user14@example.com', '2025-01-27 15:41:56'),
(40, 'user15', 'password15', 'user15@example.com', '2025-01-27 15:41:56'),
(41, 'user16', 'password16', 'user16@example.com', '2025-01-27 15:41:56'),
(42, 'user17', 'password17', 'user17@example.com', '2025-01-27 15:41:56'),
(43, 'user18', 'password18', 'user18@example.com', '2025-01-27 15:41:56'),
(44, 'user19', 'password19', 'user19@example.com', '2025-01-27 15:41:56'),
(45, 'user20', 'password20', 'user20@example.com', '2025-01-27 15:41:56'),
(47, 'user22', 'password22', 'user22@example.com', '2025-01-27 15:41:56'),
(48, 'user23', 'password23', 'user23@example.com', '2025-01-27 15:41:56'),
(49, 'user24', 'password24', 'user24@example.com', '2025-01-27 15:41:56'),
(50, 'user25', 'password25', 'user25@example.com', '2025-01-27 15:41:56'),
(51, 'user26', 'password26', 'user26@example.com', '2025-01-27 15:41:56'),
(52, 'user27', 'password27', 'user27@example.com', '2025-01-27 15:41:56'),
(53, 'user28', 'password28', 'user28@example.com', '2025-01-27 15:41:56'),
(54, 'user29', 'password29', 'user29@example.com', '2025-01-27 15:41:56'),
(55, 'user30', 'password30', 'user30@example.com', '2025-01-27 15:41:56'),
(58, 'asd', '$2y$10$Znoh5w96MMRER5NJJxFtS.4s0UY.6OYqbNrHselv2li5PshLlh4vi', 'asdasdsa@dasdasd', '2025-01-31 05:29:38'),
(59, 'asd', '$2y$10$qbbvaPZyEBT80HHORsgMyOoTI6gLVCuiqdha.qFG1t0AGpoLOGuxW', 'asdasdsa@dasdasd', '2025-01-31 05:29:46');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
