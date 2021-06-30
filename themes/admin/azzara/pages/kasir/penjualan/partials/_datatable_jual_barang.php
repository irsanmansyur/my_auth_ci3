<table id="datatable-jual_barang" class="table table-hover display table table-striped table-hover w-100">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col" class="pilih"></th>
      <th scope="col">Nama</th>
      <th scope="col">Kode</th>
      <th scope="col">Harga Jual</th>
      <th scope="col">Sisa Stok</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<script>
  const datatable_barang = $("#datatable-jual_barang").DataTable({
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
      [0, "desc"]
    ],
    ajax: {
      url: baseUrl + "admin/barang/data/datatable",
      type: 'POST',
      data: {
        "pilih_barang": "yes"
      }
    },
    columns: [{
        data: 'urut',
        name: "created_at"
      }, {
        data: 'pilih',
        orderable: false
      },
      {
        data: 'nama',
        name: 'barangs.nama'
      },
      {
        data: 'kode',
        name: "kode"
      },
      {
        data: 'harga_jual',
        name: "harga_jual"
      },
      {
        data: 'stok',
        name: 'stok'
      }
    ]
  });

  // event
  $("#datatable-jual_barang").on("click", ".btn-pilih", function(e) {
    e.preventDefault();
    let elClosesTr = $(this).parents('tr');
    let barang = datatable_barang.row(elClosesTr).data();

    $("[name=kode_barang]").val(barang.kode);
    $("#modal-barang").modal("hide");
    tambahKeranjang();
  })
</script>