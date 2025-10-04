<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use App\Models\AttendanceHistoryModel;
use App\Models\EmployeeModel;
use App\Models\DepartementModel;

class AttendanceHistory extends BaseApiController
{
    use ResponseTrait;

    protected $modelName = AttendanceHistoryModel::class;
    protected $format = 'json';

    public function index()
    {
        $employeeModel = new EmployeeModel();

        $employees = $employeeModel
            ->select('employee.employee_id, employee.name, employee.departement_id, departement.departement_name')
            ->join('departement', 'departement.id = employee.departement_id', 'left')
            ->orderBy('employee.name', 'ASC')
            ->findAll();

        return $this->respond([
            'employees' => $employees,
        ]);
    }

    public function show($employeeId = null)
    {
        if ($employeeId === null) {
            return $this->fail('Employee ID required', 400);
        }
    
        $date = $this->request->getGet('date');
    
        $builder = $this->model
            ->select('attendance_history.*, employee.name as employee_name, departement.departement_name, departement.max_clock_in_time, departement.max_clock_out_time')
            ->join('employee', 'employee.employee_id = attendance_history.employee_id', 'left')
            ->join('departement', 'departement.id = employee.departement_id', 'left')
            ->where('attendance_history.employee_id', $employeeId);
    
        if ($date) {
            $builder->where('DATE(attendance_history.date_attendance)', $date);
        }
    
        $history = $builder->findAll();
    
        foreach ($history as &$h) {
            $attendanceTime = date('H:i:s', strtotime($h['date_attendance']));
            $status = '-';
    
            if ($h['attendance_type'] == 1) {
                $status = ($attendanceTime <= $h['max_clock_in_time']) ? 'Tepat Waktu' : 'Terlambat';
            } elseif ($h['attendance_type'] == 2) {
                $status = ($attendanceTime >= $h['max_clock_out_time']) ? 'Pulang Tepat' : 'Pulang Terlambat';
            }
    
            $h['status'] = $status;
        }
    
        return $this->respond([
            'employee_id' => $employeeId,
            'attendance_history' => $history
        ]);
    }
    
}
