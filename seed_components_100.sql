-- Add 100 components with placeholder images. Run after database_migration.sql
-- Uses Taka; image_url uses placehold.co for consistent look.

SET NAMES utf8mb4;

-- Placeholder base URL (260x140, dark bg, green text)
SET @img = 'https://placehold.co/260x140/1a1a2e/36ec4e';

-- Cabinet (11)
INSERT INTO `cabinet` (model_name, full_name, price, stock, image_url, description) VALUES
('CAB-001', 'NZXT H510 Compact Mid Tower', 8500, 15, CONCAT(@img,'?text=Case'), 'Tempered glass, USB 3.1'),
('CAB-002', 'Corsair 4000D Airflow', 9200, 12, CONCAT(@img,'?text=Case'), 'Mid tower, excellent airflow'),
('CAB-003', 'Lian Li O11 Dynamic', 14500, 8, CONCAT(@img,'?text=Case'), 'Dual chamber, glass'),
('CAB-004', 'Cooler Master MasterBox Q300L', 5500, 20, CONCAT(@img,'?text=Case'), 'Micro ATX, compact'),
('CAB-005', 'Fractal Design Meshify C', 11000, 10, CONCAT(@img,'?text=Case'), 'Mesh front, quiet'),
('CAB-006', 'Phanteks P400A', 9500, 14, CONCAT(@img,'?text=Case'), 'RGB optional, airflow'),
('CAB-007', 'be quiet! Pure Base 500', 10200, 9, CONCAT(@img,'?text=Case'), 'Silent focused'),
('CAB-008', 'Antec NX410', 6200, 18, CONCAT(@img,'?text=Case'), 'Mid tower, value'),
('CAB-009', 'Thermaltake View 21', 7800, 11, CONCAT(@img,'?text=Case'), 'Tempered glass'),
('CAB-010', 'Silverstone Fara R1', 5800, 16, CONCAT(@img,'?text=Case'), 'Budget ATX'),
('CAB-011', 'MSI MAG Forge 100R', 7200, 13, CONCAT(@img,'?text=Case'), 'RGB, tempered glass');

-- Processor (12) – need cpu_id, cpu_full_name, price, stock, image_url, socket_type, description
INSERT INTO `processor` (cpu_id, cpu_full_name, price, stock, image_url, socket_type, description) VALUES
('i3-12100', 'Intel Core i3-12100 4C/8T', 12500, 25, CONCAT(@img,'?text=CPU'), 'LGA1700', '12th Gen'),
('i5-12400', 'Intel Core i5-12400 6C/12T', 18500, 20, CONCAT(@img,'?text=CPU'), 'LGA1700', '12th Gen'),
('i5-13400', 'Intel Core i5-13400 6C/12T', 22000, 18, CONCAT(@img,'?text=CPU'), 'LGA1700', '13th Gen'),
('i7-12700', 'Intel Core i7-12700 12C/20T', 32000, 12, CONCAT(@img,'?text=CPU'), 'LGA1700', '12th Gen'),
('i7-13700', 'Intel Core i7-13700 16C/24T', 38000, 10, CONCAT(@img,'?text=CPU'), 'LGA1700', '13th Gen'),
('i9-13900', 'Intel Core i9-13900 24C/32T', 52000, 6, CONCAT(@img,'?text=CPU'), 'LGA1700', '13th Gen'),
('R5-5600', 'AMD Ryzen 5 5600 6C/12T', 14500, 22, CONCAT(@img,'?text=CPU'), 'AM4', 'Zen 3'),
('R5-5600X', 'AMD Ryzen 5 5600X 6C/12T', 16500, 15, CONCAT(@img,'?text=CPU'), 'AM4', 'Zen 3'),
('R7-5700X', 'AMD Ryzen 7 5700X 8C/16T', 23500, 14, CONCAT(@img,'?text=CPU'), 'AM4', 'Zen 3'),
('R7-5800X3D', 'AMD Ryzen 7 5800X3D 8C/16T 3D V-Cache', 32000, 8, CONCAT(@img,'?text=CPU'), 'AM4', 'Zen 3'),
('R5-7600', 'AMD Ryzen 5 7600 6C/12T', 24500, 12, CONCAT(@img,'?text=CPU'), 'AM5', 'Zen 4'),
('R7-7700', 'AMD Ryzen 7 7700 8C/16T', 33500, 9, CONCAT(@img,'?text=CPU'), 'AM5', 'Zen 4');

