const dataTableSatuan = $('#barang-datatable').DataTable({
  "columnDefs": [{
    "width": "90px",
    className: 'dt-body-center text-center py-0 my-0',
    "targets": 0
  }],
  processing: true,
  "pageLength": 10,
  serverSide: true,
  "searching": true,
  "order": [[7, "DESC"]],
  ajax: {
    url: $('#barang-datatable').attr('endpoint'),
    type: 'POST'
  },
  columns: [{
    data: 'action',
    orderable: false,
  }, {
    data: 'kode',
    name: 'kode'
  },
  {
    data: 'nama',
    name: 'nama'
  },
  {
    data: 'harga_jual',
    name: 'harga_jual'
  },
  {
    data: 'harga_beli',
    name: 'harga_beli'
  },
  {
    data: 'stok',
    name: 'stok'
  },

  {
    data: 'tanggal_kadaluarsa',
    name: 'expired_at'
  },
  {
    data: 'dibuat_pada',
    name: 'created_at'
  }
  ]
});