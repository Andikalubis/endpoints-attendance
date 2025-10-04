<?php

namespace App\Controllers\Api;

use App\Models\EmployeeModel;

class Employee extends BaseApiController
{
    protected $model;

    public function __construct()
    {
        $this->model = new EmployeeModel();
    }

    public function index()
    {
        return $this->success($this->model->select('employee.*, departement.departement_name')
            ->join('departement', 'departement.id = employee.departement_id', 'left')
            ->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        return $data ? $this->success($data) : $this->error('Employee not found', 404);
    }

    public function create()
    {
        $json = $this->request->getJSON(true);

        if (empty($json['employee_id']) || empty($json['name']))
            return $this->error('employee_id and name required');

        $this->model->insert($json);
        return $this->success($json, 'Employee created', 201);
    }

    public function update($id = null)
    {
        $json = $this->request->getJSON(true);
        if (!$this->model->find($id))
            return $this->error('Employee not found', 404);

        $this->model->update($id, $json);
        return $this->success($json, 'Employee updated');
    }

    public function delete($id = null)
    {
        if (!$this->model->find($id))
            return $this->error('Employee not found', 404);

        $this->model->delete($id);
        return $this->success([], 'Employee deleted');
    }
}
