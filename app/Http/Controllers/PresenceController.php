<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Stevebauman\Location\Facades\Location;

class PresenceController extends Controller
{
    public function index(Request $request)
    {
        $employee = Employee::where('user_id', auth()->user()->id)->first();
        // dd($employee);
        $currentDate = Carbon::now()->format('Y-m-d');

        
        return view('admin.presenceIndex', compact('employee', 'currentDate'));
    }

    public function data(Request $request)
    {
        $employeee = Employee::get();
        $presence = Presence::groupBy('date')->get();
        // dd($presence);

        return DataTables($presence)
        ->addColumn('date', function ($row) {
            return $row->date;
        })
        ->addColumn('action', function ($row) {
            $date = $row->created_at->format('Y-m-d');
            return '<button class="text-primary btn-primary btn" type="button" onclick="presenceDetail('."'".$row->date."'".', '."'".$date."'".')" id="presenceDetail data-bs-toggle="modal" data-bs-target="#presenceDetail">Cek Absen</button>';
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function store(Request $request)
    {

        $request->validate([
            'tanggal' => 'required',
            'area' => 'required',
        ],[
            'tanggal.required' => 'Tanggal wajib diisi!',
            'area.required' => 'Area wajib diisi!',
        ]);

    // Pengambilan API tanggal merah dan API tahun hijriyah
        $liburan = file_get_contents("https://api-harilibur.vercel.app/api");
        $hari_libur = json_decode($liburan, true);

        $ki = file_get_contents("http://api.aladhan.com/v1/gToH");
        $kalender_islam = json_decode($ki, true);
        $hijriyah = $kalender_islam['data']['hijri']['year'];
    // Akhir pengambilan API tanggal merah dan API tahun hijriyah    

        $checkDate = Carbon::parse($request->tanggal)->format('Y-m-j');
        $today = Carbon::now()->format('D');
        
        $employee = Employee::find($request->employee_id);
        
    // Mengubah metode gaji menjadi harian    
        $gaji_harian = 0;
        if ($employee->salary_method === "Bulanan") {
            $gaji_harian = $employee->daily_salary / 25;
        } else {
            $gaji_harian = $employee->daily_salary;
        }
    // Akhir mengubah metode gaji menjadi harian    

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
        $found_key_fitri = array_search('Hari Raya Idul Fitri ' . $hijriyah . ' Hijriyah', $holiday_name);
        $found_key_adha = array_search('Hari Raya Idul Adha ' . $hijriyah . ' Hijriyah', $holiday_name);

        $tanggal_adha = $libur_nasional[$found_key_adha];
        $tanggal_fitri = $libur_nasional[$found_key_fitri+1];

        if (in_array($today, $tanggal_fitri)) {
            $hari_raya = true;
        } elseif (in_array($today, $tanggal_adha)) {
            $hari_raya = true;
        } else {
            $hari_raya = false;
        }
        
        // dd($hari_raya);
    // Akhir pengecekan Hari Raya Idul-fitri dan Idul Adha 



    // Pengecekan libur hari minggu dan hari besar
        if ($today === "Sun") {
            $hari_besar = true;
        } elseif (in_array($today, $tanggal_merah)) {
            $hari_besar = true;
        } else {
            $hari_besar = false;
        }
    // Akhir pengecekan libur hari minggu dan hari besar    


        $currentTime = Carbon::now()->format('h:i:s');

        $check = Presence::where('date' , $request->tanggal)->where('employee_id', $request->employee_id)->get();
        if (count($check) > 0) {
            return redirect('/kehadiran')->with('failed', 'Anda sudah melakukan absen hari ini');
        }

        $salary = 0;
        if ($request->area == 1) {
            $salary = $gaji_harian;
        } elseif ($request->area == 2) {
            $salary = $gaji_harian + 50000;
        } elseif ($request->area == 3) {
            $salary = $gaji_harian + 75000;
        } elseif ($request->area == 4) {
            $salary = $gaji_harian * 3;
        }   

    if (!$hari_raya) {
        if ($hari_besar) {
            $salary *=  2;
        }
    } else {
        $salary *= 3;
    }

            $presence = new Presence;
            $presence->employee_id = $request->employee_id;
            $presence->area = $request->area;
            $presence->status = 1;
            $presence->date = $request->tanggal.' '.$currentTime;
            $presence->salary = $salary;
            $presence->save();

        return redirect('/kehadiran')->with('success', 'Berhasil mengisi Absensi');

    }

    public function detail(Request $request)
    {
        $presence = Presence::whereDate('date', $request->tgl)->with('employees')->get();
        $presence_array = [];
        foreach ($presence as $key) {
            if ($key->area == 1) {
                $area = "Area Gerbang Kertasusila";
            } elseif ($key->area == 2) {
                $area = "Area Pulau Jawa Selain Gerbang Kertasusila";
            } elseif ($key->area == 3) {
                $area = "Area Luar Pulau Jawa selain Bangkalan";
            } elseif($key->area == 4) {
                $area = "Area Offshore / Anchorage";
            }

            $push['name'] = ucfirst($key->employees->users->name);
            $push['status'] = $key->status;
            $push['area'] = $area;
            $push['time'] = $key->created_at->format('H:i:s');
            $push['date'] = $key->created_at->format('Y-m-d');
            array_push($presence_array, $push);
        }
        return response()->json([
            'presence' => $presence_array,
        ]);
    }
}
