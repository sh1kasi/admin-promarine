<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use App\Models\User;
use Grei\TanggalMerah;
use App\Models\Employee;
use App\Models\Presence;
use PDF;
use Illuminate\Http\Request;
use App\Models\Employee_overtime;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


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
            return '<a class="btn btn-primary" type="button" href="/pegawai/detail/'.$row->id.'" id="employeeDetail"><i class="fa fa-xl fa-circle-info"></i></a>
                    <button class="btn-warning btn" type="button" data-bs-toggle="modal" data-bs-target="#employeeEdit" onclick="employeeEdit('.$row->id.')" id="employeeEdit"><i class="fas fa-edit"></i></button>
                    <a class="btn-danger btn delete_employee" href="#" type="button"  data-name="'.ucfirst($row->users->name).'" id="delete" data-id="' . $row->id . '" onclick="deleteEmployee(' . $row->id . ')"><i class="fas fa-trash"></i></a>';
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

    public function delete($id)
    {
        // dd($id);
        $employee = Employee::find($id);
        
        $employee->delete();
        return back()->with('success', 'Berhasil Mengedit Pegawai!');   

    }

    public function employee_detail($id)
    {
        $employee = Employee::find($id);

        return view('admin.employeeDetailIndex', compact('employee', 'id'));
    }
    
    public function data_detail(Request $request, $id)
    {
        // $id = $id;
        function rp($angka)
        {
            $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
            return $hasil_rupiah;
        }

        // dd($request);

        if ($request->ajax()) {
            if (!empty($request->from_date)) {
                if ($request->from_date === $request->to_date) {
                    $presence = Presence::where('employee_id', $id)->where('date', $request->from_date)->get();
                } else {
                    $presence = Presence::where('employee_id', $id)->where('date', '>=', $request->from_date)
                                                              ->where('date', '<=', $request->to_date)->get();
                }
            } else {
                $presence = Presence::where('employee_id', $id)->get();
            }
        }       

        // dd($presence);

        // $presence = Presence::where('employee_id', $id)->get();
        $employee = Employee::find($id);
        return DataTables($presence)
        ->addColumn('area', function ($row) {
            if ($row->status == 1) {
                return "Area Gerbang Kertasusila";
            } elseif ($row->status == 2) {
                return "Area Pulau Jawa selain Gerbang Kertasusila";
            } elseif ($row->status == 3) {
                return "Area Luar Pulau Jawa selain Bangkalan";
            } elseif ($row->status == 4) {
                return "Offshore / Anchorage";
            }
        }) 
        ->addColumn('overtime', function($row) {
            $employee_overtime = Employee_overtime::where('date', $row->date)->where('employee_id', $row->employee_id)->first();
            // dd($employee_overtime);
            if (is_null($employee_overtime)) {
                return "-";
            } else {
                return $employee_overtime->overtimes->name . ' (' . $employee_overtime->hour . ' Jam - ' . rp($employee_overtime->salary)  . ')';
            }
        }) 
        ->addColumn('total_salary', function($row) {
            // $employee
            $employee_overtime = Employee_overtime::where('date', $row->date)->where('employee_id', $row->employee_id)->first();
            return $row->salary + $employee_overtime?->salary;
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function employee_detail_pdf(Request $request)
    {

        function rupiah($angka)
        {
            $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
            return $hasil_rupiah;
        }

        $id = $request->employee_id;
        $from = $request->from_date;
        $to = $request->to_date;

        $employee = Employee::find($id);

        if (!empty($request->from_date)) {
            if ($request->from_date === $request->to_date) {
                $presence = Presence::where('employee_id', $id)->where('date', $request->from_date)->get();
            } else {
                $presence = Presence::where('employee_id', $id)->where('date', '>=', $request->from_date)
                                                          ->where('date', '<=', $request->to_date)->get();
            }
        } else {
            $presence = Presence::where('employee_id', $id)->get();
        }

        $presences = [];
        foreach ($presence as $absen) {

            if ($absen->status == 1) {
                $area = "Area Gerbang Kertasusila";
            } elseif ($absen->status == 2) {
                $area = "Area Pulau Jawa selain Gerbang Kertasusila";
            } elseif ($absen->status == 3) {
                $area = "Area Luar Pulau Jawa selain Bangkalan";
            } elseif ($absen->status == 4) {
                $area = "Offshore / Anchorage";
            }

            $employee_overtime = Employee_overtime::where('date', $absen->date)->where('employee_id', $absen->employee_id)->first();


            $push['date'] = $absen->date;
            $push['area'] = $area;
            $push['overtime'] = is_null($employee_overtime) ? "-" : $employee_overtime->overtimes->name . ' (' . $employee_overtime->hour . ' Jam - ' . rupiah($employee_overtime->salary)  . ')';
            $push['total_salary'] = $absen->salary + $employee_overtime?->salary;
            array_push($presences, $push);
        }
        
        $tanggal_terlama = $presence->first()->created_at->format('Y-m-d');
        $tanggal_terbaru = $presence->last()->created_at->format('Y-m-d');

        view()->share([
            'from' => $from,
            'to' => $to,
            'presence' => $presence,
            'presences' => $presences,
            'employee' => $employee,
            'tanggal_terlama' => $tanggal_terlama,
            'tanggal_terbaru' => $tanggal_terbaru,
        ]);

        $pdf = PDF::loadview('admin.employeeDetailExportPDF');
        return $pdf->download('Detail Gaji '. ucfirst($employee->users->name) . '.pdf');
    }

}
