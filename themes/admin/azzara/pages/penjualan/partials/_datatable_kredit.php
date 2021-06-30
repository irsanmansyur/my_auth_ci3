<div class="table-responsive">
  <table id="datatable-kredit" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th></th>
        <th>#</th>
        <th>Invoice Penjualan</th>
        <th>Pelanggan</th>
        <th>Jumlah</th>
        <th>Pinjaman</th>
        <th>Jatuh Tempo</th>
      </tr>
    </thead>
  </table>
</div>
<script>
  const datatable_kredit = $('#datatable-kredit').DataTable({
    "columnDefs": [{
      "width": "33px",
      className: 'dt-body-center text-center py-0 my-0',
      "targets": [0, 1]
    }],
    processing: true,
    "pageLength": 10,
    serverSide: true,
    "searching": true,
    "order": [
      [1, "desc"]
    ],
    ajax: {
      url: baseUrl + "admin/penjualan/data/datatable",
      type: 'POST',
      data: {
        status_bayar: "kredit"
      }
    },
    columns: [{
        data: 'pilih',
        orderable: false
      }, {
        data: 'urut',
        name: "created_at"
      },
      {
        data: 'no_invoice',
        name: 'no_invoice'
      },
      {
        data: 'pelanggan',
        name: "users.name"
      }, {
        data: 'jumlah_bayar_rp',
        name: 'jumlah_bayar'
      },
      {
        data: 'pinjaman_rp',
        orderable: false
      },
      {
        data: 'jatuh_tempo_f',
        name: 'jatuh_tempo'
      }
    ]
  });
  $(document).ready(() => {
    $('#datatable-kredit').on('click', ".btn-pilih", function(e) {
      e.preventDefault();
      let elClosesTr = $(this).parents('tr');
      let penjualan = datatable_kredit.row(elClosesTr).data();
      const obj = document.createElement("audio");
      obj.src = baseUrl + "assets/audio/beep.mp3";
      obj.play();
      btn_pilih(penjualan);
    })
  })
</script>