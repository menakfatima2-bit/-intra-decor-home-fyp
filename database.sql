-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql301.infinityfree.com
-- Generation Time: Sep 22, 2026 at 03:08 AM
-- Server version: 11.4.13-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_42479335_intradecorhome`
--

-- --------------------------------------------------------

--
-- Table structure for table `addservice`
--

CREATE TABLE `addservice` (
  `serviceprovider_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `serviceprovider_name` varchar(255) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_description` text DEFAULT NULL,
  `started_at` decimal(10,2) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `experience` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Active',
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addservice`
--

INSERT INTO `addservice` (`serviceprovider_id`, `service_id`, `serviceprovider_name`, `service_name`, `service_description`, `started_at`, `city`, `experience`, `created_at`, `status`, `category`) VALUES
(110, 40, 'Ali Hassan', 'Tile Fitting & Installation', 'Professional tile fitting service for floors and walls. We use premium quality adhesive and provide finishing work. Available for residential and commercial projects.', '35.00', 'Lahore - DHA', '5', '2026-06-04 11:37:41', 'Active', 'Tiles'),
(111, 41, 'Abdullah', ' NameTile Fitting & Installation', 'Professional tile fitting service for floors and walls. We use premium quality adhesive and provide finishing work. Available for residential and commercial projects.', '28.00', 'Lahore - DHA', '3', '2026-06-04 11:51:59', 'Active', 'Tiles'),
(112, 42, 'Ahmed', 'Tile Fitting & Installation', 'Professional tile fitting service for floors and walls. We use premium quality adhesive and provide finishing work. Available for residential and commercial projects.', '34.00', 'Lahore - Gulberg', '4', '2026-06-04 16:20:35', 'Active', 'Tiles'),
(113, 43, 'Umar', ' NameTile Fitting & Installation', 'Professional tile fitting service for floors and walls. We use premium quality adhesive and provide finishing work. Available for residential and commercial projects.', '39.00', 'Lahore - Johar Town', '5', '2026-06-04 16:24:35', 'Active', 'Tiles'),
(114, 44, 'Hamza', 'Tile Fitting & Installation', 'Professional tile fitting service for floors and walls. We use premium quality adhesive and provide finishing work. Available for residential and commercial projects.', '44.00', 'Lahore - Bahria Town', '6', '2026-06-04 16:29:58', 'Active', 'Tiles'),
(115, 45, 'Ayan', 'Tile Fitting & Installation', 'Professional tile fitting service for floors and walls. We use premium quality adhesive and provide finishing work. Available for residential and commercial projects.', '44.00', 'Sheikhupura - Sheikhupura City', '2', '2026-06-05 09:24:25', 'Active', 'Tiles'),
(116, 46, 'zain', 'Tile Fitting & Installation', 'Professional tile fitting service for floors and walls. We use premium quality adhesive and provide finishing work. Available for residential and commercial projects.', '33.00', 'Sheikhupura - Housing Colony', '4', '2026-06-05 09:26:56', 'Active', 'Tiles'),
(117, 47, 'Taha', 'Tile Fitting & Installation', 'Professional tile fitting service for floors and walls. We use premium quality adhesive and provide finishing work. Available for residential and commercial projects.', '34.00', 'Sheikhupura', '4', '2026-06-05 09:29:25', 'Active', 'Tiles'),
(118, 48, 'Bilal', 'Tile Fitting & Installation', 'Professional tile fitting service for floors and walls. We use premium quality adhesive and provide finishing work. Available for residential and commercial projects.', '25.00', 'Sheikhupura - Ghang Road', '3', '2026-06-05 09:35:38', 'Active', 'Tiles'),
(119, 49, 'Saad', 'Tile Fitting & Installation', 'Professional tile fitting service for floors and walls. We use premium quality adhesive and provide finishing work. Available for residential and commercial projects.', '40.00', 'Sheikhupura - Bhikhi Road', '5', '2026-06-05 09:45:40', 'Active', 'Tiles'),
(126, 50, 'Ahsan Qureshi', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1311.00', 'Lahore - DHA', '2 years', '2026-06-15 11:28:49', 'Active', NULL),
(127, 51, 'Bilal Siddiqui', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2083.00', 'Lahore - DHA', '3 years', '2026-06-15 11:28:49', 'Active', NULL),
(128, 52, 'Faisal Mirza', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1729.00', 'Lahore - DHA', '4 years', '2026-06-15 11:28:49', 'Active', NULL),
(129, 53, 'Hassan Chaudhry', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3735.00', 'Lahore - Gulberg', '5 years', '2026-06-15 11:28:49', 'Active', NULL),
(130, 54, 'Imran Butt', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1373.00', 'Lahore - Gulberg', '6 years', '2026-06-15 11:28:49', 'Active', NULL),
(131, 55, 'Junaid Rana', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2259.00', 'Lahore - Gulberg', '7 years', '2026-06-15 11:28:49', 'Active', NULL),
(132, 56, 'Kamran Bhatti', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '714.00', 'Lahore - Johar Town', '8 years', '2026-06-15 11:28:49', 'Active', NULL),
(133, 57, 'Nasir Nawaz', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '1925.00', 'Lahore - Johar Town', '10 years', '2026-06-15 11:28:49', 'Active', NULL),
(134, 58, 'Omar Dar', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1681.00', 'Lahore - Johar Town', '2 years', '2026-06-15 11:28:49', 'Active', NULL),
(135, 59, 'Rizwan Gill', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2418.00', 'Lahore - Bahria Town', '3 years', '2026-06-15 11:28:49', 'Active', NULL),
(136, 60, 'Shahid Javed', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1288.00', 'Lahore - Bahria Town', '4 years', '2026-06-15 11:28:49', 'Active', NULL),
(137, 61, 'Tariq Latif', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3140.00', 'Lahore - Bahria Town', '5 years', '2026-06-15 11:28:49', 'Active', NULL),
(138, 62, 'Waqas Mehmood', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1925.00', 'Karachi - DHA Karachi', '6 years', '2026-06-15 11:28:49', 'Active', NULL),
(139, 63, 'Yasir Niazi', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1599.00', 'Karachi - DHA Karachi', '7 years', '2026-06-15 11:28:49', 'Active', NULL),
(140, 64, 'Zubair Paracha', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1323.00', 'Karachi - DHA Karachi', '8 years', '2026-06-15 11:28:49', 'Active', NULL),
(141, 65, 'Adnan Raja', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3392.00', 'Karachi - Clifton', '10 years', '2026-06-15 11:28:49', 'Active', NULL),
(142, 66, 'Danish Saeed', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1108.00', 'Karachi - Clifton', '2 years', '2026-06-15 11:28:49', 'Active', NULL),
(143, 67, 'Fahad Tanveer', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1929.00', 'Karachi - Clifton', '3 years', '2026-06-15 11:28:49', 'Active', NULL),
(144, 68, 'Ghulam Ullah', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '753.00', 'Karachi - Gulshan-e-Iqbal', '4 years', '2026-06-15 11:28:49', 'Active', NULL),
(145, 69, 'Hamid Virk', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '2911.00', 'Karachi - Gulshan-e-Iqbal', '5 years', '2026-06-15 11:28:49', 'Active', NULL),
(146, 70, 'Irfan Warraich', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1772.00', 'Karachi - Gulshan-e-Iqbal', '6 years', '2026-06-15 11:28:49', 'Active', NULL),
(147, 71, 'Khalid Yousaf', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1987.00', 'Karachi - Saddar', '7 years', '2026-06-15 11:28:49', 'Active', NULL),
(148, 72, 'Luqman Zahid', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1513.00', 'Karachi - Saddar', '8 years', '2026-06-15 11:28:49', 'Active', NULL),
(149, 73, 'Mohsin Khan', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '2556.00', 'Karachi - Saddar', '10 years', '2026-06-15 11:28:49', 'Active', NULL),
(150, 74, 'Naveed Ahmed', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '819.00', 'Islamabad - F-7', '2 years', '2026-06-15 11:28:49', 'Active', NULL),
(151, 75, 'Pervaiz Ali', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2603.00', 'Islamabad - F-7', '3 years', '2026-06-15 11:28:49', 'Active', NULL),
(152, 76, 'Qaiser Malik', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1618.00', 'Islamabad - F-7', '4 years', '2026-06-15 11:28:49', 'Active', NULL),
(153, 77, 'Salman Raza', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '2818.00', 'Islamabad - F-10', '5 years', '2026-06-15 11:28:49', 'Active', NULL),
(154, 78, 'Usman Hussain', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1924.00', 'Islamabad - F-10', '6 years', '2026-06-15 11:28:49', 'Active', NULL),
(155, 79, 'Waseem Sheikh', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1971.00', 'Islamabad - F-10', '7 years', '2026-06-15 11:28:49', 'Active', NULL),
(156, 80, 'Ahsan Qureshi', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1654.00', 'Islamabad - Bahria Town', '8 years', '2026-06-15 11:28:49', 'Active', NULL),
(157, 81, 'Bilal Siddiqui', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3119.00', 'Islamabad - Bahria Town', '10 years', '2026-06-15 11:28:49', 'Active', NULL),
(158, 82, 'Faisal Mirza', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '967.00', 'Islamabad - Bahria Town', '2 years', '2026-06-15 11:28:49', 'Active', NULL),
(159, 83, 'Hassan Chaudhry', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2079.00', 'Islamabad - DHA Islamabad', '3 years', '2026-06-15 11:28:49', 'Active', NULL),
(160, 84, 'Imran Butt', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1326.00', 'Islamabad - DHA Islamabad', '4 years', '2026-06-15 11:28:49', 'Active', NULL),
(161, 85, 'Junaid Rana', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '2117.00', 'Islamabad - DHA Islamabad', '5 years', '2026-06-15 11:28:49', 'Active', NULL),
(162, 86, 'Kamran Bhatti', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1733.00', 'Rawalpindi - Bahria Town', '6 years', '2026-06-15 11:28:49', 'Active', NULL),
(163, 87, 'Nasir Nawaz', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1392.00', 'Rawalpindi - Bahria Town', '7 years', '2026-06-15 11:28:49', 'Active', NULL),
(164, 88, 'Omar Dar', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1144.00', 'Rawalpindi - Bahria Town', '8 years', '2026-06-15 11:28:49', 'Active', NULL),
(165, 89, 'Rizwan Gill', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3562.00', 'Rawalpindi - Saddar', '10 years', '2026-06-15 11:28:49', 'Active', NULL),
(166, 90, 'Shahid Javed', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1302.00', 'Rawalpindi - Saddar', '2 years', '2026-06-15 11:28:49', 'Active', NULL),
(167, 91, 'Tariq Latif', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2808.00', 'Rawalpindi - Saddar', '3 years', '2026-06-15 11:28:49', 'Active', NULL),
(168, 92, 'Waqas Mehmood', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '824.00', 'Rawalpindi - Westridge', '4 years', '2026-06-15 11:28:49', 'Active', NULL),
(169, 93, 'Yasir Niazi', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '2575.00', 'Rawalpindi - Westridge', '5 years', '2026-06-15 11:28:49', 'Active', NULL),
(170, 94, 'Zubair Paracha', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1735.00', 'Rawalpindi - Westridge', '6 years', '2026-06-15 11:28:49', 'Active', NULL),
(171, 95, 'Adnan Raja', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2493.00', 'Rawalpindi - Satellite Town', '7 years', '2026-06-15 11:28:49', 'Active', NULL),
(172, 96, 'Danish Saeed', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1477.00', 'Rawalpindi - Satellite Town', '8 years', '2026-06-15 11:28:49', 'Active', NULL),
(173, 97, 'Fahad Tanveer', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3001.00', 'Rawalpindi - Satellite Town', '10 years', '2026-06-15 11:28:49', 'Active', NULL),
(174, 98, 'Ghulam Ullah', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1381.00', 'Faisalabad - Gulberg', '2 years', '2026-06-15 11:28:49', 'Active', NULL),
(175, 99, 'Hamid Virk', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1353.00', 'Faisalabad - Gulberg', '3 years', '2026-06-15 11:28:49', 'Active', NULL),
(176, 100, 'Irfan Warraich', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1781.00', 'Faisalabad - Gulberg', '4 years', '2026-06-15 11:28:49', 'Active', NULL),
(177, 101, 'Khalid Yousaf', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '1773.00', 'Faisalabad - Madina Town', '5 years', '2026-06-15 11:28:49', 'Active', NULL),
(178, 102, 'Luqman Zahid', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '814.00', 'Faisalabad - Madina Town', '6 years', '2026-06-15 11:28:49', 'Active', NULL),
(179, 103, 'Mohsin Khan', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1793.00', 'Faisalabad - Madina Town', '7 years', '2026-06-15 11:28:49', 'Active', NULL),
(180, 104, 'Naveed Ahmed', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1421.00', 'Faisalabad - Canal Road', '8 years', '2026-06-15 11:28:49', 'Active', NULL),
(181, 105, 'Pervaiz Ali', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '2919.00', 'Faisalabad - Canal Road', '10 years', '2026-06-15 11:28:49', 'Active', NULL);
INSERT INTO `addservice` (`serviceprovider_id`, `service_id`, `serviceprovider_name`, `service_name`, `service_description`, `started_at`, `city`, `experience`, `created_at`, `status`, `category`) VALUES
(182, 106, 'Qaiser Malik', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1074.00', 'Faisalabad - Canal Road', '2 years', '2026-06-15 11:28:49', 'Active', NULL),
(183, 107, 'Salman Raza', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2702.00', 'Faisalabad - Susan Road', '3 years', '2026-06-15 11:28:49', 'Active', NULL),
(184, 108, 'Usman Hussain', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1173.00', 'Faisalabad - Susan Road', '4 years', '2026-06-15 11:28:49', 'Active', NULL),
(185, 109, 'Waseem Sheikh', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '2386.00', 'Faisalabad - Susan Road', '5 years', '2026-06-15 11:28:49', 'Active', NULL),
(186, 110, 'Ahsan Qureshi', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '928.00', 'Multan - Cantt', '6 years', '2026-06-15 11:28:49', 'Active', NULL),
(187, 111, 'Bilal Siddiqui', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2226.00', 'Multan - Cantt', '7 years', '2026-06-15 11:28:49', 'Active', NULL),
(188, 112, 'Faisal Mirza', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '963.00', 'Multan - Cantt', '8 years', '2026-06-15 11:28:49', 'Active', NULL),
(189, 113, 'Hassan Chaudhry', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3979.00', 'Multan - Gulgasht', '10 years', '2026-06-15 11:28:49', 'Active', NULL),
(190, 114, 'Imran Butt', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1164.00', 'Multan - Gulgasht', '2 years', '2026-06-15 11:28:49', 'Active', NULL),
(191, 115, 'Junaid Rana', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1609.00', 'Multan - Gulgasht', '3 years', '2026-06-15 11:28:49', 'Active', NULL),
(192, 116, 'Kamran Bhatti', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1022.00', 'Multan - Shah Rukn-e-Alam', '4 years', '2026-06-15 11:28:49', 'Active', NULL),
(193, 117, 'Nasir Nawaz', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3393.00', 'Multan - Shah Rukn-e-Alam', '5 years', '2026-06-15 11:28:49', 'Active', NULL),
(194, 118, 'Omar Dar', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1811.00', 'Multan - Shah Rukn-e-Alam', '6 years', '2026-06-15 11:28:49', 'Active', NULL),
(195, 119, 'Rizwan Gill', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2002.00', 'Multan - New Multan', '7 years', '2026-06-15 11:28:49', 'Active', NULL),
(196, 120, 'Shahid Javed', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '748.00', 'Multan - New Multan', '8 years', '2026-06-15 11:28:49', 'Active', NULL),
(197, 121, 'Tariq Latif', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '2023.00', 'Multan - New Multan', '10 years', '2026-06-15 11:28:49', 'Active', NULL),
(198, 122, 'Waqas Mehmood', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1037.00', 'Gujranwala - GT Road', '2 years', '2026-06-15 11:28:49', 'Active', NULL),
(199, 123, 'Yasir Niazi', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2313.00', 'Gujranwala - GT Road', '3 years', '2026-06-15 11:28:49', 'Active', NULL),
(200, 124, 'Zubair Paracha', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1067.00', 'Gujranwala - GT Road', '4 years', '2026-06-15 11:28:49', 'Active', NULL),
(201, 125, 'Adnan Raja', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '1939.00', 'Gujranwala - Satellite Town', '5 years', '2026-06-15 11:28:49', 'Active', NULL),
(202, 126, 'Danish Saeed', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1101.00', 'Gujranwala - Satellite Town', '6 years', '2026-06-15 11:28:49', 'Active', NULL),
(203, 127, 'Fahad Tanveer', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2253.00', 'Gujranwala - Satellite Town', '7 years', '2026-06-15 11:28:49', 'Active', NULL),
(204, 128, 'Ghulam Ullah', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '974.00', 'Gujranwala - Model Town', '8 years', '2026-06-15 11:28:49', 'Active', NULL),
(205, 129, 'Hamid Virk', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3238.00', 'Gujranwala - Model Town', '10 years', '2026-06-15 11:28:49', 'Active', NULL),
(206, 130, 'Irfan Warraich', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1907.00', 'Gujranwala - Model Town', '2 years', '2026-06-15 11:28:49', 'Active', NULL),
(207, 131, 'Khalid Yousaf', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1897.00', 'Gujranwala - Peoples Colony', '3 years', '2026-06-15 11:28:49', 'Active', NULL),
(208, 132, 'Luqman Zahid', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1736.00', 'Gujranwala - Peoples Colony', '4 years', '2026-06-15 11:28:49', 'Active', NULL),
(209, 133, 'Mohsin Khan', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3202.00', 'Gujranwala - Peoples Colony', '5 years', '2026-06-15 11:28:49', 'Active', NULL),
(210, 134, 'Naveed Ahmed', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1590.00', 'Sialkot - Cantt', '6 years', '2026-06-15 11:28:49', 'Active', NULL),
(211, 135, 'Pervaiz Ali', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2138.00', 'Sialkot - Cantt', '7 years', '2026-06-15 11:28:49', 'Active', NULL),
(212, 136, 'Qaiser Malik', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1348.00', 'Sialkot - Cantt', '8 years', '2026-06-15 11:28:50', 'Active', NULL),
(213, 137, 'Salman Raza', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '1929.00', 'Sialkot - Allama Iqbal Road', '10 years', '2026-06-15 11:28:50', 'Active', NULL),
(214, 138, 'Usman Hussain', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1087.00', 'Sialkot - Allama Iqbal Road', '2 years', '2026-06-15 11:28:50', 'Active', NULL),
(215, 139, 'Waseem Sheikh', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2944.00', 'Sialkot - Allama Iqbal Road', '3 years', '2026-06-15 11:28:50', 'Active', NULL),
(216, 140, 'Ahsan Qureshi', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '726.00', 'Sialkot - Hajipura', '4 years', '2026-06-15 11:28:50', 'Active', NULL),
(217, 141, 'Bilal Siddiqui', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '1879.00', 'Sialkot - Hajipura', '5 years', '2026-06-15 11:28:50', 'Active', NULL),
(218, 142, 'Faisal Mirza', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1632.00', 'Sialkot - Hajipura', '6 years', '2026-06-15 11:28:50', 'Active', NULL),
(219, 143, 'Hassan Chaudhry', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2242.00', 'Sialkot - Paris Road', '7 years', '2026-06-15 11:28:50', 'Active', NULL),
(220, 144, 'Imran Butt', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1232.00', 'Sialkot - Paris Road', '8 years', '2026-06-15 11:28:50', 'Active', NULL),
(221, 145, 'Junaid Rana', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '1646.00', 'Sialkot - Paris Road', '10 years', '2026-06-15 11:28:50', 'Active', NULL),
(222, 146, 'Kamran Bhatti', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1418.00', 'Peshawar - Hayatabad', '2 years', '2026-06-15 11:28:50', 'Active', NULL),
(223, 147, 'Nasir Nawaz', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2974.00', 'Peshawar - Hayatabad', '3 years', '2026-06-15 11:28:50', 'Active', NULL),
(224, 148, 'Omar Dar', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '744.00', 'Peshawar - Hayatabad', '4 years', '2026-06-15 11:28:50', 'Active', NULL),
(225, 149, 'Rizwan Gill', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3819.00', 'Peshawar - University Road', '5 years', '2026-06-15 11:28:50', 'Active', NULL),
(226, 150, 'Shahid Javed', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '910.00', 'Peshawar - University Road', '6 years', '2026-06-15 11:28:50', 'Active', NULL),
(227, 151, 'Tariq Latif', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1530.00', 'Peshawar - University Road', '7 years', '2026-06-15 11:28:50', 'Active', NULL),
(228, 152, 'Waqas Mehmood', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1667.00', 'Peshawar - Cantt', '8 years', '2026-06-15 11:28:50', 'Active', NULL),
(229, 153, 'Yasir Niazi', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '2600.00', 'Peshawar - Cantt', '10 years', '2026-06-15 11:28:50', 'Active', NULL),
(230, 154, 'Zubair Paracha', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1487.00', 'Peshawar - Cantt', '2 years', '2026-06-15 11:28:50', 'Active', NULL),
(231, 155, 'Adnan Raja', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1914.00', 'Peshawar - Saddar', '3 years', '2026-06-15 11:28:50', 'Active', NULL),
(232, 156, 'Danish Saeed', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1494.00', 'Peshawar - Saddar', '4 years', '2026-06-15 11:28:50', 'Active', NULL),
(233, 157, 'Fahad Tanveer', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '1677.00', 'Peshawar - Saddar', '5 years', '2026-06-15 11:28:50', 'Active', NULL),
(234, 158, 'Ghulam Ullah', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1229.00', 'Quetta - Cantt', '6 years', '2026-06-15 11:28:50', 'Active', NULL),
(235, 159, 'Hamid Virk', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1823.00', 'Quetta - Cantt', '7 years', '2026-06-15 11:28:50', 'Active', NULL),
(236, 160, 'Irfan Warraich', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1173.00', 'Quetta - Cantt', '8 years', '2026-06-15 11:28:50', 'Active', NULL),
(237, 161, 'Khalid Yousaf', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3508.00', 'Quetta - Satellite Town', '10 years', '2026-06-15 11:28:50', 'Active', NULL),
(238, 162, 'Luqman Zahid', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1187.00', 'Quetta - Satellite Town', '2 years', '2026-06-15 11:28:50', 'Active', NULL),
(239, 163, 'Mohsin Khan', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1533.00', 'Quetta - Satellite Town', '3 years', '2026-06-15 11:28:50', 'Active', NULL),
(240, 164, 'Naveed Ahmed', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1262.00', 'Quetta - Jinnah Road', '4 years', '2026-06-15 11:28:50', 'Active', NULL),
(241, 165, 'Pervaiz Ali', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3701.00', 'Quetta - Jinnah Road', '5 years', '2026-06-15 11:28:50', 'Active', NULL),
(242, 166, 'Qaiser Malik', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1900.00', 'Quetta - Jinnah Road', '6 years', '2026-06-15 11:28:50', 'Active', NULL),
(243, 167, 'Salman Raza', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2852.00', 'Quetta - Sariab Road', '7 years', '2026-06-15 11:28:50', 'Active', NULL),
(244, 168, 'Usman Hussain', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '700.00', 'Quetta - Sariab Road', '8 years', '2026-06-15 11:28:50', 'Active', NULL),
(245, 169, 'Waseem Sheikh', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3142.00', 'Quetta - Sariab Road', '10 years', '2026-06-15 11:28:50', 'Active', NULL),
(246, 170, 'Ahsan Qureshi', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1629.00', 'Sheikhupura - Sheikhupura City', '2 years', '2026-06-15 11:28:50', 'Active', NULL);
INSERT INTO `addservice` (`serviceprovider_id`, `service_id`, `serviceprovider_name`, `service_name`, `service_description`, `started_at`, `city`, `experience`, `created_at`, `status`, `category`) VALUES
(247, 171, 'Bilal Siddiqui', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2716.00', 'Sheikhupura - Sheikhupura City', '3 years', '2026-06-15 11:28:50', 'Active', NULL),
(248, 172, 'Faisal Mirza', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '887.00', 'Sheikhupura - Sheikhupura City', '4 years', '2026-06-15 11:28:50', 'Active', NULL),
(249, 173, 'Hassan Chaudhry', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3753.00', 'Sheikhupura - Housing Colony', '5 years', '2026-06-15 11:28:50', 'Active', NULL),
(250, 174, 'Imran Butt', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1671.00', 'Sheikhupura - Housing Colony', '6 years', '2026-06-15 11:28:50', 'Active', NULL),
(251, 175, 'Junaid Rana', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2782.00', 'Sheikhupura - Housing Colony', '7 years', '2026-06-15 11:28:50', 'Active', NULL),
(252, 176, 'Kamran Bhatti', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '785.00', 'Sheikhupura - Ghang Road', '8 years', '2026-06-15 11:28:50', 'Active', NULL),
(253, 177, 'Nasir Nawaz', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '1703.00', 'Sheikhupura - Ghang Road', '10 years', '2026-06-15 11:28:50', 'Active', NULL),
(254, 178, 'Omar Dar', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '816.00', 'Sheikhupura - Ghang Road', '2 years', '2026-06-15 11:28:50', 'Active', NULL),
(255, 179, 'Rizwan Gill', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '2565.00', 'Sheikhupura - Bhikhi Road', '3 years', '2026-06-15 11:28:50', 'Active', NULL),
(256, 180, 'Shahid Javed', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1715.00', 'Sheikhupura - Bhikhi Road', '4 years', '2026-06-15 11:28:50', 'Active', NULL),
(257, 181, 'Tariq Latif', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '2865.00', 'Sheikhupura - Bhikhi Road', '5 years', '2026-06-15 11:28:50', 'Active', NULL),
(258, 182, 'Waqas Mehmood', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '884.00', 'Farooqabad - Farooqabad City', '6 years', '2026-06-15 11:28:50', 'Active', NULL),
(259, 183, 'Yasir Niazi', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1250.00', 'Farooqabad - Farooqabad City', '7 years', '2026-06-15 11:28:50', 'Active', NULL),
(260, 184, 'Zubair Paracha', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1341.00', 'Farooqabad - Farooqabad City', '8 years', '2026-06-15 11:28:50', 'Active', NULL),
(261, 185, 'Adnan Raja', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '2664.00', 'Farooqabad - GT Road', '10 years', '2026-06-15 11:28:50', 'Active', NULL),
(262, 186, 'Danish Saeed', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '964.00', 'Farooqabad - GT Road', '2 years', '2026-06-15 11:28:50', 'Active', NULL),
(263, 187, 'Fahad Tanveer', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1316.00', 'Farooqabad - GT Road', '3 years', '2026-06-15 11:28:50', 'Active', NULL),
(264, 188, 'Ghulam Ullah', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1483.00', 'Farooqabad - Railway Road', '4 years', '2026-06-15 11:28:50', 'Active', NULL),
(265, 189, 'Hamid Virk', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '2648.00', 'Farooqabad - Railway Road', '5 years', '2026-06-15 11:28:50', 'Active', NULL),
(266, 190, 'Irfan Warraich', 'Home Painting', 'Professional home painting service including wall preparation, premium paint application, and smooth finishing. Interior and exterior work available across all room types.', '1862.00', 'Farooqabad - Railway Road', '6 years', '2026-06-15 11:28:50', 'Active', NULL),
(267, 191, 'Khalid Yousaf', 'Floor Tiling', 'Expert floor and wall tiling service using high-quality tiles. Includes surface leveling, precise cutting, grouting, and polishing for a flawless finish.', '1405.00', 'Farooqabad - New Town', '7 years', '2026-06-15 11:28:50', 'Active', NULL),
(268, 192, 'Luqman Zahid', 'Wallpaper Installation', 'Professional wallpaper installation for all wall types. We handle measurement, surface prep, precise cutting, and bubble-free application of imported and local wallpapers.', '1575.00', 'Farooqabad - New Town', '8 years', '2026-06-15 11:28:50', 'Active', NULL),
(269, 193, 'Mohsin Khan', 'Wall Panels Installation', 'Modern wall panel installation including 3D panels, wooden panels, PVC panels, and decorative cladding. Perfect for feature walls and premium interior looks.', '3047.00', 'Farooqabad - New Town', '10 years', '2026-06-15 11:28:50', 'Active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$e7QP40Wmal8dRydUnANjs.acdtiEUznw7mNXr4Sb5A3Wa5fj/gwNe');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `booking_date` date NOT NULL,
  `address` varchar(500) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `map_link` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `user_id`, `provider_id`, `service_id`, `service_name`, `booking_date`, `address`, `status`, `created_at`, `latitude`, `longitude`, `map_link`) VALUES
(6, 120, 111, 41, 'NameTile Fitting & Installation', '2026-06-09', 'bheiki road', 'Pending', '2026-06-08 06:48:56', NULL, NULL, NULL),
(7, 120, 112, 42, 'Tile Fitting & Installation', '2026-06-08', 'bheki road', 'Pending', '2026-06-08 07:17:29', NULL, NULL, NULL),
(8, 121, 111, 41, 'NameTile Fitting & Installation', '2026-06-09', 'bheiki road', 'Pending', '2026-06-08 08:58:25', NULL, NULL, NULL),
(9, 121, 112, 42, 'Tile Fitting & Installation', '2026-06-09', 'bheikorroD', 'Pending', '2026-06-08 09:21:57', NULL, NULL, NULL),
(10, 121, 114, 44, 'Tile Fitting & Installation', '2026-06-09', 'snjs', 'Pending', '2026-06-08 10:51:12', NULL, NULL, NULL),
(11, 121, 111, 41, 'NameTile Fitting & Installation', '2026-06-10', 'knsa ', 'Pending', '2026-06-08 11:40:46', NULL, NULL, NULL),
(12, 121, 114, 44, 'Tile Fitting & Installation', '2026-06-11', 'kcsnjak', 'Pending', '2026-06-09 05:21:46', NULL, NULL, NULL),
(13, 271, 267, 191, 'Floor Tiling', '2026-07-15', 'bhekhi road skp', 'Pending', '2026-07-03 11:29:51', '31.712796237046202', '73.97486043840709', 'https://www.google.com/maps?q=31.712796237046202,73.97486043840709'),
(14, 271, 267, 191, 'Floor Tiling', '2026-07-15', 'bhekhi road skp', 'Pending', '2026-07-03 11:29:55', '31.712796237046202', '73.97486043840709', 'https://www.google.com/maps?q=31.712796237046202,73.97486043840709'),
(15, 271, 267, 191, 'Floor Tiling', '2026-07-15', 'bhekhi road skp', 'Pending', '2026-07-03 11:29:59', '31.712796237046202', '73.97486043840709', 'https://www.google.com/maps?q=31.712796237046202,73.97486043840709'),
(16, 271, 246, 170, 'Home Painting', '2026-07-14', 'bheki road skp', 'Pending', '2026-07-03 12:24:54', NULL, NULL, NULL),
(17, 271, 269, 193, 'Wall Panels Installation', '2026-12-07', 'bhekhi road skp', 'Accepted', '2026-07-03 12:27:47', '31.71279418148905', '73.97485538768446', 'https://www.google.com/maps?q=31.71279418148905,73.97485538768446'),
(18, 271, 267, 191, 'Floor Tiling', '2026-07-13', 'bhekhi road skp', 'Pending', '2026-07-03 12:36:16', NULL, NULL, NULL),
(19, 277, 256, 180, 'Wallpaper Installation', '2026-09-17', 'bhikhi road Allah hu chock sheikupura', 'Pending', '2026-09-11 06:42:18', '31.694409631812487', '73.97048657926582', 'https://www.google.com/maps?q=31.694409631812487,73.97048657926582'),
(20, 277, 256, 180, 'Wallpaper Installation', '2026-09-17', 'bhikhi road Allah hu chock sheikupura', 'Pending', '2026-09-11 06:51:27', NULL, NULL, NULL),
(21, 277, 256, 180, 'Wallpaper Installation', '2026-09-17', 'bhikhi road Allah hu chock sheikupura', 'Pending', '2026-09-11 06:51:28', NULL, NULL, NULL),
(22, 277, 136, 60, 'Wallpaper Installation', '2026-10-19', 'bahria town lahore', 'Accepted', '2026-09-11 06:54:11', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(2, 95, 49, 1, '2026-04-01 07:56:30'),
(3, 98, 56, 1, '2026-04-01 15:01:42'),
(9, 102, 58, 1, '2026-05-06 10:43:57'),
(12, 103, 59, 2, '2026-05-08 10:28:47'),
(15, 101, 61, 3, '2026-05-12 04:32:03'),
(16, 101, 59, 1, '2026-05-12 04:34:52'),
(17, 104, 89, 1, '2026-05-21 11:26:07'),
(18, 122, 89, 2, '2026-06-09 10:59:28'),
(25, 273, 98, 5, '2026-07-09 13:20:39'),
(27, 274, 101, 1, '2026-07-23 14:05:06'),
(31, 272, 250, 1, '2026-08-28 10:04:14');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'product',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `item_id`, `type`, `created_at`) VALUES
(1, 122, 89, '', '2026-06-09 11:22:03'),
(2, 273, 98, '', '2026-07-09 13:20:49'),
(3, 274, 99, '', '2026-07-23 14:07:14'),
(4, 272, 98, 'product', '2026-07-25 04:31:59'),
(5, 274, 98, 'product', '2026-07-25 04:33:37');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subscribed_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(4) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `provider_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `seller_id`, `message`, `is_read`, `created_at`, `provider_id`, `user_id`, `admin_id`) VALUES
(1, 101, '🛒 New order for \'tiles\' — Ordered: 1 — Remaining stock: 49', 0, '2026-05-08 11:15:27', NULL, NULL, NULL),
(2, 103, '🛒 New order for \'wood wallpaper\' — Ordered: 1 — Remaining stock: 39', 0, '2026-05-08 11:58:15', NULL, NULL, NULL),
(3, 270, 'Your product \"tiles\" was rejected. Reason: Title does not clearly describe the product', 1, '2026-07-02 22:39:38', NULL, NULL, NULL),
(4, 270, 'Your product \"tiles\" has been approved.', 1, '2026-07-03 09:51:40', NULL, NULL, NULL),
(5, 270, '🛒 New order for \'tiles\' — Ordered: 10 — Remaining stock: 20', 0, '2026-07-03 10:23:53', NULL, NULL, NULL),
(6, 270, '🛒 New order for \'wood wallpaper\' — Ordered: 6 — Remaining stock: 444', 0, '2026-07-03 10:25:13', NULL, NULL, NULL),
(7, 0, 'New booking for \"Home Painting\" from Eman Fatima on 2026-07-14.', 0, '2026-07-03 17:24:54', 246, NULL, NULL),
(8, 0, 'New booking for \"Wall Panels Installation\" from Eman Fatima on 2026-12-07.', 1, '2026-07-03 17:27:47', 269, NULL, NULL),
(9, 0, 'New booking for \"Floor Tiling\" from Eman Fatima on 2026-07-13.', 0, '2026-07-03 17:36:16', 267, NULL, NULL),
(10, 272, 'Your product \"tiles\" has been approved.', 0, '2026-07-09 12:46:27', NULL, NULL, NULL),
(11, 272, '🛒 New order for \'tiles\' — Ordered: 1 — Remaining stock: 39', 1, '2026-07-09 12:48:09', NULL, NULL, NULL),
(12, 0, 'Your order for \"tiles\" is now: pending', 0, '2026-07-09 15:00:11', NULL, 271, NULL),
(13, 0, 'Your order for \"tiles\" is now: pending', 0, '2026-07-09 15:00:12', NULL, 271, NULL),
(14, 0, 'Your order for \"tiles\" is now: pending', 0, '2026-07-09 15:00:13', NULL, 271, NULL),
(15, 0, 'Your order for \"tiles\" is now: confirmed', 0, '2026-07-09 15:00:25', NULL, 271, NULL),
(16, 272, 'New product \"tiles\" submitted by seller (ID: 272) - pending approval', 1, '2026-07-09 15:16:33', NULL, NULL, 1),
(17, 272, 'New product \"wallpaper\" submitted by seller (ID: 272) - pending approval', 0, '2026-07-23 06:04:30', NULL, NULL, 1),
(18, 272, 'Your product \"wallpaper\" has been approved.', 0, '2026-07-23 06:04:48', NULL, NULL, NULL),
(19, 272, 'ðŸ›’ New order for \'wallpaper\' â€” Ordered: 10 â€” Remaining stock: 990', 0, '2026-07-23 06:56:38', NULL, NULL, NULL),
(20, 275, 'ðŸ’³ New PAID (Safepay) order for \'Wood Panel 6\' â€” Ordered: 2 â€” Remaining stock: 48', 0, '2026-08-28 04:32:09', NULL, NULL, NULL),
(21, 273, 'ðŸ’³ New PAID (Safepay) order for \'Grey Granite Tile 3\' â€” Ordered: 1 â€” Remaining stock: 49', 0, '2026-08-28 04:32:11', NULL, NULL, NULL),
(22, 273, 'ðŸ’³ New PAID (Safepay) order for \'Limestone Tile 3\' â€” Ordered: 1 â€” Remaining stock: 49', 0, '2026-08-28 04:32:15', NULL, NULL, NULL),
(23, 275, 'ðŸ’³ New PAID (Safepay) order for \'Wood Panel 3\' â€” Ordered: 1 â€” Remaining stock: 49', 0, '2026-08-28 04:40:58', NULL, NULL, NULL),
(24, 0, 'New booking for \"Wallpaper Installation\" from emu on 2026-09-17.', 0, '2026-09-10 23:42:18', 256, NULL, NULL),
(25, 0, 'New booking for \"Wallpaper Installation\" from emu on 2026-09-17.', 0, '2026-09-10 23:51:27', 256, NULL, NULL),
(26, 0, 'New booking for \"Wallpaper Installation\" from emu on 2026-09-17.', 0, '2026-09-10 23:51:28', 256, NULL, NULL),
(27, 0, 'New booking for \"Wallpaper Installation\" from emu on 2026-10-19.', 1, '2026-09-10 23:54:11', 136, NULL, NULL),
(28, 0, 'Your service booking #22 has been Accepted', 0, '2026-09-11 00:16:01', NULL, 277, NULL),
(29, 272, 'ðŸ’³ New PAID (Safepay) order for \'Premium Red Wall Paint\' â€” Ordered: 2 â€” Remaining stock: 18', 0, '2026-09-12 00:30:52', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `payment_method` varchar(20) NOT NULL DEFAULT 'cod',
  `payment_status` varchar(20) NOT NULL DEFAULT 'unpaid',
  `transaction_ref` varchar(100) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `amount`, `status`, `created_at`, `name`, `phone`, `address`, `city`, `payment_method`, `payment_status`, `transaction_ref`, `quantity`) VALUES
(1, 99, 56, '1045.00', 'pending', '2026-05-05 11:27:03', 'testing cart', '03034907951', 'Bhikhi road skp', 'Sheikhupura', 'cod', 'unpaid', NULL, 5),
(2, 101, 58, '776.00', 'pending', '2026-05-05 19:04:11', 'testseller1', '03034907951', 'Bhikhi road skp', 'Sheikhupura', 'cod', 'unpaid', NULL, 2),
(3, 101, 58, '388.00', 'pending', '2026-05-05 19:29:45', 'testseller1', '03034907951', 'Bhikhi road skp', 'Sheikhupura', 'cod', 'unpaid', NULL, 1),
(4, 101, 58, '388.00', 'pending', '2026-05-05 19:42:18', 'testseller1', '03034907951', 'Bhikhi road skp', 'Sheikhupura', 'cod', 'unpaid', NULL, 1),
(5, 100, 58, '388.00', 'pending', '2026-05-08 06:15:25', 'sellertest', '03034907951', 'Bhikhi road skp', 'Sheikhupura', 'cod', 'unpaid', NULL, 1),
(6, 103, 59, '475.00', 'pending', '2026-05-08 06:58:11', 'eman', '03034907951', 'Bhikhi road skp', 'Sheikhupura', 'cod', 'unpaid', NULL, 1),
(7, 1, 98, '32300.00', 'pending', '2026-07-03 05:23:44', 'Eman Fatima', '03034907951', 'Bhikhi road skp', 'Sheikhupura', 'jazzcash', 'unpaid', NULL, 10),
(8, 1, 96, '2160.00', 'pending', '2026-07-03 05:25:09', 'Eman Fatima', '03034907951', 'Bhikhi road skp', 'Sheikhupura', 'jazzcash', 'unpaid', NULL, 6),
(9, 271, 99, '288.00', 'confirmed', '2026-07-09 07:48:05', 'Eman Fatima', '03034907951', 'Bhikhi road skp', 'Sheikhupura', 'jazzcash', 'unpaid', NULL, 1),
(10, 274, 101, '3150.00', 'pending', '2026-07-23 13:56:38', 'fatima', '03034907951', 'Bhaki road skp', 'skp', 'jazzcash', 'unpaid', NULL, 10),
(11, 276, 339, '1100.00', 'confirmed', '2026-08-28 11:32:07', 'eman', '03034907951', 'Bhaki road skp', 'skp', 'safepay', 'paid', 'track_815e4b61-f72a-4d86-bfab-13c9dfa99e84', 2),
(12, 276, 247, '480.00', 'confirmed', '2026-08-28 11:32:09', 'eman', '03034907951', 'Bhaki road skp', 'skp', 'safepay', 'paid', 'track_815e4b61-f72a-4d86-bfab-13c9dfa99e84', 1),
(13, 276, 250, '300.00', 'confirmed', '2026-08-28 11:32:11', 'eman', '03034907951', 'Bhaki road skp', 'skp', 'safepay', 'paid', 'track_815e4b61-f72a-4d86-bfab-13c9dfa99e84', 1),
(14, 276, 336, '550.00', 'confirmed', '2026-08-28 11:40:56', 'back', '03034907951', 'Bhaki road skp', 'skp', 'safepay', 'paid', 'track_b56b7adf-2e06-4b41-9823-cd13d5950365', 1),
(15, 273, 247, '450.00', 'delivered', '2026-09-11 08:08:54', 'menak', '03034907951', 'Bhikhi road skp', 'Sheikhupura', 'cod', 'paid', NULL, 1),
(16, 276, 247, '450.00', 'delivered', '2026-09-11 08:08:54', 'back', '03034907951', 'Bhaki road skp', 'skp', 'cod', 'paid', NULL, 1),
(17, 274, 250, '350.00', 'delivered', '2026-09-11 08:08:54', 'fatima', '03034907951', 'Bhaki road skp', 'skp', 'cod', 'paid', NULL, 1),
(18, 273, 336, '1800.00', 'delivered', '2026-09-11 08:08:54', 'menak', '03034907951', 'Bhikhi road skp', 'Sheikhupura', 'cod', 'paid', NULL, 1),
(19, 274, 279, '2800.00', 'delivered', '2026-09-11 08:08:54', 'fatima', '03034907951', 'Bhaki road skp', 'skp', 'cod', 'paid', NULL, 1),
(20, 277, 344, '5000.00', 'confirmed', '2026-09-12 07:30:51', 'Eman Fatima', '03034907951', 'Bhikhi road skp', 'Sheikhupura', 'safepay', 'paid', 'track_19162a11-eb7c-4321-9e50-91d665ce0186', 2);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tracker_token` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'PKR',
  `status` varchar(30) NOT NULL DEFAULT 'initiated',
  `raw_response` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `tracker_token`, `amount`, `currency`, `status`, `raw_response`, `created_at`, `updated_at`) VALUES
(1, 276, 'track_35328277-105f-4b78-8b7c-454f7646682c', '1100.00', 'PKR', 'initiated', '{\"data\":{\"id\":0,\"token\":\"track_35328277-105f-4b78-8b7c-454f7646682c\",\"user_id\":\"\",\"billing\":\"\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"amount\":1100,\"discount\":0,\"currency\":\"PKR\",\"intent\":\"\",\"default_currency\":\"PKR\",\"conversion_rate\":1,\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"state_reason\":\"\",\"created_at\":\"2026-08-27T13:26:03.386058953Z\",\"updated_at\":\"2026-08-27T13:26:03.386067284Z\",\"transaction\":null,\"dynamic_currency_conversion\":null,\"metadata\":null,\"automatic_currency_conversion\":false},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-27 13:26:02', '2026-08-27 13:26:02'),
(2, 276, 'track_9e8d07e9-d338-4ddf-9978-0b3f1e38a552', '1100.00', 'PKR', 'initiated', '{\"data\":{\"id\":0,\"token\":\"track_9e8d07e9-d338-4ddf-9978-0b3f1e38a552\",\"user_id\":\"\",\"billing\":\"\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"amount\":1100,\"discount\":0,\"currency\":\"PKR\",\"intent\":\"\",\"default_currency\":\"PKR\",\"conversion_rate\":1,\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"state_reason\":\"\",\"created_at\":\"2026-08-27T13:26:05.099927693Z\",\"updated_at\":\"2026-08-27T13:26:05.099934133Z\",\"transaction\":null,\"dynamic_currency_conversion\":null,\"metadata\":null,\"automatic_currency_conversion\":false},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-27 13:26:04', '2026-08-27 13:26:04'),
(3, 276, 'track_4571ebe3-c868-4784-92e9-48c0d34c40a5', '1100.00', 'PKR', 'initiated', '{\"data\":{\"id\":0,\"token\":\"track_4571ebe3-c868-4784-92e9-48c0d34c40a5\",\"user_id\":\"\",\"billing\":\"\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"amount\":1100,\"discount\":0,\"currency\":\"PKR\",\"intent\":\"\",\"default_currency\":\"PKR\",\"conversion_rate\":1,\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"state_reason\":\"\",\"created_at\":\"2026-08-27T13:26:07.327635898Z\",\"updated_at\":\"2026-08-27T13:26:07.327644598Z\",\"transaction\":null,\"dynamic_currency_conversion\":null,\"metadata\":null,\"automatic_currency_conversion\":false},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-27 13:26:06', '2026-08-27 13:26:06'),
(4, 276, 'track_fd964620-f652-4502-be7c-cf3bd873cbbe', '1100.00', 'PKR', 'initiated', '{\"data\":{\"id\":0,\"token\":\"track_fd964620-f652-4502-be7c-cf3bd873cbbe\",\"user_id\":\"\",\"billing\":\"\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"amount\":1100,\"discount\":0,\"currency\":\"PKR\",\"intent\":\"\",\"default_currency\":\"PKR\",\"conversion_rate\":1,\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"state_reason\":\"\",\"created_at\":\"2026-08-27T13:26:07.562164632Z\",\"updated_at\":\"2026-08-27T13:26:07.562171843Z\",\"transaction\":null,\"dynamic_currency_conversion\":null,\"metadata\":null,\"automatic_currency_conversion\":false},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-27 13:26:07', '2026-08-27 13:26:07'),
(5, 276, 'track_d6c1f103-66dc-4581-aa46-c518de5c5799', '1100.00', 'PKR', 'initiated', '{\"data\":{\"id\":0,\"token\":\"track_d6c1f103-66dc-4581-aa46-c518de5c5799\",\"user_id\":\"\",\"billing\":\"\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"amount\":1100,\"discount\":0,\"currency\":\"PKR\",\"intent\":\"\",\"default_currency\":\"PKR\",\"conversion_rate\":1,\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"state_reason\":\"\",\"created_at\":\"2026-08-27T13:29:19.852581284Z\",\"updated_at\":\"2026-08-27T13:29:19.852590594Z\",\"transaction\":null,\"dynamic_currency_conversion\":null,\"metadata\":null,\"automatic_currency_conversion\":false},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-27 13:29:19', '2026-08-27 13:29:19'),
(6, 276, 'track_45e830ab-c159-4484-9d11-e3a5ad8d62c4', '1100.00', 'PKR', 'initiated', '{\"data\":{\"id\":0,\"token\":\"track_45e830ab-c159-4484-9d11-e3a5ad8d62c4\",\"user_id\":\"\",\"billing\":\"\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"amount\":1100,\"discount\":0,\"currency\":\"PKR\",\"intent\":\"\",\"default_currency\":\"PKR\",\"conversion_rate\":1,\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"state_reason\":\"\",\"created_at\":\"2026-08-27T13:35:52.883640132Z\",\"updated_at\":\"2026-08-27T13:35:52.883646712Z\",\"transaction\":null,\"dynamic_currency_conversion\":null,\"metadata\":null,\"automatic_currency_conversion\":false},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-27 13:35:52', '2026-08-27 13:35:52'),
(7, 276, 'track_04b57e86-91b0-4ed2-b0ee-b86965a59af1', '1580.00', 'PKR', 'initiated', '{\"data\":{\"id\":0,\"token\":\"track_04b57e86-91b0-4ed2-b0ee-b86965a59af1\",\"user_id\":\"\",\"billing\":\"\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"amount\":1580,\"discount\":0,\"currency\":\"PKR\",\"intent\":\"\",\"default_currency\":\"PKR\",\"conversion_rate\":1,\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"state_reason\":\"\",\"created_at\":\"2026-08-27T13:37:18.513004226Z\",\"updated_at\":\"2026-08-27T13:37:18.513013447Z\",\"transaction\":null,\"dynamic_currency_conversion\":null,\"metadata\":null,\"automatic_currency_conversion\":false},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-27 13:37:18', '2026-08-27 13:37:18'),
(8, 276, 'track_10bb8993-9c2d-469b-ba98-b6b19b344167', '1580.00', 'PKR', 'initiated', '{\"data\":{\"id\":0,\"token\":\"track_10bb8993-9c2d-469b-ba98-b6b19b344167\",\"user_id\":\"\",\"billing\":\"\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"amount\":1580,\"discount\":0,\"currency\":\"PKR\",\"intent\":\"\",\"default_currency\":\"PKR\",\"conversion_rate\":1,\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"state_reason\":\"\",\"created_at\":\"2026-08-27T13:40:32.704646398Z\",\"updated_at\":\"2026-08-27T13:40:32.704656748Z\",\"transaction\":null,\"dynamic_currency_conversion\":null,\"metadata\":null,\"automatic_currency_conversion\":false},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-27 13:40:32', '2026-08-27 13:40:32'),
(9, 276, 'track_e1835653-b89d-4a39-98bc-3dca874ed61f', '1580.00', 'PKR', 'initiated', '{\"data\":{\"id\":0,\"token\":\"track_e1835653-b89d-4a39-98bc-3dca874ed61f\",\"user_id\":\"\",\"billing\":\"\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"amount\":1580,\"discount\":0,\"currency\":\"PKR\",\"intent\":\"\",\"default_currency\":\"PKR\",\"conversion_rate\":1,\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"state_reason\":\"\",\"created_at\":\"2026-08-27T13:48:42.948821414Z\",\"updated_at\":\"2026-08-27T13:48:42.948827944Z\",\"transaction\":null,\"dynamic_currency_conversion\":null,\"metadata\":null,\"automatic_currency_conversion\":false},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-27 13:48:42', '2026-08-27 13:48:42'),
(10, 276, 'track_319c4ae4-f9d9-4a26-9e1e-175f4a46efb0', '1880.00', 'PKR', 'initiated', '{\"data\":{\"tracker\":{\"token\":\"track_319c4ae4-f9d9-4a26-9e1e-175f4a46efb0\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"payment_method_kind\":\"card\",\"intent\":\"CYBERSOURCE\",\"mode\":\"payment\",\"entry_mode\":\"flex\",\"next_actions\":{\"CYBERSOURCE\":{\"kind\":\"GENERATE_CAPTURE_CONTEXT\"},\"MPGS\":{\"kind\":\"NOOP\"},\"PAYFAST\":{\"kind\":\"NOOP\"},\"RAAST\":{\"kind\":\"NOOP\"}},\"purchase_totals\":{\"quote_amount\":{\"currency\":\"PKR\",\"amount\":188000},\"base_amount\":{\"currency\":\"PKR\",\"amount\":188000},\"conversion_rate\":{\"base_currency\":\"PKR\",\"quote_currency\":\"PKR\",\"rate\":1}},\"metadata\":{}},\"capabilities\":{\"CYBERSOURCE\":true,\"MPGS\":true,\"PAYFAST\":true,\"RAAST\":true}},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-28 10:00:03', '2026-08-28 10:00:03'),
(11, 276, 'track_dadf930a-b6b8-447f-ad25-9c1a90699faa', '1880.00', 'PKR', 'initiated', '{\"data\":{\"tracker\":{\"token\":\"track_dadf930a-b6b8-447f-ad25-9c1a90699faa\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"payment_method_kind\":\"card\",\"intent\":\"CYBERSOURCE\",\"mode\":\"payment\",\"entry_mode\":\"flex\",\"next_actions\":{\"CYBERSOURCE\":{\"kind\":\"GENERATE_CAPTURE_CONTEXT\"},\"MPGS\":{\"kind\":\"NOOP\"},\"PAYFAST\":{\"kind\":\"NOOP\"},\"RAAST\":{\"kind\":\"NOOP\"}},\"purchase_totals\":{\"quote_amount\":{\"currency\":\"PKR\",\"amount\":188000},\"base_amount\":{\"currency\":\"PKR\",\"amount\":188000},\"conversion_rate\":{\"base_currency\":\"PKR\",\"quote_currency\":\"PKR\",\"rate\":1}},\"metadata\":{}},\"capabilities\":{\"CYBERSOURCE\":true,\"MPGS\":true,\"PAYFAST\":true,\"RAAST\":true}},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-28 10:01:37', '2026-08-28 10:01:37'),
(12, 276, 'track_74b498e6-4c43-472d-8efa-734a2a40879d', '1880.00', 'PKR', 'initiated', '{\"data\":{\"tracker\":{\"token\":\"track_74b498e6-4c43-472d-8efa-734a2a40879d\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"payment_method_kind\":\"card\",\"intent\":\"CYBERSOURCE\",\"mode\":\"payment\",\"entry_mode\":\"flex\",\"next_actions\":{\"CYBERSOURCE\":{\"kind\":\"GENERATE_CAPTURE_CONTEXT\"},\"MPGS\":{\"kind\":\"NOOP\"},\"PAYFAST\":{\"kind\":\"NOOP\"},\"RAAST\":{\"kind\":\"NOOP\"}},\"purchase_totals\":{\"quote_amount\":{\"currency\":\"PKR\",\"amount\":188000},\"base_amount\":{\"currency\":\"PKR\",\"amount\":188000},\"conversion_rate\":{\"base_currency\":\"PKR\",\"quote_currency\":\"PKR\",\"rate\":1}},\"metadata\":{}},\"capabilities\":{\"CYBERSOURCE\":true,\"MPGS\":true,\"PAYFAST\":true,\"RAAST\":true}},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-28 10:01:54', '2026-08-28 10:01:54'),
(13, 272, 'track_acd8fb41-c7a9-4d5d-b5ed-1d5ba510ba12', '300.00', 'PKR', 'initiated', '{\"data\":{\"tracker\":{\"token\":\"track_acd8fb41-c7a9-4d5d-b5ed-1d5ba510ba12\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"payment_method_kind\":\"card\",\"intent\":\"CYBERSOURCE\",\"mode\":\"payment\",\"entry_mode\":\"flex\",\"next_actions\":{\"CYBERSOURCE\":{\"kind\":\"GENERATE_CAPTURE_CONTEXT\"},\"MPGS\":{\"kind\":\"NOOP\"},\"PAYFAST\":{\"kind\":\"NOOP\"},\"RAAST\":{\"kind\":\"NOOP\"}},\"purchase_totals\":{\"quote_amount\":{\"currency\":\"PKR\",\"amount\":30000},\"base_amount\":{\"currency\":\"PKR\",\"amount\":30000},\"conversion_rate\":{\"base_currency\":\"PKR\",\"quote_currency\":\"PKR\",\"rate\":1}},\"metadata\":{}},\"capabilities\":{\"CYBERSOURCE\":true,\"MPGS\":true,\"PAYFAST\":true,\"RAAST\":true}},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-28 10:04:39', '2026-08-28 10:04:39'),
(14, 276, 'track_a6398158-677b-44ef-8beb-cfce7b7b6ab0', '1880.00', 'PKR', 'initiated', '{\"data\":{\"tracker\":{\"token\":\"track_a6398158-677b-44ef-8beb-cfce7b7b6ab0\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"payment_method_kind\":\"card\",\"intent\":\"CYBERSOURCE\",\"mode\":\"payment\",\"entry_mode\":\"raw\",\"next_actions\":{\"CYBERSOURCE\":{\"kind\":\"PAYER_AUTH_SETUP\"},\"MPGS\":{\"kind\":\"CREATE_SESSION\"},\"PAYFAST\":{\"kind\":\"CUSTOMER_VALIDATE\"},\"RAAST\":{\"kind\":\"CREATE_RAAST_PAYMENT\"}},\"purchase_totals\":{\"quote_amount\":{\"currency\":\"PKR\",\"amount\":188000},\"base_amount\":{\"currency\":\"PKR\",\"amount\":188000},\"conversion_rate\":{\"base_currency\":\"PKR\",\"quote_currency\":\"PKR\",\"rate\":1}},\"metadata\":{}},\"capabilities\":{\"CYBERSOURCE\":true,\"MPGS\":true,\"PAYFAST\":true,\"RAAST\":true}},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-28 10:08:33', '2026-08-28 10:08:33'),
(15, 276, 'track_781c82bf-4ff7-4f9a-aa60-026c954cf75e', '1880.00', 'PKR', 'initiated', '{\"data\":{\"tracker\":{\"token\":\"track_781c82bf-4ff7-4f9a-aa60-026c954cf75e\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"payment_method_kind\":\"card\",\"intent\":\"CYBERSOURCE\",\"mode\":\"payment\",\"entry_mode\":\"raw\",\"next_actions\":{\"CYBERSOURCE\":{\"kind\":\"PAYER_AUTH_SETUP\"},\"MPGS\":{\"kind\":\"CREATE_SESSION\"},\"PAYFAST\":{\"kind\":\"CUSTOMER_VALIDATE\"},\"RAAST\":{\"kind\":\"CREATE_RAAST_PAYMENT\"}},\"purchase_totals\":{\"quote_amount\":{\"currency\":\"PKR\",\"amount\":188000},\"base_amount\":{\"currency\":\"PKR\",\"amount\":188000},\"conversion_rate\":{\"base_currency\":\"PKR\",\"quote_currency\":\"PKR\",\"rate\":1}},\"metadata\":{}},\"capabilities\":{\"CYBERSOURCE\":true,\"MPGS\":true,\"PAYFAST\":true,\"RAAST\":true}},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-28 10:13:38', '2026-08-28 10:13:38'),
(16, 276, 'track_3aed0360-0404-4889-ba46-2a8ae4960afc', '1880.00', 'PKR', 'initiated', '{\"data\":{\"tracker\":{\"token\":\"track_3aed0360-0404-4889-ba46-2a8ae4960afc\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"payment_method_kind\":\"card\",\"intent\":\"CYBERSOURCE\",\"mode\":\"payment\",\"entry_mode\":\"raw\",\"next_actions\":{\"CYBERSOURCE\":{\"kind\":\"PAYER_AUTH_SETUP\"},\"MPGS\":{\"kind\":\"CREATE_SESSION\"},\"PAYFAST\":{\"kind\":\"CUSTOMER_VALIDATE\"},\"RAAST\":{\"kind\":\"CREATE_RAAST_PAYMENT\"}},\"purchase_totals\":{\"quote_amount\":{\"currency\":\"PKR\",\"amount\":188000},\"base_amount\":{\"currency\":\"PKR\",\"amount\":188000},\"conversion_rate\":{\"base_currency\":\"PKR\",\"quote_currency\":\"PKR\",\"rate\":1}},\"metadata\":{}},\"capabilities\":{\"CYBERSOURCE\":true,\"MPGS\":true,\"PAYFAST\":true,\"RAAST\":true}},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-28 11:10:31', '2026-08-28 11:10:31'),
(17, 276, 'track_9fc7520d-ef5d-46e6-bdbe-9423fbc7e4e1', '1880.00', 'PKR', 'unconfirmed', '{\"code\":\"error.unauthorized_access\",\"message\":\"strategies/union: [strategies/jwt_client: token is malformed, strategies/jwt_user: token is malformed, strategies/jwt_user_v2: token is malformed, strategies/secret: merchant webhook secret not found in the request header, strategies/tbt: invalid token, expected delimiter \':\' not found, strategies/jwt_admin: token inactive, could not find email key against token]\"}\n', '2026-08-28 11:14:39', '2026-08-28 11:19:21'),
(18, 276, 'track_1a3e1b7b-0c3d-44ea-992c-232be9526f69', '1880.00', 'PKR', 'unconfirmed', '{\"code\":\"error.unauthorized_access\",\"message\":\"strategies/union: [strategies/jwt_client: token is malformed, strategies/jwt_user: token is malformed, strategies/jwt_user_v2: token is malformed, strategies/secret: merchant webhook secret not found in the request header, strategies/tbt: invalid token, expected delimiter \':\' not found, strategies/jwt_admin: token inactive, could not find email key against token]\"}\n', '2026-08-28 11:22:05', '2026-08-28 11:23:28');
INSERT INTO `payments` (`id`, `user_id`, `tracker_token`, `amount`, `currency`, `status`, `raw_response`, `created_at`, `updated_at`) VALUES
(19, 276, 'track_815e4b61-f72a-4d86-bfab-13c9dfa99e84', '1880.00', 'PKR', 'paid', '{\"ok\":true,\"data\":{\"token\":\"track_815e4b61-f72a-4d86-bfab-13c9dfa99e84\",\"environment\":\"sandbox\",\"state\":\"TRACKER_ENDED\",\"intent\":\"CYBERSOURCE\",\"mode\":\"payment\",\"entry_mode\":\"raw\",\"client\":{\"token\":\"client_6b206ac8-8e94-4205-a14e-0bd568725534\",\"api_key\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"name\":\"intradecorhome\",\"email\":\"menakfatima2@gmail.com\",\"api_settings\":{}},\"customer\":{\"token\":\"guest_b0a36620-6303-47ea-a691-6d3f349a26b6\",\"first_name\":\"eman\",\"last_name\":\"eman\",\"email\":\"b96691804@gmail.com\",\"phone\":\"+92 303 4907951\"},\"next_actions\":{\"CYBERSOURCE\":{\"kind\":\"NOOP\",\"request_id\":\"req_e2eb640d-76d3-4cda-bfb8-9ab4822d8506\"},\"MPGS\":{\"kind\":\"CREATE_SESSION\"},\"PAYFAST\":{\"kind\":\"CUSTOMER_VALIDATE\"},\"RAAST\":{\"kind\":\"CREATE_RAAST_PAYMENT\"}},\"purchase_totals\":{\"quote_amount\":{\"currency\":\"PKR\",\"amount\":188000},\"base_amount\":{\"currency\":\"PKR\",\"amount\":188000},\"conversion_rate\":{\"base_currency\":\"PKR\",\"quote_currency\":\"PKR\",\"rate\":1}},\"charge\":{\"token\":\"ch_5c46b736-8f3e-4b2a-9813-0a10468277ad\",\"tracker\":\"track_815e4b61-f72a-4d86-bfab-13c9dfa99e84\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"user\":\"guest_b0a36620-6303-47ea-a691-6d3f349a26b6\",\"amount\":{\"currency\":\"PKR\",\"amount\":188000},\"fees\":{\"currency\":\"PKR\",\"amount\":11910},\"tax\":{\"currency\":\"PKR\",\"amount\":818},\"net\":{\"currency\":\"PKR\",\"amount\":176090},\"signature\":\"835d8f2386a51a88c189ffc01ff25710ca4b49a070723ede2a13ef6ba9e14bc7\",\"capture\":{\"token\":\"cap_8130f3ee-dda5-47fa-9c1c-dc7ecd6550da\",\"tracker\":\"track_815e4b61-f72a-4d86-bfab-13c9dfa99e84\",\"attempt\":\"attemp_df99f728-81e1-46f7-92e5-c717a279f7b2\",\"intent\":\"CYBERSOURCE\",\"cybersource_rid\":\"7879167167106122104805\",\"is_voidable\":true,\"kind\":\"PAYMENT\",\"totals\":{\"currency\":\"PKR\",\"amount\":188000},\"created_at\":{\"seconds\":1787916718},\"updated_at\":{\"seconds\":1787916718}},\"balance\":{\"currency\":\"PKR\",\"amount\":188000},\"created_at\":{\"seconds\":1787916718},\"updated_at\":{\"seconds\":1787916718},\"withholding_tax\":{\"sales_tax_withholding\":{\"currency\":\"PKR\",\"amount\":3760},\"income_tax_withholding\":{\"currency\":\"PKR\",\"amount\":1880},\"digital_presence_tax\":{\"currency\":\"PKR\",\"amount\":0}}},\"events\":[{\"intent\":\"CYBERSOURCE\",\"type\":\"ENROLLMENT\",\"intent_request_id\":\"7879167132576864704806\",\"reason\":\"Successful enrollment\",\"created_at\":{\"seconds\":1787916714}},{\"intent\":\"CYBERSOURCE\",\"type\":\"AUTHORIZATION\",\"intent_request_id\":\"7879167167106122104805\",\"reason\":\"Successful authorization\",\"purchase_totals\":{\"currency\":\"PKR\",\"amount\":188000},\"created_at\":{\"seconds\":1787916718}},{\"intent\":\"CYBERSOURCE\",\"type\":\"CAPTURE\",\"intent_request_id\":\"7879167167106122104805\",\"reason\":\"Successful transaction\",\"purchase_totals\":{\"currency\":\"PKR\",\"amount\":188000},\"created_at\":{\"seconds\":1787916718}}],\"attempts\":[{\"token\":\"attemp_df99f728-81e1-46f7-92e5-c717a279f7b2\",\"tracker\":\"track_815e4b61-f72a-4d86-bfab-13c9dfa99e84\",\"intent\":\"CYBERSOURCE\",\"idempotency_key\":\"req_e2eb640d-76d3-4cda-bfb8-9ab4822d8506\",\"kind\":1,\"actions_performed\":[{\"token\":\"act_870d09c2-9d02-4ff8-886f-2d158852278c\",\"tracker\":\"track_815e4b61-f72a-4d86-bfab-13c9dfa99e84\",\"attempt\":\"attemp_df99f728-81e1-46f7-92e5-c717a279f7b2\",\"kind\":\"PAYER_AUTH_SETUP\",\"created_at\":{\"seconds\":1787916698},\"updated_at\":{\"seconds\":1787916698}},{\"token\":\"act_ccae0bc9-6be0-4397-a86c-979765842a9d\",\"tracker\":\"track_815e4b61-f72a-4d86-bfab-13c9dfa99e84\",\"attempt\":\"attemp_df99f728-81e1-46f7-92e5-c717a279f7b2\",\"kind\":\"PAYER_AUTH_ENROLLMENT\",\"created_at\":{\"seconds\":1787916713},\"updated_at\":{\"seconds\":1787916713}},{\"token\":\"act_83551744-f0a6-4f19-8f04-8a6fe3637f0f\",\"tracker\":\"track_815e4b61-f72a-4d86-bfab-13c9dfa99e84\",\"attempt\":\"attemp_df99f728-81e1-46f7-92e5-c717a279f7b2\",\"kind\":\"AUTHORIZATION\",\"created_at\":{\"seconds\":1787916717},\"updated_at\":{\"seconds\":1787916717}}],\"payment_method\":{\"token\":\"method_260373ab-8c54-4daf-b28c-31f7d3f43c35\",\"tracker\":\"track_815e4b61-f72a-4d86-bfab-13c9dfa99e84\",\"attempt\":\"attemp_df99f728-81e1-46f7-92e5-c717a279f7b2\",\"last_four\":\"1111\",\"kind\":\"CARD\",\"scheme\":\"Visa\",\"issuer\":\"Conotoxia Sp.zo.o.\",\"bin\":\"411111\",\"expiration_month\":\"12\",\"expiration_year\":\"2028\",\"do_card_on_file\":true,\"created_at\":{\"seconds\":1787916699},\"updated_at\":{\"seconds\":1787916699}},\"billing\":{\"token\":\"bill_509afd0f-8741-4a6f-a69b-6c85a9316edf\",\"attempt\":\"attemp_df99f728-81e1-46f7-92e5-c717a279f7b2\",\"street_1\":\"Bhaki road skp\",\"city\":\"skp\",\"country\":\"PK\",\"created_at\":{\"seconds\":1787916714},\"updated_at\":{\"seconds\":1787916714}},\"enrollment\":{\"token\":\"enroll_7cef53cf-a8fd-467d-a20a-a6e293e4a0e0\",\"attempt\":\"attemp_df99f728-81e1-46f7-92e5-c717a279f7b2\",\"cybersource_rid\":\"7879167132576864704806\",\"specification_version\":\"2.2.0\",\"veres_enrolled\":\"Y\",\"eci\":\"05\",\"created_at\":{\"seconds\":1787916714},\"updated_at\":{\"seconds\":1787916714},\"pares_status\":\"Y\",\"authentication_status\":\"FRICTIONLESS\"},\"risk\":{\"token\":\"risk_8351d809-aeb2-48f7-8ad5-0965febd9e28\",\"attempt\":\"attemp_df99f728-81e1-46f7-92e5-c717a279f7b2\",\"score\":\"52\",\"factor_codes\":[\"B\",\"F\",\"N\"],\"info_codes\":[\"MM-BIN\",\"UNV-ADDR\",\"NEG-ASUSP\",\"NEG-CC\",\"NEG-EM\",\"NEG-SUSP\",\"AutoCompleteDetected\",\"VELL-TIP\",\"FREE-EM\",\"NON-FN\",\"RISK-SD\"],\"created_at\":{\"seconds\":1787916718},\"updated_at\":{\"seconds\":1787916718}},\"authorization\":{\"token\":\"auth_5d2c5909-8396-410e-b9df-ab5ec917a7df\",\"tracker\":\"track_815e4b61-f72a-4d86-bfab-13c9dfa99e84\",\"attempt\":\"attemp_df99f728-81e1-46f7-92e5-c717a279f7b2\",\"intent\":\"CYBERSOURCE\",\"cybersource_rid\":\"7879167167106122104805\",\"totals\":{\"currency\":\"PKR\",\"amount\":188000},\"created_at\":{\"seconds\":1787916718},\"updated_at\":{\"seconds\":1787916718}},\"capture\":{\"token\":\"cap_8130f3ee-dda5-47fa-9c1c-dc7ecd6550da\",\"tracker\":\"track_815e4b61-f72a-4d86-bfab-13c9dfa99e84\",\"attempt\":\"attemp_df99f728-81e1-46f7-92e5-c717a279f7b2\",\"intent\":\"CYBERSOURCE\",\"cybersource_rid\":\"7879167167106122104805\",\"is_voidable\":true,\"kind\":\"PAYMENT\",\"totals\":{\"currency\":\"PKR\",\"amount\":188000},\"created_at\":{\"seconds\":1787916718},\"updated_at\":{\"seconds\":1787916718}},\"is_success\":true,\"created_at\":{\"seconds\":1787916698},\"updated_at\":{\"seconds\":1787916718},\"mode\":\"payment\",\"entry_mode\":\"raw\",\"customer\":{\"token\":\"guest_b0a36620-6303-47ea-a691-6d3f349a26b6\",\"first_name\":\"eman\",\"last_name\":\"eman\",\"email\":\"b96691804@gmail.com\",\"phone\":\"+92 303 4907951\"}}],\"location\":{\"tracker\":\"track_815e4b61-f72a-4d86-bfab-13c9dfa99e84\",\"token\":\"loc_b125f7b4-47f4-4943-af78-73da81dbfcb7\",\"ip_address\":\"2402:e000:42b:56f4:1c55:fe62:8ba9:d7a5\",\"city\":\"Lahore\",\"country\":\"PK\",\"latitude\":31.558,\"longitude\":74.35071,\"region\":\"Punjab\",\"created_at\":{\"seconds\":1787916716},\"updated_at\":{\"seconds\":1787916716}},\"device\":{\"tracker\":\"track_815e4b61-f72a-4d86-bfab-13c9dfa99e84\",\"token\":\"dev_89f993e9-34e2-47b1-ac3c-c762afdce0c7\",\"user_agent\":\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36\",\"entity\":\"browser\",\"browser\":\"Chrome\",\"browser_version\":\"151.0.0.0\",\"device_type\":\"desktop\",\"platform\":\"Windows 10\",\"platform_icon\":\"https://assets.userstack.com/icon/os/windows10.png\",\"created_at\":{\"seconds\":1787916717},\"updated_at\":{\"seconds\":1787916717}},\"created_at\":{\"seconds\":1787916652},\"updated_at\":{\"seconds\":1787916718},\"payment_method_kind\":\"card\",\"is_routed\":false}}\n', '2026-08-28 11:30:52', '2026-08-28 11:32:07'),
(20, 276, 'track_b526eda7-6007-4768-9022-5175584fcffd', '550.00', 'PKR', 'initiated', '{\"data\":{\"tracker\":{\"token\":\"track_b526eda7-6007-4768-9022-5175584fcffd\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"environment\":\"sandbox\",\"state\":\"TRACKER_STARTED\",\"payment_method_kind\":\"card\",\"intent\":\"CYBERSOURCE\",\"mode\":\"payment\",\"entry_mode\":\"raw\",\"next_actions\":{\"CYBERSOURCE\":{\"kind\":\"PAYER_AUTH_SETUP\"},\"MPGS\":{\"kind\":\"CREATE_SESSION\"},\"PAYFAST\":{\"kind\":\"CUSTOMER_VALIDATE\"},\"RAAST\":{\"kind\":\"CREATE_RAAST_PAYMENT\"}},\"purchase_totals\":{\"quote_amount\":{\"currency\":\"PKR\",\"amount\":55000},\"base_amount\":{\"currency\":\"PKR\",\"amount\":55000},\"conversion_rate\":{\"base_currency\":\"PKR\",\"quote_currency\":\"PKR\",\"rate\":1}},\"metadata\":{}},\"capabilities\":{\"CYBERSOURCE\":true,\"MPGS\":true,\"PAYFAST\":true,\"RAAST\":true}},\"status\":{\"errors\":[],\"message\":\"success\"}}\n', '2026-08-28 11:34:38', '2026-08-28 11:34:38'),
(21, 276, 'track_b56b7adf-2e06-4b41-9823-cd13d5950365', '550.00', 'PKR', 'paid', '{\"ok\":true,\"data\":{\"token\":\"track_b56b7adf-2e06-4b41-9823-cd13d5950365\",\"environment\":\"sandbox\",\"state\":\"TRACKER_ENDED\",\"intent\":\"CYBERSOURCE\",\"mode\":\"payment\",\"entry_mode\":\"raw\",\"client\":{\"token\":\"client_6b206ac8-8e94-4205-a14e-0bd568725534\",\"api_key\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"name\":\"intradecorhome\",\"email\":\"menakfatima2@gmail.com\",\"api_settings\":{}},\"customer\":{\"token\":\"guest_98a8b942-7f9e-4257-8a8e-727f5a1fefb7\",\"first_name\":\"eman\",\"last_name\":\"eman\",\"email\":\"b96691804@gmail.com\",\"phone\":\"+92 303 4907951\"},\"next_actions\":{\"CYBERSOURCE\":{\"kind\":\"NOOP\",\"request_id\":\"req_38bdeaa8-8449-4861-9234-3ea3af47ca28\"},\"MPGS\":{\"kind\":\"CREATE_SESSION\"},\"PAYFAST\":{\"kind\":\"CUSTOMER_VALIDATE\"},\"RAAST\":{\"kind\":\"CREATE_RAAST_PAYMENT\"}},\"purchase_totals\":{\"quote_amount\":{\"currency\":\"PKR\",\"amount\":55000},\"base_amount\":{\"currency\":\"PKR\",\"amount\":55000},\"conversion_rate\":{\"base_currency\":\"PKR\",\"quote_currency\":\"PKR\",\"rate\":1}},\"charge\":{\"token\":\"ch_b770ea77-99dc-4314-b922-10f081afe8a4\",\"tracker\":\"track_b56b7adf-2e06-4b41-9823-cd13d5950365\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"user\":\"guest_98a8b942-7f9e-4257-8a8e-727f5a1fefb7\",\"amount\":{\"currency\":\"PKR\",\"amount\":55000},\"fees\":{\"currency\":\"PKR\",\"amount\":3484},\"tax\":{\"currency\":\"PKR\",\"amount\":239},\"net\":{\"currency\":\"PKR\",\"amount\":51516},\"signature\":\"bdb7424393f164ad6f4d561576f46ad10718204171f295168a66b89ee17b2d5d\",\"capture\":{\"token\":\"cap_991be35f-5fb8-4722-ace0-115383353826\",\"tracker\":\"track_b56b7adf-2e06-4b41-9823-cd13d5950365\",\"attempt\":\"attemp_3127656c-cf41-4ed9-a15a-344b4f4eec77\",\"intent\":\"CYBERSOURCE\",\"cybersource_rid\":\"7879172478156293204807\",\"is_voidable\":true,\"kind\":\"PAYMENT\",\"totals\":{\"currency\":\"PKR\",\"amount\":55000},\"created_at\":{\"seconds\":1787917249},\"updated_at\":{\"seconds\":1787917249}},\"balance\":{\"currency\":\"PKR\",\"amount\":55000},\"created_at\":{\"seconds\":1787917249},\"updated_at\":{\"seconds\":1787917249},\"withholding_tax\":{\"sales_tax_withholding\":{\"currency\":\"PKR\",\"amount\":1100},\"income_tax_withholding\":{\"currency\":\"PKR\",\"amount\":550},\"digital_presence_tax\":{\"currency\":\"PKR\",\"amount\":0}}},\"events\":[{\"intent\":\"CYBERSOURCE\",\"type\":\"ENROLLMENT\",\"intent_request_id\":\"7879172437826370004806\",\"reason\":\"Successful enrollment\",\"created_at\":{\"seconds\":1787917244}},{\"intent\":\"CYBERSOURCE\",\"type\":\"AUTHORIZATION\",\"intent_request_id\":\"7879172478156293204807\",\"reason\":\"Successful authorization\",\"purchase_totals\":{\"currency\":\"PKR\",\"amount\":55000},\"created_at\":{\"seconds\":1787917249}},{\"intent\":\"CYBERSOURCE\",\"type\":\"CAPTURE\",\"intent_request_id\":\"7879172478156293204807\",\"reason\":\"Successful transaction\",\"purchase_totals\":{\"currency\":\"PKR\",\"amount\":55000},\"created_at\":{\"seconds\":1787917249}}],\"attempts\":[{\"token\":\"attemp_3127656c-cf41-4ed9-a15a-344b4f4eec77\",\"tracker\":\"track_b56b7adf-2e06-4b41-9823-cd13d5950365\",\"intent\":\"CYBERSOURCE\",\"idempotency_key\":\"req_38bdeaa8-8449-4861-9234-3ea3af47ca28\",\"kind\":1,\"actions_performed\":[{\"token\":\"act_248e4162-d0d4-4bd9-bb4e-1d340191b90b\",\"tracker\":\"track_b56b7adf-2e06-4b41-9823-cd13d5950365\",\"attempt\":\"attemp_3127656c-cf41-4ed9-a15a-344b4f4eec77\",\"kind\":\"PAYER_AUTH_SETUP\",\"created_at\":{\"seconds\":1787917231},\"updated_at\":{\"seconds\":1787917231}},{\"token\":\"act_6a3a45b6-7aa9-43e0-b39e-b0051ee6df1a\",\"tracker\":\"track_b56b7adf-2e06-4b41-9823-cd13d5950365\",\"attempt\":\"attemp_3127656c-cf41-4ed9-a15a-344b4f4eec77\",\"kind\":\"PAYER_AUTH_ENROLLMENT\",\"created_at\":{\"seconds\":1787917244},\"updated_at\":{\"seconds\":1787917244}},{\"token\":\"act_fd556b30-78d8-44dd-afb5-078bdafea842\",\"tracker\":\"track_b56b7adf-2e06-4b41-9823-cd13d5950365\",\"attempt\":\"attemp_3127656c-cf41-4ed9-a15a-344b4f4eec77\",\"kind\":\"AUTHORIZATION\",\"created_at\":{\"seconds\":1787917248},\"updated_at\":{\"seconds\":1787917248}}],\"payment_method\":{\"token\":\"method_0d99e74d-6664-47b3-8ff1-1778fd5a2020\",\"tracker\":\"track_b56b7adf-2e06-4b41-9823-cd13d5950365\",\"attempt\":\"attemp_3127656c-cf41-4ed9-a15a-344b4f4eec77\",\"last_four\":\"1111\",\"kind\":\"CARD\",\"scheme\":\"Visa\",\"issuer\":\"Conotoxia Sp.zo.o.\",\"bin\":\"411111\",\"expiration_month\":\"12\",\"expiration_year\":\"2028\",\"do_card_on_file\":true,\"created_at\":{\"seconds\":1787917232},\"updated_at\":{\"seconds\":1787917232}},\"billing\":{\"token\":\"bill_e48c63ea-1ccc-4f0a-85b4-f15cba84d380\",\"attempt\":\"attemp_3127656c-cf41-4ed9-a15a-344b4f4eec77\",\"street_1\":\"Bhaki road skp\",\"city\":\"skp\",\"country\":\"PK\",\"created_at\":{\"seconds\":1787917244},\"updated_at\":{\"seconds\":1787917244}},\"enrollment\":{\"token\":\"enroll_702226e9-103a-478c-8907-7d6a0fe5f980\",\"attempt\":\"attemp_3127656c-cf41-4ed9-a15a-344b4f4eec77\",\"cybersource_rid\":\"7879172437826370004806\",\"specification_version\":\"2.2.0\",\"veres_enrolled\":\"Y\",\"eci\":\"05\",\"created_at\":{\"seconds\":1787917244},\"updated_at\":{\"seconds\":1787917244},\"pares_status\":\"Y\",\"authentication_status\":\"FRICTIONLESS\"},\"risk\":{\"token\":\"risk_90205841-34e9-476a-b812-9828dcc69500\",\"attempt\":\"attemp_3127656c-cf41-4ed9-a15a-344b4f4eec77\",\"score\":\"43\",\"factor_codes\":[\"B\",\"F\",\"N\"],\"info_codes\":[\"MM-BIN\",\"UNV-ADDR\",\"NEG-ASUSP\",\"NEG-CC\",\"NEG-EM\",\"NEG-SUSP\",\"VELL-TIP\",\"FREE-EM\",\"NON-FN\",\"RISK-SD\"],\"created_at\":{\"seconds\":1787917249},\"updated_at\":{\"seconds\":1787917249}},\"authorization\":{\"token\":\"auth_77696932-ac29-4bc4-9161-5d1e56543144\",\"tracker\":\"track_b56b7adf-2e06-4b41-9823-cd13d5950365\",\"attempt\":\"attemp_3127656c-cf41-4ed9-a15a-344b4f4eec77\",\"intent\":\"CYBERSOURCE\",\"cybersource_rid\":\"7879172478156293204807\",\"totals\":{\"currency\":\"PKR\",\"amount\":55000},\"created_at\":{\"seconds\":1787917249},\"updated_at\":{\"seconds\":1787917249}},\"capture\":{\"token\":\"cap_991be35f-5fb8-4722-ace0-115383353826\",\"tracker\":\"track_b56b7adf-2e06-4b41-9823-cd13d5950365\",\"attempt\":\"attemp_3127656c-cf41-4ed9-a15a-344b4f4eec77\",\"intent\":\"CYBERSOURCE\",\"cybersource_rid\":\"7879172478156293204807\",\"is_voidable\":true,\"kind\":\"PAYMENT\",\"totals\":{\"currency\":\"PKR\",\"amount\":55000},\"created_at\":{\"seconds\":1787917249},\"updated_at\":{\"seconds\":1787917249}},\"is_success\":true,\"created_at\":{\"seconds\":1787917231},\"updated_at\":{\"seconds\":1787917249},\"mode\":\"payment\",\"entry_mode\":\"raw\",\"customer\":{\"token\":\"guest_98a8b942-7f9e-4257-8a8e-727f5a1fefb7\",\"first_name\":\"eman\",\"last_name\":\"eman\",\"email\":\"b96691804@gmail.com\",\"phone\":\"+92 303 4907951\"}}],\"location\":{\"tracker\":\"track_b56b7adf-2e06-4b41-9823-cd13d5950365\",\"token\":\"loc_cc35c6c9-ccc7-43c2-8b6c-a52803203c84\",\"ip_address\":\"2402:e000:42b:56f4:1c55:fe62:8ba9:d7a5\",\"city\":\"Lahore\",\"country\":\"PK\",\"latitude\":31.558,\"longitude\":74.35071,\"region\":\"Punjab\",\"created_at\":{\"seconds\":1787917248},\"updated_at\":{\"seconds\":1787917248}},\"device\":{\"tracker\":\"track_b56b7adf-2e06-4b41-9823-cd13d5950365\",\"token\":\"dev_b1dc31a0-de4c-43ff-b1ce-97e27fa609d0\",\"user_agent\":\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36\",\"entity\":\"browser\",\"browser\":\"Chrome\",\"browser_version\":\"151.0.0.0\",\"device_type\":\"desktop\",\"platform\":\"Windows 10\",\"platform_icon\":\"https://assets.userstack.com/icon/os/windows10.png\",\"created_at\":{\"seconds\":1787917248},\"updated_at\":{\"seconds\":1787917248}},\"created_at\":{\"seconds\":1787916881},\"updated_at\":{\"seconds\":1787917249},\"payment_method_kind\":\"card\",\"is_routed\":false}}\n', '2026-08-28 11:34:40', '2026-08-28 11:40:56');
INSERT INTO `payments` (`id`, `user_id`, `tracker_token`, `amount`, `currency`, `status`, `raw_response`, `created_at`, `updated_at`) VALUES
(22, 277, 'track_19162a11-eb7c-4321-9e50-91d665ce0186', '5000.00', 'PKR', 'paid', '{\"ok\":true,\"data\":{\"token\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"environment\":\"sandbox\",\"state\":\"TRACKER_ENDED\",\"intent\":\"CYBERSOURCE\",\"mode\":\"payment\",\"entry_mode\":\"raw\",\"client\":{\"token\":\"client_6b206ac8-8e94-4205-a14e-0bd568725534\",\"api_key\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"name\":\"intradecorhome\",\"email\":\"menakfatima2@gmail.com\",\"api_settings\":{}},\"customer\":{\"token\":\"guest_62379408-d760-4ee5-82c7-eb5c5b26ade8\",\"first_name\":\"eman\",\"last_name\":\"fatima\",\"email\":\"emanf.ppc@gmail.com\",\"phone\":\"+92 303 4907951\"},\"next_actions\":{\"CYBERSOURCE\":{\"kind\":\"NOOP\",\"request_id\":\"req_f3baabc2-4dbb-4831-89b2-662a91a53027\"},\"MPGS\":{\"kind\":\"CREATE_SESSION\"},\"PAYFAST\":{\"kind\":\"CUSTOMER_VALIDATE\"},\"RAAST\":{\"kind\":\"CREATE_RAAST_PAYMENT\"}},\"purchase_totals\":{\"quote_amount\":{\"currency\":\"PKR\",\"amount\":500000},\"base_amount\":{\"currency\":\"PKR\",\"amount\":500000},\"conversion_rate\":{\"base_currency\":\"PKR\",\"quote_currency\":\"PKR\",\"rate\":1}},\"charge\":{\"token\":\"ch_10a6249c-0b89-4417-8544-d2858cd20994\",\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"client\":\"sec_98aa9bc1-58a1-4d1c-93ae-5d966149b8a5\",\"user\":\"guest_62379408-d760-4ee5-82c7-eb5c5b26ade8\",\"amount\":{\"currency\":\"PKR\",\"amount\":500000},\"fees\":{\"currency\":\"PKR\",\"amount\":31675},\"tax\":{\"currency\":\"PKR\",\"amount\":2175},\"net\":{\"currency\":\"PKR\",\"amount\":468325},\"signature\":\"09a06c2da7c75ae7cf24f2d6f1d633f161fe6b62c34b6e65ee687b4a9b0afd17\",\"capture\":{\"token\":\"cap_d3565a90-ccea-4d4e-ac59-5f064942f39c\",\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"attempt\":\"attemp_47e7be3a-6624-4ec0-8dc2-a6676a209627\",\"intent\":\"CYBERSOURCE\",\"cybersource_rid\":\"7891982477836672904805\",\"is_voidable\":true,\"kind\":\"PAYMENT\",\"totals\":{\"currency\":\"PKR\",\"amount\":500000},\"created_at\":{\"seconds\":1789198249},\"updated_at\":{\"seconds\":1789198249}},\"balance\":{\"currency\":\"PKR\",\"amount\":500000},\"created_at\":{\"seconds\":1789198249},\"updated_at\":{\"seconds\":1789198249},\"withholding_tax\":{\"sales_tax_withholding\":{\"currency\":\"PKR\",\"amount\":10000},\"income_tax_withholding\":{\"currency\":\"PKR\",\"amount\":5000},\"digital_presence_tax\":{\"currency\":\"PKR\",\"amount\":0}}},\"events\":[{\"intent\":\"CYBERSOURCE\",\"type\":\"ENROLLMENT\",\"intent_request_id\":\"7891982054266597804805\",\"reason\":\"Successful enrollment\",\"created_at\":{\"seconds\":1789198206}},{\"intent\":\"CYBERSOURCE\",\"type\":\"ENROLLMENT\",\"intent_request_id\":\"7891982278506332404807\",\"reason\":\"Successful enrollment\",\"created_at\":{\"seconds\":1789198228}},{\"intent\":\"CYBERSOURCE\",\"type\":\"AUTHORIZATION\",\"intent_request_id\":\"7891982477836672904805\",\"reason\":\"Successful authorization\",\"purchase_totals\":{\"currency\":\"PKR\",\"amount\":500000},\"created_at\":{\"seconds\":1789198249}},{\"intent\":\"CYBERSOURCE\",\"type\":\"CAPTURE\",\"intent_request_id\":\"7891982477836672904805\",\"reason\":\"Successful transaction\",\"purchase_totals\":{\"currency\":\"PKR\",\"amount\":500000},\"created_at\":{\"seconds\":1789198249}}],\"attempts\":[{\"token\":\"attemp_1b72faca-8185-4a92-bb80-dfa573268282\",\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"intent\":\"CYBERSOURCE\",\"idempotency_key\":\"req_f3baabc2-4dbb-4831-89b2-662a91a53027\",\"kind\":1,\"actions_performed\":[{\"token\":\"act_32a4d6f9-2376-402e-b0d9-36041f7a5c6e\",\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"attempt\":\"attemp_1b72faca-8185-4a92-bb80-dfa573268282\",\"kind\":\"PAYER_AUTH_SETUP\",\"created_at\":{\"seconds\":1789198191},\"updated_at\":{\"seconds\":1789198191}},{\"token\":\"act_f05c22d1-307b-4f70-951f-75ea23fcd960\",\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"attempt\":\"attemp_1b72faca-8185-4a92-bb80-dfa573268282\",\"kind\":\"PAYER_AUTH_ENROLLMENT\",\"created_at\":{\"seconds\":1789198205},\"updated_at\":{\"seconds\":1789198205}}],\"payment_method\":{\"token\":\"method_6089ab05-07db-42e0-ae85-a6fede736cb4\",\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"attempt\":\"attemp_1b72faca-8185-4a92-bb80-dfa573268282\",\"last_four\":\"1096\",\"kind\":\"CARD\",\"scheme\":\"Mastercard\",\"bin\":\"520000\",\"expiration_month\":\"03\",\"expiration_year\":\"2028\",\"do_card_on_file\":true,\"created_at\":{\"seconds\":1789198192},\"updated_at\":{\"seconds\":1789198192}},\"billing\":{\"token\":\"bill_569e9511-d48a-4275-a2d4-7f2904b4391a\",\"attempt\":\"attemp_1b72faca-8185-4a92-bb80-dfa573268282\",\"street_1\":\"Bhikhi road skp\",\"city\":\"Sheikhupura\",\"country\":\"PK\",\"created_at\":{\"seconds\":1789198206},\"updated_at\":{\"seconds\":1789198206}},\"enrollment\":{\"token\":\"enroll_4aed3e6d-994d-4e71-ae8c-fcd46dcf438c\",\"attempt\":\"attemp_1b72faca-8185-4a92-bb80-dfa573268282\",\"cybersource_rid\":\"7891982054266597804805\",\"specification_version\":\"2.1.0\",\"veres_enrolled\":\"Y\",\"created_at\":{\"seconds\":1789198206},\"updated_at\":{\"seconds\":1789198206},\"pares_status\":\"C\",\"authentication_status\":\"REQUIRED\"},\"created_at\":{\"seconds\":1789198191},\"updated_at\":{\"seconds\":1789198206},\"mode\":\"payment\",\"entry_mode\":\"raw\",\"customer\":{\"token\":\"guest_5c6037ee-8e56-4a4f-a5b7-1d372e7ecdf3\",\"first_name\":\"eman\",\"last_name\":\"fatima\",\"email\":\"emanf.ppc@gmail.com\",\"phone\":\"+92 303 4907951\"}},{\"token\":\"attemp_47e7be3a-6624-4ec0-8dc2-a6676a209627\",\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"intent\":\"CYBERSOURCE\",\"idempotency_key\":\"req_f3baabc2-4dbb-4831-89b2-662a91a53027\",\"kind\":1,\"actions_performed\":[{\"token\":\"act_7ba8386e-74f6-48b1-bfd6-769ac10e0c2c\",\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"attempt\":\"attemp_47e7be3a-6624-4ec0-8dc2-a6676a209627\",\"kind\":\"PAYER_AUTH_SETUP\",\"created_at\":{\"seconds\":1789198222},\"updated_at\":{\"seconds\":1789198222}},{\"token\":\"act_194fdfde-87a5-4c73-8d5c-f3f19423d200\",\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"attempt\":\"attemp_47e7be3a-6624-4ec0-8dc2-a6676a209627\",\"kind\":\"PAYER_AUTH_ENROLLMENT\",\"created_at\":{\"seconds\":1789198228},\"updated_at\":{\"seconds\":1789198228}},{\"token\":\"act_4e1ca546-7a58-4c11-babb-c811a38ec057\",\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"attempt\":\"attemp_47e7be3a-6624-4ec0-8dc2-a6676a209627\",\"kind\":\"PAYER_AUTH_VALIDATION\",\"created_at\":{\"seconds\":1789198247},\"updated_at\":{\"seconds\":1789198247}}],\"payment_method\":{\"token\":\"method_c6501429-400c-4cfa-b895-6cb52100e7df\",\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"attempt\":\"attemp_47e7be3a-6624-4ec0-8dc2-a6676a209627\",\"last_four\":\"1096\",\"kind\":\"CARD\",\"scheme\":\"Mastercard\",\"issuer\":\"PUBLIC BANK BERHAD\",\"bin\":\"520000\",\"expiration_month\":\"03\",\"expiration_year\":\"2028\",\"do_card_on_file\":true,\"network_transaction_id\":\"0912MCC435498\",\"created_at\":{\"seconds\":1789198222},\"updated_at\":{\"seconds\":1789198222}},\"billing\":{\"token\":\"bill_9409bac9-dc8f-4658-886d-b6ef016e803b\",\"attempt\":\"attemp_47e7be3a-6624-4ec0-8dc2-a6676a209627\",\"street_1\":\"Bhikhi road skp\",\"city\":\"Sheikhupura\",\"country\":\"PK\",\"created_at\":{\"seconds\":1789198228},\"updated_at\":{\"seconds\":1789198228}},\"enrollment\":{\"token\":\"enroll_80353d4a-a581-4e7b-9b72-d2ed0301a085\",\"attempt\":\"attemp_47e7be3a-6624-4ec0-8dc2-a6676a209627\",\"cybersource_rid\":\"7891982278506332404807\",\"specification_version\":\"2.1.0\",\"veres_enrolled\":\"Y\",\"eci\":\"02\",\"created_at\":{\"seconds\":1789198228},\"updated_at\":{\"seconds\":1789198228},\"pares_status\":\"C\",\"authentication_status\":\"REQUIRED\"},\"risk\":{\"token\":\"risk_bc485269-1923-4459-b5c5-9c56ad88bdb9\",\"attempt\":\"attemp_47e7be3a-6624-4ec0-8dc2-a6676a209627\",\"score\":\"37\",\"factor_codes\":[\"F\",\"H\"],\"info_codes\":[\"COR-BA\",\"MM-BIN\",\"NEG-CC\",\"NEG-SUSP\",\"VEL-NAME\",\"VELL-CC\",\"VELV-CC\",\"ID-M-HPOS\",\"MORPH-C\",\"MORPH-P\",\"FREE-EM\",\"MUL-EM\",\"RISK-SD\"],\"created_at\":{\"seconds\":1789198249},\"updated_at\":{\"seconds\":1789198249}},\"authorization\":{\"token\":\"auth_afe33d18-479e-4480-ba17-03642a80ba5b\",\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"attempt\":\"attemp_47e7be3a-6624-4ec0-8dc2-a6676a209627\",\"intent\":\"CYBERSOURCE\",\"cybersource_rid\":\"7891982477836672904805\",\"totals\":{\"currency\":\"PKR\",\"amount\":500000},\"created_at\":{\"seconds\":1789198249},\"updated_at\":{\"seconds\":1789198249}},\"capture\":{\"token\":\"cap_d3565a90-ccea-4d4e-ac59-5f064942f39c\",\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"attempt\":\"attemp_47e7be3a-6624-4ec0-8dc2-a6676a209627\",\"intent\":\"CYBERSOURCE\",\"cybersource_rid\":\"7891982477836672904805\",\"is_voidable\":true,\"kind\":\"PAYMENT\",\"totals\":{\"currency\":\"PKR\",\"amount\":500000},\"created_at\":{\"seconds\":1789198249},\"updated_at\":{\"seconds\":1789198249}},\"is_success\":true,\"created_at\":{\"seconds\":1789198222},\"updated_at\":{\"seconds\":1789198249},\"mode\":\"payment\",\"entry_mode\":\"raw\",\"customer\":{\"token\":\"guest_62379408-d760-4ee5-82c7-eb5c5b26ade8\",\"first_name\":\"eman\",\"last_name\":\"fatima\",\"email\":\"emanf.ppc@gmail.com\",\"phone\":\"+92 303 4907951\"}}],\"location\":{\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"token\":\"loc_ac04a53e-e786-46af-b541-943866e4b9bb\",\"ip_address\":\"59.103.112.24\",\"city\":\"Shekhupura\",\"country\":\"PK\",\"latitude\":31.71287,\"longitude\":73.98556,\"region\":\"Punjab\",\"created_at\":{\"seconds\":1789198228},\"updated_at\":{\"seconds\":1789198228}},\"device\":{\"tracker\":\"track_19162a11-eb7c-4321-9e50-91d665ce0186\",\"token\":\"dev_644f35c0-fffe-4c8f-a430-53d7f84e6ddd\",\"user_agent\":\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36\",\"entity\":\"browser\",\"browser\":\"Chrome\",\"browser_version\":\"152.0.0.0\",\"device_type\":\"desktop\",\"platform\":\"Windows 10\",\"platform_icon\":\"https://assets.userstack.com/icon/os/windows10.png\",\"created_at\":{\"seconds\":1789198228},\"updated_at\":{\"seconds\":1789198228}},\"created_at\":{\"seconds\":1789197892},\"updated_at\":{\"seconds\":1789198249},\"payment_method_kind\":\"card\",\"is_routed\":false}}\n', '2026-09-12 07:24:51', '2026-09-12 07:30:51');

-- --------------------------------------------------------

--
-- Table structure for table `productadd`
--

CREATE TABLE `productadd` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(65,0) NOT NULL,
  `category` varchar(50) NOT NULL,
  `product_type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(20) DEFAULT 'Active',
  `quantity` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `roll_width` int(11) DEFAULT NULL,
  `roll_length` int(11) DEFAULT NULL,
  `material` varchar(50) DEFAULT NULL,
  `color_image2` varchar(255) DEFAULT NULL,
  `color_image3` varchar(255) DEFAULT NULL,
  `tile_length` decimal(8,4) DEFAULT NULL,
  `tile_width` decimal(8,4) DEFAULT NULL,
  `finish_type` varchar(50) DEFAULT NULL,
  `panel_length` decimal(6,2) DEFAULT NULL,
  `panel_width` decimal(6,2) DEFAULT NULL,
  `reject_reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productadd`
--

INSERT INTO `productadd` (`id`, `seller_id`, `name`, `price`, `category`, `product_type`, `description`, `product_image`, `created_at`, `status`, `quantity`, `discount`, `roll_width`, `roll_length`, `material`, `color_image2`, `color_image3`, `tile_length`, `tile_width`, `finish_type`, `panel_length`, `panel_width`, `reject_reason`) VALUES
(245, 273, 'Beige Tan Granite Tile', '450', 'tiles', 'Granite Tiles', 'A quality granite tiles product, ideal for floors and walls.', 'uploads/tile_granite_1.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Polished', NULL, NULL, NULL),
(246, 273, 'Deep Red Granite Tile', '450', 'tiles', 'Granite Tiles', 'A quality granite tiles product, ideal for floors and walls.', 'uploads/tile_granite_4.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Polished', NULL, NULL, NULL),
(247, 273, 'Silver Grey Granite Tile', '450', 'tiles', 'Granite Tiles', 'A quality granite tiles product, ideal for floors and walls.', 'uploads/tile_granite_5.jpg', '2026-08-31 11:17:39', 'approved', 49, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Polished', NULL, NULL, NULL),
(248, 273, 'Charcoal Dark Limestone Tile', '350', 'tiles', 'Limestone Tiles', 'A quality limestone tiles product, ideal for floors and walls.', 'uploads/tile_ceramic-1.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Matte', NULL, NULL, NULL),
(249, 273, 'Ocean Blue Limestone Tile', '350', 'tiles', 'Limestone Tiles', 'A quality limestone tiles product, ideal for floors and walls.', 'uploads/tile_ceramic-2.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Matte', NULL, NULL, NULL),
(250, 273, 'Terracotta Red Limestone Tile', '350', 'tiles', 'Limestone Tiles', 'A quality limestone tiles product, ideal for floors and walls.', 'uploads/tile_ceramic-3.jpg', '2026-08-31 11:17:39', 'approved', 49, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Matte', NULL, NULL, NULL),
(251, 273, 'Sage Green Floral Limestone Tile', '350', 'tiles', 'Limestone Tiles', 'A quality limestone tiles product, ideal for floors and walls.', 'uploads/tile_ceramic-4.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Matte', NULL, NULL, NULL),
(252, 273, 'Classic Black Marble Tile', '400', 'tiles', 'Marble Tiles', 'A quality marble tiles product, ideal for floors and walls.', 'uploads/tile_marble_1.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Polished', NULL, NULL, NULL),
(253, 273, 'Green Veined Marble Tile', '400', 'tiles', 'Marble Tiles', 'A quality marble tiles product, ideal for floors and walls.', 'uploads/tile_marble_2.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Polished', NULL, NULL, NULL),
(254, 273, 'Blush Pink Marble Tile', '400', 'tiles', 'Marble Tiles', 'A quality marble tiles product, ideal for floors and walls.', 'uploads/tile_marble_3.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Polished', NULL, NULL, NULL),
(255, 273, 'Beige Gold-Veined Marble Tile', '400', 'tiles', 'Marble Tiles', 'A quality marble tiles product, ideal for floors and walls.', 'uploads/tile_marble_4.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Polished', NULL, NULL, NULL),
(256, 273, 'Rustic Orange Quarry Tile', '250', 'tiles', 'Quarry Tiles', 'A quality quarry tiles product, ideal for floors and walls.', 'uploads/tile_terracotta_1.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Textured', NULL, NULL, NULL),
(257, 273, 'Burnt Sienna Quarry Tile', '250', 'tiles', 'Quarry Tiles', 'A quality quarry tiles product, ideal for floors and walls.', 'uploads/tile_terracotta_2.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Textured', NULL, NULL, NULL),
(258, 273, 'Warm Brown Quarry Tile', '250', 'tiles', 'Quarry Tiles', 'A quality quarry tiles product, ideal for floors and walls.', 'uploads/tile_terracotta_3.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Textured', NULL, NULL, NULL),
(259, 273, 'Sandy Tan Quarry Tile', '250', 'tiles', 'Quarry Tiles', 'A quality quarry tiles product, ideal for floors and walls.', 'uploads/tile_terracotta_4.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Textured', NULL, NULL, NULL),
(260, 273, 'Deep Red Quarry Tile', '250', 'tiles', 'Quarry Tiles', 'A quality quarry tiles product, ideal for floors and walls.', 'uploads/tile_terracotta_5.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Textured', NULL, NULL, NULL),
(261, 273, 'Grey Textured Sandstone Tile', '300', 'tiles', 'Sandstone Tiles', 'A quality sandstone tiles product, ideal for floors and walls.', 'uploads/tile_ceramic-5.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Textured', NULL, NULL, NULL),
(262, 273, 'Beige Plain Sandstone Tile', '300', 'tiles', 'Sandstone Tiles', 'A quality sandstone tiles product, ideal for floors and walls.', 'uploads/tile_ceramic-6.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Textured', NULL, NULL, NULL),
(263, 273, 'Blue Floral Sandstone Tile', '300', 'tiles', 'Sandstone Tiles', 'A quality sandstone tiles product, ideal for floors and walls.', 'uploads/tile_ceramic-7.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Textured', NULL, NULL, NULL),
(264, 273, 'Peach Floral Sandstone Tile', '300', 'tiles', 'Sandstone Tiles', 'A quality sandstone tiles product, ideal for floors and walls.', 'uploads/tile_ceramic-8.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Textured', NULL, NULL, NULL),
(265, 273, 'Black Glossy Slate Tile', '380', 'tiles', 'Slate Tiles', 'A quality slate tiles product, ideal for floors and walls.', 'uploads/tile_vitrified_1.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Matte', NULL, NULL, NULL),
(266, 273, 'Cream Beige Slate Tile', '380', 'tiles', 'Slate Tiles', 'A quality slate tiles product, ideal for floors and walls.', 'uploads/tile_vitrified_2.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Matte', NULL, NULL, NULL),
(267, 273, 'Light Grey Slate Tile', '380', 'tiles', 'Slate Tiles', 'A quality slate tiles product, ideal for floors and walls.', 'uploads/tile_vitrified_3.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Matte', NULL, NULL, NULL),
(268, 273, 'White Glossy Slate Tile', '380', 'tiles', 'Slate Tiles', 'A quality slate tiles product, ideal for floors and walls.', 'uploads/tile_vitrified_4.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Matte', NULL, NULL, NULL),
(271, 273, 'Warm Beige Travertine Tile', '420', 'tiles', 'Travertine Tiles', 'A quality travertine tiles product, ideal for floors and walls.', 'uploads/tile_porcelain_1.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Matte', NULL, NULL, NULL),
(272, 273, 'Ivory Travertine Tile', '420', 'tiles', 'Travertine Tiles', 'A quality travertine tiles product, ideal for floors and walls.', 'uploads/tile_porcelain_2.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Matte', NULL, NULL, NULL),
(273, 273, 'Sand Toned Travertine Tile', '420', 'tiles', 'Travertine Tiles', 'A quality travertine tiles product, ideal for floors and walls.', 'uploads/tile_porcelain_3.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '2.0000', '2.0000', 'Matte', NULL, NULL, NULL),
(274, 273, 'Aqua Blue Silver Glass Tile', '320', 'tiles', 'Glass Tiles', 'A quality glass tiles product, ideal for floors and walls.', 'uploads/tile_glass_1.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '1.0000', '1.0000', 'Glossy', NULL, NULL, NULL),
(275, 273, 'Maroon Purple Glass Tile', '320', 'tiles', 'Glass Tiles', 'A quality glass tiles product, ideal for floors and walls.', 'uploads/tile_glass_2.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '1.0000', '1.0000', 'Glossy', NULL, NULL, NULL),
(276, 273, 'Teal Green Glass Tile', '320', 'tiles', 'Glass Tiles', 'A quality glass tiles product, ideal for floors and walls.', 'uploads/tile_glass_3.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '1.0000', '1.0000', 'Glossy', NULL, NULL, NULL),
(277, 273, 'Fresh Green Glass Tile', '320', 'tiles', 'Glass Tiles', 'A quality glass tiles product, ideal for floors and walls.', 'uploads/tile_glass_4.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '1.0000', '1.0000', 'Glossy', NULL, NULL, NULL),
(278, 273, 'Blush Pink Glass Tile', '320', 'tiles', 'Glass Tiles', 'A quality glass tiles product, ideal for floors and walls.', 'uploads/tile_glass_5.jpg', '2026-08-31 11:17:39', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '1.0000', '1.0000', 'Glossy', NULL, NULL, NULL),
(279, 274, 'Navy Blue Floral Wallpaper', '2800', 'wallpaper', 'Floral Wallpaper', 'A stylish floral wallpaper design for any room.', 'uploads/wallpaper_floral_1.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Non-woven', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(280, 274, 'Blue Rose Floral Wallpaper', '2800', 'wallpaper', 'Floral Wallpaper', 'A stylish floral wallpaper design for any room.', 'uploads/wallpaper_floral_2.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Non-woven', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(281, 274, 'Vintage Pink Rose Floral Wallpaper', '2800', 'wallpaper', 'Floral Wallpaper', 'A stylish floral wallpaper design for any room.', 'uploads/wallpaper_floral_3.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Non-woven', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(282, 274, 'Pink Blossom Floral Wallpaper', '2800', 'wallpaper', 'Floral Wallpaper', 'A stylish floral wallpaper design for any room.', 'uploads/wallpaper_floral_4.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Non-woven', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(283, 274, 'Blue Brushstroke Abstract Wallpaper', '2900', 'wallpaper', 'Abstract Wallpaper', 'A stylish abstract wallpaper design for any room.', 'uploads/wallpaper_abstract_1.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(284, 274, 'Terracotta Shapes Abstract Wallpaper', '2900', 'wallpaper', 'Abstract Wallpaper', 'A stylish abstract wallpaper design for any room.', 'uploads/wallpaper_abstract2.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(285, 274, 'Blue Grey Brushstroke Abstract Wallpaper', '2900', 'wallpaper', 'Abstract Wallpaper', 'A stylish abstract wallpaper design for any room.', 'uploads/wallpaper_abstract3.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(286, 274, 'Pastel Watercolor Splash Abstract Wallpaper', '2900', 'wallpaper', 'Abstract Wallpaper', 'A stylish abstract wallpaper design for any room.', 'uploads/wallpaper_abstrac4.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(287, 274, 'Black Gold Marble Swirl Abstract Wallpaper', '2900', 'wallpaper', 'Abstract Wallpaper', 'A stylish abstract wallpaper design for any room.', 'uploads/wallpaper_abstrac5.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(288, 274, 'Sage Green Wave Abstract Wallpaper', '2900', 'wallpaper', 'Abstract Wallpaper', 'A stylish abstract wallpaper design for any room.', 'uploads/wallpaper_abstrac6.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(289, 274, 'Kids Fairytale Castle Wallpaper', '2500', 'wallpaper', 'Kids Wallpaper', 'A stylish kids wallpaper design for any room.', 'uploads/tileF_1.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Paper', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(290, 274, 'Kids Dinosaur Wallpaper', '2500', 'wallpaper', 'Kids Wallpaper', 'A stylish kids wallpaper design for any room.', 'uploads/tileF_2.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Paper', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(291, 274, 'Kids Ocean Animals Wallpaper', '2500', 'wallpaper', 'Kids Wallpaper', 'A stylish kids wallpaper design for any room.', 'uploads/tileF_3.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Paper', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(292, 274, 'Kids Space Rocket Wallpaper', '2500', 'wallpaper', 'Kids Wallpaper', 'A stylish kids wallpaper design for any room.', 'uploads/tileF_4.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Paper', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(293, 274, 'Kids Forest Animals Wallpaper', '2500', 'wallpaper', 'Kids Wallpaper', 'A stylish kids wallpaper design for any room.', 'uploads/tileF_5.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Paper', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(294, 274, 'Black & White Hexagon Wallpaper', '3000', 'wallpaper', 'Geometric Wallpaper', 'A stylish geometric wallpaper design for any room.', 'uploads/wallpaper_geometric_1.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(295, 274, 'Navy Gold Diamond Geometric Wallpaper', '3000', 'wallpaper', 'Geometric Wallpaper', 'A stylish geometric wallpaper design for any room.', 'uploads/wallpaper_geometric_2.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(296, 274, 'Green Gold Moroccan Geometric Wallpaper', '3000', 'wallpaper', 'Geometric Wallpaper', 'A stylish geometric wallpaper design for any room.', 'uploads/wallpaper_geometric_3.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(297, 274, 'Green Circle Ring Geometric Wallpaper', '3000', 'wallpaper', 'Geometric Wallpaper', 'A stylish geometric wallpaper design for any room.', 'uploads/wallpaper_geometric_4.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(298, 274, 'Yellow Angular Geometric Wallpaper', '3000', 'wallpaper', 'Geometric Wallpaper', 'A stylish geometric wallpaper design for any room.', 'uploads/wallpaper_geometric_5.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(299, 274, 'Teal Star Geometric Wallpaper', '3000', 'wallpaper', 'Geometric Wallpaper', 'A stylish geometric wallpaper design for any room.', 'uploads/wallpaper_geometric_6.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(300, 274, 'Dark Brown Wood Wallpaper', '3200', 'wallpaper', 'wood Wallpaper', 'A stylish wood wallpaper design for any room.', 'uploads/wallpaper_wood_1.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(301, 274, 'Reddish Mahogany Wood Wallpaper', '3200', 'wallpaper', 'wood Wallpaper', 'A stylish wood wallpaper design for any room.', 'uploads/wallpaper_wood_2.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(302, 274, 'Rustic Barn Wood Wallpaper', '3200', 'wallpaper', 'wood Wallpaper', 'A stylish wood wallpaper design for any room.', 'uploads/wallpaper_wood_3.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(303, 274, 'Light Oak Wood Wallpaper', '3200', 'wallpaper', 'wood Wallpaper', 'A stylish wood wallpaper design for any room.', 'uploads/wallpaper_wood_4.jpg', '2026-09-01 05:50:42', 'approved', 50, 0, 53, 1000, 'Vinyl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(304, 275, 'Multicolor Stacked Stone Veneer Panel', '900', 'paneling', 'Brick Veneer', 'A quality brick veneer wall panel for modern interiors.', 'uploads/panel_brickveneer_2.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(305, 275, 'Multicolor Brick Veneer Panel', '900', 'paneling', 'Brick Veneer', 'A quality brick veneer wall panel for modern interiors.', 'uploads/panel_brickveneer_3.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(306, 275, 'Mixed Stone Veneer Panel', '900', 'paneling', 'Brick Veneer', 'A quality brick veneer wall panel for modern interiors.', 'uploads/panel_brickveneer_4.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(307, 275, 'Beige Rustic Brick Veneer Panel', '900', 'paneling', 'Brick Veneer', 'A quality brick veneer wall panel for modern interiors.', 'uploads/panel_brickveneer_5.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(308, 275, 'Classic Red Brick Veneer Panel', '900', 'paneling', 'Brick Veneer', 'A quality brick veneer wall panel for modern interiors.', 'uploads/panel_brickveneer_6.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(309, 275, 'Brushed Silver Metal Panel', '1500', 'paneling', 'Metal', 'A quality metal wall panel for modern interiors.', 'uploads/panel_metal_1.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(310, 275, 'Matte Black Metal Panel', '1500', 'paneling', 'Metal', 'A quality metal wall panel for modern interiors.', 'uploads/panel_metal_2.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(311, 275, 'Black Faceted Metal Panel', '1500', 'paneling', 'Metal', 'A quality metal wall panel for modern interiors.', 'uploads/panel_metal_3.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(312, 275, 'Navy Gold Star Metal Panel', '1500', 'paneling', 'Metal', 'A quality metal wall panel for modern interiors.', 'uploads/panel_metal_4.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(313, 275, 'Rose Gold Metal Panel', '1500', 'paneling', 'Metal', 'A quality metal wall panel for modern interiors.', 'uploads/panel_metal_5.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(314, 275, 'Black Gold Geometric Metal Panel', '1500', 'paneling', 'Metal', 'A quality metal wall panel for modern interiors.', 'uploads/panel_metal_6.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(315, 275, 'White Cream Faceted Metal Panel', '1500', 'paneling', 'Metal', 'A quality metal wall panel for modern interiors.', 'uploads/panel_metal_7.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL);
INSERT INTO `productadd` (`id`, `seller_id`, `name`, `price`, `category`, `product_type`, `description`, `product_image`, `created_at`, `status`, `quantity`, `discount`, `roll_width`, `roll_length`, `material`, `color_image2`, `color_image3`, `tile_length`, `tile_width`, `finish_type`, `panel_length`, `panel_width`, `reject_reason`) VALUES
(316, 275, 'Antique Gold Ornate Mirror Panel', '1800', 'paneling', 'Mirror', 'A quality mirror wall panel for modern interiors.', 'uploads/panel_mirror_1.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(317, 275, 'Silver Faceted Mirror Panel', '1800', 'paneling', 'Mirror', 'A quality mirror wall panel for modern interiors.', 'uploads/panel_mirror_2.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(318, 275, 'Silver 3D Faceted Mirror Panel', '1800', 'paneling', 'Mirror', 'A quality mirror wall panel for modern interiors.', 'uploads/panel_mirror_3.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(319, 275, 'Grey Tinted Mirror Panel', '1800', 'paneling', 'Mirror', 'A quality mirror wall panel for modern interiors.', 'uploads/panel_mirror_4.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(320, 275, 'Silver Diamond Mosaic Mirror Panel', '1800', 'paneling', 'Mirror', 'A quality mirror wall panel for modern interiors.', 'uploads/panel_mirror_6.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(321, 275, 'Navy Gold Scalloped MDF Panel', '1000', 'paneling', 'MDF', 'A quality mdf wall panel for modern interiors.', 'uploads/panel_mdf_1.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(322, 275, 'Bronze Copper Triangle MDF Panel', '1000', 'paneling', 'MDF', 'A quality mdf wall panel for modern interiors.', 'uploads/panel_mdf_2.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(323, 275, 'Dark Walnut MDF Panel', '1000', 'paneling', 'MDF', 'A quality mdf wall panel for modern interiors.', 'uploads/panel_mdf_3.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(324, 275, 'Brown Geometric Triangle MDF Panel', '1000', 'paneling', 'MDF', 'A quality mdf wall panel for modern interiors.', 'uploads/panel_mdf_4.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(325, 275, 'Dark Wood Fluted Gold MDF Panel', '1000', 'paneling', 'MDF', 'A quality mdf wall panel for modern interiors.', 'uploads/panel_mdf_5.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(326, 275, 'Teal Blue Art Deco MDF Panel', '1000', 'paneling', 'MDF', 'A quality mdf wall panel for modern interiors.', 'uploads/panel_mdf_6.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(327, 275, 'Black White Grey Mosaic PVC Panel', '700', 'paneling', 'PVC', 'A quality pvc wall panel for modern interiors.', 'uploads/panel_pvc_1.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(328, 275, 'Blue Textured PVC Panel', '700', 'paneling', 'PVC', 'A quality pvc wall panel for modern interiors.', 'uploads/panel_pvc_2.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(329, 275, 'Brown Copper PVC Panel', '700', 'paneling', 'PVC', 'A quality pvc wall panel for modern interiors.', 'uploads/panel_pvc_3.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(330, 275, 'Gold Olive PVC Panel', '700', 'paneling', 'PVC', 'A quality pvc wall panel for modern interiors.', 'uploads/panel_pvc_4.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(331, 275, 'Silver Grey Square PVC Panel', '700', 'paneling', 'PVC', 'A quality pvc wall panel for modern interiors.', 'uploads/panel_pvc_5.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(332, 275, 'Silver Textured Strip PVC Panel', '700', 'paneling', 'PVC', 'A quality pvc wall panel for modern interiors.', 'uploads/panel_pvc_6.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(333, 275, 'Beige Upholstered PVC Panel', '700', 'paneling', 'PVC', 'A quality pvc wall panel for modern interiors.', 'uploads/panel_pvc_7.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(334, 275, 'Natural Oak Wood Panel', '1800', 'paneling', 'Wood', 'A quality wood wall panel for modern interiors.', 'uploads/panel_wood_1.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(335, 275, 'Reddish Orange Stacked Wood Panel', '1800', 'paneling', 'Wood', 'A quality wood wall panel for modern interiors.', 'uploads/panel_wood_2.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(336, 275, 'Reclaimed Rustic Wood Panel', '1800', 'paneling', 'Wood', 'A quality wood wall panel for modern interiors.', 'uploads/panel_wood_3.jpg', '2026-08-31 15:58:49', 'approved', 49, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(337, 275, 'Brown Geometric Wood Panel', '1800', 'paneling', 'Wood', 'A quality wood wall panel for modern interiors.', 'uploads/panel_wood_4.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(338, 275, 'Light Oak Stacked Wood Panel', '1800', 'paneling', 'Wood', 'A quality wood wall panel for modern interiors.', 'uploads/panel_wood_5.jpg', '2026-08-31 15:58:49', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(339, 275, 'Honey Brown Wood Panel', '1800', 'paneling', 'Wood', 'A quality wood wall panel for modern interiors.', 'uploads/panel_wood_6.jpg', '2026-08-31 15:58:49', 'approved', 48, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4.00', '2.00', NULL),
(340, 273, 'Beige Speckled Terrazzo Tile', '280', 'tiles', 'Terrazzo Tiles', 'A quality terrazzo tiles product, ideal for floors and walls.', 'Terrazzo_Tiles1.jpg', '2026-08-31 22:42:10', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '1.0000', '1.0000', 'Glossy', NULL, NULL, NULL),
(341, 273, 'Colorful Fleck Terrazzo Tile', '280', 'tiles', 'Terrazzo Tiles', 'A quality terrazzo tiles product, ideal for floors and walls.', 'Terrazzo_Tiles2.jpg', '2026-08-31 22:42:10', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '1.0000', '1.0000', 'Glossy', NULL, NULL, NULL),
(342, 273, 'Scalloped Pattern Terrazzo Tile', '280', 'tiles', 'Terrazzo Tiles', 'A quality terrazzo tiles product, ideal for floors and walls.', 'Terrazzo_Tiles3.jpg', '2026-08-31 22:42:10', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '1.0000', '1.0000', 'Glossy', NULL, NULL, NULL),
(343, 273, 'Green Orange Geometric Terrazzo Tile', '280', 'tiles', 'Terrazzo Tiles', 'A quality terrazzo tiles product, ideal for floors and walls.', 'Terrazzo_Tiles4.jpg', '2026-08-31 22:42:10', 'approved', 50, 0, NULL, NULL, NULL, NULL, NULL, '1.0000', '1.0000', 'Glossy', NULL, NULL, NULL),
(346, 272, 'Premium Red Wall Paint', '2500', 'paint', 'Red', 'A vibrant, long-lasting red interior paint, perfect for feature walls.', 'paint_red.jpg', '2026-09-12 10:17:16', 'approved', 20, 0, NULL, NULL, 'Water-based', NULL, NULL, NULL, NULL, 'Matte', NULL, NULL, NULL),
(347, 272, 'Premium Blue Wall Paint', '2500', 'paint', 'Blue', 'A calming, long-lasting blue interior paint, perfect for bedrooms.', 'paint_blue.jpg', '2026-09-12 10:17:16', 'approved', 20, 0, NULL, NULL, 'Water-based', NULL, NULL, NULL, NULL, 'Matte', NULL, NULL, NULL),
(348, 272, 'Premium Orange Wall Paint', '2500', 'paint', 'Orange', 'A warm, vibrant orange interior paint, great for living rooms.', 'paint_orange.jpg', '2026-09-12 10:17:16', 'approved', 20, 0, NULL, NULL, 'Water-based', NULL, NULL, NULL, NULL, 'Matte', NULL, NULL, NULL),
(349, 272, 'Premium Green Wall Paint', '2500', 'paint', 'Green', 'A fresh, natural green interior paint, ideal for any room.', 'paint_green.jpg', '2026-09-12 10:17:16', 'approved', 20, 0, NULL, NULL, 'Water-based', NULL, NULL, NULL, NULL, 'Matte', NULL, NULL, NULL),
(350, 272, 'Premium Purple Wall Paint', '2500', 'paint', 'Purple', 'A rich, elegant purple interior paint for a bold accent wall.', 'paint_purple.jpg', '2026-09-12 10:17:16', 'approved', 20, 0, NULL, NULL, 'Water-based', NULL, NULL, NULL, NULL, 'Matte', NULL, NULL, NULL),
(351, 272, 'Premium Pink Wall Paint', '2500', 'paint', 'Pink', 'A soft, warm pink interior paint, great for bedrooms.', 'paint_pink.jpg', '2026-09-12 10:17:16', 'approved', 20, 0, NULL, NULL, 'Water-based', NULL, NULL, NULL, NULL, 'Matte', NULL, NULL, NULL),
(352, 272, 'Premium Gray Wall Paint', '2500', 'paint', 'Gray', 'A modern, neutral gray interior paint that suits any decor.', 'paint_grey.jpg', '2026-09-12 10:17:16', 'approved', 20, 0, NULL, NULL, 'Water-based', NULL, NULL, NULL, NULL, 'Matte', NULL, NULL, NULL),
(353, 272, 'Premium Brown Wall Paint', '2500', 'paint', 'Brown', 'A warm, earthy brown interior paint, ideal for a cozy feel.', 'paint_brown.jpg', '2026-09-12 10:17:16', 'approved', 20, 0, NULL, NULL, 'Water-based', NULL, NULL, NULL, NULL, 'Matte', NULL, NULL, NULL),
(354, 272, 'Premium Black Wall Paint', '2500', 'paint', 'Black', 'A bold, modern black interior paint for a striking accent wall.', 'paint_black.jpg', '2026-09-12 10:17:16', 'approved', 20, 0, NULL, NULL, 'Water-based', NULL, NULL, NULL, NULL, 'Matte', NULL, NULL, NULL),
(355, 272, 'Premium White Wall Paint', '2500', 'paint', 'White', 'A clean, classic white interior paint that brightens any room.', 'paint_white.jpg', '2026-09-12 10:17:16', 'approved', 20, 0, NULL, NULL, 'Water-based', NULL, NULL, NULL, NULL, 'Matte', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(100) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `user_id`, `product_id`, `rating`, `feedback`, `created_at`) VALUES
(1, 273, 247, 4, 'Good quality tiles, colour matches the picture. Delivery took a bit long though.', '2026-09-11 08:08:54'),
(2, 276, 247, 5, 'Excellent finish, looks premium in person. Highly recommend!', '2026-09-11 08:08:54'),
(3, 274, 250, 3, 'Decent tiles for the price, but a couple of pieces had minor edge chips.', '2026-09-11 08:08:54'),
(4, 273, 336, 4, 'Beautiful rustic texture, easy to install. Would buy again.', '2026-09-11 08:08:54'),
(5, 274, 279, 2, 'Colour was slightly different from the photo, and the roll had a small tear.', '2026-09-11 08:08:54');

-- --------------------------------------------------------

--
-- Table structure for table `providerprofile`
--

CREATE TABLE `providerprofile` (
  `provider_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `call_number` varchar(20) DEFAULT NULL,
  `whatsapp_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `providerprofile`
--

INSERT INTO `providerprofile` (`provider_id`, `name`, `email`, `phone`, `city`, `profile_image`, `password`, `call_number`, `whatsapp_number`) VALUES
(126, 'Ahsan Qureshi', 'ahsan.qureshi1@intradecor.com', '03371304800', 'Lahore', 'provider1.png', '', '03371304800', '03371304800'),
(127, 'Bilal Siddiqui', 'bilal.siddiqui2@intradecor.com', '03264875227', 'Lahore', 'provider2.png', '', '03264875227', '03264875227'),
(128, 'Faisal Mirza', 'faisal.mirza3@intradecor.com', '03382575579', 'Lahore', 'provider3.png', '', '03382575579', '03382575579'),
(129, 'Hassan Chaudhry', 'hassan.chaudhry4@intradecor.com', '03436232389', 'Lahore', 'provider4.png', '', '03436232389', '03436232389'),
(130, 'Imran Butt', 'imran.butt5@intradecor.com', '03376526156', 'Lahore', 'provider5.png', '', '03376526156', '03376526156'),
(131, 'Junaid Rana', 'junaid.rana6@intradecor.com', '03447481103', 'Lahore', 'provider6.png', '', '03447481103', '03447481103'),
(132, 'Kamran Bhatti', 'kamran.bhatti7@intradecor.com', '03279267683', 'Lahore', 'provider7.png', '', '03279267683', '03279267683'),
(133, 'Nasir Nawaz', 'nasir.nawaz8@intradecor.com', '03102977081', 'Lahore', 'provider8.png', '', '03102977081', '03102977081'),
(134, 'Omar Dar', 'omar.dar9@intradecor.com', '03326923061', 'Lahore', 'provider9.png', '', '03326923061', '03326923061'),
(135, 'Rizwan Gill', 'rizwan.gill10@intradecor.com', '03105564175', 'Lahore', 'provider10.png', '', '03105564175', '03105564175'),
(136, 'Shahid Javed', 'sj939918@gmail.com', '03336594482', 'Lahore', 'provider11.png', '', '03336594482', '03336594482'),
(137, 'Tariq Latif', 'tariq.latif12@intradecor.com', '03437477012', 'Lahore', 'provider12.png', '', '03437477012', '03437477012'),
(138, 'Waqas Mehmood', 'waqas.mehmood13@intradecor.com', '03309780007', 'Karachi', '', '', '03309780007', '03309780007'),
(139, 'Yasir Niazi', 'yasir.niazi14@intradecor.com', '03251093202', 'Karachi', '', '', '03251093202', '03251093202'),
(140, 'Zubair Paracha', 'zubair.paracha15@intradecor.com', '03262105303', 'Karachi - DHA Karachi', 'provider6.png', '', '03262105303', '03262105303'),
(141, 'Adnan Raja', 'adnan.raja16@intradecor.com', '03288390350', 'Karachi - Clifton', 'provider7.png', '', '03288390350', '03288390350'),
(142, 'Danish Saeed', 'danish.saeed17@intradecor.com', '03261897533', 'Karachi - Clifton', 'provider8.png', '', '03261897533', '03261897533'),
(143, 'Fahad Tanveer', 'fahad.tanveer18@intradecor.com', '03199221215', 'Karachi - Clifton', 'provider9.png', '', '03199221215', '03199221215'),
(144, 'Ghulam Ullah', 'ghulam.ullah19@intradecor.com', '03460382802', 'Karachi - Gulshan-e-Iqbal', 'provider10.png', '', '03460382802', '03460382802'),
(145, 'Hamid Virk', 'hamid.virk20@intradecor.com', '03432536144', 'Karachi - Gulshan-e-Iqbal', 'provider11.png', '', '03432536144', '03432536144'),
(146, 'Irfan Warraich', 'irfan.warraich21@intradecor.com', '03254139484', 'Karachi - Gulshan-e-Iqbal', 'provider12.png', '', '03254139484', '03254139484'),
(147, 'Khalid Yousaf', 'khalid.yousaf22@intradecor.com', '03222893733', 'Karachi - Saddar', 'provider13.png', '', '03222893733', '03222893733'),
(148, 'Luqman Zahid', 'luqman.zahid23@intradecor.com', '03195848160', 'Karachi - Saddar', 'provider14.png', '', '03195848160', '03195848160'),
(149, 'Mohsin Khan', 'mohsin.khan24@intradecor.com', '03381751673', 'Karachi - Saddar', 'provider15.png', '', '03381751673', '03381751673'),
(150, 'Naveed Ahmed', 'naveed.ahmed25@intradecor.com', '03225056577', 'Islamabad - F-7', 'provider1.png', '', '03225056577', '03225056577'),
(151, 'Pervaiz Ali', 'pervaiz.ali26@intradecor.com', '03410445818', 'Islamabad - F-7', 'provider2.png', '', '03410445818', '03410445818'),
(152, 'Qaiser Malik', 'qaiser.malik27@intradecor.com', '03483648095', 'Islamabad - F-7', 'provider3.png', '', '03483648095', '03483648095'),
(153, 'Salman Raza', 'salman.raza28@intradecor.com', '03438911081', 'Islamabad - F-10', 'provider4.png', '', '03438911081', '03438911081'),
(154, 'Usman Hussain', 'usman.hussain29@intradecor.com', '03470307829', 'Islamabad - F-10', 'provider5.png', '', '03470307829', '03470307829'),
(155, 'Waseem Sheikh', 'waseem.sheikh30@intradecor.com', '03356879931', 'Islamabad - F-10', 'provider6.png', '', '03356879931', '03356879931'),
(156, 'Ahsan Qureshi', 'ahsan.qureshi31@intradecor.com', '03436920459', 'Islamabad - Bahria Town', 'provider7.png', '', '03436920459', '03436920459'),
(157, 'Bilal Siddiqui', 'bilal.siddiqui32@intradecor.com', '03363508365', 'Islamabad - Bahria Town', 'provider8.png', '', '03363508365', '03363508365'),
(158, 'Faisal Mirza', 'faisal.mirza33@intradecor.com', '03324884941', 'Islamabad - Bahria Town', 'provider9.png', '', '03324884941', '03324884941'),
(159, 'Hassan Chaudhry', 'hassan.chaudhry34@intradecor.com', '03283120509', 'Islamabad - DHA Islamabad', 'provider10.png', '', '03283120509', '03283120509'),
(160, 'Imran Butt', 'imran.butt35@intradecor.com', '03480315908', 'Islamabad - DHA Islamabad', 'provider11.png', '', '03480315908', '03480315908'),
(161, 'Junaid Rana', 'junaid.rana36@intradecor.com', '03379936167', 'Islamabad - DHA Islamabad', 'provider12.png', '', '03379936167', '03379936167'),
(162, 'Kamran Bhatti', 'kamran.bhatti37@intradecor.com', '03297818464', 'Rawalpindi - Bahria Town', 'provider13.png', '', '03297818464', '03297818464'),
(163, 'Nasir Nawaz', 'nasir.nawaz38@intradecor.com', '03335162229', 'Rawalpindi - Bahria Town', 'provider14.png', '', '03335162229', '03335162229'),
(164, 'Omar Dar', 'omar.dar39@intradecor.com', '03432952322', 'Rawalpindi - Bahria Town', 'provider15.png', '', '03432952322', '03432952322'),
(165, 'Rizwan Gill', 'rizwan.gill40@intradecor.com', '03381327679', 'Rawalpindi - Saddar', 'provider1.png', '', '03381327679', '03381327679'),
(166, 'Shahid Javed', 'shahid.javed41@intradecor.com', '03268135066', 'Rawalpindi - Saddar', 'provider2.png', '', '03268135066', '03268135066'),
(167, 'Tariq Latif', 'tariq.latif42@intradecor.com', '03328971631', 'Rawalpindi - Saddar', 'provider3.png', '', '03328971631', '03328971631'),
(168, 'Waqas Mehmood', 'waqas.mehmood43@intradecor.com', '03337163762', 'Rawalpindi - Westridge', 'provider4.png', '', '03337163762', '03337163762'),
(169, 'Yasir Niazi', 'yasir.niazi44@intradecor.com', '03234036875', 'Rawalpindi - Westridge', 'provider5.png', '', '03234036875', '03234036875'),
(170, 'Zubair Paracha', 'zubair.paracha45@intradecor.com', '03272691073', 'Rawalpindi - Westridge', 'provider6.png', '', '03272691073', '03272691073'),
(171, 'Adnan Raja', 'adnan.raja46@intradecor.com', '03172024814', 'Rawalpindi - Satellite Town', 'provider7.png', '', '03172024814', '03172024814'),
(172, 'Danish Saeed', 'danish.saeed47@intradecor.com', '03103867538', 'Rawalpindi - Satellite Town', 'provider8.png', '', '03103867538', '03103867538'),
(173, 'Fahad Tanveer', 'fahad.tanveer48@intradecor.com', '03169358536', 'Rawalpindi - Satellite Town', 'provider9.png', '', '03169358536', '03169358536'),
(174, 'Ghulam Ullah', 'ghulam.ullah49@intradecor.com', '03418067633', 'Faisalabad - Gulberg', 'provider10.png', '', '03418067633', '03418067633'),
(175, 'Hamid Virk', 'hamid.virk50@intradecor.com', '03355680636', 'Faisalabad - Gulberg', 'provider11.png', '', '03355680636', '03355680636'),
(176, 'Irfan Warraich', 'irfan.warraich51@intradecor.com', '03407820957', 'Faisalabad - Gulberg', 'provider12.png', '', '03407820957', '03407820957'),
(177, 'Khalid Yousaf', 'khalid.yousaf52@intradecor.com', '03272223882', 'Faisalabad - Madina Town', 'provider13.png', '', '03272223882', '03272223882'),
(178, 'Luqman Zahid', 'luqman.zahid53@intradecor.com', '03357754849', 'Faisalabad - Madina Town', 'provider14.png', '', '03357754849', '03357754849'),
(179, 'Mohsin Khan', 'mohsin.khan54@intradecor.com', '03137504929', 'Faisalabad - Madina Town', 'provider15.png', '', '03137504929', '03137504929'),
(180, 'Naveed Ahmed', 'naveed.ahmed55@intradecor.com', '03444652619', 'Faisalabad - Canal Road', 'provider1.png', '', '03444652619', '03444652619'),
(181, 'Pervaiz Ali', 'pervaiz.ali56@intradecor.com', '03312635852', 'Faisalabad - Canal Road', 'provider2.png', '', '03312635852', '03312635852'),
(182, 'Qaiser Malik', 'qaiser.malik57@intradecor.com', '03198593066', 'Faisalabad - Canal Road', 'provider3.png', '', '03198593066', '03198593066'),
(183, 'Salman Raza', 'salman.raza58@intradecor.com', '03228792923', 'Faisalabad - Susan Road', 'provider4.png', '', '03228792923', '03228792923'),
(184, 'Usman Hussain', 'usman.hussain59@intradecor.com', '03364920577', 'Faisalabad - Susan Road', 'provider5.png', '', '03364920577', '03364920577'),
(185, 'Waseem Sheikh', 'waseem.sheikh60@intradecor.com', '03416563490', 'Faisalabad - Susan Road', 'provider6.png', '', '03416563490', '03416563490'),
(186, 'Ahsan Qureshi', 'ahsan.qureshi61@intradecor.com', '03256699148', 'Multan - Cantt', 'provider7.png', '', '03256699148', '03256699148'),
(187, 'Bilal Siddiqui', 'bilal.siddiqui62@intradecor.com', '03122672199', 'Multan - Cantt', 'provider8.png', '', '03122672199', '03122672199'),
(188, 'Faisal Mirza', 'faisal.mirza63@intradecor.com', '03261210027', 'Multan - Cantt', 'provider9.png', '', '03261210027', '03261210027'),
(189, 'Hassan Chaudhry', 'hassan.chaudhry64@intradecor.com', '03320855019', 'Multan - Gulgasht', 'provider10.png', '', '03320855019', '03320855019'),
(190, 'Imran Butt', 'imran.butt65@intradecor.com', '03258157391', 'Multan - Gulgasht', 'provider11.png', '', '03258157391', '03258157391'),
(191, 'Junaid Rana', 'junaid.rana66@intradecor.com', '03229265717', 'Multan - Gulgasht', 'provider12.png', '', '03229265717', '03229265717'),
(192, 'Kamran Bhatti', 'kamran.bhatti67@intradecor.com', '03483732095', 'Multan - Shah Rukn-e-Alam', 'provider13.png', '', '03483732095', '03483732095'),
(193, 'Nasir Nawaz', 'nasir.nawaz68@intradecor.com', '03390879640', 'Multan - Shah Rukn-e-Alam', 'provider14.png', '', '03390879640', '03390879640'),
(194, 'Omar Dar', 'omar.dar69@intradecor.com', '03232400581', 'Multan - Shah Rukn-e-Alam', 'provider15.png', '', '03232400581', '03232400581'),
(195, 'Rizwan Gill', 'rizwan.gill70@intradecor.com', '03475823549', 'Multan - New Multan', 'provider1.png', '', '03475823549', '03475823549'),
(196, 'Shahid Javed', 'shahid.javed71@intradecor.com', '03333492716', 'Multan - New Multan', 'provider2.png', '', '03333492716', '03333492716'),
(197, 'Tariq Latif', 'tariq.latif72@intradecor.com', '03324170159', 'Multan - New Multan', 'provider3.png', '', '03324170159', '03324170159'),
(198, 'Waqas Mehmood', 'waqas.mehmood73@intradecor.com', '03445105570', 'Gujranwala - GT Road', 'provider4.png', '', '03445105570', '03445105570'),
(199, 'Yasir Niazi', 'yasir.niazi74@intradecor.com', '03150401325', 'Gujranwala - GT Road', 'provider5.png', '', '03150401325', '03150401325'),
(200, 'Zubair Paracha', 'zubair.paracha75@intradecor.com', '03374938553', 'Gujranwala - GT Road', 'provider6.png', '', '03374938553', '03374938553'),
(201, 'Adnan Raja', 'adnan.raja76@intradecor.com', '03459746375', 'Gujranwala - Satellite Town', 'provider7.png', '', '03459746375', '03459746375'),
(202, 'Danish Saeed', 'danish.saeed77@intradecor.com', '03289540884', 'Gujranwala - Satellite Town', 'provider8.png', '', '03289540884', '03289540884'),
(203, 'Fahad Tanveer', 'fahad.tanveer78@intradecor.com', '03456108775', 'Gujranwala - Satellite Town', 'provider9.png', '', '03456108775', '03456108775'),
(204, 'Ghulam Ullah', 'ghulam.ullah79@intradecor.com', '03187790569', 'Gujranwala - Model Town', 'provider10.png', '', '03187790569', '03187790569'),
(205, 'Hamid Virk', 'hamid.virk80@intradecor.com', '03116449151', 'Gujranwala - Model Town', 'provider11.png', '', '03116449151', '03116449151'),
(206, 'Irfan Warraich', 'irfan.warraich81@intradecor.com', '03317130208', 'Gujranwala - Model Town', 'provider12.png', '', '03317130208', '03317130208'),
(207, 'Khalid Yousaf', 'khalid.yousaf82@intradecor.com', '03386795928', 'Gujranwala - Peoples Colony', 'provider13.png', '', '03386795928', '03386795928'),
(208, 'Luqman Zahid', 'luqman.zahid83@intradecor.com', '03346062846', 'Gujranwala - Peoples Colony', 'provider14.png', '', '03346062846', '03346062846'),
(209, 'Mohsin Khan', 'mohsin.khan84@intradecor.com', '03263193422', 'Gujranwala - Peoples Colony', 'provider15.png', '', '03263193422', '03263193422'),
(210, 'Naveed Ahmed', 'naveed.ahmed85@intradecor.com', '03437575614', 'Sialkot - Cantt', 'provider1.png', '', '03437575614', '03437575614'),
(211, 'Pervaiz Ali', 'pervaiz.ali86@intradecor.com', '03367248568', 'Sialkot - Cantt', 'provider2.png', '', '03367248568', '03367248568'),
(212, 'Qaiser Malik', 'qaiser.malik87@intradecor.com', '03429099795', 'Sialkot - Cantt', 'provider3.png', '', '03429099795', '03429099795'),
(213, 'Salman Raza', 'salman.raza88@intradecor.com', '03374691976', 'Sialkot - Allama Iqbal Road', 'provider4.png', '', '03374691976', '03374691976'),
(214, 'Usman Hussain', 'usman.hussain89@intradecor.com', '03471482609', 'Sialkot - Allama Iqbal Road', 'provider5.png', '', '03471482609', '03471482609'),
(215, 'Waseem Sheikh', 'waseem.sheikh90@intradecor.com', '03279499694', 'Sialkot - Allama Iqbal Road', 'provider6.png', '', '03279499694', '03279499694'),
(216, 'Ahsan Qureshi', 'ahsan.qureshi91@intradecor.com', '03373600834', 'Sialkot - Hajipura', 'provider7.png', '', '03373600834', '03373600834'),
(217, 'Bilal Siddiqui', 'bilal.siddiqui92@intradecor.com', '03144528276', 'Sialkot - Hajipura', 'provider8.png', '', '03144528276', '03144528276'),
(218, 'Faisal Mirza', 'faisal.mirza93@intradecor.com', '03320635960', 'Sialkot - Hajipura', 'provider9.png', '', '03320635960', '03320635960'),
(219, 'Hassan Chaudhry', 'hassan.chaudhry94@intradecor.com', '03403113081', 'Sialkot - Paris Road', 'provider10.png', '', '03403113081', '03403113081'),
(220, 'Imran Butt', 'imran.butt95@intradecor.com', '03141059200', 'Sialkot - Paris Road', 'provider11.png', '', '03141059200', '03141059200'),
(221, 'Junaid Rana', 'junaid.rana96@intradecor.com', '03453126055', 'Sialkot - Paris Road', 'provider12.png', '', '03453126055', '03453126055'),
(222, 'Kamran Bhatti', 'kamran.bhatti97@intradecor.com', '03234225509', 'Peshawar - Hayatabad', 'provider13.png', '', '03234225509', '03234225509'),
(223, 'Nasir Nawaz', 'nasir.nawaz98@intradecor.com', '03156901681', 'Peshawar - Hayatabad', 'provider14.png', '', '03156901681', '03156901681'),
(224, 'Omar Dar', 'omar.dar99@intradecor.com', '03317400081', 'Peshawar - Hayatabad', 'provider15.png', '', '03317400081', '03317400081'),
(225, 'Rizwan Gill', 'rizwan.gill100@intradecor.com', '03150529765', 'Peshawar - University Road', 'provider1.png', '', '03150529765', '03150529765'),
(226, 'Shahid Javed', 'shahid.javed101@intradecor.com', '03175465693', 'Peshawar - University Road', 'provider2.png', '', '03175465693', '03175465693'),
(227, 'Tariq Latif', 'tariq.latif102@intradecor.com', '03136507755', 'Peshawar - University Road', 'provider3.png', '', '03136507755', '03136507755'),
(228, 'Waqas Mehmood', 'waqas.mehmood103@intradecor.com', '03459704619', 'Peshawar - Cantt', 'provider4.png', '', '03459704619', '03459704619'),
(229, 'Yasir Niazi', 'yasir.niazi104@intradecor.com', '03139753865', 'Peshawar - Cantt', 'provider5.png', '', '03139753865', '03139753865'),
(230, 'Zubair Paracha', 'zubair.paracha105@intradecor.com', '03418107433', 'Peshawar - Cantt', 'provider6.png', '', '03418107433', '03418107433'),
(231, 'Adnan Raja', 'adnan.raja106@intradecor.com', '03327783057', 'Peshawar - Saddar', 'provider7.png', '', '03327783057', '03327783057'),
(232, 'Danish Saeed', 'danish.saeed107@intradecor.com', '03174544533', 'Peshawar - Saddar', 'provider8.png', '', '03174544533', '03174544533'),
(233, 'Fahad Tanveer', 'fahad.tanveer108@intradecor.com', '03483826757', 'Peshawar - Saddar', 'provider9.png', '', '03483826757', '03483826757'),
(234, 'Ghulam Ullah', 'ghulam.ullah109@intradecor.com', '03212307565', 'Quetta - Cantt', 'provider10.png', '', '03212307565', '03212307565'),
(235, 'Hamid Virk', 'hamid.virk110@intradecor.com', '03421078206', 'Quetta - Cantt', 'provider11.png', '', '03421078206', '03421078206'),
(236, 'Irfan Warraich', 'irfan.warraich111@intradecor.com', '03442739684', 'Quetta - Cantt', 'provider12.png', '', '03442739684', '03442739684'),
(237, 'Khalid Yousaf', 'khalid.yousaf112@intradecor.com', '03203486341', 'Quetta - Satellite Town', 'provider13.png', '', '03203486341', '03203486341'),
(238, 'Luqman Zahid', 'luqman.zahid113@intradecor.com', '03150316789', 'Quetta - Satellite Town', 'provider14.png', '', '03150316789', '03150316789'),
(239, 'Mohsin Khan', 'mohsin.khan114@intradecor.com', '03416370347', 'Quetta - Satellite Town', 'provider15.png', '', '03416370347', '03416370347'),
(240, 'Naveed Ahmed', 'naveed.ahmed115@intradecor.com', '03196777977', 'Quetta - Jinnah Road', 'provider1.png', '', '03196777977', '03196777977'),
(241, 'Pervaiz Ali', 'pervaiz.ali116@intradecor.com', '03493560788', 'Quetta - Jinnah Road', 'provider2.png', '', '03493560788', '03493560788'),
(242, 'Qaiser Malik', 'qaiser.malik117@intradecor.com', '03309907947', 'Quetta - Jinnah Road', 'provider3.png', '', '03309907947', '03309907947'),
(243, 'Salman Raza', 'salman.raza118@intradecor.com', '03252399358', 'Quetta - Sariab Road', 'provider4.png', '', '03252399358', '03252399358'),
(244, 'Usman Hussain', 'usman.hussain119@intradecor.com', '03205978194', 'Quetta - Sariab Road', 'provider5.png', '', '03205978194', '03205978194'),
(245, 'Waseem Sheikh', 'waseem.sheikh120@intradecor.com', '03439151402', 'Quetta - Sariab Road', 'provider6.png', '', '03439151402', '03439151402'),
(246, 'Ahsan Qureshi', 'ahsan.qureshi121@intradecor.com', '03357670069', 'Sheikhupura - Sheikhupura City', 'provider7.png', '', '03357670069', '03357670069'),
(247, 'Bilal Siddiqui', 'bilal.siddiqui122@intradecor.com', '03485886273', 'Sheikhupura - Sheikhupura City', 'provider8.png', '', '03485886273', '03485886273'),
(248, 'Faisal Mirza', 'faisal.mirza123@intradecor.com', '03333808262', 'Sheikhupura - Sheikhupura City', 'provider9.png', '', '03333808262', '03333808262'),
(249, 'Hassan Chaudhry', 'hassan.chaudhry124@intradecor.com', '03189576196', 'Sheikhupura - Housing Colony', 'provider10.png', '', '03189576196', '03189576196'),
(250, 'Imran Butt', 'imran.butt125@intradecor.com', '03404231754', 'Sheikhupura - Housing Colony', 'provider11.png', '', '03404231754', '03404231754'),
(251, 'Junaid Rana', 'junaid.rana126@intradecor.com', '03406258676', 'Sheikhupura - Housing Colony', 'provider12.png', '', '03406258676', '03406258676'),
(252, 'Kamran Bhatti', 'kamran.bhatti127@intradecor.com', '03488035755', 'Sheikhupura - Ghang Road', 'provider13.png', '', '03488035755', '03488035755'),
(253, 'Nasir Nawaz', 'nasir.nawaz128@intradecor.com', '03186880998', 'Sheikhupura - Ghang Road', 'provider14.png', '', '03186880998', '03186880998'),
(254, 'Omar Dar', 'omar.dar129@intradecor.com', '03171752419', 'Sheikhupura - Ghang Road', 'provider15.png', '', '03171752419', '03171752419'),
(255, 'Rizwan Gill', 'rizwan.gill130@intradecor.com', '03454079503', 'Sheikhupura - Bhikhi Road', 'provider1.png', '', '03454079503', '03454079503'),
(256, 'Shahid Javed', 'shahid.javed131@intradecor.com', '03229250908', 'Sheikhupura - Bhikhi Road', 'provider2.png', '', '03229250908', '03229250908'),
(257, 'Tariq Latif', 'tariq.latif132@intradecor.com', '03127485959', 'Sheikhupura - Bhikhi Road', 'provider3.png', '', '03127485959', '03127485959'),
(258, 'Waqas Mehmood', 'waqas.mehmood133@intradecor.com', '03355217337', 'Farooqabad - Farooqabad City', 'provider4.png', '', '03355217337', '03355217337'),
(259, 'Yasir Niazi', 'yasir.niazi134@intradecor.com', '03214845602', 'Farooqabad - Farooqabad City', 'provider5.png', '', '03214845602', '03214845602'),
(260, 'Zubair Paracha', 'zubair.paracha135@intradecor.com', '03456501636', 'Farooqabad - Farooqabad City', 'provider6.png', '', '03456501636', '03456501636'),
(261, 'Adnan Raja', 'adnan.raja136@intradecor.com', '03442547178', 'Farooqabad - GT Road', 'provider7.png', '', '03442547178', '03442547178'),
(262, 'Danish Saeed', 'danish.saeed137@intradecor.com', '03404426543', 'Farooqabad - GT Road', 'provider8.png', '', '03404426543', '03404426543');
INSERT INTO `providerprofile` (`provider_id`, `name`, `email`, `phone`, `city`, `profile_image`, `password`, `call_number`, `whatsapp_number`) VALUES
(263, 'Fahad Tanveer', 'fahad.tanveer138@intradecor.com', '03185303684', 'Farooqabad - GT Road', 'provider9.png', '', '03185303684', '03185303684'),
(264, 'Ghulam Ullah', 'ghulam.ullah139@intradecor.com', '03479504834', 'Farooqabad - Railway Road', 'provider10.png', '', '03479504834', '03479504834'),
(265, 'Hamid Virk', 'hamid.virk140@intradecor.com', '03307516087', 'Farooqabad - Railway Road', 'provider11.png', '', '03307516087', '03307516087'),
(266, 'Irfan Warraich', 'irfan.warraich141@intradecor.com', '03111519202', 'Farooqabad - Railway Road', 'provider12.png', '', '03111519202', '03111519202'),
(267, 'Khalid Yousaf', 'khalid.yousaf142@intradecor.com', '03284041942', 'Farooqabad - New Town', 'provider13.png', '', '03284041942', '03284041942'),
(268, 'Luqman Zahid', 'luqman.zahid143@intradecor.com', '03369714208', 'Farooqabad - New Town', 'provider14.png', '', '03369714208', '03369714208'),
(269, 'Mohsin Khan', 'mohsin.khan144@intradecor.com', '03351750057', 'Farooqabad - New Town', 'provider15.png', '', '03351750057', '03351750057');

-- --------------------------------------------------------

--
-- Table structure for table `sellerprofile`
--

CREATE TABLE `sellerprofile` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `storename` varchar(100) DEFAULT NULL,
  `storeaddress` varchar(255) DEFAULT NULL,
  `storedescription` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellerprofile`
--

INSERT INTO `sellerprofile` (`id`, `userid`, `phone`, `storename`, `storeaddress`, `storedescription`, `city`, `created_at`) VALUES
(2, 273, '03001234567', 'Fatima Tiles Store', 'Lahore, Pakistan', 'We sell high quality ceramic, marble, granite and porcelain tiles.', NULL, '2026-08-19 11:04:26'),
(3, 274, '03007654321', 'Fatima Wallpaper Store', 'Lahore, Pakistan', 'We sell beautiful floral, abstract, geometric and kids wallpaper designs.', NULL, '2026-08-19 11:04:26'),
(4, 275, '03009876543', 'Mano Wall Panels Store', 'Lahore, Pakistan', 'We sell brick veneer, metal, mirror, MDF and PVC wall panels.', NULL, '2026-08-19 11:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `service_gallery`
--

CREATE TABLE `service_gallery` (
  `gallery_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_gallery`
--

INSERT INTO `service_gallery` (`gallery_id`, `service_id`, `image_path`, `uploaded_at`) VALUES
(106, 50, 'paintimage1.png', '2026-06-18 11:44:13'),
(107, 50, 'paintimage2.png', '2026-06-18 11:44:13'),
(108, 50, 'paintimage3.png', '2026-06-18 11:44:13'),
(109, 51, 'tileimage1.png', '2026-06-18 11:44:13'),
(110, 51, 'tileimage2.png', '2026-06-18 11:44:13'),
(111, 51, 'tileimage3.png', '2026-06-18 11:44:13'),
(112, 52, 'wallpaperimage1.png', '2026-06-18 11:44:13'),
(113, 52, 'wallpaperimage2.png', '2026-06-18 11:44:13'),
(114, 52, 'wallpaperimage3.png', '2026-06-18 11:44:13'),
(115, 53, 'wallpenals1.png', '2026-06-18 11:44:13'),
(116, 53, 'wallpenals2.png', '2026-06-18 11:44:13'),
(117, 53, 'wallpenals3.png', '2026-06-18 11:44:13'),
(118, 54, 'paintimage4.png', '2026-06-18 11:44:13'),
(119, 54, 'paintimage5.png', '2026-06-18 11:44:13'),
(120, 54, 'paintimage6.png', '2026-06-18 11:44:13'),
(121, 55, 'tileimage4.png', '2026-06-18 11:44:13'),
(122, 55, 'tileimage5.png', '2026-06-18 11:44:13'),
(123, 55, 'tileimage6.png', '2026-06-18 11:44:13'),
(124, 56, 'wallpaperimage4.png', '2026-06-18 11:44:13'),
(125, 56, 'wallpaperimage5.png', '2026-06-18 11:44:13'),
(126, 56, 'wallpaperimage6.png', '2026-06-18 11:44:13'),
(127, 57, 'wallpenals4.png', '2026-06-18 11:44:13'),
(128, 57, 'wallpenals5.png', '2026-06-18 11:44:13'),
(129, 57, 'wallpenals6.png', '2026-06-18 11:44:13'),
(130, 58, 'paintimage7.png', '2026-06-18 11:44:13'),
(131, 58, 'paintimage8.png', '2026-06-18 11:44:13'),
(132, 58, 'paintimage9.png', '2026-06-18 11:44:13'),
(133, 59, 'tileimage7.png', '2026-06-18 11:44:13'),
(134, 59, 'tileimage8.png', '2026-06-18 11:44:13'),
(135, 59, 'tileimage9.png', '2026-06-18 11:44:13'),
(136, 60, 'wallpaperimage7.png', '2026-06-18 11:44:13'),
(137, 60, 'wallpaperimage8.png', '2026-06-18 11:44:13'),
(138, 60, 'wallpaperimage9.png', '2026-06-18 11:44:13'),
(139, 61, 'wallpenals7.png', '2026-06-18 11:44:13'),
(140, 61, 'wallpenals8.png', '2026-06-18 11:44:13'),
(141, 61, 'wallpenals9.png', '2026-06-18 11:44:13'),
(142, 62, 'paintimage10.png', '2026-06-18 11:44:13'),
(143, 62, 'paintimage11.png', '2026-06-18 11:44:13'),
(144, 62, 'paintimage12.png', '2026-06-18 11:44:13'),
(145, 63, 'tileimage10.png', '2026-06-18 11:44:13'),
(146, 63, 'tileimage11.png', '2026-06-18 11:44:13'),
(147, 63, 'tileimage12.png', '2026-06-18 11:44:13'),
(148, 64, 'wallpaperimage10.png', '2026-06-18 11:44:13'),
(149, 64, 'wallpaperimage11.png', '2026-06-18 11:44:13'),
(150, 64, 'wallpaperimage12.png', '2026-06-18 11:44:13'),
(151, 65, 'wallpenals10.png', '2026-06-18 11:44:13'),
(152, 65, 'wallpenals11.png', '2026-06-18 11:44:13'),
(153, 65, 'wallpenals12.png', '2026-06-18 11:44:13'),
(154, 66, 'paintimage1.png', '2026-06-18 11:44:13'),
(155, 66, 'paintimage2.png', '2026-06-18 11:44:13'),
(156, 66, 'paintimage3.png', '2026-06-18 11:44:13'),
(157, 67, 'tileimage1.png', '2026-06-18 11:44:13'),
(158, 67, 'tileimage2.png', '2026-06-18 11:44:13'),
(159, 67, 'tileimage3.png', '2026-06-18 11:44:13'),
(160, 68, 'wallpaperimage1.png', '2026-06-18 11:44:13'),
(161, 68, 'wallpaperimage2.png', '2026-06-18 11:44:13'),
(162, 68, 'wallpaperimage3.png', '2026-06-18 11:44:13'),
(163, 69, 'wallpenals1.png', '2026-06-18 11:44:13'),
(164, 69, 'wallpenals2.png', '2026-06-18 11:44:13'),
(165, 69, 'wallpenals3.png', '2026-06-18 11:44:13'),
(166, 70, 'paintimage4.png', '2026-06-18 11:44:13'),
(167, 70, 'paintimage5.png', '2026-06-18 11:44:13'),
(168, 70, 'paintimage6.png', '2026-06-18 11:44:13'),
(169, 71, 'tileimage4.png', '2026-06-18 11:44:13'),
(170, 71, 'tileimage5.png', '2026-06-18 11:44:13'),
(171, 71, 'tileimage6.png', '2026-06-18 11:44:13'),
(172, 72, 'wallpaperimage4.png', '2026-06-18 11:44:13'),
(173, 72, 'wallpaperimage5.png', '2026-06-18 11:44:13'),
(174, 72, 'wallpaperimage6.png', '2026-06-18 11:44:13'),
(175, 73, 'wallpenals4.png', '2026-06-18 11:44:13'),
(176, 73, 'wallpenals5.png', '2026-06-18 11:44:13'),
(177, 73, 'wallpenals6.png', '2026-06-18 11:44:13'),
(178, 74, 'paintimage7.png', '2026-06-18 11:44:13'),
(179, 74, 'paintimage8.png', '2026-06-18 11:44:13'),
(180, 74, 'paintimage9.png', '2026-06-18 11:44:13'),
(181, 75, 'tileimage7.png', '2026-06-18 11:44:13'),
(182, 75, 'tileimage8.png', '2026-06-18 11:44:13'),
(183, 75, 'tileimage9.png', '2026-06-18 11:44:13'),
(184, 76, 'wallpaperimage7.png', '2026-06-18 11:44:13'),
(185, 76, 'wallpaperimage8.png', '2026-06-18 11:44:13'),
(186, 76, 'wallpaperimage9.png', '2026-06-18 11:44:13'),
(187, 77, 'wallpenals7.png', '2026-06-18 11:44:13'),
(188, 77, 'wallpenals8.png', '2026-06-18 11:44:13'),
(189, 77, 'wallpenals9.png', '2026-06-18 11:44:13'),
(190, 78, 'paintimage10.png', '2026-06-18 11:44:13'),
(191, 78, 'paintimage11.png', '2026-06-18 11:44:13'),
(192, 78, 'paintimage12.png', '2026-06-18 11:44:13'),
(193, 79, 'tileimage10.png', '2026-06-18 11:44:13'),
(194, 79, 'tileimage11.png', '2026-06-18 11:44:13'),
(195, 79, 'tileimage12.png', '2026-06-18 11:44:13'),
(196, 80, 'wallpaperimage10.png', '2026-06-18 11:44:13'),
(197, 80, 'wallpaperimage11.png', '2026-06-18 11:44:13'),
(198, 80, 'wallpaperimage12.png', '2026-06-18 11:44:13'),
(199, 81, 'wallpenals10.png', '2026-06-18 11:44:13'),
(200, 81, 'wallpenals11.png', '2026-06-18 11:44:13'),
(201, 81, 'wallpenals12.png', '2026-06-18 11:44:13'),
(202, 82, 'paintimage1.png', '2026-06-18 11:44:13'),
(203, 82, 'paintimage2.png', '2026-06-18 11:44:13'),
(204, 82, 'paintimage3.png', '2026-06-18 11:44:13'),
(205, 83, 'tileimage1.png', '2026-06-18 11:44:13'),
(206, 83, 'tileimage2.png', '2026-06-18 11:44:13'),
(207, 83, 'tileimage3.png', '2026-06-18 11:44:13'),
(208, 84, 'wallpaperimage1.png', '2026-06-18 11:44:13'),
(209, 84, 'wallpaperimage2.png', '2026-06-18 11:44:13'),
(210, 84, 'wallpaperimage3.png', '2026-06-18 11:44:13'),
(211, 85, 'wallpenals1.png', '2026-06-18 11:44:13'),
(212, 85, 'wallpenals2.png', '2026-06-18 11:44:13'),
(213, 85, 'wallpenals3.png', '2026-06-18 11:44:13'),
(214, 86, 'paintimage4.png', '2026-06-18 11:44:13'),
(215, 86, 'paintimage5.png', '2026-06-18 11:44:13'),
(216, 86, 'paintimage6.png', '2026-06-18 11:44:13'),
(217, 87, 'tileimage4.png', '2026-06-18 11:44:13'),
(218, 87, 'tileimage5.png', '2026-06-18 11:44:13'),
(219, 87, 'tileimage6.png', '2026-06-18 11:44:13'),
(220, 88, 'wallpaperimage4.png', '2026-06-18 11:44:13'),
(221, 88, 'wallpaperimage5.png', '2026-06-18 11:44:13'),
(222, 88, 'wallpaperimage6.png', '2026-06-18 11:44:13'),
(223, 89, 'wallpenals4.png', '2026-06-18 11:44:13'),
(224, 89, 'wallpenals5.png', '2026-06-18 11:44:13'),
(225, 89, 'wallpenals6.png', '2026-06-18 11:44:13'),
(226, 90, 'paintimage7.png', '2026-06-18 11:44:13'),
(227, 90, 'paintimage8.png', '2026-06-18 11:44:13'),
(228, 90, 'paintimage9.png', '2026-06-18 11:44:13'),
(229, 91, 'tileimage7.png', '2026-06-18 11:44:13'),
(230, 91, 'tileimage8.png', '2026-06-18 11:44:13'),
(231, 91, 'tileimage9.png', '2026-06-18 11:44:13'),
(232, 92, 'wallpaperimage7.png', '2026-06-18 11:44:13'),
(233, 92, 'wallpaperimage8.png', '2026-06-18 11:44:13'),
(234, 92, 'wallpaperimage9.png', '2026-06-18 11:44:13'),
(235, 93, 'wallpenals7.png', '2026-06-18 11:44:13'),
(236, 93, 'wallpenals8.png', '2026-06-18 11:44:13'),
(237, 93, 'wallpenals9.png', '2026-06-18 11:44:13'),
(238, 94, 'paintimage10.png', '2026-06-18 11:44:13'),
(239, 94, 'paintimage11.png', '2026-06-18 11:44:13'),
(240, 94, 'paintimage12.png', '2026-06-18 11:44:13'),
(241, 95, 'tileimage10.png', '2026-06-18 11:44:13'),
(242, 95, 'tileimage11.png', '2026-06-18 11:44:13'),
(243, 95, 'tileimage12.png', '2026-06-18 11:44:13'),
(244, 96, 'wallpaperimage10.png', '2026-06-18 11:44:13'),
(245, 96, 'wallpaperimage11.png', '2026-06-18 11:44:13'),
(246, 96, 'wallpaperimage12.png', '2026-06-18 11:44:13'),
(247, 97, 'wallpenals10.png', '2026-06-18 11:44:13'),
(248, 97, 'wallpenals11.png', '2026-06-18 11:44:13'),
(249, 97, 'wallpenals12.png', '2026-06-18 11:44:13'),
(250, 98, 'paintimage1.png', '2026-06-18 11:44:13'),
(251, 98, 'paintimage2.png', '2026-06-18 11:44:13'),
(252, 98, 'paintimage3.png', '2026-06-18 11:44:13'),
(253, 99, 'tileimage1.png', '2026-06-18 11:44:13'),
(254, 99, 'tileimage2.png', '2026-06-18 11:44:13'),
(255, 99, 'tileimage3.png', '2026-06-18 11:44:13'),
(256, 100, 'wallpaperimage1.png', '2026-06-18 11:44:13'),
(257, 100, 'wallpaperimage2.png', '2026-06-18 11:44:13'),
(258, 100, 'wallpaperimage3.png', '2026-06-18 11:44:13'),
(259, 101, 'wallpenals1.png', '2026-06-18 11:44:13'),
(260, 101, 'wallpenals2.png', '2026-06-18 11:44:13'),
(261, 101, 'wallpenals3.png', '2026-06-18 11:44:13'),
(262, 102, 'paintimage4.png', '2026-06-18 11:44:13'),
(263, 102, 'paintimage5.png', '2026-06-18 11:44:13'),
(264, 102, 'paintimage6.png', '2026-06-18 11:44:13'),
(265, 103, 'tileimage4.png', '2026-06-18 11:44:13'),
(266, 103, 'tileimage5.png', '2026-06-18 11:44:13'),
(267, 103, 'tileimage6.png', '2026-06-18 11:44:13'),
(268, 104, 'wallpaperimage4.png', '2026-06-18 11:44:13'),
(269, 104, 'wallpaperimage5.png', '2026-06-18 11:44:13'),
(270, 104, 'wallpaperimage6.png', '2026-06-18 11:44:13'),
(271, 105, 'wallpenals4.png', '2026-06-18 11:44:13'),
(272, 105, 'wallpenals5.png', '2026-06-18 11:44:13'),
(273, 105, 'wallpenals6.png', '2026-06-18 11:44:13'),
(274, 106, 'paintimage7.png', '2026-06-18 11:44:13'),
(275, 106, 'paintimage8.png', '2026-06-18 11:44:13'),
(276, 106, 'paintimage9.png', '2026-06-18 11:44:13'),
(277, 107, 'tileimage7.png', '2026-06-18 11:44:13'),
(278, 107, 'tileimage8.png', '2026-06-18 11:44:13'),
(279, 107, 'tileimage9.png', '2026-06-18 11:44:13'),
(280, 108, 'wallpaperimage7.png', '2026-06-18 11:44:13'),
(281, 108, 'wallpaperimage8.png', '2026-06-18 11:44:13'),
(282, 108, 'wallpaperimage9.png', '2026-06-18 11:44:13'),
(283, 109, 'wallpenals7.png', '2026-06-18 11:44:13'),
(284, 109, 'wallpenals8.png', '2026-06-18 11:44:13'),
(285, 109, 'wallpenals9.png', '2026-06-18 11:44:13'),
(286, 110, 'paintimage10.png', '2026-06-18 11:44:13'),
(287, 110, 'paintimage11.png', '2026-06-18 11:44:13'),
(288, 110, 'paintimage12.png', '2026-06-18 11:44:13'),
(289, 111, 'tileimage10.png', '2026-06-18 11:44:13'),
(290, 111, 'tileimage11.png', '2026-06-18 11:44:13'),
(291, 111, 'tileimage12.png', '2026-06-18 11:44:13'),
(292, 112, 'wallpaperimage10.png', '2026-06-18 11:44:13'),
(293, 112, 'wallpaperimage11.png', '2026-06-18 11:44:13'),
(294, 112, 'wallpaperimage12.png', '2026-06-18 11:44:13'),
(295, 113, 'wallpenals10.png', '2026-06-18 11:44:13'),
(296, 113, 'wallpenals11.png', '2026-06-18 11:44:13'),
(297, 113, 'wallpenals12.png', '2026-06-18 11:44:13'),
(298, 114, 'paintimage1.png', '2026-06-18 11:44:13'),
(299, 114, 'paintimage2.png', '2026-06-18 11:44:13'),
(300, 114, 'paintimage3.png', '2026-06-18 11:44:13'),
(301, 115, 'tileimage1.png', '2026-06-18 11:44:13'),
(302, 115, 'tileimage2.png', '2026-06-18 11:44:13'),
(303, 115, 'tileimage3.png', '2026-06-18 11:44:13'),
(304, 116, 'wallpaperimage1.png', '2026-06-18 11:44:13'),
(305, 116, 'wallpaperimage2.png', '2026-06-18 11:44:13'),
(306, 116, 'wallpaperimage3.png', '2026-06-18 11:44:13'),
(307, 117, 'wallpenals1.png', '2026-06-18 11:44:13'),
(308, 117, 'wallpenals2.png', '2026-06-18 11:44:13'),
(309, 117, 'wallpenals3.png', '2026-06-18 11:44:13'),
(310, 118, 'paintimage4.png', '2026-06-18 11:44:13'),
(311, 118, 'paintimage5.png', '2026-06-18 11:44:13'),
(312, 118, 'paintimage6.png', '2026-06-18 11:44:13'),
(313, 119, 'tileimage4.png', '2026-06-18 11:44:13'),
(314, 119, 'tileimage5.png', '2026-06-18 11:44:13'),
(315, 119, 'tileimage6.png', '2026-06-18 11:44:13'),
(316, 120, 'wallpaperimage4.png', '2026-06-18 11:44:13'),
(317, 120, 'wallpaperimage5.png', '2026-06-18 11:44:13'),
(318, 120, 'wallpaperimage6.png', '2026-06-18 11:44:13'),
(319, 121, 'wallpenals4.png', '2026-06-18 11:44:13'),
(320, 121, 'wallpenals5.png', '2026-06-18 11:44:13'),
(321, 121, 'wallpenals6.png', '2026-06-18 11:44:13'),
(322, 122, 'paintimage7.png', '2026-06-18 11:44:13'),
(323, 122, 'paintimage8.png', '2026-06-18 11:44:13'),
(324, 122, 'paintimage9.png', '2026-06-18 11:44:13'),
(325, 123, 'tileimage7.png', '2026-06-18 11:44:13'),
(326, 123, 'tileimage8.png', '2026-06-18 11:44:13'),
(327, 123, 'tileimage9.png', '2026-06-18 11:44:13'),
(328, 124, 'wallpaperimage7.png', '2026-06-18 11:44:13'),
(329, 124, 'wallpaperimage8.png', '2026-06-18 11:44:13'),
(330, 124, 'wallpaperimage9.png', '2026-06-18 11:44:13'),
(331, 125, 'wallpenals7.png', '2026-06-18 11:44:13'),
(332, 125, 'wallpenals8.png', '2026-06-18 11:44:13'),
(333, 125, 'wallpenals9.png', '2026-06-18 11:44:13'),
(334, 126, 'paintimage10.png', '2026-06-18 11:44:13'),
(335, 126, 'paintimage11.png', '2026-06-18 11:44:13'),
(336, 126, 'paintimage12.png', '2026-06-18 11:44:13'),
(337, 127, 'tileimage10.png', '2026-06-18 11:44:13'),
(338, 127, 'tileimage11.png', '2026-06-18 11:44:13'),
(339, 127, 'tileimage12.png', '2026-06-18 11:44:13'),
(340, 128, 'wallpaperimage10.png', '2026-06-18 11:44:13'),
(341, 128, 'wallpaperimage11.png', '2026-06-18 11:44:13'),
(342, 128, 'wallpaperimage12.png', '2026-06-18 11:44:13'),
(343, 129, 'wallpenals10.png', '2026-06-18 11:44:13'),
(344, 129, 'wallpenals11.png', '2026-06-18 11:44:13'),
(345, 129, 'wallpenals12.png', '2026-06-18 11:44:13'),
(346, 130, 'paintimage1.png', '2026-06-18 11:44:13'),
(347, 130, 'paintimage2.png', '2026-06-18 11:44:13'),
(348, 130, 'paintimage3.png', '2026-06-18 11:44:13'),
(349, 131, 'tileimage1.png', '2026-06-18 11:44:13'),
(350, 131, 'tileimage2.png', '2026-06-18 11:44:13'),
(351, 131, 'tileimage3.png', '2026-06-18 11:44:13'),
(352, 132, 'wallpaperimage1.png', '2026-06-18 11:44:13'),
(353, 132, 'wallpaperimage2.png', '2026-06-18 11:44:13'),
(354, 132, 'wallpaperimage3.png', '2026-06-18 11:44:13'),
(355, 133, 'wallpenals1.png', '2026-06-18 11:44:13'),
(356, 133, 'wallpenals2.png', '2026-06-18 11:44:13'),
(357, 133, 'wallpenals3.png', '2026-06-18 11:44:13'),
(358, 134, 'paintimage4.png', '2026-06-18 11:44:13'),
(359, 134, 'paintimage5.png', '2026-06-18 11:44:13'),
(360, 134, 'paintimage6.png', '2026-06-18 11:44:13'),
(361, 135, 'tileimage4.png', '2026-06-18 11:44:13'),
(362, 135, 'tileimage5.png', '2026-06-18 11:44:13'),
(363, 135, 'tileimage6.png', '2026-06-18 11:44:13'),
(364, 136, 'wallpaperimage4.png', '2026-06-18 11:44:13'),
(365, 136, 'wallpaperimage5.png', '2026-06-18 11:44:13'),
(366, 136, 'wallpaperimage6.png', '2026-06-18 11:44:13'),
(367, 137, 'wallpenals4.png', '2026-06-18 11:44:13'),
(368, 137, 'wallpenals5.png', '2026-06-18 11:44:13'),
(369, 137, 'wallpenals6.png', '2026-06-18 11:44:13'),
(370, 138, 'paintimage7.png', '2026-06-18 11:44:13'),
(371, 138, 'paintimage8.png', '2026-06-18 11:44:13'),
(372, 138, 'paintimage9.png', '2026-06-18 11:44:13'),
(373, 139, 'tileimage7.png', '2026-06-18 11:44:13'),
(374, 139, 'tileimage8.png', '2026-06-18 11:44:13'),
(375, 139, 'tileimage9.png', '2026-06-18 11:44:13'),
(376, 140, 'wallpaperimage7.png', '2026-06-18 11:44:13'),
(377, 140, 'wallpaperimage8.png', '2026-06-18 11:44:13'),
(378, 140, 'wallpaperimage9.png', '2026-06-18 11:44:13'),
(379, 141, 'wallpenals7.png', '2026-06-18 11:44:13'),
(380, 141, 'wallpenals8.png', '2026-06-18 11:44:13'),
(381, 141, 'wallpenals9.png', '2026-06-18 11:44:13'),
(382, 142, 'paintimage10.png', '2026-06-18 11:44:13'),
(383, 142, 'paintimage11.png', '2026-06-18 11:44:13'),
(384, 142, 'paintimage12.png', '2026-06-18 11:44:13'),
(385, 143, 'tileimage10.png', '2026-06-18 11:44:13'),
(386, 143, 'tileimage11.png', '2026-06-18 11:44:13'),
(387, 143, 'tileimage12.png', '2026-06-18 11:44:13'),
(388, 144, 'wallpaperimage10.png', '2026-06-18 11:44:13'),
(389, 144, 'wallpaperimage11.png', '2026-06-18 11:44:13'),
(390, 144, 'wallpaperimage12.png', '2026-06-18 11:44:13'),
(391, 145, 'wallpenals10.png', '2026-06-18 11:44:13'),
(392, 145, 'wallpenals11.png', '2026-06-18 11:44:13'),
(393, 145, 'wallpenals12.png', '2026-06-18 11:44:13'),
(394, 146, 'paintimage1.png', '2026-06-18 11:44:13'),
(395, 146, 'paintimage2.png', '2026-06-18 11:44:13'),
(396, 146, 'paintimage3.png', '2026-06-18 11:44:13'),
(397, 147, 'tileimage1.png', '2026-06-18 11:44:13'),
(398, 147, 'tileimage2.png', '2026-06-18 11:44:13'),
(399, 147, 'tileimage3.png', '2026-06-18 11:44:13'),
(400, 148, 'wallpaperimage1.png', '2026-06-18 11:44:13'),
(401, 148, 'wallpaperimage2.png', '2026-06-18 11:44:13'),
(402, 148, 'wallpaperimage3.png', '2026-06-18 11:44:13'),
(403, 149, 'wallpenals1.png', '2026-06-18 11:44:13'),
(404, 149, 'wallpenals2.png', '2026-06-18 11:44:13'),
(405, 149, 'wallpenals3.png', '2026-06-18 11:44:13'),
(406, 150, 'paintimage4.png', '2026-06-18 11:44:13'),
(407, 150, 'paintimage5.png', '2026-06-18 11:44:13'),
(408, 150, 'paintimage6.png', '2026-06-18 11:44:13'),
(409, 151, 'tileimage4.png', '2026-06-18 11:44:13'),
(410, 151, 'tileimage5.png', '2026-06-18 11:44:13'),
(411, 151, 'tileimage6.png', '2026-06-18 11:44:13'),
(412, 152, 'wallpaperimage4.png', '2026-06-18 11:44:13'),
(413, 152, 'wallpaperimage5.png', '2026-06-18 11:44:13'),
(414, 152, 'wallpaperimage6.png', '2026-06-18 11:44:13'),
(415, 153, 'wallpenals4.png', '2026-06-18 11:44:13'),
(416, 153, 'wallpenals5.png', '2026-06-18 11:44:13'),
(417, 153, 'wallpenals6.png', '2026-06-18 11:44:13'),
(418, 154, 'paintimage7.png', '2026-06-18 11:44:13'),
(419, 154, 'paintimage8.png', '2026-06-18 11:44:13'),
(420, 154, 'paintimage9.png', '2026-06-18 11:44:13'),
(421, 155, 'tileimage7.png', '2026-06-18 11:44:13'),
(422, 155, 'tileimage8.png', '2026-06-18 11:44:13'),
(423, 155, 'tileimage9.png', '2026-06-18 11:44:13'),
(424, 156, 'wallpaperimage7.png', '2026-06-18 11:44:13'),
(425, 156, 'wallpaperimage8.png', '2026-06-18 11:44:13'),
(426, 156, 'wallpaperimage9.png', '2026-06-18 11:44:13'),
(427, 157, 'wallpenals7.png', '2026-06-18 11:44:13'),
(428, 157, 'wallpenals8.png', '2026-06-18 11:44:13'),
(429, 157, 'wallpenals9.png', '2026-06-18 11:44:13'),
(430, 158, 'paintimage10.png', '2026-06-18 11:44:13'),
(431, 158, 'paintimage11.png', '2026-06-18 11:44:13'),
(432, 158, 'paintimage12.png', '2026-06-18 11:44:13'),
(433, 159, 'tileimage10.png', '2026-06-18 11:44:13'),
(434, 159, 'tileimage11.png', '2026-06-18 11:44:13'),
(435, 159, 'tileimage12.png', '2026-06-18 11:44:13'),
(436, 160, 'wallpaperimage10.png', '2026-06-18 11:44:13'),
(437, 160, 'wallpaperimage11.png', '2026-06-18 11:44:13'),
(438, 160, 'wallpaperimage12.png', '2026-06-18 11:44:13'),
(439, 161, 'wallpenals10.png', '2026-06-18 11:44:13'),
(440, 161, 'wallpenals11.png', '2026-06-18 11:44:13'),
(441, 161, 'wallpenals12.png', '2026-06-18 11:44:13'),
(442, 162, 'paintimage1.png', '2026-06-18 11:44:13'),
(443, 162, 'paintimage2.png', '2026-06-18 11:44:13'),
(444, 162, 'paintimage3.png', '2026-06-18 11:44:13'),
(445, 163, 'tileimage1.png', '2026-06-18 11:44:13'),
(446, 163, 'tileimage2.png', '2026-06-18 11:44:13'),
(447, 163, 'tileimage3.png', '2026-06-18 11:44:13'),
(448, 164, 'wallpaperimage1.png', '2026-06-18 11:44:13'),
(449, 164, 'wallpaperimage2.png', '2026-06-18 11:44:13'),
(450, 164, 'wallpaperimage3.png', '2026-06-18 11:44:13'),
(451, 165, 'wallpenals1.png', '2026-06-18 11:44:13'),
(452, 165, 'wallpenals2.png', '2026-06-18 11:44:13'),
(453, 165, 'wallpenals3.png', '2026-06-18 11:44:13'),
(454, 166, 'paintimage4.png', '2026-06-18 11:44:13'),
(455, 166, 'paintimage5.png', '2026-06-18 11:44:13'),
(456, 166, 'paintimage6.png', '2026-06-18 11:44:13'),
(457, 167, 'tileimage4.png', '2026-06-18 11:44:13'),
(458, 167, 'tileimage5.png', '2026-06-18 11:44:13'),
(459, 167, 'tileimage6.png', '2026-06-18 11:44:13'),
(460, 168, 'wallpaperimage4.png', '2026-06-18 11:44:13'),
(461, 168, 'wallpaperimage5.png', '2026-06-18 11:44:13'),
(462, 168, 'wallpaperimage6.png', '2026-06-18 11:44:13'),
(463, 169, 'wallpenals4.png', '2026-06-18 11:44:13'),
(464, 169, 'wallpenals5.png', '2026-06-18 11:44:13'),
(465, 169, 'wallpenals6.png', '2026-06-18 11:44:13'),
(466, 170, 'paintimage7.png', '2026-06-18 11:44:13'),
(467, 170, 'paintimage8.png', '2026-06-18 11:44:13'),
(468, 170, 'paintimage9.png', '2026-06-18 11:44:13'),
(469, 171, 'tileimage7.png', '2026-06-18 11:44:13'),
(470, 171, 'tileimage8.png', '2026-06-18 11:44:13'),
(471, 171, 'tileimage9.png', '2026-06-18 11:44:13'),
(472, 172, 'wallpaperimage7.png', '2026-06-18 11:44:13'),
(473, 172, 'wallpaperimage8.png', '2026-06-18 11:44:13'),
(474, 172, 'wallpaperimage9.png', '2026-06-18 11:44:13'),
(475, 173, 'wallpenals7.png', '2026-06-18 11:44:13'),
(476, 173, 'wallpenals8.png', '2026-06-18 11:44:13'),
(477, 173, 'wallpenals9.png', '2026-06-18 11:44:13'),
(478, 174, 'paintimage10.png', '2026-06-18 11:44:13'),
(479, 174, 'paintimage11.png', '2026-06-18 11:44:13'),
(480, 174, 'paintimage12.png', '2026-06-18 11:44:13'),
(481, 175, 'tileimage10.png', '2026-06-18 11:44:13'),
(482, 175, 'tileimage11.png', '2026-06-18 11:44:13'),
(483, 175, 'tileimage12.png', '2026-06-18 11:44:13');
INSERT INTO `service_gallery` (`gallery_id`, `service_id`, `image_path`, `uploaded_at`) VALUES
(484, 176, 'wallpaperimage10.png', '2026-06-18 11:44:13'),
(485, 176, 'wallpaperimage11.png', '2026-06-18 11:44:13'),
(486, 176, 'wallpaperimage12.png', '2026-06-18 11:44:13'),
(487, 177, 'wallpenals10.png', '2026-06-18 11:44:13'),
(488, 177, 'wallpenals11.png', '2026-06-18 11:44:13'),
(489, 177, 'wallpenals12.png', '2026-06-18 11:44:13'),
(490, 178, 'paintimage1.png', '2026-06-18 11:44:13'),
(491, 178, 'paintimage2.png', '2026-06-18 11:44:13'),
(492, 178, 'paintimage3.png', '2026-06-18 11:44:13'),
(493, 179, 'tileimage1.png', '2026-06-18 11:44:13'),
(494, 179, 'tileimage2.png', '2026-06-18 11:44:13'),
(495, 179, 'tileimage3.png', '2026-06-18 11:44:13'),
(496, 180, 'wallpaperimage1.png', '2026-06-18 11:44:13'),
(497, 180, 'wallpaperimage2.png', '2026-06-18 11:44:13'),
(498, 180, 'wallpaperimage3.png', '2026-06-18 11:44:13'),
(499, 181, 'wallpenals1.png', '2026-06-18 11:44:13'),
(500, 181, 'wallpenals2.png', '2026-06-18 11:44:13'),
(501, 181, 'wallpenals3.png', '2026-06-18 11:44:13'),
(502, 182, 'paintimage4.png', '2026-06-18 11:44:13'),
(503, 182, 'paintimage5.png', '2026-06-18 11:44:13'),
(504, 182, 'paintimage6.png', '2026-06-18 11:44:13'),
(505, 183, 'tileimage4.png', '2026-06-18 11:44:13'),
(506, 183, 'tileimage5.png', '2026-06-18 11:44:13'),
(507, 183, 'tileimage6.png', '2026-06-18 11:44:13'),
(508, 184, 'wallpaperimage4.png', '2026-06-18 11:44:13'),
(509, 184, 'wallpaperimage5.png', '2026-06-18 11:44:13'),
(510, 184, 'wallpaperimage6.png', '2026-06-18 11:44:13'),
(511, 185, 'wallpenals4.png', '2026-06-18 11:44:13'),
(512, 185, 'wallpenals5.png', '2026-06-18 11:44:13'),
(513, 185, 'wallpenals6.png', '2026-06-18 11:44:13'),
(514, 186, 'paintimage7.png', '2026-06-18 11:44:13'),
(515, 186, 'paintimage8.png', '2026-06-18 11:44:13'),
(516, 186, 'paintimage9.png', '2026-06-18 11:44:13'),
(517, 187, 'tileimage7.png', '2026-06-18 11:44:13'),
(518, 187, 'tileimage8.png', '2026-06-18 11:44:13'),
(519, 187, 'tileimage9.png', '2026-06-18 11:44:13'),
(520, 188, 'wallpaperimage7.png', '2026-06-18 11:44:13'),
(521, 188, 'wallpaperimage8.png', '2026-06-18 11:44:13'),
(522, 188, 'wallpaperimage9.png', '2026-06-18 11:44:13'),
(523, 189, 'wallpenals7.png', '2026-06-18 11:44:13'),
(524, 189, 'wallpenals8.png', '2026-06-18 11:44:13'),
(525, 189, 'wallpenals9.png', '2026-06-18 11:44:13'),
(526, 190, 'paintimage10.png', '2026-06-18 11:44:13'),
(527, 190, 'paintimage11.png', '2026-06-18 11:44:13'),
(528, 190, 'paintimage12.png', '2026-06-18 11:44:13'),
(529, 191, 'tileimage10.png', '2026-06-18 11:44:13'),
(530, 191, 'tileimage11.png', '2026-06-18 11:44:13'),
(531, 191, 'tileimage12.png', '2026-06-18 11:44:13'),
(532, 192, 'wallpaperimage10.png', '2026-06-18 11:44:13'),
(533, 192, 'wallpaperimage11.png', '2026-06-18 11:44:13'),
(534, 192, 'wallpaperimage12.png', '2026-06-18 11:44:13'),
(535, 193, 'wallpenals10.png', '2026-06-18 11:44:13'),
(536, 193, 'wallpenals11.png', '2026-06-18 11:44:13'),
(537, 193, 'wallpenals12.png', '2026-06-18 11:44:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT 'NOT NULL',
  `email` varchar(100) NOT NULL DEFAULT 'NOT NULL UNIQUE',
  `password` varchar(255) NOT NULL DEFAULT 'NOT NULL',
  `city` varchar(100) NOT NULL DEFAULT 'NOT NULL',
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expire` datetime DEFAULT NULL,
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expire` datetime DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `city`, `phone`, `role`, `reset_token`, `token_expire`, `otp_code`, `otp_expire`, `is_approved`) VALUES
(126, 'Ahsan Qureshi', 'ahsan.qureshi1@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Lahore', '03371304800', 'service_provider', NULL, NULL, NULL, NULL, 1),
(127, 'Bilal Siddiqui', 'bilal.siddiqui2@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Lahore', '03264875227', 'service_provider', NULL, NULL, NULL, NULL, 1),
(128, 'Faisal Mirza', 'faisal.mirza3@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Lahore', '03382575579', 'service_provider', NULL, NULL, NULL, NULL, 1),
(129, 'Hassan Chaudhry', 'hassan.chaudhry4@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Lahore', '03436232389', 'service_provider', NULL, NULL, NULL, NULL, 1),
(130, 'Imran Butt', 'imran.butt5@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Lahore', '03376526156', 'service_provider', NULL, NULL, NULL, NULL, 1),
(131, 'Junaid Rana', 'junaid.rana6@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Lahore', '03447481103', 'service_provider', NULL, NULL, NULL, NULL, 1),
(132, 'Kamran Bhatti', 'kamran.bhatti7@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Lahore', '03279267683', 'service_provider', NULL, NULL, NULL, NULL, 1),
(133, 'Nasir Nawaz', 'nasir.nawaz8@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Lahore', '03102977081', 'service_provider', NULL, NULL, NULL, NULL, 1),
(134, 'Omar Dar', 'omar.dar9@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Lahore', '03326923061', 'service_provider', NULL, NULL, NULL, NULL, 1),
(135, 'Rizwan Gill', 'rizwan.gill10@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Lahore', '03105564175', 'service_provider', NULL, NULL, NULL, NULL, 1),
(136, 'Shahid Javed', 'sj939918@gmail.com', '$2b$10$2KnOMcQ7em21CkIfvEARw.uUg9lqx40Tm8EZ7wIoI8Gt7UNuxRPga', 'Lahore', '03336594482', 'service_provider', NULL, NULL, NULL, NULL, 1),
(137, 'Tariq Latif', 'tariq.latif12@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Lahore', '03437477012', 'service_provider', NULL, NULL, NULL, NULL, 1),
(138, 'Waqas Mehmood', 'waqas.mehmood13@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Karachi', '03309780007', 'service_provider', NULL, NULL, NULL, NULL, 1),
(139, 'Yasir Niazi', 'yasir.niazi14@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Karachi', '03251093202', 'service_provider', NULL, NULL, NULL, NULL, 1),
(140, 'Zubair Paracha', 'zubair.paracha15@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Karachi', '03262105303', 'service_provider', NULL, NULL, NULL, NULL, 1),
(141, 'Adnan Raja', 'adnan.raja16@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Karachi', '03288390350', 'service_provider', NULL, NULL, NULL, NULL, 1),
(142, 'Danish Saeed', 'danish.saeed17@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Karachi', '03261897533', 'service_provider', NULL, NULL, NULL, NULL, 1),
(143, 'Fahad Tanveer', 'fahad.tanveer18@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Karachi', '03199221215', 'service_provider', NULL, NULL, NULL, NULL, 1),
(144, 'Ghulam Ullah', 'ghulam.ullah19@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Karachi', '03460382802', 'service_provider', NULL, NULL, NULL, NULL, 1),
(145, 'Hamid Virk', 'hamid.virk20@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Karachi', '03432536144', 'service_provider', NULL, NULL, NULL, NULL, 1),
(146, 'Irfan Warraich', 'irfan.warraich21@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Karachi', '03254139484', 'service_provider', NULL, NULL, NULL, NULL, 1),
(147, 'Khalid Yousaf', 'khalid.yousaf22@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Karachi', '03222893733', 'service_provider', NULL, NULL, NULL, NULL, 1),
(148, 'Luqman Zahid', 'luqman.zahid23@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Karachi', '03195848160', 'service_provider', NULL, NULL, NULL, NULL, 1),
(149, 'Mohsin Khan', 'mohsin.khan24@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Karachi', '03381751673', 'service_provider', NULL, NULL, NULL, NULL, 1),
(150, 'Naveed Ahmed', 'naveed.ahmed25@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Islamabad', '03225056577', 'service_provider', NULL, NULL, NULL, NULL, 1),
(151, 'Pervaiz Ali', 'pervaiz.ali26@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Islamabad', '03410445818', 'service_provider', NULL, NULL, NULL, NULL, 1),
(152, 'Qaiser Malik', 'qaiser.malik27@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Islamabad', '03483648095', 'service_provider', NULL, NULL, NULL, NULL, 1),
(153, 'Salman Raza', 'salman.raza28@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Islamabad', '03438911081', 'service_provider', NULL, NULL, NULL, NULL, 1),
(154, 'Usman Hussain', 'usman.hussain29@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Islamabad', '03470307829', 'service_provider', NULL, NULL, NULL, NULL, 1),
(155, 'Waseem Sheikh', 'waseem.sheikh30@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Islamabad', '03356879931', 'service_provider', NULL, NULL, NULL, NULL, 1),
(156, 'Ahsan Qureshi', 'ahsan.qureshi31@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Islamabad', '03436920459', 'service_provider', NULL, NULL, NULL, NULL, 1),
(157, 'Bilal Siddiqui', 'bilal.siddiqui32@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Islamabad', '03363508365', 'service_provider', NULL, NULL, NULL, NULL, 1),
(158, 'Faisal Mirza', 'faisal.mirza33@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Islamabad', '03324884941', 'service_provider', NULL, NULL, NULL, NULL, 1),
(159, 'Hassan Chaudhry', 'hassan.chaudhry34@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Islamabad', '03283120509', 'service_provider', NULL, NULL, NULL, NULL, 1),
(160, 'Imran Butt', 'imran.butt35@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Islamabad', '03480315908', 'service_provider', NULL, NULL, NULL, NULL, 1),
(161, 'Junaid Rana', 'junaid.rana36@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Islamabad', '03379936167', 'service_provider', NULL, NULL, NULL, NULL, 1),
(162, 'Kamran Bhatti', 'kamran.bhatti37@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Rawalpindi', '03297818464', 'service_provider', NULL, NULL, NULL, NULL, 1),
(163, 'Nasir Nawaz', 'nasir.nawaz38@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Rawalpindi', '03335162229', 'service_provider', NULL, NULL, NULL, NULL, 1),
(164, 'Omar Dar', 'omar.dar39@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Rawalpindi', '03432952322', 'service_provider', NULL, NULL, NULL, NULL, 1),
(165, 'Rizwan Gill', 'rizwan.gill40@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Rawalpindi', '03381327679', 'service_provider', NULL, NULL, NULL, NULL, 1),
(166, 'Shahid Javed', 'shahid.javed41@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Rawalpindi', '03268135066', 'service_provider', NULL, NULL, NULL, NULL, 1),
(167, 'Tariq Latif', 'tariq.latif42@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Rawalpindi', '03328971631', 'service_provider', NULL, NULL, NULL, NULL, 1),
(168, 'Waqas Mehmood', 'waqas.mehmood43@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Rawalpindi', '03337163762', 'service_provider', NULL, NULL, NULL, NULL, 1),
(169, 'Yasir Niazi', 'yasir.niazi44@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Rawalpindi', '03234036875', 'service_provider', NULL, NULL, NULL, NULL, 1),
(170, 'Zubair Paracha', 'zubair.paracha45@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Rawalpindi', '03272691073', 'service_provider', NULL, NULL, NULL, NULL, 1),
(171, 'Adnan Raja', 'adnan.raja46@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Rawalpindi', '03172024814', 'service_provider', NULL, NULL, NULL, NULL, 1),
(172, 'Danish Saeed', 'danish.saeed47@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Rawalpindi', '03103867538', 'service_provider', NULL, NULL, NULL, NULL, 1),
(173, 'Fahad Tanveer', 'fahad.tanveer48@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Rawalpindi', '03169358536', 'service_provider', NULL, NULL, NULL, NULL, 1),
(174, 'Ghulam Ullah', 'ghulam.ullah49@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Faisalabad', '03418067633', 'service_provider', NULL, NULL, NULL, NULL, 1),
(175, 'Hamid Virk', 'hamid.virk50@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Faisalabad', '03355680636', 'service_provider', NULL, NULL, NULL, NULL, 1),
(176, 'Irfan Warraich', 'irfan.warraich51@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Faisalabad', '03407820957', 'service_provider', NULL, NULL, NULL, NULL, 1),
(177, 'Khalid Yousaf', 'khalid.yousaf52@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Faisalabad', '03272223882', 'service_provider', NULL, NULL, NULL, NULL, 1),
(178, 'Luqman Zahid', 'luqman.zahid53@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Faisalabad', '03357754849', 'service_provider', NULL, NULL, NULL, NULL, 1),
(179, 'Mohsin Khan', 'mohsin.khan54@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Faisalabad', '03137504929', 'service_provider', NULL, NULL, NULL, NULL, 1),
(180, 'Naveed Ahmed', 'naveed.ahmed55@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Faisalabad', '03444652619', 'service_provider', NULL, NULL, NULL, NULL, 1),
(181, 'Pervaiz Ali', 'pervaiz.ali56@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Faisalabad', '03312635852', 'service_provider', NULL, NULL, NULL, NULL, 1),
(182, 'Qaiser Malik', 'qaiser.malik57@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Faisalabad', '03198593066', 'service_provider', NULL, NULL, NULL, NULL, 1),
(183, 'Salman Raza', 'salman.raza58@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Faisalabad', '03228792923', 'service_provider', NULL, NULL, NULL, NULL, 1),
(184, 'Usman Hussain', 'usman.hussain59@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Faisalabad', '03364920577', 'service_provider', NULL, NULL, NULL, NULL, 1),
(185, 'Waseem Sheikh', 'waseem.sheikh60@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Faisalabad', '03416563490', 'service_provider', NULL, NULL, NULL, NULL, 1),
(186, 'Ahsan Qureshi', 'ahsan.qureshi61@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Multan', '03256699148', 'service_provider', NULL, NULL, NULL, NULL, 1),
(187, 'Bilal Siddiqui', 'bilal.siddiqui62@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Multan', '03122672199', 'service_provider', NULL, NULL, NULL, NULL, 1),
(188, 'Faisal Mirza', 'faisal.mirza63@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Multan', '03261210027', 'service_provider', NULL, NULL, NULL, NULL, 1),
(189, 'Hassan Chaudhry', 'hassan.chaudhry64@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Multan', '03320855019', 'service_provider', NULL, NULL, NULL, NULL, 1),
(190, 'Imran Butt', 'imran.butt65@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Multan', '03258157391', 'service_provider', NULL, NULL, NULL, NULL, 1),
(191, 'Junaid Rana', 'junaid.rana66@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Multan', '03229265717', 'service_provider', NULL, NULL, NULL, NULL, 1),
(192, 'Kamran Bhatti', 'kamran.bhatti67@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Multan', '03483732095', 'service_provider', NULL, NULL, NULL, NULL, 1),
(193, 'Nasir Nawaz', 'nasir.nawaz68@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Multan', '03390879640', 'service_provider', NULL, NULL, NULL, NULL, 1),
(194, 'Omar Dar', 'omar.dar69@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Multan', '03232400581', 'service_provider', NULL, NULL, NULL, NULL, 1),
(195, 'Rizwan Gill', 'rizwan.gill70@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Multan', '03475823549', 'service_provider', NULL, NULL, NULL, NULL, 1),
(196, 'Shahid Javed', 'shahid.javed71@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Multan', '03333492716', 'service_provider', NULL, NULL, NULL, NULL, 1),
(197, 'Tariq Latif', 'tariq.latif72@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Multan', '03324170159', 'service_provider', NULL, NULL, NULL, NULL, 1),
(198, 'Waqas Mehmood', 'waqas.mehmood73@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Gujranwala', '03445105570', 'service_provider', NULL, NULL, NULL, NULL, 1),
(199, 'Yasir Niazi', 'yasir.niazi74@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Gujranwala', '03150401325', 'service_provider', NULL, NULL, NULL, NULL, 1),
(200, 'Zubair Paracha', 'zubair.paracha75@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Gujranwala', '03374938553', 'service_provider', NULL, NULL, NULL, NULL, 1),
(201, 'Adnan Raja', 'adnan.raja76@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Gujranwala', '03459746375', 'service_provider', NULL, NULL, NULL, NULL, 1),
(202, 'Danish Saeed', 'danish.saeed77@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Gujranwala', '03289540884', 'service_provider', NULL, NULL, NULL, NULL, 1),
(203, 'Fahad Tanveer', 'fahad.tanveer78@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Gujranwala', '03456108775', 'service_provider', NULL, NULL, NULL, NULL, 1),
(204, 'Ghulam Ullah', 'ghulam.ullah79@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Gujranwala', '03187790569', 'service_provider', NULL, NULL, NULL, NULL, 1),
(205, 'Hamid Virk', 'hamid.virk80@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Gujranwala', '03116449151', 'service_provider', NULL, NULL, NULL, NULL, 1),
(206, 'Irfan Warraich', 'irfan.warraich81@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Gujranwala', '03317130208', 'service_provider', NULL, NULL, NULL, NULL, 1),
(207, 'Khalid Yousaf', 'khalid.yousaf82@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Gujranwala', '03386795928', 'service_provider', NULL, NULL, NULL, NULL, 1),
(208, 'Luqman Zahid', 'luqman.zahid83@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Gujranwala', '03346062846', 'service_provider', NULL, NULL, NULL, NULL, 1),
(209, 'Mohsin Khan', 'mohsin.khan84@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Gujranwala', '03263193422', 'service_provider', NULL, NULL, NULL, NULL, 1),
(210, 'Naveed Ahmed', 'naveed.ahmed85@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sialkot', '03437575614', 'service_provider', NULL, NULL, NULL, NULL, 1),
(211, 'Pervaiz Ali', 'pervaiz.ali86@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sialkot', '03367248568', 'service_provider', NULL, NULL, NULL, NULL, 1),
(212, 'Qaiser Malik', 'qaiser.malik87@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sialkot', '03429099795', 'service_provider', NULL, NULL, NULL, NULL, 1),
(213, 'Salman Raza', 'salman.raza88@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sialkot', '03374691976', 'service_provider', NULL, NULL, NULL, NULL, 1),
(214, 'Usman Hussain', 'usman.hussain89@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sialkot', '03471482609', 'service_provider', NULL, NULL, NULL, NULL, 1),
(215, 'Waseem Sheikh', 'waseem.sheikh90@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sialkot', '03279499694', 'service_provider', NULL, NULL, NULL, NULL, 1),
(216, 'Ahsan Qureshi', 'ahsan.qureshi91@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sialkot', '03373600834', 'service_provider', NULL, NULL, NULL, NULL, 1),
(217, 'Bilal Siddiqui', 'bilal.siddiqui92@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sialkot', '03144528276', 'service_provider', NULL, NULL, NULL, NULL, 1),
(218, 'Faisal Mirza', 'faisal.mirza93@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sialkot', '03320635960', 'service_provider', NULL, NULL, NULL, NULL, 1),
(219, 'Hassan Chaudhry', 'hassan.chaudhry94@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sialkot', '03403113081', 'service_provider', NULL, NULL, NULL, NULL, 1),
(220, 'Imran Butt', 'imran.butt95@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sialkot', '03141059200', 'service_provider', NULL, NULL, NULL, NULL, 1),
(221, 'Junaid Rana', 'junaid.rana96@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sialkot', '03453126055', 'service_provider', NULL, NULL, NULL, NULL, 1),
(222, 'Kamran Bhatti', 'kamran.bhatti97@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Peshawar', '03234225509', 'service_provider', NULL, NULL, NULL, NULL, 1),
(223, 'Nasir Nawaz', 'nasir.nawaz98@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Peshawar', '03156901681', 'service_provider', NULL, NULL, NULL, NULL, 1),
(224, 'Omar Dar', 'omar.dar99@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Peshawar', '03317400081', 'service_provider', NULL, NULL, NULL, NULL, 1),
(225, 'Rizwan Gill', 'rizwan.gill100@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Peshawar', '03150529765', 'service_provider', NULL, NULL, NULL, NULL, 1),
(226, 'Shahid Javed', 'shahid.javed101@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Peshawar', '03175465693', 'service_provider', NULL, NULL, NULL, NULL, 1),
(227, 'Tariq Latif', 'tariq.latif102@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Peshawar', '03136507755', 'service_provider', NULL, NULL, NULL, NULL, 1),
(228, 'Waqas Mehmood', 'waqas.mehmood103@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Peshawar', '03459704619', 'service_provider', NULL, NULL, NULL, NULL, 1);
INSERT INTO `users` (`id`, `name`, `email`, `password`, `city`, `phone`, `role`, `reset_token`, `token_expire`, `otp_code`, `otp_expire`, `is_approved`) VALUES
(229, 'Yasir Niazi', 'yasir.niazi104@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Peshawar', '03139753865', 'service_provider', NULL, NULL, NULL, NULL, 1),
(230, 'Zubair Paracha', 'zubair.paracha105@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Peshawar', '03418107433', 'service_provider', NULL, NULL, NULL, NULL, 1),
(231, 'Adnan Raja', 'adnan.raja106@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Peshawar', '03327783057', 'service_provider', NULL, NULL, NULL, NULL, 1),
(232, 'Danish Saeed', 'danish.saeed107@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Peshawar', '03174544533', 'service_provider', NULL, NULL, NULL, NULL, 1),
(233, 'Fahad Tanveer', 'fahad.tanveer108@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Peshawar', '03483826757', 'service_provider', NULL, NULL, NULL, NULL, 1),
(234, 'Ghulam Ullah', 'ghulam.ullah109@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Quetta', '03212307565', 'service_provider', NULL, NULL, NULL, NULL, 1),
(235, 'Hamid Virk', 'hamid.virk110@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Quetta', '03421078206', 'service_provider', NULL, NULL, NULL, NULL, 1),
(236, 'Irfan Warraich', 'irfan.warraich111@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Quetta', '03442739684', 'service_provider', NULL, NULL, NULL, NULL, 1),
(237, 'Khalid Yousaf', 'khalid.yousaf112@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Quetta', '03203486341', 'service_provider', NULL, NULL, NULL, NULL, 1),
(238, 'Luqman Zahid', 'luqman.zahid113@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Quetta', '03150316789', 'service_provider', NULL, NULL, NULL, NULL, 1),
(239, 'Mohsin Khan', 'mohsin.khan114@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Quetta', '03416370347', 'service_provider', NULL, NULL, NULL, NULL, 1),
(240, 'Naveed Ahmed', 'naveed.ahmed115@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Quetta', '03196777977', 'service_provider', NULL, NULL, NULL, NULL, 1),
(241, 'Pervaiz Ali', 'pervaiz.ali116@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Quetta', '03493560788', 'service_provider', NULL, NULL, NULL, NULL, 1),
(242, 'Qaiser Malik', 'qaiser.malik117@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Quetta', '03309907947', 'service_provider', NULL, NULL, NULL, NULL, 1),
(243, 'Salman Raza', 'salman.raza118@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Quetta', '03252399358', 'service_provider', NULL, NULL, NULL, NULL, 1),
(244, 'Usman Hussain', 'usman.hussain119@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Quetta', '03205978194', 'service_provider', NULL, NULL, NULL, NULL, 1),
(245, 'Waseem Sheikh', 'waseem.sheikh120@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Quetta', '03439151402', 'service_provider', NULL, NULL, NULL, NULL, 1),
(246, 'Ahsan Qureshi', 'ahsan.qureshi121@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sheikhupura', '03357670069', 'service_provider', NULL, NULL, NULL, NULL, 1),
(247, 'Bilal Siddiqui', 'bilal.siddiqui122@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sheikhupura', '03485886273', 'service_provider', NULL, NULL, NULL, NULL, 1),
(248, 'Faisal Mirza', 'faisal.mirza123@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sheikhupura', '03333808262', 'service_provider', NULL, NULL, NULL, NULL, 1),
(249, 'Hassan Chaudhry', 'hassan.chaudhry124@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sheikhupura', '03189576196', 'service_provider', NULL, NULL, NULL, NULL, 1),
(250, 'Imran Butt', 'imran.butt125@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sheikhupura', '03404231754', 'service_provider', NULL, NULL, NULL, NULL, 1),
(251, 'Junaid Rana', 'junaid.rana126@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sheikhupura', '03406258676', 'service_provider', NULL, NULL, NULL, NULL, 1),
(252, 'Kamran Bhatti', 'kamran.bhatti127@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sheikhupura', '03488035755', 'service_provider', NULL, NULL, NULL, NULL, 1),
(253, 'Nasir Nawaz', 'nasir.nawaz128@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sheikhupura', '03186880998', 'service_provider', NULL, NULL, NULL, NULL, 1),
(254, 'Omar Dar', 'omar.dar129@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sheikhupura', '03171752419', 'service_provider', NULL, NULL, NULL, NULL, 1),
(255, 'Rizwan Gill', 'rizwan.gill130@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sheikhupura', '03454079503', 'service_provider', NULL, NULL, NULL, NULL, 1),
(256, 'Shahid Javed', 'shahid.javed131@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sheikhupura', '03229250908', 'service_provider', NULL, NULL, NULL, NULL, 1),
(257, 'Tariq Latif', 'tariq.latif132@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Sheikhupura', '03127485959', 'service_provider', NULL, NULL, NULL, NULL, 1),
(258, 'Waqas Mehmood', 'waqas.mehmood133@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Farooqabad', '03355217337', 'service_provider', NULL, NULL, NULL, NULL, 1),
(259, 'Yasir Niazi', 'yasir.niazi134@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Farooqabad', '03214845602', 'service_provider', NULL, NULL, NULL, NULL, 1),
(260, 'Zubair Paracha', 'zubair.paracha135@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Farooqabad', '03456501636', 'service_provider', NULL, NULL, NULL, NULL, 1),
(261, 'Adnan Raja', 'adnan.raja136@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Farooqabad', '03442547178', 'service_provider', NULL, NULL, NULL, NULL, 1),
(262, 'Danish Saeed', 'danish.saeed137@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Farooqabad', '03404426543', 'service_provider', NULL, NULL, NULL, NULL, 1),
(263, 'Fahad Tanveer', 'fahad.tanveer138@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Farooqabad', '03185303684', 'service_provider', NULL, NULL, NULL, NULL, 1),
(264, 'Ghulam Ullah', 'ghulam.ullah139@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Farooqabad', '03479504834', 'service_provider', NULL, NULL, NULL, NULL, 1),
(265, 'Hamid Virk', 'hamid.virk140@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Farooqabad', '03307516087', 'service_provider', NULL, NULL, NULL, NULL, 1),
(266, 'Irfan Warraich', 'irfan.warraich141@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Farooqabad', '03111519202', 'service_provider', NULL, NULL, NULL, NULL, 1),
(267, 'Khalid Yousaf', 'khalid.yousaf142@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Farooqabad', '03284041942', 'service_provider', NULL, NULL, NULL, NULL, 1),
(268, 'Luqman Zahid', 'luqman.zahid143@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Farooqabad', '03369714208', 'service_provider', NULL, NULL, NULL, NULL, 1),
(269, 'Mohsin Khan', 'mohsin.khan144@intradecor.com', '$2b$10$HPVo63ZkoD1qOp8tUFiCxeGKAUjmLlId7o7lXFIgZSfBuv55TlGLC', 'Farooqabad', '03351750057', 'service_provider', NULL, NULL, NULL, NULL, 1),
(272, 'eman', 'ef91646@gmail.com', '$2y$10$BAQ3yTSMAW5XDsSE6SQ2AO.HXJd5i6NZQydkT9q0MShOhEN8S4eay', '', NULL, 'seller', NULL, NULL, NULL, NULL, 1),
(273, 'menak', 'menakfatima2@gmail.com', '$2y$10$H8Vf8gwi6Z.esQr3H./KKerWzarmNBsEik3WVvCA0omfeC.N/UQke', '', NULL, 'user', NULL, NULL, NULL, NULL, 0),
(274, 'fatima', 'fatimamano958@gmail.com', '$2y$10$kz3E.AQDQAQJhk3vzUJvU.Q3aiGc5Y.DNrJ2EkkkX2ZRoJ1RK4.S6', '', NULL, 'user', NULL, NULL, NULL, NULL, 0),
(275, 'Mano Wall Panels Store', 'manof2968@gmail.com', '$2b$10$Ije16IknSz.yaxhtFY/UFuAmQDSG5sLU7a2Dh/4MWIJG7wfyG1bq2', 'Lahore', NULL, 'seller', NULL, NULL, NULL, NULL, 1),
(276, 'back', 'b96691804@gmail.com', '$2y$10$4BQr/XZ4sxFTv8I0XMxZ/uvyOG8AaeqRTvoP5u/5GXSlTcZVlQbwe', '', NULL, 'user', NULL, NULL, NULL, NULL, 0),
(277, 'emu', 'emanf.ppc@gmail.com', '$2y$10$ZYnpUHts7Ho6unOuDGJLq.4N.EQUwS0JIFgq.hL1M9tCWjXm0YEmC', '', NULL, 'user', NULL, NULL, NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addservice`
--
ALTER TABLE `addservice`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notif_user` (`user_id`),
  ADD KEY `idx_notif_admin` (`admin_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tracker_token` (`tracker_token`);

--
-- Indexes for table `productadd`
--
ALTER TABLE `productadd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `providerprofile`
--
ALTER TABLE `providerprofile`
  ADD PRIMARY KEY (`provider_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `sellerprofile`
--
ALTER TABLE `sellerprofile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`userid`);

--
-- Indexes for table `service_gallery`
--
ALTER TABLE `service_gallery`
  ADD PRIMARY KEY (`gallery_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addservice`
--
ALTER TABLE `addservice`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `productadd`
--
ALTER TABLE `productadd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=356;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `providerprofile`
--
ALTER TABLE `providerprofile`
  MODIFY `provider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT for table `sellerprofile`
--
ALTER TABLE `sellerprofile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service_gallery`
--
ALTER TABLE `service_gallery`
  MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=538;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=278;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `productadd` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sellerprofile`
--
ALTER TABLE `sellerprofile`
  ADD CONSTRAINT `fk_seller_user` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_gallery`
--
ALTER TABLE `service_gallery`
  ADD CONSTRAINT `service_gallery_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `addservice` (`service_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
