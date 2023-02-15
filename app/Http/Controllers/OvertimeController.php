<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Overtime;
use Illuminate\Http\Request;
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

        return view('admin.overtimeIndex', compact('employee'));
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
                     <a class="text-primary"  href="/lemburan/edit/'.$row->id.'"><i class="fa-solid fa-lg fa-pen-to-square"></i></a>
                     <a class="text-primary" href="/lemburan/delete/'.$row->id.'"><i class="fa-solid fa-trash fa-lg"></i></a>
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

    public function presence_index()
    {
        $overtime = Overtime::get();
        $employee = Employee::where('user_id', auth()->user()->id)->first();
        $currentDate = Carbon::now()->format('Y-m-d');
        
        return view('admin.presenceOvertimeIndex', compact('overtime', 'employee', 'currentDate'));
    }

    public function presence_data(Request $request)
    {
        $employee = Employee::get();
        return DataTables($employee)
        ->addColumn('name', function($row) {
            return ucfirst($row->users->name);
        })
        ->addColumn('action', function($row) {
          return  '<button class="text-primary btn-primary btn" type="button" data-bs-toggle="modal" data-bs-target="#overtimeDetail" onclick="overtimeDetail('.$row->id.')" id="overtimeDetail">Detail</button>';
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
            'to_time' => 'required',
        ],[
            'tanggal.required' => 'Tanggal wajib diisi!',
            'lemburan.required' => 'Menu pilih lemburan wajib diisi!',
            'from_time.required' => 'Kedua jam wajib diisi!',
            'to_time.required' => 'Kedua jam wajib diisi!',
        ]);

        $startTime = Carbon::parse($request->from_time);
        $finishTime = carbon::parse($request->to_time);
        $total_duration = $finishTime->diffInHours($startTime);
        
        if ($total_duration > 5) {
            $total_duration -= 5;
            // dd($total_duration);
        }


    }
}
