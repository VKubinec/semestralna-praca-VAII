-- AI-assisted database initialization for VAII assignment 6.
-- Imported automatically on the FIRST initialization of the MariaDB data volume.
CREATE TABLE IF NOT EXISTS vozidla (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    znacka VARCHAR(80) NOT NULL,
    model VARCHAR(80) NOT NULL,
    rok_vyroby SMALLINT UNSIGNED NOT NULL,
    ecv VARCHAR(16) NOT NULL,
    vin VARCHAR(17) NULL,
    palivo VARCHAR(30) NOT NULL,
    stav_km INT UNSIGNED NOT NULL DEFAULT 0,
    stk_do DATE NULL,
    ek_do DATE NULL,
    servis_do DATE NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO vozidla
(znacka, model, rok_vyroby, ecv, vin, palivo, stav_km, stk_do, ek_do, servis_do)
VALUES
('Skoda', 'Octavia III', 2018, 'ZA-123AB', 'TMBJG7NE8J0123456', 'Diesel', 142350, '2027-05-14', '2027-05-14', '2026-12-01'),
('Volkswagen', 'Golf', 2017, 'ZA-917VP', 'WVWZZZ1KZHW123456', 'Benzin', 128320, '2027-04-18', '2027-04-18', '2027-02-20'),
('Toyota', 'Yaris', 2022, 'ZA-236RN', 'VNKKJ3D370A123456', 'Hybrid', 34200, '2028-09-22', '2028-09-22', '2027-03-10');
