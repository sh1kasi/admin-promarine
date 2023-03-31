<?php

namespace App\Http\Controllers;

use PDF;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use Grei\TanggalMerah;
use App\Models\Employee;
use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\Employee_overtime;
use Illuminate\Support\Facades\DB;
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
            if ($row->call_name != null) {
                return $row->call_name;
            } else {
                return ucfirst($row->users->name);
            }
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
        $employee->call_name = $request->call_name;
        $employee->role = $request->role;
        $employee->salary_method = $request->salary_method;
        $employee->daily_salary = str_replace(".","",$request->daily_salary);
        $employee->save();

        return back()->with('success', 'Berhasil Menambahkan pegawai!');
    }

    public function edit($id, Request $request)
    {
        $employee = Employee::find($id);
        // dd($employee);

        return response()->json([
            'employee' => $employee,
        ]);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        // dd($ca);
        
        $this->validate($request, [
            // 'user_id' => 'required',
            'role' => 'required',
            'salary_method' => 'required',
            'daily_salary' => 'required',
        ],
        [
            // 'user_id.required' => 'Wajib mengisi akun pegawai!',
            'role.required' => 'Wajib mengisi role pegawai!',
            'salary_method.required' => 'Wajib mengisi metode gajian!',
            'daily_salary.required' => 'Wajib mengisi nominal gaji pegawai!',
        ]);

        // $employee->user_id = $request->user_id;
        $employee->call_name = $request->call_name;
        $employee->role = $request->role;
        $employee->salary_method = $request->salary_method;
        $employee->daily_salary = str_replace(".","",$request->daily_salary);
        // dd($employee);
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
    
    public function data_detail_harian(Request $request, $id)
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
                    $presence = Presence::where('employee_id', $id)->where('date', $request->from_date)->orderBy('date', 'ASC')->get();
                } else {
                    $presence = Presence::where('employee_id', $id)->where('date', '>=', $request->from_date)
                                                              ->orderBy('date', 'ASC')
                                                              ->where('date', '<=', $request->to_date)->get();
                }
            } else {
                $presence = Presence::where('employee_id', $id)->orderBy('date', 'ASC')->get();
            }
        }       

        // dd($presence);

        // $presence = Presence::where('employee_id', $id)->get();
        $employee = Employee::find($id);
        $lookup = [0, 50000, 75000, ($employee->daily_salary / 25) * 3];
        $traveling = 0;
        $minggu = 0;


        return DataTables($presence)
        ->addColumn('date', function ($row) {
            $date = Carbon::parse($row->date);
            return $date->translatedFormat('l, j F Y');
        })
        ->addColumn('area', function ($row) {
            if ($row->area == 1) {
                return "Area Gerbang Kertasusila";
            } elseif ($row->area == 2) {
                return "Area Pulau Jawa selain Gerbang Kertasusila";
            } elseif ($row->area == 3) {
                return "Area Luar Pulau Jawa selain Bangkalan";
            } elseif ($row->area == 4) {
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
        ->addColumn('total_salary', function($row) use($employee, $lookup, $traveling, $minggu) {
            // $employee
            $employee_overtime = Employee_overtime::where('date', $row->date)->where('employee_id', $row->employee_id)->first();
            $day = Carbon::parse($row->date)->format("D");

            if ($day === "Sun") {
                $minggu += ($employee->daily_salary / 25) * 2;
            }

            $traveling += $lookup[$row->area - 1];
            $total_salary = $traveling + $employee_overtime?->salary + $minggu;

            if ($employee->salary_method === "Harian") {
                return $row->salary + $employee_overtime?->salary;
            } else {
                return $total_salary;
            }
            

        })
        ->addIndexColumn()
        ->make(true);
    }

    public function data_detail_bulanan(Request $request, $id)
    {
        function rupe($angka)
        {
            $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
            return $hasil_rupiah;
        }

        $presence = Presence::where('employee_id', $id)->orderBy('date', 'ASC')->get();
        $employee_overtime = Employee_overtime::where('employee_id', $id)->orderBy('date', 'ASC')->get();

        $data = DB::table('employees')
                ->join('presences', 'employees.id', '=', 'presences.employee_id')
                ->join('employee_overtime', 'employees.id', '=', 'employee_overtime.employee_id')
                ->select('employees.daily_salary', 'presences.date AS presence_date', 'presences.area', 'employee_overtime.date AS overtime_date',
                         'employee_overtime.hour', 'employee_overtime.salary')
                ->where('employees.id', $id)
                ->get();

        dd($data);

        return Datatables($data)
        ->addColumn('date', function ($row) {
            if (isset($row->presence_date)) {
                return $row->presence_date;
            } else {
                $row->overtime_date;
            }
        })
        ->addColumn('area', function($row) {
                if ($row->area == 1) {
                    return "Area Gerbang Kertasusila";
                } elseif ($row->area == 2) {
                    return "Area Pulau Jawa selain Gerbang Kertasusila";
                } elseif ($row->area == 3) {
                    return "Area Luar Pulau Jawa selain Bangkalan";
                } elseif ($row->area == 4) {
                    return "Offshore / Anchorage";
                } else {
                    return '-';
                }

        })
        ->addColumn('overtime', function($row) {



            return $row->hour;

        })
        ->escapeColumns([])
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
                $presence_traveling = Presence::where('employee_id', $id)->where('area', '!=', '1')
                                                ->where('date', $request->from_date)->get();

            } else {
                $presence = Presence::where('employee_id', $id)->where('date', '>=', $request->from_date)
                                                          ->where('date', '<=', $request->to_date)->get();
                 $presence_traveling = Presence::where('employee_id', $id)->where('area', '!=', '1')
                 ->where('date', '>=', $request->from_date)
                 ->where('date', '<=', $request->to_date)->get();

            }
        } else {
            $presence = Presence::where('employee_id', $id)->get();
            $presence_traveling = Presence::where('employee_id', $id)->where('area', '!=', '1')->get();
        }

        $presences = [];
        $lookup = [0, 50000, 75000, ($employee->daily_salary / 25) * 3];
        $totalTravel = 0;
        $minggu = 0;
        foreach ($presence as $absen) {

            // $d2 = date('D', strtotime($absen['date']));
            // if ($d2 === "Sun") {
            //     print_r($d2);
            // }

            if ($absen->area == 1) {
                $area = "Area Gerbang Kertasusila";
            } elseif ($absen->area == 2) {
                $area = "Area Pulau Jawa selain Gerbang Kertasusila";
            } elseif ($absen->area == 3) {
                $area = "Area Luar Pulau Jawa selain Bangkalan";
            } elseif ($absen->area == 4) {
                $area = "Offshore / Anchorage";
            }

            $totalTravel += $lookup[$absen->area - 1];
            $satuanTravel = $lookup[$absen->area - 1];

            $day = Carbon::parse($absen->date)->format("D");
            if ($day === "Sun") {
                $minggu += ($employee->daily_salary / 25) * 2;
            }

            $employee_overtime = Employee_overtime::where('date', $absen->date)->where('employee_id', $absen->employee_id)->first();
            
            
            $push['date'] = Carbon::parse($absen->date)->translatedFormat('l, j F Y');
            $push['day'] = $day;
            $push['area'] = $area;
            $push['overtime'] = is_null($employee_overtime) ? "-" : $employee_overtime->overtimes->name . ' (' . $employee_overtime->hour . ' Jam - ' . rupiah($employee_overtime->salary)  . ')';
            $push['ot_salary'] = $employee_overtime?->salary;
            $push['total_traveling'] = $totalTravel;
            if ($employee->salary_method === "Harian") {
                $push['total_salary'] = $absen->salary + $employee_overtime?->salary;
            } else {
                $push['total_salary'] = $employee_overtime?->salary + $satuanTravel;
            }
            array_push($presences, $push);
        }

        $total_minggu = 0;
        if (in_array("Sun", array_column($presences, 'day'))) {
            $total_minggu += array_count_values(array_column($presences, 'day'))['Sun'];
        }
        


        
        $tanggal_terlama = $presence->first()->date;
        $tanggal_terbaru = $presence->last()->date;
        // dd($tanggal_terbaru);

        view()->share([
            'from' => $from,
            'to' => $to,
            'presence' => $presence,
            'presences' => $presences,
            'employee' => $employee,
            'tanggal_terlama' => $tanggal_terlama,
            'tanggal_terbaru' => $tanggal_terbaru,
            'total_traveling' => $totalTravel,
            'total_minggu' => $total_minggu,
        ]);

        $pdf = PDF::loadview('admin.employeeDetailExportPDF');
        return $pdf->stream('Detail Gaji '. ucfirst($employee->users->name) . '.pdf');
    }

}
