<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Traits\GetMasterOptions;
use Illuminate\Http\Request;

class JenisPemeliharaanController extends ApiController
{

    use GetMasterOptions;

    public function extracomptable(Request $request)
    {
        $listJenis = $this->getOptionsJenisPemeliharaanExtracomptable();

        return $this->apiSuccess($listJenis);
    }

    public function aktivaTetap(Request $request)
    {
        $listJenis = $this->getOptionsJenisPemeliharaanAktivaTetap();

        return $this->apiSuccess($listJenis);
    }

}
