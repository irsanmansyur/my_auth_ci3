<table id="datatable-keranjang_barang_barcode" class="table table-hover display table table-striped table-hover w-100">
  <thead>
    <tr>
      <th scope="col" width="20px"></th>
      <th scope="col">#</th>
      <th scope="col">Kode</th>
      <th scope="col">Nama Barang</th>
      <th scope="col" style="min-width: 70px!important;">Jumlah</th>
      <th scope="col" class="text-left" style="text-align:left">Total</th>
    </tr>
  </thead>
</table>


<script>
  const datatable_keranjang_barang_barcode = $("#datatable-keranjang_barang_barcode").DataTable({
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
        "pilih_barang": "yes",
        "jenis" => 
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
</script>