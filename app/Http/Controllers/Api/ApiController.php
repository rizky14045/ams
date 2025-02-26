<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Closure;
use JWTAuth;

class ApiController extends Controller
{

    public function loggedUser()
    {
        $token = JWTAuth::parseToken();
        return $token ? $token->toUser() : null;
    }

    public function getUserNik()
    {
        $user = $this->loggedUser();
        return $user && $user->karyawan ? $user->karyawan->nik : null;
    }

    public function apiSuccess(array $data = null, array $payload = [])
    {
        $result = array_merge($payload, [
            'status' => 'success',
            'data' => $data
        ]);

        return response()->json($result);
    }

    public function apiError($errorMessage, $status = 500, array $payload = [])
    {
        $result = array_merge($payload, [
            'status' => 'error',
            'error' => $errorMessage
        ]);

        return response()->json($result, $status);
    }

    public function listOf(Builder $query, Request $req, array $options = [])
    {
        $options = array_merge([
            'max_limit' => null,
            'selectables' => null,
            'filter' => null,
            'map' => null,
        ], $options);

        $fields = $req->get('fields');
        $fields = $fields ? array_map(function($str) { return trim($str); }, explode(',', $fields)) : null;

        $limit = (int) $req->get('limit');
        $offset = (int) $req->get('offset');
        $keyword = $req->get('q');

        if ($options['max_limit'] AND (!$limit OR $limit > $options['max_limit'])) {
            $limit = $options['max_limit'];
        }

        if ($fields AND $options['selectables']) {
            $selects = array_intersect($fields, $options['selectables']);
            $query->select($selects);
        }

        if ($keyword AND $options['filter'] instanceof Closure) {
            $options['filter']($query, $keyword);
        }

        $countRecords = $query->count();
        if ($offset) $query->skip($offset);
        if ($limit) $query->take($limit);
        $records = $query->get();

        if ($options['map'] AND $options['map'] instanceof Closure) {
            $records = $records->map(function($model, $i) use ($options, $fields) {
                $data = $options['map']($model, $i);
                if (is_object($data)) {
                    $data = $data->toArray();
                }
                return $fields ? array_only($data, $fields) : $data;
            });
        } elseif($fields) {
            $records = $records->map(function($model, $i) use ($options, $fields) {
                $data = $model->toArray();
                return array_only($data, $fields);
            });
        } else {
            $records = $records->toArray();
        }

        return $this->apiSuccess(is_object($records) ? $records->toArray() : $records, [
            'meta' => [
                'q' => $keyword,
                'limit' => $limit,
                'offset' => $offset,
                'count_records' => $countRecords,
                'fields' => $fields
            ]
        ]);
    }

    public function detailOf(Builder $query, Request $req, array $options = [])
    {
        $options = array_merge([
            'selectables' => null,
            'resolve' => null,
        ], $options);

        $fields = $req->get('fields');
        $fields = $fields ? array_map(function($str) { return trim($str); }, explode(',', $fields)) : null;
        if ($fields AND $options['selectables']) {
            $selects = array_intersect($fields, $options['selectables']);
            $query->select($selects);
        }

        $model = $query->first();

        if ($options['resolve'] AND $options['resolve'] instanceof Closure) {
            $model = $options['resolve']($model);
        }

        $data = is_object($model) ? $model->toArray() : $model;

        if ($fields) {
            $data = array_only($data, $fields);
        }

        return $this->apiSuccess($data);
    }

}
