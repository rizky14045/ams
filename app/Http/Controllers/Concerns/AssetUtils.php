<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

trait AssetUtils
{

    public function getHistories(Request $req, $id)
    {
        $asset = $this->findAssetOrFail($id);
        $logs = $asset->getResolvedLogs([
            'limit' => $req->get('limit'),
            'offset' => $req->get('offset') ?: 0,
            'type' => $req->get('type')
        ]);

        return [
            'status' => 'success',
            'meta' => array_merge($logs->options, ['total' => $logs->total]),
            'data' => $logs->items,
        ];
    }

    protected function getModelClass()
    {
        return $this->model ?: abort(500, "Controller '".__CLASS__."' must have 'protected model' property that refer to it's asset model class name.");
    }

    protected function getModel()
    {
        $class = $this->getModelClass();
        return app($class);
    }

    protected function findAsset($id)
    {
        return $this->getModel()->find($id);
    }

    protected function findAssetOrFail($id)
    {
        return $this->getModel()->findOrFail($id);
    }

}
