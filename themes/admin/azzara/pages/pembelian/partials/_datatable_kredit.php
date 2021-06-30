<div class="table-responsive">
  <table id="datatable-kredit" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th></th>
        <th>#</th>
        <th>Kode Pembelian</th>
        <th>Status Order</th>
        <th>Total</th>
        <th>Telah Dibayar</th>
        <th>Kembalian</th>
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
      url: baseUrl + "admin/pembelian/data/datatable",
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
        data: 'kode',
        name: 'kode'
      },
      {
        data: 'status_order',
        name: "status_order"
      }, {
        data: 'total_rp',
        name: 'total'
      },
      {
        data: 'dibayar_rp',
        name: 'jumlah_bayar'
      },
      {
        data: 'kembalian_rp',
        name: 'kembalian'
      }
    ]
  });

  $(document).ready(() => {
    $("#datatable-kredit").on("click", ".btn-pilih", function(e) {
      e.preventDefault();
      playBip();
      let elClosesTr = $(this).parents('tr');
      let pembelian = datatable_kredit.row(elClosesTr).data();
      btn_pilih(pembelian);
    })
  })

  function playBip() {
    const obj = document.createElement("audio");
    obj.src = baseUrl + "assets/audio/beep.mp3";
    obj.play();
  }
</script>