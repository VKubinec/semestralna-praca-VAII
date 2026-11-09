<?php

namespace App\Models;

use Framework\Core\Model;

class Tankovanie extends Model
{
    protected static ?string $tableName = 'tankovania';

    public ?int $id = null;
    public int $vozidlo_id = 0;
    public string $datum_tankovania = '';
    public string $mnozstvo_l = '0.00';
    public string $cena_za_liter = '0.000';
    public int $stav_km = 0;
    public ?string $cerpacia_stanica = null;
}
