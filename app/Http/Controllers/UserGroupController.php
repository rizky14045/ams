<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use App\Models\Ruang;
use App\Models\UserGroup;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'User Group';
        $data['datagrid'] = $this->datagrid();
        return view('user-group.index', $data);
    }

    /**
     * Get json list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getJsonList()
    {
        return $this->datagrid()->getResults();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function formCreate()
    {
        $data['page_title'] = 'Tambah User Group';
        $data['list_gedung'] = Gedung::orderBy('nama', 'asc')->get();
        return view('user-group.form-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCreate(Request $request)
    {
        $userGroup = $this->saveUserGroup(new UserGroup, $request);
        $action = $request->get('action');
        $redirectRoute = ($action == 'save-and-new') ? 'user-group::form-create' : 'user-group::index';
        return redirect()->route($redirectRoute)->with('alert-success', 'User group '.$userGroup->name.' berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function formEdit($id)
    {
        $data['user_group'] = UserGroup::findOrfail($id);
        $data['page_title'] = 'Edit User Group';
        $data['list_gedung'] = Gedung::orderBy('nama', 'asc')->get();
        return view('user-group.form-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function postEdit(Request $request, $id)
    {
        $userGroup = UserGroup::findOrfail($id);
        $this->saveUserGroup($userGroup, $request);
        return redirect()->route('user-group::index')->with('alert-info', 'User group '.$userGroup->name.' berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deletes()
    {
        $ids = request('ids');

        if (is_array($ids) && count($ids)) {
            UserGroup::whereIn('id', $ids)->delete();
        }

        return ['status' => 'success'];
    }

    protected function saveUserGroup(UserGroup $userGroup, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'list_akses_ruang' => 'present|array',
        ]);

        $userGroup->name = $request->get('name');
        $userGroup->save();

        if (is_array($listAksesRuang = $request->get('list_akses_ruang'))) {
            $userGroup->setting('list_akses_ruang', $listAksesRuang);
        }

        return $userGroup;
    }

    protected function datagrid()
    {
        $query = UserGroup::query()->whereNull('deleted_at');
        return \Datagrid::make($query, [
            'id' => [
                'real_key' => 'id',
                'display' => false,
            ],
            'no' => [
                'real_key' => 'id',
                'label' => 'No.',
                'width' => 20,
                'th_class' => 'text-center',
                'td_class' => 'text-center',
                'format' => function($val, $row, $i, $res) {
                    return $res['from'] + $i;
                }
            ],
            'name' => [
                'real_key' => 'name',
                'label' => 'Nama Grup',
                'sortable' => true,
                'searchable' => true,
                'width' => 200,
            ],
            'settings' => [
                'label' => 'Akses Ruang',
                'sortable' => false,
                'searchable' => false,
                'width' => null,
                'format' => function($val, $row, $i, $res) {
                    $settings = json_decode($val, true) ?: [];
                    $listAksesRuang = isset($settings['list_akses_ruang']) ? $settings['list_akses_ruang'] : [];
                    if (!$listAksesRuang) {
                        return '';
                    } else {
                        return Ruang::whereIn('id', $listAksesRuang)->get()->map(function($ruang) {
                            return $ruang->nama_ruang;
                        })->implode(', ');
                    }
                }
            ],
            'aksi' => [
                'real_key' => 'id',
                'label' => 'Aksi',
                'width' => 120,
                'format' => function($val, $row, $i, $results) {
                    $urlEdit = route('user-group::form-edit', $val);
                    return "
                        <a class='btn btn-primary btn-xs btn-edit' href='{$urlEdit}'>Edit</a>
                        <a class='btn btn-danger btn-xs btn-delete'>Delete</a>
                    ";
                }
            ],
        ])
        ->withOptions([
            'per_page' => 15,
            'limit_options' => [15, 30, 50, 100],
            'checkables' => true,
            'primary_key' => 'id',
            'empty_message' => 'Data grup kosong',
            'fetch_url' => route('user-group::json-list')
        ]);
    }

}
