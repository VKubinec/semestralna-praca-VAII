CREATE TABLE IF NOT EXISTS tankovania (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    vozidlo_id BIGINT UNSIGNED NOT NULL,
    datum_tankovania DATE NOT NULL,
    mnozstvo_l DECIMAL(8,2) NOT NULL,
    cena_za_liter DECIMAL(7,3) NOT NULL,
    stav_km INT UNSIGNED NOT NULL DEFAULT 0,
    cerpacia_stanica VARCHAR(120) NULL,
    PRIMARY KEY (id),
    INDEX idx_tankovania_vozidlo (vozidlo_id),
    CONSTRAINT fk_tankovania_vozidlo
        FOREIGN KEY (vozidlo_id) REFERENCES vozidla(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
