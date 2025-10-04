<?php

namespace App\Controllers\Api;

use App\Models\DepartementModel;

class Departement extends BaseApiController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DepartementModel();
    }

    public function index()
    {
        return $this->success($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        return $data ? $this->success($data) : $this->error('Departement not found', 404);
    }

    public function create()
    {
        $json = $this->request->getJSON(true);

        if (empty($json['departement_name']))
            return $this->error('departement_name required');

        $this->model->insert($json);
        return $this->success($json, 'Departement created', 201);
    }

    public function update($id = null)
    {
        $json = $this->request->getJSON(true);
        if (!$this->model->find($id))
            return $this->error('Departement not found', 404);

        $this->model->update($id, $json);
        return $this->success($json, 'Departement updated');
    }

    public function delete($id = null)
    {
        if (!$this->model->find($id))
            return $this->error('Departement not found', 404);

        $this->model->delete($id);
        return $this->success([], 'Departement deleted');
    }
}
