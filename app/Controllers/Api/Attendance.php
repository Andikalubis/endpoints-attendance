<?php

namespace App\Controllers\Api;

use App\Models\AttendanceModel;
use App\Models\AttendanceHistoryModel;
use App\Models\EmployeeModel;
use App\Models\DepartementModel;

class Attendance extends BaseApiController
{
    protected $attendanceModel;
    protected $historyModel;
    protected $employeeModel;
    protected $departementModel;

    public function __construct()
    {
        $this->attendanceModel = new AttendanceModel();
        $this->historyModel = new AttendanceHistoryModel();
        $this->employeeModel = new EmployeeModel();
        $this->departementModel = new DepartementModel();
    }

    public function checkin()
    {
        $json = $this->request->getJSON(true);
    
        if (empty($json['employee_id'])) return $this->error('employee_id required');
    
        $employee = $this->employeeModel->where('employee_id', $json['employee_id'])->first();
        if (!$employee) return $this->error('Employee not found');
    
        $today = date('Y-m-d');
    
        $attendance = $this->attendanceModel
            ->where('employee_id', $json['employee_id'])
            ->where('DATE(clock_in)', $today)
            ->first();
    
        if ($attendance) return $this->error('Already checked in today', 400);
    
        $attendanceId = uniqid('ATT_');
        $clockIn = $json['clock_in'] ?? date('Y-m-d H:i:s');
    
        $inserted = $this->attendanceModel->insert([
            'employee_id' => $json['employee_id'],
            'attendance_id' => $attendanceId,
            'clock_in' => $clockIn
        ]);
    
        if (!$inserted) return $this->error('Failed to insert attendance', 500);
    
        $historyInserted = $this->historyModel->insert([
            'employee_id' => $json['employee_id'],
            'attendance_id' => $attendanceId,
            'date_attendance' => $clockIn,
            'attendance_type' => 1,
            'description' => $json['note'] ?? null
        ]);
    
        if (!$historyInserted) return $this->error('Failed to insert attendance history', 500);
    
        return $this->success([
            'employee_id' => $json['employee_id'],
            'attendance_id' => $attendanceId,
            'clock_in' => $clockIn
        ], 'Check-in recorded', 201);
    }    
    
    public function checkout()
    {
        $json = $this->request->getJSON(true);
    
        if (empty($json['employee_id'])) return $this->error('employee_id required');
    
        $today = date('Y-m-d');
        $attendance = $this->attendanceModel
            ->where('employee_id', $json['employee_id'])
            ->where('DATE(clock_in)', $today)
            ->orderBy('id', 'DESC')
            ->first();
    
        if (!$attendance) return $this->error('No check-in record found today', 404);
        if (!empty($attendance['clock_out'])) return $this->error('Already checked out today', 400);
    
        $clockOut = $json['clock_out'] ?? date('Y-m-d H:i:s');
    
        $this->attendanceModel->update($attendance['id'], [
            'clock_out' => $clockOut
        ]);
    
        // Insert ke history
        $this->historyModel->insert([
            'employee_id' => $json['employee_id'],
            'attendance_id' => $attendance['attendance_id'],
            'date_attendance' => $clockOut,
            'attendance_type' => 2,
            'description' => $json['note'] ?? null
        ]);
    
        return $this->success([], 'Check-out recorded', 200);
    }
    
}
