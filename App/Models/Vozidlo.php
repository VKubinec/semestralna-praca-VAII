<?php

namespace App\Models;

use Framework\Core\Model;

// AI-assisted implementation: ChatGPT, VAII assignment 6.
class Vozidlo extends Model
{
    protected static ?string $tableName = 'vozidla';

    public ?int $id = null;
    public string $znacka = '';
    public string $model = '';
    public int $rok_vyroby = 2020;
    public string $ecv = '';
    public ?string $vin = null;
    public string $palivo = 'Benzin';
    public int $stav_km = 0;
    public ?string $stk_do = null;
    public ?string $ek_do = null;
    public ?string $servis_do = null;
}
