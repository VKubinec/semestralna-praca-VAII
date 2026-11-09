-- AI-assisted SQL for VAII assignment 7.
-- The script runs after 01_vozidla.sql when a new MariaDB volume is initialized.
CREATE TABLE IF NOT EXISTS servisne_zaznamy (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    vozidlo_id BIGINT UNSIGNED NOT NULL,
    nazov_ukonu VARCHAR(120) NOT NULL,
    popis VARCHAR(500) NULL,
    datum_servisu DATE NOT NULL,
    stav_km INT UNSIGNED NOT NULL DEFAULT 0,
    cena DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    nazov_servisu VARCHAR(150) NULL,
    PRIMARY KEY (id),
    INDEX idx_servisne_zaznamy_vozidlo (vozidlo_id),
    CONSTRAINT fk_servisne_zaznamy_vozidlo
        FOREIGN KEY (vozidlo_id) REFERENCES vozidla(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
