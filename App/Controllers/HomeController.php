<?php

namespace App\Controllers;

use App\Models\ServisnyZaznam;
use App\Models\Tankovanie;
use App\Models\Vozidlo;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

// AI-assisted extension of the existing HomeController: ChatGPT, VAII assignment 6.
class HomeController extends BaseController
{
    public function index(Request $request): Response
    {
        return $this->html([
            'vozidla' => Vozidlo::getAll(orderBy: 'id DESC'),
            'servisneZaznamy' => ServisnyZaznam::getAll(orderBy: 'datum_servisu DESC, id DESC'),
            'tankovania' => Tankovanie::getAll(orderBy: 'datum_tankovania DESC, id DESC')
        ]);
    }

    public function detail(Request $request): Response
    {
        $id = filter_var($request->get('id'), FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1]
        ]);
        if ($id === false) {
            return $this->redirect($this->url('vozidlo.index'));
        }

        $vozidlo = Vozidlo::getOne($id);
        if ($vozidlo === null) {
            throw new HttpException(404);
        }

        return $this->html([
            'vozidlo' => $vozidlo,
            'servisneZaznamy' => ServisnyZaznam::getAll(
                'vozidlo_id = ?', [$vozidlo->id], 'datum_servisu DESC, id DESC'
            ),
            'tankovania' => Tankovanie::getAll(
                'vozidlo_id = ?', [$vozidlo->id], 'datum_tankovania DESC, id DESC'
            )
        ]);
    }
}
