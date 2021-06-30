<div class="table-responsive">
  <table id="datatable-jurnal" class="table table-striped table-bordered mytable" style="width:100%">
    <thead>
      <tr>
        <th class="align-center">#</th>
        <th class="align-center">Tanggal</th>
        <th class="align-center">Keterangan</th>
        <th class="text-center">Debit</th>
        <th class="text-center">Kredit</th>
      </tr>
    </thead>
  </table>
</div>
<script>
  const datatable_jurnal = $('#datatable-jurnal').DataTable({
    "columnDefs": [{
      "width": "33px",
      className: 'dt-body-center text-center py-0 my-0',
      "targets": 0
    }, {
      className: 'align-top py-0 my-0',
      "targets": [0, 1, 2]
    }, {
      className: 'align-top text-right py-0 my-0',
      "targets": [3, 4]
    }],
    processing: true,
    "pageLength": 10,
    serverSide: true,
    "searching": true,
    "order": [
      [1, "desc"]
    ],
    ajax: {
      url: baseUrl + "admin/transaksi/jurnal/datatable",
      type: 'POST',
      data: {
        status_bayar: "kredit"
      }
    },
    columns: [{
        data: 'urut',
        name: "created_at"
      },
      {
        data: 'tanggal',
        name: 'created_at'
      },
      {
        data: 'keterangan_tp',
        orderable: false
      }, {
        data: 'debit_tp',
        name: 'jumlah'
      }, {
        data: 'kredit_tp',
        name: 'jumlah'
      }
    ]
  });
</script>