-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Lis 14, 2023 at 08:32 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_panel`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `access_rights`
--

CREATE TABLE `access_rights` (
  `id_access` int(10) UNSIGNED NOT NULL,
  `name_access` varchar(150) DEFAULT NULL,
  `is_edit_access_rights` int(11) NOT NULL DEFAULT 0 COMMENT 'Edytowanie uprawnień',
  `is_delete_access_rights` int(11) NOT NULL DEFAULT 0 COMMENT 'Usuwanie uprawnien',
  `is_insert_access_rights` int(11) NOT NULL DEFAULT 0 COMMENT 'Dodawanie nowych uprawnien',
  `is_edit_announcements` int(11) NOT NULL DEFAULT 0 COMMENT 'Edytowanie ogłoszen',
  `is_delete_announcements` int(11) NOT NULL DEFAULT 0 COMMENT 'Usuwanie ogloszen',
  `is_insert_announcements` int(11) NOT NULL DEFAULT 0 COMMENT 'Dodawanie nowyc ogloszen',
  `is_edit_users` int(11) NOT NULL DEFAULT 0 COMMENT 'Edytowanie uzytkownika',
  `is_view_users` int(11) NOT NULL DEFAULT 0,
  `is_delete_users` int(11) NOT NULL DEFAULT 0 COMMENT 'usuwanie uzytkownika',
  `is_insert_users` int(11) NOT NULL DEFAULT 0 COMMENT 'Dodawanie nowego użytkownika',
  `is_edit_logo` int(11) NOT NULL DEFAULT 0 COMMENT 'Edytowanie logo.',
  `is_edit_name_website` int(11) NOT NULL DEFAULT 0 COMMENT 'Usuwanie logo.',
  `is_edit_this_id_access` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `access_rights`
--

INSERT INTO `access_rights` (`id_access`, `name_access`, `is_edit_access_rights`, `is_delete_access_rights`, `is_insert_access_rights`, `is_edit_announcements`, `is_delete_announcements`, `is_insert_announcements`, `is_edit_users`, `is_view_users`, `is_delete_users`, `is_insert_users`, `is_edit_logo`, `is_edit_name_website`, `is_edit_this_id_access`) VALUES
(1, 'Administrator', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0),
(2, 'Użytkownik', 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `access_token`
--

CREATE TABLE `access_token` (
  `id_token` int(10) UNSIGNED NOT NULL,
  `access_token` varchar(100) NOT NULL,
  `refresh_token` varchar(150) DEFAULT NULL,
  `expirens_time` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `access_token`
--

INSERT INTO `access_token` (`id_token`, `access_token`, `refresh_token`, `expirens_time`, `user_id`) VALUES
(3, '9ui7YSWNoIxVtP1lGBZTLKLoivOpU0IvHxBgdsgWKznQoSb8uSDaiYtdVwS8CSaWamXJT6lavYWGOzYY', '9njZfgRtNFmRSNfbJly9tN0w0jzioMM3QZdDJt09ImM2pS7kiRwJsq0G5t3xzQxI5B34LLOODn6PEx5HlvZ6WpPRRs2ENCOLP4wbdNDywt2CN82dUVaTQsGKeJ9vPk4iSy', 1699646229, 1),
(4, 'FyBzFRwBpWXNcI4kJkmgZVobYCMaPHtkaxeYXzqR2GEKd9uJGQUVjstwYjXdoNk3ocfH3DvmNLKRAair', 'n32cCqiKH08gLHoBP1kBe29oSP1nq6CSEeFO7kCOt0Th3GAANKnp2DOMhxkJCH7gtjQ7nZibomQjyjNlUdhyfNk402NkpMoWwDqmgLQXChycr0Sl29oU5SdF19U3DeKWSf', 1699646300, 1),
(5, 'bBzJVIZc8BAeJzRTVSGp6QyDrItXSmQJBValkfR0I2vsl70zDslmRLXQLMAYi2nWAg7sqty2rTxZX3UZ', 'Uwd3v5hZrZZg4l36UAaJWJr9PIYWoPWFr0ZknbJoJywWWnxQI0GOEoR1y72EFGdijvn0eh1BB5ND5Dqksg6PWPUd9MOCUUIKKIVZUFDSMEV3kK32xlBM9EfogXsxRton3z', 1699703004, 1),
(6, 'At97oEcuEryeGq8oQtu2af4fZAkw09ECfhX2YRvMGXMd8dPCoBdfX0rqOBcvDglpNH8ofEXPKSOsWrMr', 'MpybiRKPNCcIoPJfDIlTYHU7Ll2Zelt9idx8HQ7bcrNghC1fuvF9UjU8QZX57FAux5H8ZsIqbp4CZBotAmjxgKQPompFu9JCJ6fQ5gxUQYrRU7A06qV3v3YtmQjtUqibWB', 1699703013, 1),
(7, 'nn4aqcarHccarQyfnJHKqtUiglIN5mh64wHrOMMQ37xStIkA882pdDquhJRtwnxEIktnZGABGtND9gYk', '2Pn7z8uhvy9NntlOabpgPHryip4YhEYb63CeqnQ0hkisF1J8cSRKAL0HyDqBeRL6PKaMUizre38fQMdKiKrTiWhs5vxNShaLYWa6ThEISu34HjR3SwGrkTwoAjBRoX9ORs', 1699704669, 1),
(8, 'at66amAXqDPxL62gcGuBAwQK2yJGUK9SEfXlMntrQO7jrRf8FJs53EjmoSoVuJhLRJvJecB1nbLZMWLf', 'ee0MN78ujSLeKesBz1OUjh4TAhMpqE6lBEv4y18x2GZk3FPcxKgpfdFYa76KSSPMHyaRnhwk9uKz3Fgf19d92AfMkZUJmj7o6mMsHqJTYxAq52yj0YRsnuQSbDTLFoYOUK', 1699704671, 1),
(9, 'MJR3voB97SDVBHmK7st2UGIkgkfvMNYAjKF8L7372dRVlcl8CQXhbm8PrJ7cIOYB037uuEnlR7gFsKFT', 'DlUfbA4n9uwcSVjwUxNJ72uYx8BuIr6pWGcEojgWyCo3G80NSwuWaG8d84e6nxtrbhfA8fLbIZNilZOdm8q567DJvMTPL4tFqe1z3vlDQ6rh9gNx7MMgBxo8GKEKsWEpno', 1699704672, 1),
(10, 'EBxB1hteplz7D5aO8uQSxkCc0DqZbgEgqmEeOm3azM59FiAdFkKDgbEJ7aX647OCgZVHgZPsEZSfmgCF', 'KoUH9CHdTT3lFLCo8xnUhlyN03dUIKrqS2xWAyIrIbtphNYjhgwb3yHJ68Mg1yycab92zyKbEQwCm8qrFEqysGOYSxP8LegH7DjOLys6JRdmZ1Q1JHKyqExHvHeGwfxnuq', 1699704699, 1),
(11, 'gHlUh1H9tSCz2X2oKkwYPs7dL9UCLNYDWmEpChsMJfDH4xUO3XZ4lJ6LVtYSvLxRPoOQ4kEOSsP9nrEf', 'XeVTRCDrNV6PUujzj4vqiCB4a1s5JYDAsQg3nfQmSKC1ujjrEppYsxO1i7A4Wj5O0AiPVg9tRbrsPdmNWLqQy0CDW2MF3KBI4kEsT74lEd27nf2qlWjKEpWaZuJTBMMPi6', 1699704700, 1),
(12, 'exkvDsDcNhp4qic8Zn7anMzN6VhpvCgIpNy0hbyEcGG5KyvDqRXhgLPV7LyedprIND8z8UESuKMyq6ta', 'aNfz8sqWrLsIlHiSIKu5aGm9shLccnFi8P9xZgfIdQmfByHrhvvNgkaBEyUq01SuJR8foLw8Sh8FYbiJNmc2moseEOzxeQfiejVAFBOAJFvpDxwQv3NYK4yDUNCLVgCBFR', 1699706366, 1),
(13, 'Pft3kGPrNWZdSvoaYcuCg2ihAflQHjpv233S9GwuSCqLvv8jEvAEp4Gx2y1xJXPZQSZBQX00mzedDS0t', 'HyFQMZDWHA2Ngo5z3jSXsCIgalSvng9ST2yWHn6JdkXfqNvOsQwLs6mLsX1CCZVb0yNadLw2SubG3BZesC4hR2YPfy9NhxEppxU0RKt8KAeYgeHpC214wiGz1XGfgvjrCE', 1699706393, 1),
(14, 'LnrXRB2SZL7rxw3q5ZmsZgy0MQJPSifltqsnkuiCSNUVYMoG9r0Im7apyrLWgPJXJ1v6skLfDccrQAHb', 'HQXwTpov4XnB9Lo08sLeiF3UHF6tI0wXYkZVTY3FBOvZplVv3M6AHX6fO52pfgk4iLpaCI3AM4K3u9O6ulDbHHtbVeOCNh6bM2PIboe8BYY7F1GzhjM7uDCOwx0PS3OafJ', 1699706427, 1),
(15, '95suCcbtJr90kBYDpTeIt4f4br6RxkSQkOko2GcqnQVjFvVlryfs5TysvC5tQFEBnRkVT9CXfUCUAQQ3', 'jRkloIU1CCiBNYFi1TsPov3WHKrZ8a81WHJiPjiNJZVlloazpWZPbhGk0OLWNmNL4LtD9GJ0Y9ioyu8HfFGHPQF48x1pyAo6584tModm6CEaBpsVy7r4L6HEpyRJ8bGTez', 1699706884, 1),
(16, '734H6gFGj2oBDbeKUmGEBG82tx1lST137milUdlzsRQhLFzt7gcoRLGTlWOdDeBJIahFDWYg9IK1adFz', 'W3svfQk270famGbrLaSEGrNH4XtV50hsNzXdEC9gAAhGIyrvtKcmFoS00M8hw8bkDK0QmRo1BfFnQOe3bmHqp9OClYSzFYgIppKZqopvjpYdyqhczpirUZwEt8elzcGGpE', 1699707064, 1),
(17, 'A4jqcSEUDcUPrzWiGizGU507XdnQiaNImgmYw72SDsR8adnP3r7rbqmDTuTVN9HHfEw0ZfviPwET1P0L', 'UOijsVhnMEszyjJhftqEWtK8vtDGJknULnnSdNQqMgJUT9iTP62ReJ4Ll2Vh8BRxlBk7QzjV6pF6ULZ7h8s23euFyksKG6Ns6pxGdiVdVz4ZGs7YyxP7fKDytINWHi1A7b', 1699707584, 1),
(18, 'RWbPxMUb5x4AIR0lehDESATxHLQWWZ1rZj70yS7LY6lxc63ljoeEw50VPhsU0Cb5IB9RCC7Jz6qmoS7Z', 'SV6krNhhFePuGSmN54Kvj31h9H716EBSjSUotjlR2azW6dtYqsJgNCgDa3MFGRR8ErA4Be4NjaOLXYEutlxHmcTvSldthsBtAGw9489AjoKGwGxChCyGdJXhuOfkbfDMXh', 1699707585, 1),
(19, 'pMszTSLulEllZn9KmhoEwrxkb8Ppqsv8SBI89Lg5CQ3le1XDXaNrJLhtlkJFhQnOOvzWt9T2DuWCYv3g', 'i8ujNZNr3kC807iJvzy4AptUu9I2wgGdCVDuwWRPVhVKttExiOymyWnq5bUxCCK80fsDZQYkVJ1yGAIKOwcS7USIsooB2xV1XLqaSQBsdfDLkm6MdNQUPpOTdagptsCsGb', 1699794322, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `announcements`
--

CREATE TABLE `announcements` (
  `id_announcements` int(10) UNSIGNED NOT NULL,
  `text` varchar(500) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `datetime_add` int(10) UNSIGNED DEFAULT NULL,
  `personal_start_date` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `personal_end_date` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id_announcements`, `text`, `url`, `user_id`, `datetime_add`, `personal_start_date`, `personal_end_date`) VALUES
