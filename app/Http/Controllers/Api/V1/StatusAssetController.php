<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class StatusAssetController extends ApiController
{

    public function extracomptable(Request $request)
    {
        return $this->apiSuccess(config('asset.status_extracomptable'));
    }

    public function aktivaTetap(Request $request)
    {
        return $this->apiSuccess(config('asset.status_aktiva_tetap'));
    }

}
