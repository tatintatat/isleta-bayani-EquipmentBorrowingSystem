-- Equipment Borrowing System Database
-- ITEL 203 - Web Systems and Technologies

CREATE DATABASE IF NOT EXISTS db_equipment_borrowing;
USE db_equipment_borrowing;

-- Equipment table
CREATE TABLE IF NOT EXISTS equipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT,
    serial_number VARCHAR(100),
    total_quantity INT NOT NULL DEFAULT 1,
    available_quantity INT NOT NULL DEFAULT 1,
    condition_status ENUM('Excellent','Good','Fair','Needs Repair') DEFAULT 'Good',
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Borrowers / Borrow Records table
CREATE TABLE IF NOT EXISTS borrow_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    borrower_name VARCHAR(150) NOT NULL,
    borrower_email VARCHAR(150),
    borrower_contact VARCHAR(50),
    department VARCHAR(100),
    equipment_id INT NOT NULL,
    quantity_borrowed INT NOT NULL DEFAULT 1,
    purpose TEXT,
    borrow_date DATE NOT NULL,
    expected_return DATE NOT NULL,
    actual_return DATE NULL,
    status ENUM('Borrowed','Returned','Overdue') DEFAULT 'Borrowed',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (equipment_id) REFERENCES equipment(id) ON DELETE CASCADE
);

-- Sample equipment data
INSERT INTO equipment (name, category, description, serial_number, total_quantity, available_quantity, condition_status) VALUES
('Laptop - Dell Inspiron 15', 'Computing', '15.6" FHD display, Intel Core i5, 8GB RAM, 512GB SSD', 'DL-INS-2024-001', 5, 4, 'Excellent'),
('Projector - Epson EX3280', 'Presentation', '3LCD projector, SVGA, 3,600 lumens brightness', 'EP-EX32-2023-001', 3, 3, 'Good'),
('DSLR Camera - Canon EOS 2000D', 'Photography', '24.1MP APS-C CMOS sensor, Full HD video', 'CN-EOS2-2022-001', 2, 2, 'Good'),
('Arduino Uno R3 Kit', 'Electronics', 'Microcontroller board with sensors and components kit', 'AR-UNO-2024-001', 10, 9, 'Excellent'),
('Oscilloscope - Rigol DS1054Z', 'Electronics', '4-channel digital oscilloscope, 50MHz bandwidth', 'RG-DS10-2023-001', 2, 2, 'Good'),
('Portable Speaker - JBL Charge 5', 'Audio', 'Bluetooth portable speaker with IP67 waterproof rating', 'JBL-CH5-2024-001', 4, 4, 'Excellent'),
('Raspberry Pi 4 Model B', 'Computing', '4GB RAM, Broadcom BCM2711 quad-core Cortex-A72', 'RP-PI4-2024-001', 8, 7, 'Excellent'),
('Tripod - Manfrotto MT055', 'Photography', 'Professional aluminum tripod, max height 170cm', 'MF-MT05-2022-001', 3, 3, 'Fair'),
('Soldering Station - Hakko FX-888D', 'Electronics', 'Digital soldering station, temperature range 200–480°C', 'HK-FX88-2023-001', 2, 2, 'Good'),
('Extension Cord 10m', 'Utilities', 'Heavy-duty 3-socket extension cord with surge protection', 'EC-10M-2024-001', 6, 6, 'Good');

-- Sample borrow records
INSERT INTO borrow_records (borrower_name, borrower_email, borrower_contact, department, equipment_id, quantity_borrowed, purpose, borrow_date, expected_return, status) VALUES
('Juan Dela Cruz', 'juan@school.edu', '09171234567', 'Computer Science', 1, 1, 'Thesis project development', '2026-03-28', '2026-04-05', 'Borrowed'),
('Maria Santos', 'maria@school.edu', '09281234567', 'Information Technology', 4, 1, 'IoT class project', '2026-03-30', '2026-04-06', 'Borrowed'),
('Pedro Reyes', 'pedro@school.edu', '09391234567', 'Electronics Engineering', 7, 1, 'Embedded systems project', '2026-03-25', '2026-04-01', 'Overdue');
