<?php

namespace App\Controllers;

use App\Models\ServisnyZaznam;
use App\Models\Vozidlo;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

// AI-assisted implementation: ChatGPT, VAII assignment 7.
class ServisController extends BaseController
{
    public function index(Request $request): Response
    {
        $vozidloId = null;
        if ($request->get('vozidlo_id') !== null && $request->get('vozidlo_id') !== '') {
            $vozidloId = $this->findVehicle($request->get('vozidlo_id'))->id;
        }

        return $this->html([
            'zaznamy' => $vozidloId === null
                ? ServisnyZaznam::getAll(orderBy: 'datum_servisu DESC, id DESC')
                : ServisnyZaznam::getAll('vozidlo_id = ?', [$vozidloId], 'datum_servisu DESC, id DESC'),
            'vozidla' => Vozidlo::getAll(orderBy: 'znacka, model'),
            'vybraneVozidloId' => $vozidloId
        ]);
    }

    public function create(Request $request): Response
    {
        $vozidla = Vozidlo::getAll(orderBy: 'znacka, model');
        $zaznam = new ServisnyZaznam();
        if ($request->get('vozidlo_id') !== null) {
            $zaznam->vozidlo_id = $this->findVehicle($request->get('vozidlo_id'))->id;
        } elseif ($vozidla) {
            $zaznam->vozidlo_id = $vozidla[0]->id;
        }
        $zaznam->datum_servisu = date('Y-m-d');

        return $this->html([
            'formValues' => $this->values($zaznam),
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
        $zaznam = $editing ? $this->findRecord($postedId) : new ServisnyZaznam();

        $values = ['id' => $zaznam->id];
        foreach (['vozidlo_id', 'nazov_ukonu', 'datum_servisu', 'stav_km', 'cena', 'nazov_servisu', 'popis'] as $field) {
            $value = $request->post($field);
            $values[$field] = is_scalar($value) ? trim((string) $value) : '';
        }

        $vozidloId = filter_var($values['vozidlo_id'], FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1]
        ]);
        $km = filter_var($values['stav_km'], FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 0, 'max_range' => 9999999]
        ]);
        $date = \DateTimeImmutable::createFromFormat('!Y-m-d', $values['datum_servisu']);
        $validDate = $date !== false && $date->format('Y-m-d') === $values['datum_servisu'];
        $validPrice = preg_match('/^\d{1,8}(?:\.\d{1,2})?$/', $values['cena']) === 1;

        $error = null;
        if ($vozidloId === false || Vozidlo::getOne($vozidloId) === null) {
            $error = 'Vyberte existujuce vozidlo.';
        } elseif ($values['nazov_ukonu'] === '' || strlen($values['nazov_ukonu']) > 120) {
            $error = 'Vyplnte nazov servisneho ukonu (max. 120 znakov).';
        } elseif (!$validDate || $km === false || !$validPrice) {
            $error = 'Skontrolujte datum, pocet kilometrov a cenu.';
        } elseif (strlen($values['nazov_servisu']) > 150 || strlen($values['popis']) > 500) {
            $error = 'Nazov servisu alebo popis je prilis dlhy.';
        }

        if ($error !== null) {
            return $this->html([
                'formValues' => $values,
                'vozidla' => Vozidlo::getAll(orderBy: 'znacka, model'),
                'error' => $error,
                'editing' => $editing
            ], 'form');
        }

        $zaznam->vozidlo_id = $vozidloId;
        $zaznam->nazov_ukonu = $values['nazov_ukonu'];
        $zaznam->datum_servisu = $values['datum_servisu'];
        $zaznam->stav_km = $km;
        $zaznam->cena = number_format((float) $values['cena'], 2, '.', '');
        $zaznam->nazov_servisu = $values['nazov_servisu'] !== '' ? $values['nazov_servisu'] : null;
        $zaznam->popis = $values['popis'] !== '' ? $values['popis'] : null;
        $zaznam->save();

        return $this->redirect($this->url('servis.index'));
    }

    public function delete(Request $request): Response
    {
        if (!$request->isPost()) {
            throw new HttpException(405);
        }

        $this->findRecord($request->post('id'))->delete();
        return $this->redirect($this->url('servis.index'));
    }

    private function findRecord(mixed $id): ServisnyZaznam
    {
        $identifier = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($identifier === false) {
            throw new HttpException(404);
        }
        $zaznam = ServisnyZaznam::getOne($identifier);
        if ($zaznam === null) {
            throw new HttpException(404);
        }
        return $zaznam;
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

    private function values(ServisnyZaznam $zaznam): array
    {
        return [
            'id' => $zaznam->id,
            'vozidlo_id' => $zaznam->vozidlo_id,
            'nazov_ukonu' => $zaznam->nazov_ukonu,
            'datum_servisu' => $zaznam->datum_servisu,
            'stav_km' => $zaznam->stav_km,
            'cena' => $zaznam->cena,
            'nazov_servisu' => $zaznam->nazov_servisu ?? '',
            'popis' => $zaznam->popis ?? ''
        ];
    }
}