(1, 'witam moi drodzy', 'witam moi drodzy', 1, 1699739166, 1699825566, 1699825566),
(4, 'witam moi drodzy', NULL, 1, 1699739307, 0, 1699825707),
(5, 'witam moi drodzy', NULL, 1, 1699739322, 0, 1699825722);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logs`
--

CREATE TABLE `logs` (
  `id_logs` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datetime_add` int(11) NOT NULL,
  `is_success` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id_logs`, `user_id`, `datetime_add`, `is_success`) VALUES
(18, 1, 1699705727, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `settings`
--

CREATE TABLE `settings` (
  `id_settings` int(10) UNSIGNED NOT NULL,
  `name_website` varchar(200) DEFAULT NULL,
  `logo_website` text DEFAULT NULL,
  `default_id_access_for_user` int(10) UNSIGNED DEFAULT NULL,
  `on_replacements` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `on_announcements` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `how_many_failed_login_attempts` int(11) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id_settings`, `name_website`, `logo_website`, `default_id_access_for_user`, `on_replacements`, `on_announcements`, `how_many_failed_login_attempts`) VALUES
(1, 'Page Name', NULL, 2, 1, 1, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `id_access` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `user_lastname` varchar(150) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `email` varchar(250) NOT NULL,
  `password` text NOT NULL,
  `is_new_pass` int(11) DEFAULT 0,
  `is_active` int(11) DEFAULT 0,
  `is_blocked` int(11) DEFAULT 0,
  `datetime_add` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `id_access`, `user_name`, `user_lastname`, `login`, `email`, `password`, `is_new_pass`, `is_active`, `is_blocked`, `datetime_add`) VALUES
