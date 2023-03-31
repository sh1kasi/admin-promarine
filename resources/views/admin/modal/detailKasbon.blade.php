<div class="modal fade text-dark" id="kasbonDetailModal'.$row->id.'" tabindex="-1" aria-labelledby="kasbonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-bottom mb-5">
          <h1 class="modal-title fs-6" id="kasbonModalLabel">Deskripsi Kasbon '.ucfirst($row->employees->users->name).' Tanggal &nbsp; - &nbsp; (' . $row->date . ')</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <h5>Deskripsi Kasbon: </h5>
          <p class="ms-4 fs-6">'.$row->description.'</p>
        </div>
        {{-- <div class="rincian_kasbon"> --}}
            {{-- <table class="table table-bordered" id="kasbonDetailTable"></table> --}}
        {{-- </div> --}}
        <div class="modal-footer d-flex mt-5 justify-content-start border-top d-flex align-items-center">
          <h5>Bukti Foto Kasbon:</h5>
          <div class="image">
            <h4><img class="img-fluid mt-2" src="'.asset('/kasbon-image'.'/'. $row->photo).'" alt=""></h4>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-start border-top">
          <h5>Total Kasbon: </h5> <br>
          <h5>'.rupiah($row->nominal).'</h5>  
        </div>
      </div>
    </div>
  </div>'