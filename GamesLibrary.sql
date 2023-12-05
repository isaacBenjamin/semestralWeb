-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 05, 2023 at 04:24 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `GamesLibrary`
--

-- --------------------------------------------------------

--
-- Table structure for table `juegos`
--

CREATE TABLE `juegos` (
  `idJuego` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `consola` varchar(100) DEFAULT NULL,
  `lanzamiento` varchar(50) DEFAULT NULL,
  `disponibilidad` enum('0','1') DEFAULT NULL,
  `publisher` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `juegos`
--

INSERT INTO `juegos` (`idJuego`, `nombre`, `consola`, `lanzamiento`, `disponibilidad`, `publisher`) VALUES
(1, 'Mario Kart DS', 'Nintendo DS', '2005', '1', 'Nintendo'),
(3, 'Donkey Kong Country', 'SNES', '1994', '1', 'Nintendo'),
(4, 'Metal Gear Solid', 'Playstation', '1998', '1', 'Konami'),
(5, 'Super Mario Bros.', 'NES', '1985', '1', 'Nintendo'),
(6, 'The Legend of Zelda', 'NES', '1986', '1', 'Nintendo'),
(7, 'Donkey Kong', 'Arcade, NES', '1981', '1', 'Nintendo'),
(8, 'Street Fighter II', 'SNES', '1991', '1', 'Capcom'),
(9, 'Final Fantasy VII', 'PlayStation', '1997', '1', 'Square Enix'),
(10, 'Super Metroid', 'Super Nintendo', '1994', '1', 'Nintendo'),
(11, 'Mega Man 2', 'NES', '1988', '1', 'Capcom'),
(12, 'Castlevania: Symphony of the Night', 'PlayStation', '1997', '1', 'Konami'),
(13, 'Chrono Trigger', 'Super Nintendo', '1995', '1', 'Square Enix'),
(14, 'Metal Gear Solid', 'PlayStation', '1998', '1', 'Konami'),
(15, 'Diablo II', 'PC', '2000', '1', 'Blizzard Entertainment'),
(16, 'Super Mario 64', 'Nintendo 64', '1996', '1', 'Nintendo'),
(17, 'Resident Evil 4', 'GameCube', '2005', '1', 'Capcom'),
(18, 'Grand Theft Auto: San Andreas', 'PlayStation 2', '2004', '1', 'Rockstar Games'),
(19, 'The Legend of Zelda: Ocarina of Time', 'Nintendo 64', '1998', '1', 'Nintendo'),
(20, 'StarCraft', 'PC', '1998', '1', 'Blizzard Entertainment'),
(21, 'The Sims', 'PC', '2000', '1', 'Electronic Arts'),
(22, 'Civilization IV', 'PC', '2005', '1', '2K Games'),
(23, 'Deus Ex', 'PC', '2000', '1', 'Square Enix'),
(24, 'Half-Life 2', 'PC', '2004', '1', 'Valve'),
(25, 'Pokémon Red/Blue', 'Game Boy', '1996', '1', 'Nintendo'),
(26, 'Mass Effect 2', 'Xbox 360', '2010', '1', 'Electronic Arts'),
(27, 'Bioshock', 'Xbox 360', '2007', '1', '2K Games'),
(28, 'Fallout 3', 'Xbox 360', '2008', '1', 'Bethesda Softworks'),
(29, 'Sonic the Hedgehog', 'Sega Genesis / Mega Drive', '1991', '1', 'Sega'),
(30, 'Castlevania', 'NES', '1986', '1', 'Konami'),
(31, 'Metroid', 'NES', '1986', '1', 'Nintendo'),
(32, 'Mega Man X', 'Super Nintendo', '1993', '1', 'Capcom'),
(33, 'EarthBound', 'Super Nintendo', '1994', NULL, 'Nintendo'),
(34, 'Streets of Rage', 'Sega Genesis / Mega Drive', '1991', '1', 'Sega'),
(35, 'Golden Axe', 'Sega Genesis / Mega Drive', '1989', '1', 'Sega'),
(36, 'Altered Beast', 'Sega Genesis / Mega Drive', '1988', '1', 'Sega');

-- --------------------------------------------------------

--
-- Table structure for table `transacciones`
--

CREATE TABLE `transacciones` (
  `transacciones_id` int(11) NOT NULL,
  `juego_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_prestamo` date DEFAULT NULL,
  `fecha_devolucion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transacciones`
--

INSERT INTO `transacciones` (`transacciones_id`, `juego_id`, `usuario_id`, `fecha_prestamo`, `fecha_devolucion`) VALUES
(1, 1, 1, '2023-12-04', '2023-12-04'),
(2, 1, 1, '2023-12-04', '2023-12-04'),
(3, 1, 1, '2023-12-04', '2023-12-04'),
(4, 1, 1, '2023-12-04', '2023-12-04'),
(5, 3, 1, '2023-12-04', '2023-12-04'),
(6, 1, 1, '2023-12-04', '2023-12-04'),
(7, 3, 1, '2023-12-04', '2023-12-04'),
(8, 3, 1, '2023-12-04', '2023-12-04'),
(9, 1, 1, '2023-12-04', '2023-12-04'),
(10, 4, 1, '2023-12-04', '2023-12-04'),
(11, 4, 1, '2023-12-04', '2023-12-04'),
(12, 3, 2, '2023-12-04', '2023-12-04'),
(13, 3, 1, '2023-12-04', '2023-12-05'),
(14, 4, 1, '2023-12-04', '2023-12-05'),
(15, 1, 1, '2023-12-04', '2023-12-05'),
(16, 3, 1, '2023-12-04', '2023-12-05'),
(17, 1, 1, '2023-12-04', '2023-12-05'),
(18, 14, 1, '2023-12-04', '2023-12-05'),
(19, 3, 1, '2023-12-04', '2023-12-05'),
(20, 8, 1, '2023-12-04', '2023-12-05');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `contrasena` varchar(100) DEFAULT NULL,
  `tipo_usuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombre`, `contrasena`, `tipo_usuario`) VALUES
(1, 'admin', 'admin', 'admin'),
(2, 'Justino20', 'Justino', 'cliente');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`idJuego`);

--
-- Indexes for table `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`transacciones_id`),
  ADD KEY `juego_id` (`juego_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `juegos`
--
ALTER TABLE `juegos`
  MODIFY `idJuego` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `transacciones_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transacciones`
--
ALTER TABLE `transacciones`
  ADD CONSTRAINT `transacciones_ibfk_1` FOREIGN KEY (`juego_id`) REFERENCES `juegos` (`idJuego`),
  ADD CONSTRAINT `transacciones_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
