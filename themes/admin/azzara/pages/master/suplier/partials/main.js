const dataTableSatuan = $('#suplier-datatable').DataTable({
  processing: true,
  "pageLength": 10,
  serverSide: true,
  "searching": true,
  "order": [[0, "asc"]],
  ajax: {
    url: $('#suplier-datatable').attr('endpoint'),
    type: 'POST',
    "dataSrc": function (json) {
      return json.data.map((res) => {
        res.statusBadge = `<span class="badge badge-${res.status == "1" ? "success" : 'danger'}">${res.status == "1" ? "Aktif" : 'Tidak Aktif'}</span>`;
        res.action = ` <a type="button" href="${baseUrl}admin/suplier/edit/index/${res.id}" class="btn btn-success btn-sm rounded edit-suplier">Edit</a> || <a href="${baseUrl}admin/suplier/data/delete/${res.id}" class="delete btn btn-danger btn-sm rounded">Delete</a>`;
        return res;
      })
    }
  },
  columns: [{
    data: 'kode',
    name: 'kode'
  },

  {
    data: 'nama',
    name: 'nama'
  },
  {
    data: 'alamat',
    name: 'alamat'
  },
  {
    data: 'telp',
    name: 'telp'
  },
  {
    data: 'statusBadge',
    name: 'status'
  },
  {
    data: 'dibuat_pada',
    name: 'created_at'
  },
  {
    data: "action",
    name: 'action',
    orderable: false,
    searchable: false
  }
  ]
});