<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kasbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use PDF;
use App\Http\Controllers\Controller;
use App\Models\Kasbon_detail;

class KasbonController extends Controller
{
    public function index()
    {
        $kasbon_employee = Kasbon::groupBy('employee_id')->get();
        return view('admin.kasbonAdminIndex', compact('kasbon_employee'));
    }

    public function data(Request $request)
    {

        function rupiah($angka)
        {
            $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
            return $hasil_rupiah;
        }

        if ($request->ajax()) {
          if (!empty($request->from_date)) {
            if ($request->from_date === $request->to_date) {
              $kasbon = Kasbon::where('date', $request->from_date)->get();
            } else {
              $kasbon = Kasbon::whereDate('date', ">=", $request->from_date)->whereDate('date', "<=", $request->to_date)->get();
            }
          } else {
            $kasbon = Kasbon::get();
          }
          if (!empty($request->employee_id)) {
            $kasbon = Kasbon::where('employee_id', $request->employee_id)->get();
          } else {
            $kasbon = Kasbon::get();
          }
        }


        // $kasbon = Kasbon::get();
        // dd($kasbon);
        return datatables($kasbon)
        ->addColumn('name', function ($row) {
           return ucfirst($row->employees->users->name);
        })
        ->addColumn('foto', function ($row) {
          return '<a class="detail-image" type="button" onclick="detailImage('."'".  asset("kasbon-image/".$row->photo)   ."'".')"><img class="image-responsive" src="' . asset("kasbon-image/".$row->photo)  .  '" width="65px" alt="Bukti Foto"></a>';
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
                    <div class="modal fade text-dark" id="kasbonModal'.$row->id.'" tabindex="-1" aria-labelledby="kasbonModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header border-bottom mb-5">
                            <h1 class="modal-title fs-6" id="kasbonModalLabel">Deskripsi Kasbon '.ucfirst($row->employees->users->name).' Tanggal &nbsp; - &nbsp; (' . $row->date . ')</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body mb-4">
                            <h5>Deskripsi Kasbon: </h5>
                            <p class="ms-4 fs-6">'.$row->description.'</p>
                          </div>
                          
                          <div class="modal-footer d-flex justify-content-start border-top">
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
                    <div class="modal fade text-dark" id="kasbonModal'.$row->id.'" tabindex="-1" aria-labelledby="kasbonModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header border-bottom mb-5">
                            <h1 class="modal-title fs-6" id="kasbonModalLabel">Deskripsi Kasbon '.ucfirst($row->employees->users->name).' Tanggal &nbsp; - &nbsp; (' . $row->date . ')</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body mb-4">
                            <h5>Deskripsi Kasbon: </h5>
                            <p class="ms-4 fs-6">'.$row->description.'</p>
                          </div>
                          
                          <div class="modal-footer d-flex justify-content-start border-top">
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
                    <div class="modal fade text-dark" id="kasbonModal'.$row->id.'" tabindex="-1" aria-labelledby="kasbonModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header border-bottom mb-5">
                            <h1 class="modal-title fs-6" id="kasbonModalLabel">Deskripsi Kasbon '.ucfirst($row->employees->users->name).' Tanggal &nbsp; - &nbsp; (' . $row->date . ')</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body mb-4">
                          <h5>Deskripsi Kasbon: </h5>
                            <p class="ms-4 fs-6">'.$row->description.'</p>
                          </div>
                          
                          <div class="modal-footer d-flex justify-content-start border-top">
                            <h5>Total Kasbon: </h5> <br>
                            <h5>'.rupiah($row->nominal).'</h5>  
                          </div>
                        </div>
                      </div>
                    </div>';
          }

        })
        ->escapeColumns([])
        ->addIndexColumn()
        ->make(true);
    }

    public function user_index()
    {


      $employee = Employee::where('user_id', auth()->user()->id)->first();  
      $kasbon = Kasbon::where('employee_id', $employee?->id)->get();

      $now = Carbon::now();

      $total_pending = 0;
      foreach ($kasbon->where('status', 'pending') as $key) {
        $total_pending += $key->nominal;
      }


      return view('admin.kasbonUserIndex', compact('kasbon', 'now', 'total_pending'));
    }

    public function user_data(Request $request)
    {

      function rp($angka)
      {
          $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
          return $hasil_rupiah;
      }

      $employee = Employee::where('user_id', auth()->user()->id)->first();  
      $kasbon = Kasbon::where('employee_id', $employee?->id)->get();

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
      ->addColumn('foto', function($row) {
        return '<a class="detail-image" type="button" onclick="detailImage('."'".  asset("kasbon-image/".$row->photo)   ."'".')"><img class="image-responsive" src="' . asset("kasbon-image/".$row->photo)  .  '" width="65px" alt="Bukti Foto"></a>';
      })
      ->addColumn('description', function ($row) {
          return '<div class="action d-flex justify-content-center">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kasbonModal'.$row->id.'">Deskripsi</button>
        </div>
        <div class="modal fade text-dark" id="kasbonModal'.$row->id.'" tabindex="-1" aria-labelledby="kasbonModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header border-bottom mb-5">
                <h1 class="modal-title fs-6" id="kasbonModalLabel">Deskripsi Kasbon '.ucfirst($row->employees->users->name).' Tanggal &nbsp; - &nbsp; (' . $row->date . ')</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body mb-4">
                <h5>Deskripsi Kasbon: </h5>
                <p class="ms-4 fs-6">'.$row->description.'</p>
              </div>
              <div class="modal-footer d-flex justify-content-start border-top">
                <a type="button" onclick="moreDetail('.$row->id.')" class="btn btn-success w-100">Lihat Detail Lebih Lanjut</a>
              </div>
              <div class="modal-footer d-flex justify-content-start border-top">
                <h4>'.rp($row->nominal).'</h4>
              </div>
            </div>
          </div>
        </div>';
      })
      ->escapeColumns([])
      ->addIndexColumn()
      ->make(true);
    }

    public function input_index()
    {
      $now = Carbon::now();

      return view('admin.inputKasbon', compact('now'));
    }

    public function store(Request $request)
    {
      dd($request);
      
      $this->validate($request, [
        'tanggal' => 'required',
        'nominal' => 'required',
        'job_kasbon' => 'required',
        'input.*.date' => 'required',
        'input.*.item' => 'required',
        'input.*.nominal' => 'required',
        'photo' => 'required|image|file|max:10240',
      ],[
        'tanggal.required' => 'Tanggal wajib diisi!',
        'job_kasbon.required' => 'Keterangan Job wajib diisi!',
        'nominal.required' => 'Nominal wajib diisi!',
        'input.*.date.required' => 'Harap isi tanggal detail!',
        'input.*.item.required' => 'Harap isi detail item / barang!',
        'input.*.nominal.required' => 'Harap isi detail nominal!!',
        'photo.required' => 'Harap masukkan bukti!',
        'photo.image' => 'File yang anda masukkan wajib tipe gambar!',
        'photo.max' => 'Foto yang anda upload melebihi batas ukuran yang telah ditentukan!',
      ]);
      
      $employee = Employee::where('user_id', auth()->user()->id)->first();
      $kasbon = new Kasbon;
      $kasbon->employee_id = $employee->id;
      $kasbon->nominal = str_replace(".", "", $request->nominal);
      $kasbon->job = $request->job_kasbon;
      $kasbon->description = $request->desc;
      $request->file('photo')->move('kasbon-image/', $request->file('photo')->getClientOriginalName());
      $kasbon->photo = $request->file('photo')->getClientOriginalName();
      $kasbon->date = $request->tanggal;
      $kasbon->status = 'pending';
      $kasbon->save();

      foreach ($request->input as $key => $value) {
        $kasbon_detail = new Kasbon_detail;
        $kasbon_detail->kasbon_id = $kasbon->id;
        $kasbon_detail->date = $value['date'];
        $kasbon_detail->item = $value['item'];
        $kasbon_detail->nominal = str_replace(".", "", $value['nominal']);
        $kasbon_detail->save();
      }

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

    public function count(Request $request)
    {
      $count = Kasbon::where('status', 'pending')->count();

      return response()->json([
        'count' => $count,
      ]);
    }

    public function kasbon_detail_pdf(Request $request)
    {
      $id = $request->kasbon_id;
      $kasbon = Kasbon::find($id);
      $kasbon_detail = Kasbon_detail::where('kasbon_id', $id)->get();
      $employee = Employee::find($kasbon->employee_id);
      
      view()->share([
        'kasbon' => $kasbon,
        'kasbon_detail' => $kasbon_detail,
        'employee' => $employee
      ]);

      $pdf = PDF::loadview('admin.kasbonDetailExportPDF');
      return $pdf->stream('Detail Kasbon '. ucfirst($employee->users->name) . '.pdf');

    }
}
