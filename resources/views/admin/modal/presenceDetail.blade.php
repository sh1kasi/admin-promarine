<div class="modal fade" id="presenceDetail" tabindex="-1" role="dialog" aria-labelledby="presenceDetailLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="presenceDetailLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <table id="presenceDetailTable" class=" display table table-bordered table-responsive" style="width: 100%">
                    <thead class="table-primary">
                        <tr>
                            <th>Nama</th>
                            <th>Area</th>
                            <th>Jam Absen</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="presenceDetailTableBody" style="text-align: center">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function presenceDetail(tgl) {
        $(document).ready(function () {
            // console.log(judul);
            console.log(tgl);

            $("#presenceDetail").modal('show');
            $("#presenceDetailLabel").html(`Absensi tanggal (${tgl})`);


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/kehadiran/detail",
                data: {
                  tgl: tgl,
                },
                dataType: "json",
                success: function (response) {
                  $("#presenceDetailTableBody").html('');
                  $(response.presence).each(function (key, data) {
                    if (data.status == 1) {
                      var status = "Hadir";
                    } else {
                      var status = "Tidak hadir";
                    }
                    $("#presenceDetailTableBody").append(`
                      <tr>
                        <td>${data.name}</td>
                        <td>${data.area}</td>
                        <td>${data.time}</td>
                        <td><p class="text-success">${status}</p></td>
                      </tr>
                    `);
                  });
                }
            });

        });
    }

</script>