-- Motherboard (11) – mb_full_name, price, stock, image_url, socket_type, ram_type, form_factor, description
INSERT INTO `motherboard` (mb_full_name, price, stock, image_url, socket_type, ram_type, form_factor, description) VALUES
('ASUS Prime B660M-A', 14500, 15, CONCAT(@img,'?text=MB'), 'LGA1700', 'DDR4', 'Micro ATX', 'B660'),
('MSI Pro B650M-A WiFi', 18500, 12, CONCAT(@img,'?text=MB'), 'AM5', 'DDR5', 'Micro ATX', 'B650'),
('Gigabyte B550 Aorus Elite', 13500, 18, CONCAT(@img,'?text=MB'), 'AM4', 'DDR4', 'ATX', 'B550'),
('ASRock B760M Pro RS', 15200, 10, CONCAT(@img,'?text=MB'), 'LGA1700', 'DDR5', 'Micro ATX', 'B760'),
('MSI MAG B550 TOMAHAWK', 16800, 9, CONCAT(@img,'?text=MB'), 'AM4', 'DDR4', 'ATX', 'B550'),
('ASUS ROG Strix B650E-F', 26500, 7, CONCAT(@img,'?text=MB'), 'AM5', 'DDR5', 'ATX', 'B650E'),
('Gigabyte Z790 UD', 24500, 8, CONCAT(@img,'?text=MB'), 'LGA1700', 'DDR5', 'ATX', 'Z790'),
('ASRock X670E Pro RS', 32000, 5, CONCAT(@img,'?text=MB'), 'AM5', 'DDR5', 'ATX', 'X670E'),
('MSI B450M PRO-VDH', 9500, 20, CONCAT(@img,'?text=MB'), 'AM4', 'DDR4', 'Micro ATX', 'B450'),
('ASUS TUF Gaming B550-Plus', 15800, 11, CONCAT(@img,'?text=MB'), 'AM4', 'DDR4', 'ATX', 'B550'),
('Gigabyte H610M S2H', 9800, 16, CONCAT(@img,'?text=MB'), 'LGA1700', 'DDR4', 'Micro ATX', 'H610');

-- GPU (11)
INSERT INTO `gpu` (gpu_id, gpu_full_name, price, stock, image_url, description) VALUES
('GTX1650', 'NVIDIA GeForce GTX 1650 4GB', 18500, 14, CONCAT(@img,'?text=GPU'), 'GDDR5'),
('RTX3050', 'NVIDIA GeForce RTX 3050 8GB', 28500, 12, CONCAT(@img,'?text=GPU'), 'Ray tracing'),
('RTX3060', 'NVIDIA GeForce RTX 3060 12GB', 38500, 10, CONCAT(@img,'?text=GPU'), '1080p/1440p'),
('RTX4060', 'NVIDIA GeForce RTX 4060 8GB', 42000, 9, CONCAT(@img,'?text=GPU'), 'Ada Lovelace'),
('RTX4070', 'NVIDIA GeForce RTX 4070 12GB', 62500, 6, CONCAT(@img,'?text=GPU'), '1440p'),
('RX6600', 'AMD Radeon RX 6600 8GB', 26500, 11, CONCAT(@img,'?text=GPU'), 'RDNA 2'),
('RX7600', 'AMD Radeon RX 7600 8GB', 35500, 8, CONCAT(@img,'?text=GPU'), 'RDNA 3'),
('RX7700XT', 'AMD Radeon RX 7700 XT 12GB', 52500, 5, CONCAT(@img,'?text=GPU'), 'RDNA 3'),
('RTX3080', 'NVIDIA GeForce RTX 3080 10GB', 72000, 4, CONCAT(@img,'?text=GPU'), 'Last gen flagship'),
('GT1030', 'NVIDIA GeForce GT 1030 2GB', 8500, 25, CONCAT(@img,'?text=GPU'), 'Office/light'),
('RX6500XT', 'AMD Radeon RX 6500 XT 4GB', 19500, 15, CONCAT(@img,'?text=GPU'), 'Budget 1080p');

