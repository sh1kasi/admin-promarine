<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Grei\TanggalMerah;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Validator;

class EmployeeController extends Controller
{
    // protected $data;

    public function index()
    {
        $user = User::where('role', 'user')->get();
        $request = request();

        // $employee = Employee::get();
        if ($request->ajax()) {
            $employee = Employee::find($request->id);
        } else {
            $employee = Employee::first();
        }

        // dd($employee);

        return view('admin.employeeIndex', compact('user', 'employee'));
    }

    public function data(Request $request, TanggalMerah $libur)
    {
        $employee = Employee::get();
        return DataTables($employee)
        ->addColumn('name', function ($row) {
            return ucfirst($row->users->name);
        })
        ->addColumn('action', function ($row) {
            return '<button class="text-primary btn-primary btn" type="button" data-bs-toggle="modal" data-bs-target="#employeeDetail" onclick="employeeDetail('.$row->id.')" id="employeeDetail">Detail</button>
                    <button class="btn-warning btn" type="button" data-bs-toggle="modal" data-bs-target="#employeeEdit" onclick="employeeEdit('.$row->id.')" id="employeeEdit">Edit</button>';
        })
        ->addIndexColumn()
        ->make(true); 

    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required|unique:employees',
            'role' => 'required',
            'salary_method' => 'required',
            'daily_salary' => 'required',
        ],
        [
            'user_id.required' => 'Wajib mengisi akun pegawai!',
            'user_id.unique' => 'Pegawai tersebut sudah ada!',
            'role.required' => 'Wajib mengisi role pegawai!',
            'salary_method.required' => 'Wajib mengisi metode gajian!',
            'daily_salary.required' => 'Wajib mengisi nominal gaji pegawai!',
        ]);


        $employee = new Employee;
        $employee->user_id = $request->user_id;
        $employee->role = $request->role;
        $employee->salary_method = $request->salary_method;
        $employee->daily_salary = str_replace(".","",$request->daily_salary);
        $employee->save();

        return back()->with('success', 'Berhasil Menambahkan pegawai!');
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        
        $this->validate($request, [
            'user_id' => 'required',
            'role' => 'required',
            'salary_method' => 'required',
            'daily_salary' => 'required',
        ],
        [
            'user_id.required' => 'Wajib mengisi akun pegawai!',
            'user_id.unique' => 'Pegawai tersebut sudah ada!',
            'role.required' => 'Wajib mengisi role pegawai!',
            'salary_method.required' => 'Wajib mengisi metode gajian!',
            'daily_salary.required' => 'Wajib mengisi nominal gaji pegawai!',
        ]);

        $employee->user_id = $request->user_id;
        $employee->role = $request->role;
        $employee->salary_method = $request->salary_method;
        $employee->daily_salary = str_replace(".","",$request->daily_salary);
        $employee->save();

        return back()->with('success', 'Berhasil Mengedit Pegawai!');
    }

}
