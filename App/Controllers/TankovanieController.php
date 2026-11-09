<?php

namespace App\Controllers;

use App\Models\Tankovanie;
use App\Models\Vozidlo;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class TankovanieController extends BaseController
{
    public function index(Request $request): Response
    {
        $vozidloId = null;
        if ($request->get('vozidlo_id') !== null && $request->get('vozidlo_id') !== '') {
            $vozidloId = $this->findVehicle($request->get('vozidlo_id'))->id;
        }

        return $this->html([
            'tankovania' => $vozidloId === null
                ? Tankovanie::getAll(orderBy: 'datum_tankovania DESC, id DESC')
                : Tankovanie::getAll('vozidlo_id = ?', [$vozidloId], 'datum_tankovania DESC, id DESC'),
            'vozidla' => Vozidlo::getAll(orderBy: 'znacka, model'),
            'vybraneVozidloId' => $vozidloId
        ]);
    }

    public function create(Request $request): Response
    {
        $vozidla = Vozidlo::getAll(orderBy: 'znacka, model');
        $tankovanie = new Tankovanie();
        if ($request->get('vozidlo_id') !== null) {
            $tankovanie->vozidlo_id = $this->findVehicle($request->get('vozidlo_id'))->id;
        } elseif ($vozidla) {
            $tankovanie->vozidlo_id = $vozidla[0]->id;
        }
        $tankovanie->datum_tankovania = date('Y-m-d');

        return $this->html([
            'formValues' => $this->values($tankovanie),
            'vozidla' => $vozidla,
            'error' => null,
            'editing' => false
        ], 'form');
    }

    public function edit(Request $request): Response
    {
        return $this->html([
            'formValues' => $this->values($this->findRecord($request->get('id'))),
            'vozidla' => Vozidlo::getAll(orderBy: 'znacka, model'),
            'error' => null,
            'editing' => true
        ], 'form');
    }

    public function save(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }

        $postedId = $request->post('id');
        $editing = is_scalar($postedId) && trim((string) $postedId) !== '';
        $tankovanie = $editing ? $this->findRecord($postedId) : new Tankovanie();

        $values = ['id' => $tankovanie->id];
        foreach (['vozidlo_id', 'datum_tankovania', 'mnozstvo_l', 'cena_za_liter', 'stav_km', 'cerpacia_stanica'] as $field) {
            $value = $request->post($field);
            $values[$field] = is_scalar($value) ? trim((string) $value) : '';
        }

        $vozidloId = filter_var($values['vozidlo_id'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $km = filter_var($values['stav_km'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 9999999]]);
        $date = \DateTimeImmutable::createFromFormat('!Y-m-d', $values['datum_tankovania']);
        $validDate = $date !== false && $date->format('Y-m-d') === $values['datum_tankovania'];

        $litersText = str_replace(',', '.', $values['mnozstvo_l']);
        $priceText = str_replace(',', '.', $values['cena_za_liter']);
        $validLiters = preg_match('/^\d{1,4}(?:\.\d{1,2})?$/', $litersText) === 1
            && (float) $litersText > 0;
        $validPrice = preg_match('/^\d{1,2}(?:\.\d{1,3})?$/', $priceText) === 1
            && (float) $priceText > 0;

        $error = null;
        if ($vozidloId === false || Vozidlo::getOne($vozidloId) === null) {
            $error = 'Vyberte existujúce vozidlo.';
        } elseif (!$validDate || $km === false || !$validLiters || !$validPrice) {
            $error = 'Skontrolujte dátum, litre, cenu za liter a stav kilometrov.';
        } elseif (strlen($values['cerpacia_stanica']) > 120) {
            $error = 'Názov čerpacej stanice je príliš dlhý.';
        }

        if ($error !== null) {
            return $this->html([
                'formValues' => $values,
                'vozidla' => Vozidlo::getAll(orderBy: 'znacka, model'),
                'error' => $error,
                'editing' => $editing
            ], 'form');
        }

        $tankovanie->vozidlo_id = $vozidloId;
        $tankovanie->datum_tankovania = $values['datum_tankovania'];
        $tankovanie->mnozstvo_l = number_format((float) $litersText, 2, '.', '');
        $tankovanie->cena_za_liter = number_format((float) $priceText, 3, '.', '');
        $tankovanie->stav_km = $km;
        $tankovanie->cerpacia_stanica = $values['cerpacia_stanica'] !== '' ? $values['cerpacia_stanica'] : null;
        $tankovanie->save();

        return $this->redirect($this->url('tankovanie.index'));
    }

    public function delete(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }
        $this->findRecord($request->post('id'))->delete();
        return $this->redirect($this->url('tankovanie.index'));
    }

    private function findRecord(mixed $id): Tankovanie
    {
        $identifier = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($identifier === false) {
            throw new HttpException(404);
        }
        $tankovanie = Tankovanie::getOne($identifier);
        if ($tankovanie === null) {
            throw new HttpException(404);
        }
        return $tankovanie;
    }

    private function findVehicle(mixed $id): Vozidlo
    {
        $identifier = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($identifier === false) {
            throw new HttpException(404);
        }
        $vozidlo = Vozidlo::getOne($identifier);
        if ($vozidlo === null) {
            throw new HttpException(404);
        }
        return $vozidlo;
    }

    private function values(Tankovanie $tankovanie): array
    {
        return [
            'id' => $tankovanie->id,
            'vozidlo_id' => $tankovanie->vozidlo_id,
            'datum_tankovania' => $tankovanie->datum_tankovania,
            'mnozstvo_l' => $tankovanie->mnozstvo_l,
            'cena_za_liter' => $tankovanie->cena_za_liter,
            'stav_km' => $tankovanie->stav_km,
            'cerpacia_stanica' => $tankovanie->cerpacia_stanica ?? ''
        ];
    }
}