-- RAM (11)
INSERT INTO `ram` (ram_full_name, price, stock, image_url, ram_type, description) VALUES
('Corsair Vengeance 8GB DDR4 3200', 2500, 40, CONCAT(@img,'?text=RAM'), 'DDR4', 'Single stick'),
('Corsair Vengeance 16GB DDR4 3200', 4500, 35, CONCAT(@img,'?text=RAM'), 'DDR4', '2x8GB kit'),
('G.Skill Ripjaws V 16GB DDR4 3600', 5200, 28, CONCAT(@img,'?text=RAM'), 'DDR4', '2x8GB'),
('Kingston Fury Beast 32GB DDR4 3200', 8500, 22, CONCAT(@img,'?text=RAM'), 'DDR4', '2x16GB'),
('Corsair Vengeance 32GB DDR5 5200', 11500, 18, CONCAT(@img,'?text=RAM'), 'DDR5', '2x16GB'),
('G.Skill Trident Z5 32GB DDR5 6000', 14500, 12, CONCAT(@img,'?text=RAM'), 'DDR5', '2x16GB RGB'),
('ADATA XPG 16GB DDR4 3200', 4200, 30, CONCAT(@img,'?text=RAM'), 'DDR4', '2x8GB'),
('Teamgroup T-Force 32GB DDR5 5600', 10500, 15, CONCAT(@img,'?text=RAM'), 'DDR5', '2x16GB'),
('Crucial 8GB DDR4 2666', 2200, 45, CONCAT(@img,'?text=RAM'), 'DDR4', 'Single stick'),
('Patriot Viper 16GB DDR4 3200', 4400, 25, CONCAT(@img,'?text=RAM'), 'DDR4', '2x8GB'),
('G.Skill Flare X 32GB DDR5 6000', 13800, 10, CONCAT(@img,'?text=RAM'), 'DDR5', 'EXPO, 2x16GB');

-- SSD (11)
INSERT INTO `ssd` (ssd_full_name, price, stock, image_url, description) VALUES
('Samsung 970 EVO Plus 250GB NVMe', 4500, 30, CONCAT(@img,'?text=SSD'), 'M.2 NVMe'),
('Samsung 980 500GB NVMe', 6500, 25, CONCAT(@img,'?text=SSD'), 'M.2 NVMe'),
('WD Blue SN570 500GB NVMe', 5200, 28, CONCAT(@img,'?text=SSD'), 'M.2 NVMe'),
('Crucial P3 1TB NVMe', 8500, 20, CONCAT(@img,'?text=SSD'), 'M.2 NVMe Gen3'),
('Samsung 980 PRO 1TB NVMe', 12500, 15, CONCAT(@img,'?text=SSD'), 'M.2 NVMe Gen4'),
('Kingston NV2 1TB NVMe', 7200, 22, CONCAT(@img,'?text=SSD'), 'M.2 NVMe'),
('WD Black SN850X 1TB', 13500, 12, CONCAT(@img,'?text=SSD'), 'M.2 NVMe Gen4'),
('Crucial P5 Plus 2TB', 18500, 8, CONCAT(@img,'?text=SSD'), 'M.2 NVMe Gen4'),
('Samsung 870 EVO 500GB SATA', 5500, 18, CONCAT(@img,'?text=SSD'), '2.5" SATA'),
('ADATA XPG SX8200 Pro 1TB', 9500, 14, CONCAT(@img,'?text=SSD'), 'M.2 NVMe'),
('Teamgroup MP34 1TB', 7800, 16, CONCAT(@img,'?text=SSD'), 'M.2 NVMe');

