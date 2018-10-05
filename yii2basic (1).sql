-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 06 Gru 2017, 21:54
-- Wersja serwera: 10.1.25-MariaDB
-- Wersja PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `yii2basic`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '90', NULL),
('doctor', '76', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'this user is admin', NULL, NULL, 1512053738, 1512053738),
('createOffice', 2, 'can create office', NULL, NULL, 1512053621, 1512053621),
('doctor', 1, 'this user is doctor', NULL, NULL, 1512053682, 1512054202),
('updateOffice', 2, 'can update office', NULL, NULL, 1512053642, 1512053642),
('updateOwnOffice', 2, 'doctor can update own office', 'aurthorRule', NULL, 1512054172, 1512054172);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'doctor'),
('admin', 'updateOffice'),
('doctor', 'createOffice'),
('doctor', 'updateOwnOffice'),
('updateOwnOffice', 'updateOffice');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('aurthorRule', 0x4f3a31393a226170705c726261635c417574686f7252756c65223a333a7b733a343a226e616d65223b733a31313a2261757274686f7252756c65223b733a393a22637265617465644174223b693a313531323035343037303b733a393a22757064617465644174223b693a313531323035343037303b7d, 1512054070, 1512054070);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `certificate_photo`
--

CREATE TABLE `certificate_photo` (
  `id` int(10) NOT NULL,
  `doctor_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Zrzut danych tabeli `certificate_photo`
--

INSERT INTO `certificate_photo` (`id`, `doctor_id`, `name`) VALUES
(3, 13, '22790208_1466040846766889_1443909378_o.jpg'),
(7, 13, 'IMG_7406.JPG'),
(8, 13, '22375581_1455477217823252_166715393_o.jpg'),
(10, 13, 'IMG_7405.JPG'),
(11, 13, '22768122_1466041006766873_1189798788_o.jpg'),
(12, 13, '22766365_1466062343431406_1517013740_o.jpg'),
(13, 13, 'GIRLS byte - WBS-page-001.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(40) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Zrzut danych tabeli `city`
--

INSERT INTO `city` (`id`, `name`) VALUES
(1, 'Warszawa'),
(2, 'Kraków'),
(3, 'Rzeszów'),
(4, 'Krasiczyn'),
(5, 'łódz');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `degree`
--

CREATE TABLE `degree` (
  `id` int(11) NOT NULL,
  `degree` varchar(100) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Zrzut danych tabeli `degree`
--

INSERT INTO `degree` (`id`, `degree`) VALUES
(1, 'doktor'),
(2, 'lekarz'),
(3, 'dr n med.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `description`
--

CREATE TABLE `description` (
  `id` int(6) NOT NULL,
  `doctor_id` int(6) NOT NULL,
  `content` text COLLATE utf32_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Zrzut danych tabeli `description`
--

INSERT INTO `description` (`id`, `doctor_id`, `content`) VALUES
(3, 13, 'W pracy kieruję się moją największą pasją, jaką jest pomaganie innym.\nGłównym celem tych działań jest przywrócenie pacjentom utracone funkcje w możliwie najkrótszym czasie. W zależności od jednostki chorobowej, indywidualnie ustalam program leczenia, który na bieżąco modyfikuję w oparciu o uzyskane efekty i stan zdrowia pacjenta.\nBardzo ważne jest dla mnie holistyczne podejście do leczenia, dlatego poprzez dokładną analizę fizjoterapeutyczną instruuję pacjentów odnośnie ich stylu życia, złych nawyków, ergonomii pracy, dodatkowej aktywności fizycznej, diety i chorób współistniejących.\nChętnie współpracuje z innymi specjalistami w celu uzyskania długotrwałych rezultatów oraz zwalczenia problemu w całości.'),
(4, 18, 'hello');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `disease`
--

CREATE TABLE `disease` (
  `doctor_id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Zrzut danych tabeli `disease`
--

INSERT INTO `disease` (`doctor_id`, `name`) VALUES
(13, 'katar'),
(13, 'kaszel');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `main_category_id` int(11) NOT NULL,
  `visit_type_id` int(5) NOT NULL,
  `phone` varchar(20) COLLATE utf32_unicode_ci NOT NULL,
  `degree_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Zrzut danych tabeli `doctor`
--

INSERT INTO `doctor` (`id`, `user_id`, `city_id`, `main_category_id`, `visit_type_id`, `phone`, `degree_id`) VALUES
(13, 76, 2, 1, 2, '111222333', 2),
(18, 90, 1, 1, 2, '111222111', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `doctor_category`
--

CREATE TABLE `doctor_category` (
  `doctor_id` int(11) NOT NULL,
  `main_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Zrzut danych tabeli `doctor_category`
--

INSERT INTO `doctor_category` (`doctor_id`, `main_category_id`) VALUES
(18, 2),
(18, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `main_category`
--

CREATE TABLE `main_category` (
  `id` int(5) NOT NULL,
  `name` varchar(20) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Zrzut danych tabeli `main_category`
--

INSERT INTO `main_category` (`id`, `name`) VALUES
(1, 'alergolog'),
(2, 'androlog'),
(3, 'balneolog'),
(4, 'bariatra');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1502477586),
('m140209_132017_init', 1502477591),
('m140403_174025_create_account_table', 1502477593),
('m140504_113157_update_tables', 1502477600),
('m140504_130429_create_token_table', 1502477603),
('m140506_102106_rbac_init', 1512037592),
('m140830_171933_fix_ip_field', 1502477605),
('m140830_172703_change_account_table_name', 1502477605),
('m141222_110026_update_ip_field', 1502477606),
('m141222_135246_alter_username_length', 1502477607),
('m150614_103145_update_social_account_table', 1502477610),
('m150623_212711_fix_username_notnull', 1502477610),
('m151218_234654_add_timezone_to_profile', 1502477611),
('m160929_103127_add_last_login_at_to_user_table', 1502477612);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `office`
--

CREATE TABLE `office` (
  `id` int(9) NOT NULL,
  `doctor_id` int(9) NOT NULL,
  `name` varchar(40) COLLATE utf32_unicode_ci NOT NULL,
  `city_id` int(9) NOT NULL,
  `street` varchar(40) COLLATE utf32_unicode_ci NOT NULL,
  `postal_code` varchar(9) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Zrzut danych tabeli `office`
--

INSERT INTO `office` (`id`, `doctor_id`, `name`, `city_id`, `street`, `postal_code`) VALUES
(115, 18, 'gabinet anny', 4, 'Południowa 10/5', '34-342'),
(116, 13, 'gabinet medyczny', 3, 'Południowa 10/5', '35-302'),
(117, 13, 'MEDYK', 3, 'krakowska 10', '45-345');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `office_photo`
--

CREATE TABLE `office_photo` (
  `id` int(10) NOT NULL,
  `office_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `patient_review`
--

CREATE TABLE `patient_review` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `doctor_id` int(10) NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `competences` enum('1','2','3','4','5') CHARACTER SET utf8 NOT NULL,
  `punctuality` enum('1','2','3','4','5') CHARACTER SET utf8 NOT NULL,
  `kindness` enum('1','2','3','4','5') CHARACTER SET utf8 NOT NULL,
  `recommendable` enum('1','2','3','4','5') CHARACTER SET utf8 NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `patient_review`
--

INSERT INTO `patient_review` (`id`, `user_id`, `doctor_id`, `comment`, `competences`, `punctuality`, `kindness`, `recommendable`, `created_date`) VALUES
(21, 76, 13, 'Po dwóch wizytach z synem (sportowiec) mogę potwierdzić wszystkie pozytywne oceny. Diagnoza poprzedzona wnikliwym wywiadem i badaniem, troska o dobre samopoczucie pacjenta (kimkolwiek jest) i zainteresowanie wynikiem leczenia. Pełne bezpieczeństwo. Polecam bardzo.', '5', '5', '5', '5', '2017-12-06'),
(22, 76, 13, 'Pan Doktor starannie przeprowadził wywiad i badanie, po czym wyjaśnił dokładnie, co oznacza diagnoza. Była to pierwsza wizyta, ale mam wrażenie, że Pan Doktor jest profesjonalistą, a do tego osobą traktującą z szacunkiem swojego pacjenta.', '4', '5', '5', '4', '2017-12-06'),
(23, 76, 13, 'Zawsze z podejrzeniem patrzę na określenia typu \"jeden z najlepszych specjalistów\", ale w przypadku tego doktora to jest prawda. Od paru miesięcy poszukiwałem osoby, która potrafi zdiagnozować moje cierpienia. Zrobił to doktor Milczarek na pierwszej wizycie i jego zalecenia rehabilitacyjne przynoszą efekty. Naprawdę jest z jednym z najlepszych specjalistów w swojej dziedzinie.', '4', '3', '5', '3', '2017-12-06'),
(24, 76, 18, 'Zawsze z podejrzeniem patrzę na określenia typu \"jeden z najlepszych specjalistów\", ale w przypadku tego doktora to jest prawda. Od paru miesięcy poszukiwałem osoby, która potrafi zdiagnozować moje cierpienia. Zrobił to doktor Milczarek na pierwszej wizycie i jego zalecenia rehabilitacyjne przynoszą efekty. Naprawdę jest z jednym z najlepszych specjalistów w swojej dziedzinie.', '3', '4', '3', '4', '2017-12-06'),
(25, 90, 13, 'Zawsze z podejrzeniem patrzę na określenia typu \"jeden z najlepszych specjalistów\", ale w przypadku tego doktora to jest prawda. Od paru miesięcy poszukiwałem osoby, która potrafi zdiagnozować moje cierpienia. Zrobił to doktor Milczarek na pierwszej wizycie i jego zalecenia rehabilitacyjne przynoszą efekty. Naprawdę jest z jednym z najlepszych specjalistów w swojej dziedzinie.', '4', '5', '5', '5', '2017-12-06');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profile`
--

CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `profile`
--

INSERT INTO `profile` (`user_id`, `name`, `public_email`, `gravatar_email`, `gravatar_id`, `location`, `website`, `bio`, `timezone`) VALUES
(74, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `profile_photo`
--

CREATE TABLE `profile_photo` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Zrzut danych tabeli `profile_photo`
--

INSERT INTO `profile_photo` (`id`, `doctor_id`, `name`) VALUES
(1, 13, '20170808_185833.jpg'),
(2, 18, '18072503_1944247685809274_502783298_n.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `service`
--

CREATE TABLE `service` (
  `id` int(9) NOT NULL,
  `office_id` int(9) NOT NULL,
  `name` varchar(100) COLLATE utf32_unicode_ci NOT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Zrzut danych tabeli `service`
--

INSERT INTO `service` (`id`, `office_id`, `name`, `price`) VALUES
(1, 116, 'badanie1', 20);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `social_account`
--

CREATE TABLE `social_account` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `token`
--

CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `token`
--

INSERT INTO `token` (`user_id`, `code`, `created_at`, `type`) VALUES
(16, 'oVPsHcV-8WmAx42qjk64P6pFzIR7A__J', 1503558019, 1),
(18, '4_Yp3HDHXy5rNGB7c98m-mEkVVjZmfcZ', 1503576111, 0),
(19, 'WnE2gPhCnCf3kV9eGTTmWW8MDR6ETPaz', 1503576158, 0),
(20, 'EZqV4n0tdtYq5trcLZDnhLNY11yvM4ej', 1503576513, 0),
(21, 'rEJSwda-ilnQ7y0xPWy7B7FxRbqfkZzL', 1503576523, 0),
(22, '01OjbdSeKWwqs9w6Kmtlpmvo9GkDbL64', 1503576668, 0),
(25, 'I9FcBXc-XDn9-V3eC_V-47eIMzyCwXnN', 1509003179, 2),
(26, 'PheWdgJEZa43CULdCVDnhisgc_7avmKU', 1507552068, 0),
(27, 'vNxX2YNRvs7-IzPT5svhyl9jKZ4s87KS', 1507552449, 0),
(28, 'zkSayUp8MwWh3aEoM19WtfC_CYgseEgF', 1507552615, 0),
(30, 'vfOvNddBB1lW-30NsCzEMjHol3fP3V21', 1509003712, 0),
(32, 'vwhvOuWIwPTGqxQwr023molicR-zOR0R', 1507557459, 0),
(33, '7NMREvEKPf4_P5isv6dxLT7t3i-IaV8t', 1507557601, 0),
(34, 'sUwNryOGKAVE3gyaV-lXLfvkJgMpFXEh', 1509027241, 0),
(35, 'yTIfN1_t76uJOLdr_LuwxgqwZsMcHew4', 1509027297, 0),
(36, 'oJSuGHCHeTejC_gtgB6qc_dMPqFNQ2t2', 1509027328, 0),
(50, '9HvOnMYlzGCciK50QavXD3ZTQkM0x45C', 1509031259, 0),
(51, 'FVxoamXgscHMgIu6J2pL6p16uOXijiOs', 1509031578, 0),
(52, 'lneAgjYqpDTDbVgz7N9ayeKsgaiaCHCb', 1509031639, 0),
(53, '1HfkxaeVxLwjF13qYqpC5wbs1LIE28s5', 1509031744, 0),
(54, 'b6BMleJ3Dn7FeqFzM3vN4V8VX9G9uUhu', 1509032028, 0),
(56, 'vi2RUxDBoURdTZYuRNxpXevAUh7YBTzb', 1509032295, 0),
(57, 'qAqRULyZeXZiUzCWECU2vUA2IILNX6CG', 1509032528, 0),
(58, '1bMj_MQKUl4pCvWA3rw99njXG-p6t2uQ', 1509032835, 0),
(61, 'Qdq5qru9tpntOb2mM_l7vPN3BOK9PBYa', 1509033354, 0),
(62, 'V0H3x1RGGEcgAURMpcDlWWoIG3XrqHL3', 1509033467, 0),
(63, 'DCqFknZMScL-okPKUMt8oF8Ms9xwQfhy', 1509033621, 0),
(64, 'BJe6BqTn5ppkB6ZzVdJCt6-rSQW9ptlk', 1509033681, 0),
(65, 'VKtz7Ew3FfCYLVpWoXTDwIEXqZu-eky0', 1509033783, 0),
(66, 'Y0nhCFou_vjmgNv56osee5B9cN6NoDph', 1509033845, 0),
(67, 'rd5EFIch5mcZUYcuAXC0VQ8qwj1xr5mi', 1509033880, 0),
(68, 'VrNqWQ7RMvV4LzrKE3vFKfweLS19DIWP', 1509033925, 0),
(69, 'YrbE50LpTDdWeUdZQEcfawmIs5LkvWIi', 1509033981, 0),
(70, 'Vc8GiXK0RLOGvRsQesbA-QN7HR5Mlf8_', 1509107133, 0),
(71, 'j1rCkx8qgrA-lDCkeDe8VW6cllzjxLUE', 1509107156, 0),
(73, 'Yb0TvJ5B7eNSNFaIUkc0UrAy1BNMAWg0', 1509107239, 0),
(75, 'tanx1_5HW81T3MtLUxthUBiuDH_RoAxS', 1509107723, 0),
(78, '3imp3tDF62GH2sbaR9hk5w9UPA2eCD7R', 1511260477, 0),
(80, 'S9jJHWfn93MJL9JSVeVp_WAj94MsEObc', 1511262028, 0),
(81, 'MGgQvcmprZ8_si1kPL9jh5JI2pPT4S8E', 1511262298, 0),
(82, 'an_oGnovfYApZEGVDS5p_pm_GzPIEsGx', 1511262561, 0),
(83, 'RtOcgM_cD-3fFsPMma4O6cTxBv9XBzUK', 1511262718, 0),
(84, 'weNSFZLro9TlLhRQGMT1VgEoLJ_T1jPt', 1511263084, 0),
(85, 'TiXg7Xh5B1_7O19FB9R9IrLtET9mZBbs', 1511263251, 0),
(88, 'bMlzXjoHSmE0k2h1kA3i83HX-ByngYjZ', 1511265295, 0),
(89, 'P7dA-_uq03Vj8M34Wkjvc6U6JmT6wYVy', 1511265364, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `university`
--

CREATE TABLE `university` (
  `id_doctor` int(10) NOT NULL,
  `name` varchar(200) COLLATE utf32_unicode_ci NOT NULL,
  `date_of_graduation` varchar(30) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Zrzut danych tabeli `university`
--

INSERT INTO `university` (`id_doctor`, `name`, `date_of_graduation`) VALUES
(13, 'szkoła medyczna imieniem kogośtam w krakowie', '564');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `last_login_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `created_at`, `updated_at`, `flags`, `last_login_at`) VALUES
(74, 'lolaperolez2@niepodam.pl', 'lolaperolez2@niepodam.pl', '$2y$10$MkTnow/3fh/m.R8brgr6DOccdwpL056vVZMlBtfDvqBhkjGdDS.Aq', 'mSKoWOn5TMS0Ql2c4pvjwn95DjWizLby', 1509107640, NULL, NULL, '::1', 1509107256, 1509107256, 0, 1512040672),
(76, 'lolaperolez4@niepodam.pl', 'lolaperolez4@niepodam.pl', '$2y$10$/rAzd5d5ouwXecuTYdsobePAheToMpAztmcSAIPIc7oMdrtkm8she', 'IIKSUy_1Q8CDBrEEBBvkUwKC8syUtIhn', 1509108414, NULL, NULL, '::1', 1509108391, 1509108391, 0, 1512565226),
(90, 'lolaperolez7@niepodam.pl', 'lolaperolez7@niepodam.pl', '$2y$10$ZhlM6JPdghGQHHcSMYJXG.rXByrtH380o7RnpwirB/oUnL3MHFY0.', 'YzJvU5AtTybFlyzWuDuRt7a77GceKkJz', 1511265457, NULL, NULL, '::1', 1511265432, 1511265432, 0, 1512588878);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_details`
--

CREATE TABLE `user_details` (
  `user_id` int(11) DEFAULT NULL,
  `role` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `user_details`
--

INSERT INTO `user_details` (`user_id`, `role`, `name`, `last_name`) VALUES
(74, 'pacjent', 'jkk', 'jkk'),
(90, 'lekarz', 'Anna', 'Pilińska'),
(76, 'lekarz', 'Joanna', 'Budzik');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `visit_type`
--

CREATE TABLE `visit_type` (
  `id` int(9) NOT NULL,
  `name` varchar(30) COLLATE utf32_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Zrzut danych tabeli `visit_type`
--

INSERT INTO `visit_type` (`id`, `name`) VALUES
(1, 'NFZ'),
(2, 'Prywatnie'),
(3, 'Prywatnie i NFZ');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `certificate_photo`
--
ALTER TABLE `certificate_photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`) USING BTREE;

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `degree`
--
ALTER TABLE `degree`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `description`
--
ALTER TABLE `description`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `disease`
--
ALTER TABLE `disease`
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `main_category_id` (`main_category_id`),
  ADD KEY `visit_type_id` (`visit_type_id`),
  ADD KEY `degree_id` (`degree_id`);

--
-- Indexes for table `doctor_category`
--
ALTER TABLE `doctor_category`
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `main_category_id` (`main_category_id`);

--
-- Indexes for table `main_category`
--
ALTER TABLE `main_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `office`
--
ALTER TABLE `office`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `office_photo`
--
ALTER TABLE `office_photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `office_id` (`office_id`);

--
-- Indexes for table `patient_review`
--
ALTER TABLE `patient_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `profile_photo`
--
ALTER TABLE `profile_photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `office_id` (`office_id`);

--
-- Indexes for table `social_account`
--
ALTER TABLE `social_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_unique` (`provider`,`client_id`),
  ADD UNIQUE KEY `account_unique_code` (`code`),
  ADD KEY `fk_user_account` (`user_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD UNIQUE KEY `token_unique` (`user_id`,`code`,`type`);

--
-- Indexes for table `university`
--
ALTER TABLE `university`
  ADD KEY `id_doctor` (`id_doctor`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_unique_username` (`username`),
  ADD UNIQUE KEY `user_unique_email` (`email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD UNIQUE KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `visit_type`
--
ALTER TABLE `visit_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `certificate_photo`
--
ALTER TABLE `certificate_photo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT dla tabeli `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT dla tabeli `degree`
--
ALTER TABLE `degree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT dla tabeli `description`
--
ALTER TABLE `description`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT dla tabeli `main_category`
--
ALTER TABLE `main_category`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `office`
--
ALTER TABLE `office`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;
--
-- AUTO_INCREMENT dla tabeli `office_photo`
--
ALTER TABLE `office_photo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `patient_review`
--
ALTER TABLE `patient_review`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT dla tabeli `profile_photo`
--
ALTER TABLE `profile_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT dla tabeli `service`
--
ALTER TABLE `service`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `social_account`
--
ALTER TABLE `social_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT dla tabeli `visit_type`
--
ALTER TABLE `visit_type`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `certificate_photo`
--
ALTER TABLE `certificate_photo`
  ADD CONSTRAINT `certificate_photo_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`);

--
-- Ograniczenia dla tabeli `description`
--
ALTER TABLE `description`
  ADD CONSTRAINT `description_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`);

--
-- Ograniczenia dla tabeli `disease`
--
ALTER TABLE `disease`
  ADD CONSTRAINT `disease_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`);

--
-- Ograniczenia dla tabeli `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  ADD CONSTRAINT `doctor_ibfk_2` FOREIGN KEY (`main_category_id`) REFERENCES `main_category` (`id`),
  ADD CONSTRAINT `doctor_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `doctor_ibfk_4` FOREIGN KEY (`visit_type_id`) REFERENCES `visit_type` (`id`),
  ADD CONSTRAINT `doctor_ibfk_5` FOREIGN KEY (`degree_id`) REFERENCES `degree` (`id`);

--
-- Ograniczenia dla tabeli `doctor_category`
--
ALTER TABLE `doctor_category`
  ADD CONSTRAINT `doctor_category_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`),
  ADD CONSTRAINT `doctor_category_ibfk_2` FOREIGN KEY (`main_category_id`) REFERENCES `main_category` (`id`);

--
-- Ograniczenia dla tabeli `office`
--
ALTER TABLE `office`
  ADD CONSTRAINT `office_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  ADD CONSTRAINT `office_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`);

--
-- Ograniczenia dla tabeli `office_photo`
--
ALTER TABLE `office_photo`
  ADD CONSTRAINT `office_photo_ibfk_1` FOREIGN KEY (`office_id`) REFERENCES `office` (`id`);

--
-- Ograniczenia dla tabeli `patient_review`
--
ALTER TABLE `patient_review`
  ADD CONSTRAINT `patient_review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `patient_review_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`);

--
-- Ograniczenia dla tabeli `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `profile_photo`
--
ALTER TABLE `profile_photo`
  ADD CONSTRAINT `profile_photo_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`);

--
-- Ograniczenia dla tabeli `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `service_ibfk_1` FOREIGN KEY (`office_id`) REFERENCES `office` (`id`);

--
-- Ograniczenia dla tabeli `social_account`
--
ALTER TABLE `social_account`
  ADD CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `university`
--
ALTER TABLE `university`
  ADD CONSTRAINT `university_ibfk_1` FOREIGN KEY (`id_doctor`) REFERENCES `doctor` (`id`);

--
-- Ograniczenia dla tabeli `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