(1, 1, 'Adam', 'Nowak', 'zhenias', '', '$2y$10$j06wTJ9uAOBJRqNF5RbMN.jd9qATbWNmWlegvX7Onzznjh70ka1dm', 0, 1, 0, NULL),
(2, 2, 'Applications', 'asfjahsfk', NULL, 'zsam@g.com', '$2y$10$oFhZIxUEfyOsdSaJBXOoDun/mnk6s3I7tjgw4zJNZDnKjtQwFBEZm', NULL, NULL, NULL, 1699792058),
(3, 2, 'Applications', 'asfjahsfk', NULL, 'zsam@g.com', '$2y$10$dCA7y0ngEIm/LeFzLegfE.E79keB9e6Z4vcAxkr9HzSBw4zviIQWi', NULL, 1, NULL, 1699792124);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `access_rights`
--
ALTER TABLE `access_rights`
  ADD PRIMARY KEY (`id_access`);

--
-- Indeksy dla tabeli `access_token`
--
ALTER TABLE `access_token`
  ADD PRIMARY KEY (`id_token`);

--
-- Indeksy dla tabeli `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id_announcements`);

--
-- Indeksy dla tabeli `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id_logs`);

--
-- Indeksy dla tabeli `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id_settings`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_rights`
--
ALTER TABLE `access_rights`
  MODIFY `id_access` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `access_token`
--
ALTER TABLE `access_token`
  MODIFY `id_token` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id_announcements` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id_logs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id_settings` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
