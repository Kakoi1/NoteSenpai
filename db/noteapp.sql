-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2024 at 02:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `noteapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `n_id` int(10) NOT NULL,
  `n_title` varchar(20) NOT NULL,
  `n_description` longtext NOT NULL,
  `n_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`n_id`, `n_title`, `n_description`, `n_date`) VALUES
(20, 'gwapo si deagads', 'gwapogwapogwapogwapogwapogwapogwapogwapogwapo', '2024-03-22'),
(21, 'gwapo ', 'dsadsadsadsada', '2024-03-22'),
(22, 'sadsadasd', 'dsadasd', '2024-03-22'),
(23, 'dasdasd', 'adssadasd', '2024-03-22'),
(24, 'gwapo ka?', 'ooooooooooooooooooooooooooooooooooooooooooooooooooooooooo', '2024-03-22'),
(25, 'uig8yrtf7i6er76rt9gi', 'k;ljhuiohuioghui9gguy', '2024-03-22'),
(26, 'dasdasd', 'adasdasd', '2024-03-22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`n_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `n_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
