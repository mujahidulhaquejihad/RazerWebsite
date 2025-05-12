SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




-- Table structure for table `casing`


CREATE TABLE `casing` (
  `full_name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `casing`
--

INSERT INTO `casing` (`full_name`, `price`) VALUES
('casin1', 1212),
('casingtestfile', 123123),
('test cabinet1', 123123),
('test cabinet1', 123123),
('CorsairX1 Spec01 - 3,000BDT', 3000),
('CorsairX10 Spec10 - 7,500BDT', 7500),
('CorsairX11 Spec11 - 8,000BDT', 8000),
('CorsairX12 Spec12 - 8,500BDT', 8500),
('CorsairX13 Spec13 - 9,000BDT', 9000),
('CorsairX14 Spec14 - 9,500BDT', 9500),
('CorsairX15 Spec15 - 10,000BDT', 10000),
('CorsairX16 Spec16 - 10,500BDT', 10500),
('CorsairX17 Spec17 - 11,000BDT', 11000),
('CorsairX18 Spec18 - 11,500BDT', 11500),
('CorsairX19 Spec19 - 12,000BDT', 12000),
('CorsairX2 Spec02 - 5,000BDT', 5000),
('CorsairX20 Spec20 - 12,500BDT', 12500),
('CorsairX21 Spec21 - 13,000BDT', 13000),
('CorsairX22 Spec22 - 13,500BDT', 13500),
('CorsairX23 Spec23 - 14,000BDT', 14000),
('CorsairX24 Spec24 - 14,500BDT', 14500),
('CorsairX25 Spec25 - 15,000BDT', 15000),
('CorsairX26 Spec26 - 15,500BDT', 15500),
('CorsairX27 Spec27 - 16,000BDT', 16000),
('CorsairX28 Spec28 - 16,500BDT', 16500),
('CorsairX29 Spec29 - 17,000BDT', 17000),
('CorsairX3 ICUE RGB - 7,000BDT', 7000),
('CorsairX30 Spec30 - 17,500BDT', 17500),
('CorsairX31 Spec31 - 18,000BDT', 18000),
('CorsairX32 Spec32 - 18,500BDT', 18500),
('CorsairX33 Spec33 - 19,000BDT', 19000),
('CorsairX34 Spec34 - 19,500BDT', 19500),
('CorsairX35 Spec35 - 20,000BDT', 20000),
('CorsairX36 Spec36 - 20,500BDT', 20500),
('CorsairX37 Spec37 - 21,000BDT', 21000),
('CorsairX38 Spec38 - 21,500BDT', 21500),
('CorsairX39 Spec39 - 22,000BDT', 22000),
('CorsairX4 Spec04 - 3,500BDT', 3500),
('CorsairX40 Spec40 - 22,500BDT', 22500),
('CorsairX41 Spec41 - 23,000BDT', 23000),
('CorsairX42 Spec42 - 23,500BDT', 23500),
('CorsairX43 Spec43 - 24,000BDT', 24000),
('CorsairX44 Spec44 - 24,500BDT', 24500),
('CorsairX45 Spec45 - 25,000BDT', 25000),
('CorsairX46 Spec46 - 25,500BDT', 25500),
('CorsairX47 Spec47 - 26,000BDT', 26000),
('CorsairX48 Spec48 - 26,500BDT', 26500),
('CorsairX49 Spec49 - 27,000BDT', 27000),
('CorsairX5 Spec05 - 4,000BDT', 4000),
('CorsairX50 Spec50 - 27,500BDT', 27500),
('CorsairX6 Spec06 - 4,500BDT', 4500),
('CorsairX7 Spec07 - 5,500BDT', 5500),
('CorsairX8 Spec08 - 6,000BDT', 6000),
('CorsairX9 Spec09 - 6,500BDT', 6500);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `coupon_code` varchar(100) NOT NULL,
  `discount` decimal(5,2) NOT NULL,
  `expiry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_code`, `discount`, `expiry_date`) VALUES
(1, 'bracu20', 20.00, '2026-08-22'),
(3, 'jahidul20', 50.00, '2030-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `cpu`
--

CREATE TABLE `cpu` (
  `CPU_id` varchar(20) NOT NULL,
  `CPU_full_name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cpu`
--

INSERT INTO `cpu` (`CPU_id`, `CPU_full_name`, `price`) VALUES
('i3', 'Intel i3 11th Gen -- 7,000BDT', 7000),
('i5', 'Intel i5 11th Gen -- 15,000BDT', 15000),
('i7', 'Intel i7 11th Gen -- 25,000BDT', 25000),
('r3', 'AMD Ryzen3 -- 6,000BDT', 6000),
('r5', 'AMD Ryzen5 -- 13,500BDT', 13500),
('r7', 'AMD Ryzen7 -- 19,000BDT', 19000),
('i9', 'Intel i9 11th Gen -- 40,000BDT', 40000),
('r9', 'AMD Ryzen9 -- 35,000BDT', 35000),
('i3', 'Intel i3 10th Gen -- 6,500BDT', 6500),
('i5', 'Intel i5 10th Gen -- 14,000BDT', 14000),
('i7', 'Intel i7 10th Gen -- 22,000BDT', 22000),
('r5', 'AMD Ryzen5 3600 -- 17,000BDT', 17000),
('r7', 'AMD Ryzen7 3700X -- 23,000BDT', 23000),
('i5', 'Intel i5 12th Gen -- 18,000BDT', 18000),
('i7', 'Intel i7 12th Gen -- 28,000BDT', 28000),
('r5', 'AMD Ryzen5 5600X -- 19,000BDT', 19000),
('r7', 'AMD Ryzen7 5800X -- 27,000BDT', 27000),
('i9', 'Intel i9 12th Gen -- 50,000BDT', 50000),
('r9', 'AMD Ryzen9 5900X -- 40,000BDT', 40000),
('i3', 'Intel i3 9th Gen -- 5,500BDT', 5500),
('', 'MUJAHIDUL HAQUE JIHAD', 123),
('', 'MUJAHIDUL HAQUE JIHAD', 123),
('', 'MUJAHIDUL HAQUE JIHAD', 123),
('', 'testproduct11', 9999),
('', 'Test cpu 1', 123),
('', 'test cpu1', 111),
('', 'test cpu1', 111),
('0', 'cputest111', 111),
('0', 'psutest123123', 1231),
('0', 'test cabinet1', 123123);

-- --------------------------------------------------------

--
-- Table structure for table `cpu_cooler`
--

CREATE TABLE `cpu_cooler` (
  `cooler_full_name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cpu_cooler`
--

INSERT INTO `cpu_cooler` (`cooler_full_name`, `price`) VALUES
('cpucoller', 1231),
('Stock CPU cooler -- 0BDT', 0),
('AIR COOLER -- 6,000BDT', 6000),
('LIQUID COOLER -- 16,000BDT', 16000),
('Custom Acrylic Water Cooling Kit -- 40,000BDT', 40000),
('Basic Air Cooler -- 3,500BDT', 3500),
('Premium Air Cooler -- 8,000BDT', 8000),
('RGB Air Cooler -- 7,500BDT', 7500),
('Advanced Liquid Cooler -- 18,000BDT', 18000),
('Dual Fan Liquid Cooler -- 20,000BDT', 20000),
('Single Fan Liquid Cooler -- 14,000BDT', 14000),
('Water Cooling Kit - Basic -- 25,000BDT', 25000),
('Water Cooling Kit - Advanced -- 45,000BDT', 45000),
('Custom Copper Water Cooling Kit -- 50,000BDT', 50000),
('Compact Liquid Cooler -- 12,000BDT', 12000),
('Dual Radiator Liquid Cooler -- 30,000BDT', 30000),
('AIO Liquid Cooler -- 22,000BDT', 22000),
('Dual Tower Air Cooler -- 9,000BDT', 9000),
('Triple Fan Liquid Cooler -- 35,000BDT', 35000),
('Silent Fan Air Cooler -- 5,000BDT', 5000),
('Full Tower Water Cooling System -- 60,000BDT', 60000),
('test cooler 1', 12312),
('casin1', 123123);

-- --------------------------------------------------------

--
-- Table structure for table `gpu`
--

CREATE TABLE `gpu` (
  `GPU_full_name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `gpu`
--

INSERT INTO `gpu` (`GPU_full_name`, `price`) VALUES
('test gpu 1', 1212),
('gputestfiule', 453453),
('Nvidea RTX2060 2nd Gen 6GB VRAM -- 25,000BDT', 25000),
('Nvidea RTX2060 Super 2nd Gen 8GB VRAM -- 35,000BDT', 35000),
('Nvidea RTX2070 2nd Gen 8GB VRAM -- 45,000BDT', 45000),
('Nvidea RTX2070 Super 2nd Gen 8GB VRAM -- 50,000BDT', 50000),
('Nvidea RTX2080 2nd Gen 12GB VRAM -- 70,000BDT', 70000),
('Nvidea RTX2080 Super 2nd Gen 12GB VRAM -- 85,000BD', 85000),
('Nvidea RTX3060 2nd Gen 6GB VRAM -- 35,000BDT', 35000),
('Nvidea RTX3060 Super 2nd Gen 12GB VRAM -- 40,000BD', 40000),
('Nvidea RTX3060Ti 2nd Gen 8GB VRAM -- 50,000BDT', 50000),
('Nvidea RTX3060Ti Super 2nd Gen 8GB VRAM -- 55,000B', 55000),
('Nvidea RTX3070 3rd Gen 10GB VRAM -- 60,000BDT', 60000),
('Nvidea RTX3070 Super 3rd Gen 10GB VRAM -- 70,000BD', 70000),
('Nvidea RTX3070Ti 3rd Gen 8GB VRAM -- 75,000BDT', 75000),
('Nvidea RTX3080 3rd Gen 12GB VRAM -- 90,000BDT', 90000),
('Nvidea RTX3080 Super 3rd Gen 12GB VRAM -- 105,000B', 105000),
('Nvidea RTX3080Ti 3rd Gen 12GB VRAM -- 110,000BDT', 110000),
('Nvidea RTX3090 3rd Gen 24GB VRAM -- 150,000BDT', 150000),
('Nvidea RTX3090 Super 3rd Gen 24GB VRAM -- 160,000B', 160000),
('Nvidea RTX3090Ti 3rd Gen 24GB VRAM -- 180,000BDT', 180000),
('Nvidea RTX3090Ti Super 3rd Gen 24GB VRAM -- 200,00', 200000),
('Nvidea RTX4060 4th Gen 8GB VRAM -- 45,000BDT', 45000),
('Nvidea RTX4070 4th Gen 12GB VRAM -- 80,000BDT', 80000),
('Nvidea RTX4070 Super 4th Gen 12GB VRAM -- 85,000BD', 85000),
('Nvidea RTX4070Ti 4th Gen 12GB VRAM -- 95,000BDT', 95000),
('Nvidea RTX4070Ti Ultra 4th Gen 12GB VRAM -- 120,00', 120000),
('Nvidea RTX4080 4th Gen 16GB VRAM -- 130,000BDT', 130000),
('Nvidea RTX4080 Super 4th Gen 16GB VRAM -- 140,000B', 140000),
('Nvidea RTX4080 Ultra 4th Gen 16GB VRAM -- 150,000B', 150000),
('Nvidea RTX4090 4th Gen 24GB VRAM -- 250,000BDT', 250000),
('Nvidea RTX5090 5th Gen 24GB VRAM -- 300,000BDT', 300000),
('gputestfiule123123', 123123);

-- --------------------------------------------------------

--
-- Table structure for table `hdd`
--

CREATE TABLE `hdd` (
  `HDD_full_name` varchar(30) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hdd`
--

INSERT INTO `hdd` (`HDD_full_name`, `price`) VALUES
('hdd1', 123123),
('512GB 5400RPM HDD -- 2,100BDT', 2100),
('1TB 5400RPM HDD -- 4,000BDT', 4000),
('1TB 7200RPM HDD -- 5,000BDT', 5000),
('2TB 7200RPM HDD -- 7,000BDT', 7000),
('6TB 7200RPM HDD -- 14,000BDT', 14000),
('512GB 7200RPM HDD -- 3,500BDT', 3500),
('1TB 5400RPM HDD -- 3,500BDT', 3500),
('2TB 5400RPM HDD -- 5,500BDT', 5500),
('1TB 5400RPM HDD -- 4,200BDT', 4200),
('2TB 7200RPM HDD -- 7,500BDT', 7500),
('3TB 5400RPM HDD -- 8,500BDT', 8500),
('4TB 7200RPM HDD -- 9,500BDT', 9500),
('500GB 5400RPM HDD -- 2,500BDT', 2500),
('1TB 7200RPM HDD -- 6,000BDT', 6000),
('3TB 7200RPM HDD -- 10,500BDT', 10500),
('4TB 5400RPM HDD -- 7,500BDT', 7500),
('6TB 5400RPM HDD -- 12,000BDT', 12000),
('8TB 7200RPM HDD -- 15,500BDT', 15500),
('10TB 7200RPM HDD -- 18,000BDT', 18000),
('12TB 5400RPM HDD -- 20,000BDT', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `motherboard`
--

CREATE TABLE `motherboard` (
  `mb_full_name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `motherboard`
--

INSERT INTO `motherboard` (`mb_full_name`, `price`) VALUES
('mb1111', 1231),
('Intel H510 Motherboard -- 7,000BDT', 7000),
('Intel B450 Motherboard -- 12,000BDT', 12000),
('Intel Z590 Gaming Motherboard -- 24,000BDT', 24000),
('AMD B350 Motherboard -- 6,000BDT', 6000),
('AMD X570 Gaming Motherboard -- 18,000BDT', 18000),
('Intel B560 Motherboard -- 10,000BDT', 10000),
('Intel Z490 Motherboard -- 22,000BDT', 22000),
('AMD B450 Pro Motherboard -- 5,500BDT', 5500),
('Intel H410 Motherboard -- 5,000BDT', 5000),
('AMD A520 Motherboard -- 4,500BDT', 4500),
('Intel Z590 AORUS Motherboard -- 28,000BDT', 28000),
('AMD B550 Motherboard -- 10,500BDT', 10500),
('Intel Z370 Motherboard -- 15,000BDT', 15000),
('Intel B365 Motherboard -- 8,000BDT', 8000),
('AMD X470 Motherboard -- 12,500BDT', 12500),
('Intel H370 Motherboard -- 9,500BDT', 9500),
('AMD B550 TUF Motherboard -- 14,000BDT', 14000),
('Intel Z490 AORUS Master Motherboard -- 35,000BDT', 35000),
('AMD A320 Motherboard -- 3,800BDT', 3800),
('Intel Z370 AORUS Motherboard -- 20,000BDT', 20000),
('test cabinet1', 123123);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `userid` varchar(200) NOT NULL,
  `totalprice` int(11) NOT NULL,
  `order-status` text NOT NULL,
  `payment_method` varchar(200) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `category` enum('CPU','GPU','HDD','Cabinet','Cooler') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `category`, `created_at`) VALUES
(1, 'Intel i3 11th Gen -- 7,000BDT', 7000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(2, 'Intel i5 11th Gen -- 15,000BDT', 15000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(3, 'Intel i7 11th Gen -- 25,000BDT', 25000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(4, 'AMD Ryzen3 -- 6,000BDT', 6000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(5, 'AMD Ryzen5 -- 13,500BDT', 13500.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(6, 'AMD Ryzen7 -- 19,000BDT', 19000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(7, 'Intel i9 11th Gen -- 40,000BDT', 40000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(8, 'AMD Ryzen9 -- 35,000BDT', 35000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(9, 'Intel i3 10th Gen -- 6,500BDT', 6500.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(10, 'Intel i5 10th Gen -- 14,000BDT', 14000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(11, 'Intel i7 10th Gen -- 22,000BDT', 22000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(12, 'AMD Ryzen5 3600 -- 17,000BDT', 17000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(13, 'AMD Ryzen7 3700X -- 23,000BDT', 23000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(14, 'Intel i5 12th Gen -- 18,000BDT', 18000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(15, 'Intel i7 12th Gen -- 28,000BDT', 28000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(16, 'AMD Ryzen5 5600X -- 19,000BDT', 19000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(17, 'AMD Ryzen7 5800X -- 27,000BDT', 27000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(18, 'Intel i9 12th Gen -- 50,000BDT', 50000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(19, 'AMD Ryzen9 5900X -- 40,000BDT', 40000.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(20, 'Intel i3 9th Gen -- 5,500BDT', 5500.00, 'Description here', 'CPU', '2025-04-30 05:02:07'),
(32, 'Nvidea RTX2060 2nd Gen 6GB VRAM -- 25,000BDT', 25000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(33, 'Nvidea RTX2060 Super 2nd Gen 8GB VRAM -- 35,000BDT', 35000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(34, 'Nvidea RTX2070 2nd Gen 8GB VRAM -- 45,000BDT', 45000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(35, 'Nvidea RTX2070 Super 2nd Gen 8GB VRAM -- 50,000BDT', 50000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(36, 'Nvidea RTX2080 2nd Gen 12GB VRAM -- 70,000BDT', 70000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(37, 'Nvidea RTX2080 Super 2nd Gen 12GB VRAM -- 85,000BD', 85000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(38, 'Nvidea RTX3060 2nd Gen 6GB VRAM -- 35,000BDT', 35000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(39, 'Nvidea RTX3060 Super 2nd Gen 12GB VRAM -- 40,000BD', 40000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(40, 'Nvidea RTX3060Ti 2nd Gen 8GB VRAM -- 50,000BDT', 50000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(41, 'Nvidea RTX3060Ti Super 2nd Gen 8GB VRAM -- 55,000B', 55000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(42, 'Nvidea RTX3070 3rd Gen 10GB VRAM -- 60,000BDT', 60000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(43, 'Nvidea RTX3070 Super 3rd Gen 10GB VRAM -- 70,000BD', 70000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(44, 'Nvidea RTX3070Ti 3rd Gen 8GB VRAM -- 75,000BDT', 75000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(45, 'Nvidea RTX3080 3rd Gen 12GB VRAM -- 90,000BDT', 90000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(46, 'Nvidea RTX3080 Super 3rd Gen 12GB VRAM -- 105,000B', 105000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(47, 'Nvidea RTX3080Ti 3rd Gen 12GB VRAM -- 110,000BDT', 110000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(48, 'Nvidea RTX3090 3rd Gen 24GB VRAM -- 150,000BDT', 150000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(49, 'Nvidea RTX3090 Super 3rd Gen 24GB VRAM -- 160,000B', 160000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(50, 'Nvidea RTX3090Ti 3rd Gen 24GB VRAM -- 180,000BDT', 180000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(51, 'Nvidea RTX3090Ti Super 3rd Gen 24GB VRAM -- 200,00', 200000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(52, 'Nvidea RTX4060 4th Gen 8GB VRAM -- 45,000BDT', 45000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(53, 'Nvidea RTX4070 4th Gen 12GB VRAM -- 80,000BDT', 80000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(54, 'Nvidea RTX4070 Super 4th Gen 12GB VRAM -- 85,000BD', 85000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(55, 'Nvidea RTX4070Ti 4th Gen 12GB VRAM -- 95,000BDT', 95000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(56, 'Nvidea RTX4070Ti Ultra 4th Gen 12GB VRAM -- 120,00', 120000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(57, 'Nvidea RTX4080 4th Gen 16GB VRAM -- 130,000BDT', 130000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(58, 'Nvidea RTX4080 Super 4th Gen 16GB VRAM -- 140,000B', 140000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(59, 'Nvidea RTX4080 Ultra 4th Gen 16GB VRAM -- 150,000B', 150000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(60, 'Nvidea RTX4090 4th Gen 24GB VRAM -- 250,000BDT', 250000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(61, 'Nvidea RTX5090 5th Gen 24GB VRAM -- 300,000BDT', 300000.00, 'Description here', 'GPU', '2025-04-30 05:02:29'),
(63, '512GB 5400RPM HDD -- 2,100BDT', 2100.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(64, '1TB 5400RPM HDD -- 4,000BDT', 4000.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(65, '1TB 7200RPM HDD -- 5,000BDT', 5000.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(66, '2TB 7200RPM HDD -- 7,000BDT', 7000.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(67, '6TB 7200RPM HDD -- 14,000BDT', 14000.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(68, '512GB 7200RPM HDD -- 3,500BDT', 3500.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(69, '1TB 5400RPM HDD -- 3,500BDT', 3500.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(70, '2TB 5400RPM HDD -- 5,500BDT', 5500.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(71, '1TB 5400RPM HDD -- 4,200BDT', 4200.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(72, '2TB 7200RPM HDD -- 7,500BDT', 7500.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(73, '3TB 5400RPM HDD -- 8,500BDT', 8500.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(74, '4TB 7200RPM HDD -- 9,500BDT', 9500.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(75, '500GB 5400RPM HDD -- 2,500BDT', 2500.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(76, '1TB 7200RPM HDD -- 6,000BDT', 6000.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(77, '3TB 7200RPM HDD -- 10,500BDT', 10500.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(78, '4TB 5400RPM HDD -- 7,500BDT', 7500.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(79, '6TB 5400RPM HDD -- 12,000BDT', 12000.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(80, '8TB 7200RPM HDD -- 15,500BDT', 15500.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(81, '10TB 7200RPM HDD -- 18,000BDT', 18000.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(82, '12TB 5400RPM HDD -- 20,000BDT', 20000.00, 'Description here', 'HDD', '2025-04-30 05:02:35'),
(94, 'CorsairX1 Spec01 - 3,000BDT', 3000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(95, 'CorsairX10 Spec10 - 7,500BDT', 7500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(96, 'CorsairX11 Spec11 - 8,000BDT', 8000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(97, 'CorsairX12 Spec12 - 8,500BDT', 8500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(98, 'CorsairX13 Spec13 - 9,000BDT', 9000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(99, 'CorsairX14 Spec14 - 9,500BDT', 9500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(100, 'CorsairX15 Spec15 - 10,000BDT', 10000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(101, 'CorsairX16 Spec16 - 10,500BDT', 10500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(102, 'CorsairX17 Spec17 - 11,000BDT', 11000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(103, 'CorsairX18 Spec18 - 11,500BDT', 11500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(104, 'CorsairX19 Spec19 - 12,000BDT', 12000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(105, 'CorsairX2 Spec02 - 5,000BDT', 5000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(106, 'CorsairX20 Spec20 - 12,500BDT', 12500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(107, 'CorsairX21 Spec21 - 13,000BDT', 13000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(108, 'CorsairX22 Spec22 - 13,500BDT', 13500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(109, 'CorsairX23 Spec23 - 14,000BDT', 14000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(110, 'CorsairX24 Spec24 - 14,500BDT', 14500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(111, 'CorsairX25 Spec25 - 15,000BDT', 15000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(112, 'CorsairX26 Spec26 - 15,500BDT', 15500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(113, 'CorsairX27 Spec27 - 16,000BDT', 16000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(114, 'CorsairX28 Spec28 - 16,500BDT', 16500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(115, 'CorsairX29 Spec29 - 17,000BDT', 17000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(116, 'CorsairX3 ICUE RGB - 7,000BDT', 7000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(117, 'CorsairX30 Spec30 - 17,500BDT', 17500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(118, 'CorsairX31 Spec31 - 18,000BDT', 18000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(119, 'CorsairX32 Spec32 - 18,500BDT', 18500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(120, 'CorsairX33 Spec33 - 19,000BDT', 19000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(121, 'CorsairX34 Spec34 - 19,500BDT', 19500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(122, 'CorsairX35 Spec35 - 20,000BDT', 20000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(123, 'CorsairX36 Spec36 - 20,500BDT', 20500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(124, 'CorsairX37 Spec37 - 21,000BDT', 21000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(125, 'CorsairX38 Spec38 - 21,500BDT', 21500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(126, 'CorsairX39 Spec39 - 22,000BDT', 22000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(127, 'CorsairX4 Spec04 - 3,500BDT', 3500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(128, 'CorsairX40 Spec40 - 22,500BDT', 22500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(129, 'CorsairX41 Spec41 - 23,000BDT', 23000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(130, 'CorsairX42 Spec42 - 23,500BDT', 23500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(131, 'CorsairX43 Spec43 - 24,000BDT', 24000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(132, 'CorsairX44 Spec44 - 24,500BDT', 24500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(133, 'CorsairX45 Spec45 - 25,000BDT', 25000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(134, 'CorsairX46 Spec46 - 25,500BDT', 25500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(135, 'CorsairX47 Spec47 - 26,000BDT', 26000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(136, 'CorsairX48 Spec48 - 26,500BDT', 26500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(137, 'CorsairX49 Spec49 - 27,000BDT', 27000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(138, 'CorsairX5 Spec05 - 4,000BDT', 4000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(139, 'CorsairX50 Spec50 - 27,500BDT', 27500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(140, 'CorsairX6 Spec06 - 4,500BDT', 4500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(141, 'CorsairX7 Spec07 - 5,500BDT', 5500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(142, 'CorsairX8 Spec08 - 6,000BDT', 6000.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(143, 'CorsairX9 Spec09 - 6,500BDT', 6500.00, 'Description here', 'Cabinet', '2025-04-30 05:02:52'),
(157, 'Stock CPU cooler -- 0BDT', 0.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(158, 'AIR COOLER -- 6,000BDT', 6000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(159, 'LIQUID COOLER -- 16,000BDT', 16000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(160, 'Custom Acrylic Water Cooling Kit -- 40,000BDT', 40000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(161, 'Basic Air Cooler -- 3,500BDT', 3500.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(162, 'Premium Air Cooler -- 8,000BDT', 8000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(163, 'RGB Air Cooler -- 7,500BDT', 7500.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(164, 'Advanced Liquid Cooler -- 18,000BDT', 18000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(165, 'Dual Fan Liquid Cooler -- 20,000BDT', 20000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(166, 'Single Fan Liquid Cooler -- 14,000BDT', 14000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(167, 'Water Cooling Kit - Basic -- 25,000BDT', 25000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(168, 'Water Cooling Kit - Advanced -- 45,000BDT', 45000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(169, 'Custom Copper Water Cooling Kit -- 50,000BDT', 50000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(170, 'Compact Liquid Cooler -- 12,000BDT', 12000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(171, 'Dual Radiator Liquid Cooler -- 30,000BDT', 30000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(172, 'AIO Liquid Cooler -- 22,000BDT', 22000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(173, 'Dual Tower Air Cooler -- 9,000BDT', 9000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(174, 'Triple Fan Liquid Cooler -- 35,000BDT', 35000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(175, 'Silent Fan Air Cooler -- 5,000BDT', 5000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(176, 'Full Tower Water Cooling System -- 60,000BDT', 60000.00, 'Description here', 'Cooler', '2025-04-30 05:03:00'),
(229, 'test cpu1', 111.00, 'assdfasd', 'CPU', '2025-05-07 17:08:03'),
(230, 'test gpu', 1231.00, 'asdfasdf', 'GPU', '2025-05-07 17:08:10'),
(232, 'test gpu1', 132.00, 'dfasdf', 'GPU', '2025-05-07 17:26:35'),
(236, 'test cabinet1', 123123.00, 'sdfasdf', '', '2025-05-07 17:37:20'),
(237, 'test cabinet1', 123123.00, 'sdfasdf', '', '2025-05-07 17:38:40'),
(238, 'test cabinet1', 123123.00, 'sdfasdf', '', '2025-05-07 17:38:49'),
(239, 'test cabinet1', 1212.00, 'dfasdf', 'GPU', '2025-05-07 18:45:39'),
(240, 'test gpu', 1212.00, 'dfasdf', 'GPU', '2025-05-07 18:53:09'),
(241, 'test cabinet1', 1212.00, 'dfasdf', '', '2025-05-07 18:53:35'),
(242, 'test cpu_cooler1', 1212.00, 'dfasdf', '', '2025-05-07 18:56:27'),
(243, 'test gpu 100', 1212.00, 'dfasdf', 'GPU', '2025-05-07 19:27:29'),
(244, 'test gpu100', 123123.00, 'asdfa', 'GPU', '2025-05-07 19:33:40'),
(245, 'test gpu100', 123123.00, 'asdfa', 'GPU', '2025-05-07 19:34:19'),
(246, 'test cabinet1', 12312.00, NULL, 'GPU', '2025-05-07 19:47:33'),
(247, 'test cabinet1', 12312.00, NULL, 'GPU', '2025-05-07 19:48:47'),
(248, 'test cabinet1', 12312.00, NULL, '', '2025-05-07 19:50:22'),
(249, 'test cabinet1', 12312.00, NULL, '', '2025-05-07 19:53:40'),
(333, 'psutestfile', 452345.00, NULL, '', '2025-05-07 20:44:42'),
(555, 'cooler12363456', 1231.00, NULL, '', '2025-05-07 21:08:43'),
(888, 'testssd', 890.00, NULL, '', '2025-05-07 20:00:35'),
(991, 'test cooler 1', 12312.00, NULL, '', '2025-05-07 19:59:46'),
(999, 'test cabinet1', 123123.00, NULL, '', '2025-05-07 19:55:20'),
(1536, 'psutestfile', 452345.00, NULL, '', '2025-05-07 20:45:36'),
(90999, 'test cabinet1', 123123.00, NULL, '', '2025-05-07 20:06:50'),
(91000, 'cputest111', 111.00, NULL, 'CPU', '2025-05-07 20:23:22'),
(91001, 'gputestfiule', 453453.00, NULL, 'GPU', '2025-05-07 20:26:04'),
(91009, 'mbtestfile', 452345.00, NULL, '', '2025-05-07 20:39:38'),
(91010, 'psutestfile', 452345.00, NULL, '', '2025-05-07 20:41:48'),
(91011, 'psutest123123', 1231.00, NULL, 'CPU', '2025-05-07 20:48:39'),
(91012, 'psutest12323', 123123.00, NULL, '', '2025-05-07 20:48:56'),
(91013, 'ramtest', 123123.00, NULL, '', '2025-05-07 20:50:11'),
(91014, 'ramtest', 123123.00, NULL, 'HDD', '2025-05-07 20:52:42'),
(91015, 'ramtest', 123123.00, NULL, '', '2025-05-07 20:52:48'),
(91016, 'ramtest', 123123.00, NULL, '', '2025-05-07 20:52:53'),
(91017, 'ramtest', 123123.00, NULL, '', '2025-05-07 20:56:01'),
(91019, 'cooler12312231', 123123.00, NULL, '', '2025-05-07 20:59:26'),
(91020, 'cooler12312231', 123123.00, NULL, '', '2025-05-07 21:08:19'),
(91021, 'test cabinet1', 123123.00, NULL, 'CPU', '2025-05-07 21:19:37'),
(91022, 'goputeste', 123123.00, NULL, 'GPU', '2025-05-07 21:20:05'),
(91023, 'test mb', 12312.00, NULL, 'GPU', '2025-05-07 21:23:18'),
(91024, 'mb999', 123123.00, NULL, '', '2025-05-07 21:24:41'),
(91025, 'mb1111', 1231.00, NULL, '', '2025-05-07 21:28:36'),
(91026, 'mb1111', 1231.00, NULL, '', '2025-05-07 21:29:13'),
(91027, 'asdfasdf', 123123.00, NULL, '', '2025-05-07 21:30:01'),
(91028, 'test cabinet1', 123423.00, NULL, '', '2025-05-07 21:33:19'),
(91029, 'test cabinet1', 234234.00, NULL, '', '2025-05-07 21:34:27'),
(91030, 'test cabinet1', 3123123.00, NULL, '', '2025-05-07 21:36:14'),
(91031, 'm,bteset', 123123.00, NULL, '', '2025-05-07 21:37:20'),
(91032, 'gputestfiule123123', 123123.00, NULL, 'GPU', '2025-05-07 21:39:36'),
(91033, 'asdfasdf', 123123.00, NULL, '', '2025-05-07 21:43:59'),
(91034, 'test cabinet1', 123123.00, NULL, '', '2025-05-07 21:44:32'),
(91035, 'casin1', 123123.00, NULL, '', '2025-05-07 21:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `userid` varchar(200) NOT NULL,
  `model_name` varchar(50) NOT NULL,
  `CPU_id` varchar(20) NOT NULL,
  `GPU_id` varchar(10) NOT NULL,
  `RAM_id` varchar(200) NOT NULL,
  `mb_id` varchar(200) NOT NULL,
  `SSD_id` varchar(200) NOT NULL,
  `HDD_id` varchar(200) NOT NULL,
  `ps_id` varchar(200) NOT NULL,
  `cooler_id` varchar(200) NOT NULL,
  `total_price` int(11) NOT NULL,
  `mode_of_payment` varchar(200) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`id`, `userid`, `model_name`, `CPU_id`, `GPU_id`, `RAM_id`, `mb_id`, `SSD_id`, `HDD_id`, `ps_id`, `cooler_id`, `total_price`, `mode_of_payment`, `timestamp`) VALUES
(24, 'rut.cholera7@gmail.com', 'Corsair Spec02 - 5,000BDT', 'Intel i5 11th Gen --', 'Nvidea RTX', '16Gb 3600MHZ 16X1 -- 15000BDT', 'Intel B450 Motherboard -- 1,200BDT', '512GB SATA SSD -- 6000BDT', '1GB 7200RPM HDD -- 5,000BDT', '550W Semi-Modular 80+Silver Certified -- 6,000BDT', 'CPU_COOLER', 125000, 'Cash On Delivery', '2021-10-27 10:18:29'),
(26, 'rut.cholera7@gmail.com', 'Corsair Spec01 - 3,000BDT', 'Intel i5 11th Gen --', 'Nvidea RTX', '8GB 3200MHZ 8X1 -- 8000BDT', 'Intel B450 Motherboard -- 1,200BDT', '512GB SATA SSD -- 6000BDT', '1GB 5400RPM HDD -- 4,000BDT', '550W Semi-Modular 80+Silver Certified -- 6,000BDT', 'CPU_COOLER', 115000, 'Online Payment', '2021-10-27 11:38:32'),
(27, 'newuser@gmail.com', 'CorsairX1 Spec01 - 3,000BDT', 'AMD Ryzen7 -- 19,000', 'Nvidea RTX', '16GB 4000MHZ 8X2 -- 18,000BDT', 'AMD X470 Motherboard -- 12,500BDT', '2TB NVME SSD -- 25,000BDT', '500GB 5400RPM HDD -- 2,500BDT', '450W Non-Modular 80+Brozne Certified -- 3,500BDT', 'CPU_COOLER', 188550, 'Cash On Delivery', '2025-05-03 02:26:31'),
(28, 'newuser@gmail.com', 'CorsairX1 Spec01 - 3,000BDT', 'Intel i7 12th Gen --', 'Nvidea RTX', '16GB 4000MHZ 8X2 -- 18,000BDT', 'AMD X470 Motherboard -- 12,500BDT', '128GB SATA SSD -- 3,000BDT', '3TB 7200RPM HDD -- 10,500BDT', '450W Non-Modular 80+Brozne Certified -- 3,500BDT', 'CPU_COOLER', 190500, 'Cash On Delivery', '2025-05-03 02:31:46'),
(29, 'newuser@gmail.com', 'casingtestfile', 'AMD Ryzen7 5800X -- ', 'Nvidea RTX', '16GB 4000MHZ 8X2 -- 18,000BDT', 'AMD X470 Motherboard -- 12,500BDT', '2TB PCIe SSD -- 30,000BDT', '3TB 7200RPM HDD -- 10,500BDT', '900W Full-Modular 80+Platinum Certified -- 10,000BDT', 'CPU_COOLER', 296898, 'Cash On Delivery', '2025-05-08 04:22:35');

-- --------------------------------------------------------

--
-- Table structure for table `psu`
--

CREATE TABLE `psu` (
  `ps_full_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `psu`
--

INSERT INTO `psu` (`ps_full_name`, `price`) VALUES
('psutest12323', 123123),
('450W Non-Modular 80+Brozne Certified -- 3,500BDT', 3500),
('550W Semi-Modular 80+Silver Certified -- 6,000BDT', 6000),
('750W Full-Modular 80+Gold Certified -- 8,000BDT', 8000),
('900W Full-Modular 80+Platinum Certified -- 10,000BDT', 10000),
('1000W Full-Modular 90+Platinum Certified -- 16,000BDT', 16000);

-- --------------------------------------------------------

--
-- Table structure for table `ram`
--

CREATE TABLE `ram` (
  `RAM_full_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ram`
--

INSERT INTO `ram` (`RAM_full_name`, `price`) VALUES
('ram1', 1212),
('8GB 3200MHZ 8X1 -- 8,000BDT', 8000),
('16GB 3600MHZ 16X1 -- 15,000BDT', 15000),
('16GB 3200MHZ 8X2 -- 12,000BDT', 12000),
('32GB 3600MHZ 16X2 -- 21,000BDT', 21000),
('32GB 3000MHZ 8X4 -- 20,000BDT', 20000),
('64GB 3200MHZ 16X4 -- 32,000BDT', 32000),
('8GB 2400MHZ 8X1 -- 5,500BDT', 5500),
('16GB 2666MHZ 8X2 -- 10,500BDT', 10500),
('32GB 2666MHZ 16X2 -- 17,500BDT', 17500),
('64GB 2666MHZ 16X4 -- 27,000BDT', 27000),
('8GB 3000MHZ 8X1 -- 7,000BDT', 7000),
('16GB 2933MHZ 8X2 -- 11,000BDT', 11000),
('32GB 3200MHZ 8X4 -- 19,000BDT', 19000),
('16GB 3600MHZ 8X2 -- 13,500BDT', 13500),
('64GB 2933MHZ 16X4 -- 29,500BDT', 29500),
('16GB 4000MHZ 8X2 -- 18,000BDT', 18000),
('32GB 4000MHZ 16X2 -- 22,000BDT', 22000),
('64GB 4000MHZ 16X4 -- 37,000BDT', 37000),
('8GB 2400MHZ 4X2 -- 6,000BDT', 6000),
('16GB 2666MHZ 16X1 -- 9,500BDT', 9500);

-- --------------------------------------------------------

--
-- Table structure for table `ssd`
--

CREATE TABLE `ssd` (
  `SSD_full_name` varchar(30) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ssd`
--

INSERT INTO `ssd` (`SSD_full_name`, `price`) VALUES
('sssd1', 1231),
('256GB SATA SSD -- 4,000BDT', 4000),
('512GB SATA SSD -- 6,000BDT', 6000),
('512GB NVME SSD -- 8,000BDT', 8000),
('512GB PCIe SSD -- 13,000BDT', 13000),
('1TB SATA SSD -- 9,000BDT', 9000),
('1TB NVME SSD -- 14,000BDT', 14000),
('1TB PCIe SSD -- 21,000BDT', 21000),
('256GB NVME SSD -- 5,500BDT', 5500),
('256GB PCIe SSD -- 9,500BDT', 9500),
('512GB SATA SSD -- 7,500BDT', 7500),
('1TB SATA SSD -- 12,000BDT', 12000),
('1TB NVME SSD -- 16,000BDT', 16000),
('2TB SATA SSD -- 18,000BDT', 18000),
('2TB NVME SSD -- 25,000BDT', 25000),
('2TB PCIe SSD -- 30,000BDT', 30000),
('128GB SATA SSD -- 3,000BDT', 3000),
('128GB NVME SSD -- 4,500BDT', 4500),
('256GB PCIe SSD -- 7,000BDT', 7000),
('512GB SATA SSD -- 8,500BDT', 8500),
('1TB PCIe SSD -- 17,000BDT', 17000),
('testssd', 890);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `timestamp`, `role`) VALUES
(18, 'mhjihad12345@gmail.com', 'BnM.276720@#', '2021-10-27 10:09:46', 'admin'),
(20, 'rut.cholera09@gmail.com', '$2y$10$tWp33tjWugp//DW.b6DT3ucGB8itPkfZO50t9IP/vnWV9w2JstRRi', '2021-10-27 11:36:39', 'user'),
(21, 'newuser@gmail.com', '$2y$10$MNrYJwRoTCbZEa4bIMgWqO5ixvsENZcA9m1EoXzZfsVAPTGW6YqT.', '2025-05-03 02:25:20', 'user'),
(23, 'jahidul@gmail.com', '$2y$10$KkSM6BttvLpuRtLeyZRNB.ZYndHS7mtY3sqKxwlEWfvIctZdGbMAC', '2025-05-08 04:28:12', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `id` int(10) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `address` varchar(300) NOT NULL,
  `city` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `zip_code` varchar(200) NOT NULL,
  `mobile-number` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`id`, `user_id`, `firstname`, `lastname`, `address`, `city`, `state`, `country`, `zip_code`, `mobile-number`) VALUES
(20, 'rut.cholera7@gmail.com', 'Rut', 'Cholera', 'andheri', 'mumbai', 'maharashtra', 'india', '400001', '123456789'),
(21, 'newuser@gmail.com', 'Mujahidul Haque', 'Jihad', 'Uttar Badda, Dhaka', 'DHAKA', 'Dhaka', 'Bangladesh', '1212', '01706269707'),
(22, 'jahidul@gmail.com', 'Mujahidul Haque', 'Jihad', 'Uttar Badda, Dhaka', 'DHAKA', 'Dhaka', 'Bangladesh', '1212', '01706269707');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91036;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
