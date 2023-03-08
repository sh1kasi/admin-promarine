<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Overtime;
use App\Models\Presence;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Employee_overtime;
use Alkoumi\LaravelHijriDate\Hijri;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class OvertimeController extends Controller
{

    

    public function index()
    {

        if (auth()->user()->role === 'admin') {
            $employee = Employee::first();
        } else {
            $employee = Employee::where('user_id', auth()->user()->id)->first();     
        }

        if (request()->ajax()) {
            $overtime = Overtime::find(request()->id);
        } else {
            $overtime = Overtime::first();
        }

        return view('admin.overtimeIndex', compact('employee', 'overtime'));
    }

    public function data(Request $request)
    {
        
        function rupiah($angka)
        {
            $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
            return $hasil_rupiah;
        }

        $overtime = Overtime::get();
        return DataTables($overtime)
        ->addColumn('per_hour', function ($row) {
            return rupiah($row->per_hour);
        })
        ->addColumn('action', function ($row) {
            return '
                     <button class="btn-primary btn" type="button" data-bs-toggle="modal" data-bs-target="#overtimeEdit" onclick="overtimeEdit('.$row->id.')" id="overtimeEdit">Edit</button>
                     <a class="btn btn-danger" onclick="deleteOvertime('.$row->id.')" type="button" href="#">Delete</a>
                   ';
        })
        ->addIndexColumn()
        ->make(true);
    } 

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required | unique:overtimes',
            'perjam' => 'required | numeric',
        ]);

        $overtime = new Overtime;
        $overtime->name = $request->name;
        $overtime->per_hour = str_replace(".","",$request->perjam);
        $overtime->save();
        
        return redirect('/lemburan')->with('success', 'Berhasil menambahkan lemburan');
        
    }

    public function delete($id)
    {
        $overtime = Overtime::find($id);
        $overtime->delete();
        
        return back()->with('success', 'Berhasil Menghapus Lemburan');
    }

    public function presence_index()
    {
        $overtime = Overtime::get();
        $employee = Employee::where('user_id', auth()->user()->id)->first();
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('h:i');
        $now = Carbon::now();
        // dd($now->format("D"));
        
        return view('admin.presenceOvertimeIndex', compact('overtime', 'employee', 'currentDate', 'currentTime', 'now'));
    }

    public function presence_data(Request $request)
    {

        function rp($angka)
        {
            $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
            return $hasil_rupiah;
        }

        $employee = Employee::where('user_id', auth()->user()->id)->first();

        // if ($employee == null) {
        //     return redirect('/lemburan/absen')->with('kosong');
        // }
        
        return DataTables($employee->overtimes)
        ->addColumn('tanggal', function($row) {
            // dd($row);
            return $row->pivot->date;
        })
        ->addColumn('overtime_name', function($row) {
            // dd($row->name);
        //   return  '<button class="text-primary btn-primary btn" type="button" data-bs-toggle="modal" data-bs-target="#overtimeDetail" onclick="overtimeDetail('.$row->id.')" id="overtimeDetail">Detail</button>';
            return $row->name;
        })
        ->addColumn('overtime_hour', function($row) {
            // dd($row->pivot->hour);
        //   return  '<button class="text-primary btn-primary btn" type="button" data-bs-toggle="modal" data-bs-target="#overtimeDetail" onclick="overtimeDetail('.$row->id.')" id="overtimeDetail">Detail</button>';
            return $row->pivot->hour . ' Jam';
        })
        ->addColumn('salary', function($row) {
        //   return  '<button class="text-primary btn-primary btn" type="button" data-bs-toggle="modal" data-bs-target="#overtimeDetail" onclick="overtimeDetail('.$row->id.')" id="overtimeDetail">Detail</button>';
            return rp($row->pivot->salary);
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function presence_store(Request $request)
    {
        $this->validate($request, [
            'tanggal' => 'required',
            'lemburan' => 'required',
            'from_time' => 'required',
        ],[
            'tanggal.required' => 'Tanggal wajib diisi!',
            'lemburan.required' => 'Menu pilih lemburan wajib diisi!',
            'from_time.required' => 'Jam lembur wajib diisi!',
        ]);

        // $startTime = Carbon::parse($request->from_time);
        // $finishTime = carbon::parse($request->to_time);
        $total_duration = $request->from_time;
        $checkDate = Carbon::parse($request->tanggal)->format('Y-m-j');
        $today = Carbon::parse($request->tanggal)->format('D');
        // dd(Carbon::parse($request->tanggal));

            $employee = Employee::where('user_id', auth()->user()->id)->first();
            $presence = Presence::where('employee_id', $employee->id)->whereDate('created_at', $request->tanggal)->first();
            $overtime = Overtime::find($request->lemburan);
        
            
        // Pengecekan apakah jam lembur lebih dari 5 jam
        $extra_duration = 0;
            if ($total_duration > 5) {
                $extra_duration = $total_duration - 5;
                $total_duration -= $extra_duration;
            }
            // dd($extra_duration);
        // Akhir pengecekan jam lembur

        // dd($extra_duration + $total_duration);

        // Pengambilan API tanggal merah dan API tahun hijriyah
            $liburan = file_get_contents("https://api-harilibur.vercel.app/api");
            $hari_libur = json_decode($liburan, true);
            $hijriyah = Hijri::date('Y');
        // Akhir pengambilan API tanggal merah dan API tahun hijriyah  
        
        $libur_nasional = [];
        $tanggal_merah = [];
        foreach ($hari_libur as $libur) {
            if ($libur['is_national_holiday'])   {
                $tanggal_merah[] = $libur['holiday_date'];
                $push['tanggal'] = $libur['holiday_date'];
                $push['nama'] = $libur['holiday_name'];
                array_push($libur_nasional, $push);
            } 
        }

        // Pengecekan Hari Raya Idul-fitri dan Idul Adha    
            $holiday_name = array_column($libur_nasional, 'nama');
            // dd($holiday_name);
            $found_key_fitri = array_search('Hari Raya Idul Fitri ' . $hijriyah . ' Hijriyah', $holiday_name);
            $found_key_adha = array_search('Hari Raya Idul Adha ' . $hijriyah . ' Hijriyah', $holiday_name);

            $tanggal_adha = $libur_nasional[$found_key_adha];
            $tanggal_fitri = $libur_nasional[$found_key_fitri+1];

            if (in_array($checkDate, $tanggal_fitri)) {
                $hari_raya = true;
            } elseif (in_array($checkDate, $tanggal_adha)) {
                $hari_raya = true;
            } else {
                $hari_raya = false;
            }
        // Akhir pengecekan Hari Raya Idul-fitri dan Idul Adha 

        // Pengecekan libur hari minggu dan hari besar
             if ($today === "Sun") {
                $hari_besar = true;
            } elseif (in_array($checkDate, $tanggal_merah)) {
                $hari_besar = true;
            } else {
                $hari_besar = false;
            }
        // Akhir pengecekan libur hari minggu dan hari besar  

        $check = $employee->overtimes()->where('date' , $request->tanggal)->where('employee_id', $employee->id)->get();
        if (count($check) > 0) {
            return redirect('/lemburan/absen')->with('failed', 'Anda sudah melakukan absen lemburan hari ini');
        } elseif (!$presence) {
            return redirect('/lemburan/absen')->with('failed', 'Anda harus melakukan absen hadir sebelum melakukan absen lembur!');
        }

        $salary = 0;

        if (!$hari_raya) {
            if ($hari_besar) {
                if ($extra_duration < 1) {
                    $bonus_hariBesar = $overtime->per_hour * 2;   
                    $salary += $bonus_hariBesar * $total_duration;
                } elseif ($extra_duration > 0) {
                    $bonus_hariBesar = $overtime->per_hour * 2;   
                    $salary += $bonus_hariBesar * $total_duration;
                    $bonus_hariBesarExtra = $overtime->per_hour * 3;
                    $salary += $bonus_hariBesarExtra * $extra_duration;
                }
            } else {
                if ($extra_duration < 1) {
                    $salary += $overtime->per_hour * $total_duration;
                } elseif ($extra_duration > 0) {
                    $salary += $overtime->per_hour * $total_duration;
                    $bonus = $overtime->per_hour * 2;
                    $salary += $bonus * $extra_duration;
                }
            }
        } elseif ($hari_raya) {
            $bonus_hariRaya = $overtime->per_hour * 3;
            $salary += $bonus_hariRaya * $total_duration;
        } 

        // dd($salary);

        $employee->overtimes()->attach($request->lemburan, ['date' => $request->tanggal, 'hour' => $extra_duration + $total_duration, 'salary' => $salary]);

        return redirect('/lemburan/absen')->with('success', 'Anda berhasil mengisi absen lemburan hari ini');

    } 

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'perjam' => 'required | numeric',
        ]);
        $overtime = Overtime::find($id);
        $overtime->name = $request->name;
        $overtime->per_hour = str_replace(".","",$request->perjam);
        $overtime->save();
        
        return redirect('/lemburan')->with('success', 'Berhasil mengedit lemburan');
    }

    public function data_presence_admin(Request $request)
    {
        $employee = Employee::get();
        // $employee_overtime = Employee_overtime::groupBy('date')->get();

        if ($request->ajax()) {
            if (!empty($request->from_date)) {
                if ($request->from_date === $request->to_date) {
                    $employee_overtime = Employee_overtime::whereDate('date', $request->from_date)->groupBy('date')->get();
                } else {
                    $employee_overtime = Employee_overtime::whereDate('date', '>=', $request->from_date)
                                                          ->whereDate('date', '<=', $request->to_date)->groupBy('date')->get();
                }
            } else {
                $employee_overtime = Employee_overtime::groupBy('date')->get();
            }
        }


        return DataTables($employee_overtime)
        ->addColumn('tanggal', function($row) {
            return $row->date;
        })
        ->addColumn('action', function($row) {
            // $employee_overtime = Employee_overtime::where('employee_id', $row->id)->get();
                $tgl = Carbon::parse($row->date)->format("Ymd");
                // dd($tgl);
                return  '<button class="text-primary btn-primary btn" type="button" data-bs-toggle="modal" data-bs-target="#overtimeDetail" onclick="overtimeDetail('."'".$row->date."'".')" id="overtimeDetail">Detail</button>';
            // foreach ($row->overtimes as $pivot) {
            // }
            return 'a';
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function data_overtime_detail(Request $request)
    {
        function uang($angka)
        {
            $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
            return $hasil_rupiah;
        }

        $employee_overtime = Employee_overtime::where('date', $request->tgl)->with('employees')->get();
        
        return DataTables($employee_overtime)
        ->addColumn('name', function ($row) {
           return Str::ucfirst($row->employees->users->name);
        })
        ->addColumn('overtime_name', function ($row) {
            return $row->overtimes->name . " - " .  uang($row->overtimes->per_hour) . " / Jam";
        })
        ->addColumn('overtime_hour', function ($row) {
            return $row->hour . " Jam";
        })
        ->addColumn('salary', function ($row) {
            return uang($row->salary);
        })
        ->addIndexColumn()
        ->make(true);
    }
}
