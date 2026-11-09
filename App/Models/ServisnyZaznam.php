<?php

namespace App\Models;

use Framework\Core\Model;

// AI-assisted implementation: ChatGPT, VAII assignment 7.
class ServisnyZaznam extends Model
{
    protected static ?string $tableName = 'servisne_zaznamy';

    public ?int $id = null;
    public int $vozidlo_id = 0;
    public string $nazov_ukonu = '';
    public ?string $popis = null;
    public string $datum_servisu = '';
    public int $stav_km = 0;
    public string $cena = '0.00';
    public ?string $nazov_servisu = null;
}
