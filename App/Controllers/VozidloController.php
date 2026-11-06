<?php

namespace App\Controllers;

use App\Models\Vozidlo;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

// AI-assisted implementation: ChatGPT, VAII assignment 6.
class VozidloController extends BaseController
{
    public function index(Request $request): Response
    {
        return $this->html(['vozidla' => Vozidlo::getAll(orderBy: 'id DESC')]);
    }

    public function create(Request $request): Response
    {
        return $this->html([
            'formValues' => $this->values(new Vozidlo()),
            'error' => null,
            'editing' => false
        ], 'form');
    }

    public function edit(Request $request): Response
    {
        $vozidlo = $this->find($request->get('id'));

        return $this->html([
            'formValues' => $this->values($vozidlo),
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
        $vozidlo = $editing ? $this->find($postedId) : new Vozidlo();

        $fields = [
            'znacka', 'model', 'rok_vyroby', 'ecv', 'vin',
            'palivo', 'stav_km', 'stk_do', 'ek_do', 'servis_do'
        ];
        $values = ['id' => $vozidlo->id];
        foreach ($fields as $field) {
            $value = $request->post($field);
            $values[$field] = is_string($value) ? trim($value) : '';
        }

        $year = filter_var($values['rok_vyroby'], FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1900, 'max_range' => (int) date('Y') + 1]
        ]);
        $km = filter_var($values['stav_km'], FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 0, 'max_range' => 9999999]
        ]);

        $error = null;
        if ($values['znacka'] === '' || $values['model'] === '' || $values['ecv'] === '') {
            $error = 'Vyplnte znacku, model a evidencne cislo vozidla.';
        } elseif (strlen($values['znacka']) > 80 || strlen($values['model']) > 80
            || strlen($values['ecv']) > 16 || strlen($values['vin']) > 17) {
            $error = 'Niektore textove pole je prilis dlhe.';
        } elseif ($year === false || $km === false) {
            $error = 'Skontrolujte rok vyroby a stav kilometrov.';
        } elseif (!in_array($values['palivo'], ['Benzin', 'Diesel', 'Hybrid', 'Elektrina', 'LPG'], true)) {
            $error = 'Vyberte platny druh paliva.';
        }

        foreach (['stk_do', 'ek_do', 'servis_do'] as $field) {
            $value = $values[$field];
            if ($value === '') {
                continue;
            }
            $date = \DateTimeImmutable::createFromFormat('!Y-m-d', $value);
            if ($date === false || $date->format('Y-m-d') !== $value) {
                $error = 'Datum musi mat platny format.';
                break;
            }
        }

        if ($error !== null) {
            return $this->html(['formValues' => $values, 'error' => $error, 'editing' => $editing], 'form');
        }

        $vozidlo->znacka = $values['znacka'];
        $vozidlo->model = $values['model'];
        $vozidlo->rok_vyroby = $year;
        $vozidlo->ecv = $values['ecv'];
        $vozidlo->vin = $values['vin'] !== '' ? $values['vin'] : null;
        $vozidlo->palivo = $values['palivo'];
        $vozidlo->stav_km = $km;
        $vozidlo->stk_do = $values['stk_do'] !== '' ? $values['stk_do'] : null;
        $vozidlo->ek_do = $values['ek_do'] !== '' ? $values['ek_do'] : null;
        $vozidlo->servis_do = $values['servis_do'] !== '' ? $values['servis_do'] : null;
        $vozidlo->save();

        return $this->redirect($this->url('vozidlo.index'));
    }

    public function delete(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }

        $this->find($request->post('id'))->delete();
        return $this->redirect($this->url('vozidlo.index'));
    }

    private function find(mixed $id): Vozidlo
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

    private function values(Vozidlo $vozidlo): array
    {
        return [
            'id' => $vozidlo->id,
            'znacka' => $vozidlo->znacka,
            'model' => $vozidlo->model,
            'rok_vyroby' => $vozidlo->rok_vyroby,
            'ecv' => $vozidlo->ecv,
            'vin' => $vozidlo->vin ?? '',
            'palivo' => $vozidlo->palivo,
            'stav_km' => $vozidlo->stav_km,
            'stk_do' => $vozidlo->stk_do ?? '',
            'ek_do' => $vozidlo->ek_do ?? '',
            'servis_do' => $vozidlo->servis_do ?? ''
        ];
    }
}
