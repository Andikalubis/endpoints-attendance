# Judul: Dokumentasi Backend Sistem Absensi Karyawan
# Teknologi: PHP (CodeIgniter 4), MySQL
# Tujuan: Menyediakan API untuk CRUD Karyawan, CRUD Departemen, Absen Masuk, Absen Keluar, dan List Log Absensi Karyawan.

# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library


Judul: Dokumentasi Backend Sistem Absensi Karyawan
Teknologi: PHP (CodeIgniter 4), MySQL
Tujuan: Menyediakan API untuk CRUD Karyawan, CRUD Departemen, Absen Masuk, Absen Keluar, dan List Log Absensi Karyawan.

1. Struktur Project

/app/Controllers/Api/AttendanceHistory.php → API History Absensi

/app/Controllers/Api/Attendance.php → API Absensi

/app/Controllers/Api/Employee.php → API CRUD Karyawan

/app/Controllers/Api/Departement.php → API CRUD Departemen

/app/Models/AttendanceHistoryModel.php

/app/Models/AttendanceModel.php

/app/Models/EmployeeModel.php

/app/Models/DepartementModel.php

2. Database

Tabel employee
| Field          | Type         | Keterangan                |
| -------------- | ------------ | ------------------------- |
| employee_id    | VARCHAR(20)  | Primary key               |
| name           | VARCHAR(100) | Nama karyawan             |
| departement_id | INT          | Foreign key ke departemen |
| address        | TEXT         | Alamat karyawan           |
| created_at     | DATETIME     | Timestamp dibuat          |
| updated_at     | DATETIME     | Timestamp diupdate        |

Tabel departement
| Field            | Type         | Keterangan         |
| ---------------- | ------------ | ------------------ |
| id               | INT          | Primary key        |
| departement_name | VARCHAR(100) | Nama departemen    |
| created_at       | DATETIME     | Timestamp dibuat   |
| updated_at       | DATETIME     | Timestamp diupdate |

Table attendance_history
| Field           | Type        | Keterangan              |
| --------------- | ----------- | ----------------------- |
| id              | INT         | Primary key             |
| employee_id     | VARCHAR(20) | Foreign key ke employee |
| attendance_id   | VARCHAR(50) | ID unik absensi         |
| clock_in        | TIMESTAMP   | Waktu Masuk             |
| clock_out       | TIMESTAMP   | Waktu Pulang            |
| created_at      | DATETIME    | Timestamp dibuat        |
| updated_at      | DATETIME    | Timestamp diupdate      |

Table attendance_history
| Field           | Type        | Keterangan              |
| --------------- | ----------- | ----------------------- |
| id              | INT         | Primary key             |
| employee_id     | VARCHAR(20) | Foreign key ke employee |
| attendance_id   | VARCHAR(50) | ID unik absensi         |
| date_attendance | DATETIME    | Waktu absensi           |
| attendance_type | TINYINT     | 1 = Masuk, 2 = Pulang   |
| description     | TEXT        | Keterangan absensi      |
| created_at      | DATETIME    | Timestamp dibuat        |
| updated_at      | DATETIME    | Timestamp diupdate      |

3. Endpoint API
| Method | Endpoint                               | Deskripsi                              | Parameter                       | Response Contoh               |
| ------ | -------------------------------------- | -------------------------------------- | ------------------------------- | ----------------------------- |
| GET    | `/api/employee`                        | List semua karyawan                    | -                               | JSON list employee            |
| POST   | `/api/employee`                        | Tambah karyawan baru                   | name, departement_id, address   | JSON employee baru            |
| PUT    | `/api/employee/{id}`                   | Update karyawan                        | name, departement_id, address   | JSON employee updated         |
| DELETE | `/api/employee/{id}`                   | Hapus karyawan                         | -                               | success/error                 |
| GET    | `/api/departement`                     | List departemen                        | -                               | JSON list departemen          |
| POST   | `/api/departement`                     | Tambah departemen                      | departement_name                | JSON departemen baru          |
| PUT    | `/api/departement/{id}`                | Update departemen                      | departement_name                | JSON departemen updated       |
| DELETE | `/api/departement/{id}`                | Hapus departemen                       | -                               | success/error                 |
| POST   | `/api/attendance-/check-in`            | Absensi masuk                          | employee_id, description        | JSON success/error            |
| PUT    | `/api/attendance-/check-out`           | Absensi pulang                         | employee_id, description        | JSON success/error            |
| GET    | `/api/attendance-history`              | List semua karyawan beserta departemen | date, departement_id (opsional) | JSON employees + departements |
| GET    | `/api/attendance-history/{employeeId}` | Detail log absensi per karyawan        | date (opsional)                 | JSON log absensi              |


4. Response Contoh

GET /api/attendance-history/EMP2025001

{
  "employee_id": "EMP2025001",
  "attendance_history": [
    {
      "id": 3,
      "employee_id": "EMP2025001",
      "attendance_id": "ATT_68e0e684767e7",
      "date_attendance": "2025-10-04 07:30:00",
      "attendance_type": 1,
      "description": "Mobile app",
      "employee_name": "Ananda",
      "departement_name": "IT 2025"
    }
  ]
}

