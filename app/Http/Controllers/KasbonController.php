<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kasbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class KasbonController extends Controller
{
    public function index()
    {
        $kasbon = Kasbon::get();
        return view('admin.kasbonAdminIndex', compact('kasbon'));
    }

    public function data(Request $request)
    {

        function rupiah($angka)
        {
            $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
            return $hasil_rupiah;
        }

        if ($request->ajax()) {
          dd($request);
        }

        $kasbon = Kasbon::get();
        // dd($kasbon);
        return datatables($kasbon)
        ->addColumn('name', function ($row) {
           return ucfirst($row->employees->users->name);
        })
        ->addColumn('status', function ($row) {
          if ($row->status === 'success') {
            return "Selesai";
          } elseif ($row->status === 'pending') {
            return "Menunggu";
          } else {
            return "Ditolak";
          }
  
        })
        ->addColumn('action', function ($row) {
          if ($row->status === "success") {
            return '<div class="action d-flex justify-content-center">
                      <button class="btn btn-danger ms-1 me-1" id="reject'.$row->id.'" data-date="'.$row->date.'" data-name="'.ucfirst($row->employees->users->name).'" data-nominal="'.$row->nominal.'" data-desc="'.$row->description.'" onclick="reject('.$row->id.')">Tolak Kasbon</button>
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kasbonModal'.$row->id.'">Deskripsi</button>
                    </div>
                    <div class="modal fade" id="kasbonModal'.$row->id.'" tabindex="-1" aria-labelledby="kasbonModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header border-bottom mb-5">
                            <h1 class="modal-title fs-6" id="kasbonModalLabel">Deskripsi Kasbon '.ucfirst($row->employees->users->name).' Tanggal &nbsp; - &nbsp; (' . $row->date . ')</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body fs-5">
                            '.$row->description.'
                          </div>
                          <div class="modal-footer d-flex mt-5 justify-content-start border-top">
                            <h4>'.rupiah($row->nominal).'</h4>
                          </div>
                        </div>
                      </div>
                    </div>';
          } elseif ($row->status === "rejected") {
            return '<div class="action d-flex justify-content-center">
                      <button class="btn btn-success me-1" id="success'.$row->id.'" data-date="'.$row->date.'" data-name="'.ucfirst($row->employees->users->name).'" data-nominal="'.$row->nominal.'" data-desc="'.$row->description.'" onclick="complete('.$row->id.')">Selesaikan Kasbon</button>
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kasbonModal'.$row->id.'">Deskripsi</button>
                    </div>
                    <div class="modal fade" id="kasbonModal'.$row->id.'" tabindex="-1" aria-labelledby="kasbonModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header border-bottom mb-5">
                            <h1 class="modal-title fs-6" id="kasbonModalLabel">Deskripsi Kasbon '.ucfirst($row->employees->users->name).' Tanggal &nbsp; - &nbsp; (' . $row->date . ')</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body fs-5">
                            '.$row->description.'
                          </div>
                          <div class="modal-footer d-flex mt-5 justify-content-start border-top">
                            <h4>'.rupiah($row->nominal).'</h4>
                          </div>
                        </div>
                      </div>
                    </div>';
          } else {
            return '<div class="action d-flex justify-content-center">
                      <button class="btn btn-success me-1" id="success'.$row->id.'" data-date="'.$row->date.'" data-name="'.ucfirst($row->employees->users->name).'" data-nominal="'.$row->nominal.'" data-desc="'.$row->description.'" onclick="complete('.$row->id.')">Selesaikan Kasbon</button>
                      <button class="btn btn-danger ms-1 me-1" id="reject'.$row->id.'" data-date="'.$row->date.'" data-name="'.ucfirst($row->employees->users->name).'" data-nominal="'.$row->nominal.'" data-desc="'.$row->description.'" onclick="reject('.$row->id.')">Tolak Kasbon</button>
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kasbonModal'.$row->id.'">
                        Deskripsi
                      </button>
                    </div>
                    <div class="modal fade" id="kasbonModal'.$row->id.'" tabindex="-1" aria-labelledby="kasbonModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header border-bottom mb-5">
                            <h1 class="modal-title fs-6" id="kasbonModalLabel">Deskripsi Kasbon '.ucfirst($row->employees->users->name).' Tanggal &nbsp; - &nbsp; (' . $row->date . ')</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body fs-5">
                            '.$row->description.'
                          </div>
                          <div class="modal-footer d-flex mt-5 justify-content-start border-top">
                            <h4>'.rupiah($row->nominal).'</h4>
                          </div>
                        </div>
                      </div>
                    </div>';
          }

        })
        ->addIndexColumn()
        ->make(true);
    }

    public function user_index()
    {
      $employee = Employee::where('user_id', auth()->user()->id)->first();  
      $kasbon = Kasbon::where('employee_id', $employee->id)->get();

      $now = Carbon::now();


      return view('admin.kasbonUserIndex', compact('kasbon', 'now'));
    }

    public function user_data(Request $request)
    {
      $employee = Employee::where('user_id', auth()->user()->id)->first();  
      $kasbon = Kasbon::where('employee_id', $employee->id)->get();

      return DataTables($kasbon)
      ->addColumn('status', function ($row) {
        if ($row->status === 'success') {
          return "Selesai";
        } elseif ($row->status === 'pending') {
          return "Menunggu";
        } else {
          return "Ditolak";
        }

      })
      ->addIndexColumn()
      ->make(true);
    }

    public function store(Request $request)
    {
      $this->validate($request, [
        'tanggal' => 'required',
        'desc' => 'required',
        'nominal' => 'required',
      ],[
        'tanggal.required' => 'Tanggal wajib diisi!',
        'desc.required' => 'Deskripsi wajib diisi!',
        'nominal.required' => 'Nominal wajib diisi!',
      ]);

      $employee = Employee::where('user_id', auth()->user()->id)->first();
      $kasbon = new Kasbon;
      $kasbon->employee_id = $employee->id;
      $kasbon->nominal = str_replace(".", "", $request->nominal);
      $kasbon->description = $request->desc;
      $kasbon->date = $request->tanggal;
      $kasbon->status = 'pending';
      $kasbon->save();

      return redirect('/kasbon')->with('success', 'Anda berhasil membuat kasbon!');
    }

    public function complete(Request $request, $id)
    {
      $kasbon = Kasbon::find($id);
      $kasbon->status = 'success';
      $kasbon->save();

      return response()->json([
        'data' => $kasbon,
      ]);
    }

    public function reject(Request $request, $id)
    {
      $kasbon = Kasbon::find($id);
      $kasbon->status = 'rejected';
      $kasbon->save();

      return response()->json([
        'data' => $kasbon,
      ]);
    }
}
