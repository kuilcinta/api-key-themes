-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 21 Nov 2014 pada 11.39
-- Versi Server: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `api_ofan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `api_data`
--

CREATE TABLE IF NOT EXISTS `api_data` (
  `api_index` int(11) NOT NULL AUTO_INCREMENT,
  `api_user` varchar(55) NOT NULL,
  `api_id` varchar(115) NOT NULL,
  `api_value` varchar(225) NOT NULL,
  `api_domain` varchar(110) NOT NULL,
  `api_client` varchar(25) NOT NULL,
  `api_valid` datetime NOT NULL,
  `api_status` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`api_index`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `api_data`
--

INSERT INTO `api_data` (`api_index`, `api_user`, `api_id`, `api_value`, `api_domain`, `api_client`, `api_valid`, `api_status`) VALUES
(1, '2', '391415531810', 'T2ZhbiBFYm9ifGh0dHA6Ly9hYm91dC5tZS9vZmFufHNvZmFuZGFuaUBnbWFpbC5jb218MzkxNDE1NTMxODEwfDE0NDQxNzE1MDA=', 'http://192.168.1.5/gluckindonesia.com', 'web', '2015-10-07 05:45:00', 'Y'),
(2, '6', '6931416413110', 'none', 'http://tanganketiga.com', 'web', '2015-11-19 23:05:10', 'N'),
(3, '7', '3281416413386', 'T2ZhbiBFYm9ifGh0dHA6Ly9hYm91dC5tZS9vZmFufHNvZmFuZGFuaUBnbWFpbC5jb218MzI4MTQxNjQxMzM4NnwxNDQ3OTQ5Mzg2', 'http://ofanebob.com', 'app', '2015-11-19 23:09:46', 'Y'),
(5, '8', '5721416455892', 'none', 'http://tangankelima.com', 'mobile', '2015-11-20 10:58:12', 'N');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_access`
--

CREATE TABLE IF NOT EXISTS `log_access` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_user` varchar(55) NOT NULL,
  `log_ip` varchar(115) NOT NULL,
  `log_date` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `site_opt`
--

CREATE TABLE IF NOT EXISTS `site_opt` (
  `opt_id` int(11) NOT NULL AUTO_INCREMENT,
  `opt_name` varchar(55) NOT NULL,
  `opt_value` varchar(155) NOT NULL,
  PRIMARY KEY (`opt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data untuk tabel `site_opt`
--

INSERT INTO `site_opt` (`opt_id`, `opt_name`, `opt_value`) VALUES
(1, 'author', 'Ofan Ebob'),
(2, 'url_author', 'http://about.me/ofan'),
(3, 'email_author', 'sofandani@gmail.com'),
(4, 'color_brand', 'primary'),
(5, 'title_web', 'API Data Access'),
(6, 'description_web', 'Authenticate API data inlcuding validation information for clients web developing'),
(7, 'siteurl', 'http://192.168.1.5/api.ofanebob.com'),
(8, 'api_version', '1.0'),
(9, 'key', 'e8c0f3a38eae3fc284e8039a72e34888');

-- --------------------------------------------------------

--
-- Struktur dari tabel `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id_test` int(11) NOT NULL AUTO_INCREMENT,
  `name_test` varchar(55) NOT NULL,
  `desc_test` varchar(155) NOT NULL,
  `date_test` datetime NOT NULL,
  `status_test` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_test`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `test`
--

INSERT INTO `test` (`id_test`, `name_test`, `desc_test`, `date_test`, `status_test`) VALUES
(1, 'abcd', 'sas@fafnn', '2014-11-19 09:54:08', 'N'),
(2, 'cscdsd', 'dsds@dasa', '2014-11-19 10:23:31', 'N'),
(3, '545454545', 'bbbbb', '2014-11-19 10:24:29', 'N'),
(4, 'abcde', 'asasas', '2014-11-19 12:59:29', 'N'),
(5, 'abcdef', 'asasas', '2014-11-19 14:22:35', 'N');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(55) NOT NULL,
  `user_email` varchar(55) NOT NULL,
  `user_pass` varchar(225) NOT NULL,
  `user_firstname` varchar(155) NOT NULL,
  `user_lastname` varchar(155) NOT NULL,
  `user_status` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_pass`, `user_firstname`, `user_lastname`, `user_status`) VALUES
(1, 'nouser', 'no@email.com', 'abatasajahaho', 'No', 'Name', 'N'),
(2, 'gluckindonesia', 'admin@gluckindonesia.com', 'f0a33bce8c071116120e5ce95b34d48c', 'Gluck', 'Indonesia', 'Y'),
(6, 'tanganketiga', 'admin@tanganketiga.com', '3ea5f0a373ba8d7265b6915d6c020787', 'Tangan', 'Ketiga', 'Y'),
(7, 'ofanebob', 'cs@ofanebob.com', '125792e2ff76d45e9bc0fcc5bfda07f2', 'Ofan', 'Ebob', 'Y'),
(8, 'tangankelima', 'admin@tangankelima.com', '0b3d7802a49b2e9bcc57e68b9ea41fee', 'Tangankelima', '', 'N');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