-- HDD (11)
INSERT INTO `hdd` (hdd_full_name, price, stock, image_url, description) VALUES
('WD Blue 1TB 7200RPM', 4200, 35, CONCAT(@img,'?text=HDD'), '3.5" SATA'),
('Seagate Barracuda 1TB', 4000, 38, CONCAT(@img,'?text=HDD'), '3.5" SATA'),
('WD Blue 2TB 7200RPM', 6200, 28, CONCAT(@img,'?text=HDD'), '3.5" SATA'),
('Seagate Barracuda 2TB', 5800, 30, CONCAT(@img,'?text=HDD'), '3.5" SATA'),
('WD Red 4TB NAS', 12500, 12, CONCAT(@img,'?text=HDD'), '3.5" NAS'),
('Seagate BarraCuda 4TB', 9500, 15, CONCAT(@img,'?text=HDD'), '3.5" SATA'),
('WD Black 1TB 7200RPM', 6500, 18, CONCAT(@img,'?text=HDD'), 'Performance'),
('Toshiba P300 2TB', 5600, 22, CONCAT(@img,'?text=HDD'), '3.5" SATA'),
('WD Purple 2TB Surveillance', 7200, 10, CONCAT(@img,'?text=HDD'), 'Surveillance'),
('Seagate SkyHawk 2TB', 6800, 14, CONCAT(@img,'?text=HDD'), 'Surveillance'),
('WD Blue 4TB', 10500, 9, CONCAT(@img,'?text=HDD'), '3.5" SATA');

-- Power supply (11)
INSERT INTO `power_supply` (ps_full_name, price, stock, image_url, wattage, description) VALUES
('Corsair CV450 450W', 4200, 25, CONCAT(@img,'?text=PSU'), 450, '80+ Bronze'),
('Cooler Master MWE 550 Bronze', 5200, 22, CONCAT(@img,'?text=PSU'), 550, '80+ Bronze'),
('Corsair CX650M 650W', 6800, 18, CONCAT(@img,'?text=PSU'), 650, '80+ Bronze Semi-modular'),
('Seasonic S12III 650W', 6200, 20, CONCAT(@img,'?text=PSU'), 650, '80+ Bronze'),
('Corsair RM750 750W', 10500, 14, CONCAT(@img,'?text=PSU'), 750, '80+ Gold Fully modular'),
('Cooler Master MWE 750 Gold', 9500, 12, CONCAT(@img,'?text=PSU'), 750, '80+ Gold'),
('be quiet! Pure Power 11 600W', 8200, 15, CONCAT(@img,'?text=PSU'), 600, '80+ Gold'),
('EVGA 600 W1', 4800, 28, CONCAT(@img,'?text=PSU'), 600, '80+'),
('Corsair RM850 850W', 12500, 10, CONCAT(@img,'?text=PSU'), 850, '80+ Gold Fully modular'),
('Seasonic Focus GX-750', 11500, 11, CONCAT(@img,'?text=PSU'), 750, '80+ Gold'),
('MSI MAG A650BN 650W', 5500, 16, CONCAT(@img,'?text=PSU'), 650, '80+ Bronze');

-- CPU Cooler (11)
INSERT INTO `cpu_cooler` (cooler_full_name, price, stock, image_url, description) VALUES
('Cooler Master Hyper 212', 3500, 30, CONCAT(@img,'?text=Cooler'), 'Tower air'),
('Deepcool AK400', 3200, 28, CONCAT(@img,'?text=Cooler'), 'Single tower'),
('Arctic Freezer 34 eSports', 4200, 22, CONCAT(@img,'?text=Cooler'), 'Tower air'),
('Noctua NH-U12S', 8500, 15, CONCAT(@img,'?text=Cooler'), 'Premium air'),
('Cooler Master Hyper 212 RGB', 4500, 20, CONCAT(@img,'?text=Cooler'), 'Tower air RGB'),
('Corsair H100i Elite', 12500, 10, CONCAT(@img,'?text=Cooler'), '240mm AIO'),
('Deepcool AK620', 5500, 18, CONCAT(@img,'?text=Cooler'), 'Dual tower'),
('be quiet! Dark Rock 4', 9500, 12, CONCAT(@img,'?text=Cooler'), 'Silent tower'),
('Arctic Liquid Freezer II 240', 9800, 9, CONCAT(@img,'?text=Cooler'), '240mm AIO'),
('NZXT Kraken X53 240mm', 11500, 8, CONCAT(@img,'?text=Cooler'), '240mm AIO'),
('Stock AMD Wraith Stealth', 500, 100, CONCAT(@img,'?text=Cooler'), 'Replacement stock cooler');
