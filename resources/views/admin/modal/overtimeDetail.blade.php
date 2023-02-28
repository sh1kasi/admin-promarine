<div class="modal fade" id="overtimeDetail" tabindex="-1" role="dialog" aria-labelledby="overtimeDetailLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="overtimeDetailLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="overtimeDetailTable" class=" display table table-bordered table-responsive" style="width: 100%">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Nama Pegawai</th>
                                <th>Nama Lemburan</th>
                                <th>Jam Lembur</th>
                                <th>Bayaran</th>
                            </tr>
                        </thead>
                        <tbody id="overtimeDetailTableBody" style="text-align: center">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function overtimeDetail(tgl) {
        $("#overtimeDetailLabel").html(`Detail Lemburan Tanggal &nbsp; (${tgl})`);
        $("#overtimeDetailTable").DataTable({
                processing: true,
                serverSide: true,
                filter: false,
                info: false,
                paging: false,
                destroy: true,
                searching: true,
                ajax: {
                    type: "GET",
                    url: "/lemburan/detail/json",
                    data: {
                        tgl: tgl,
                    },
                },
                columns: [
                    {data: 'DT_RowIndex', name: '#'},
                    {data: 'name', name: 'name'},
                    {data: 'overtime_name', name: 'overtime_name'},
                    {data: 'overtime_hour', name: 'overtime_hour'},
                    {data: 'salary', name: 'salary'},
                ]
            });
    }
</script>