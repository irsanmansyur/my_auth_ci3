<div class="table-responsive">
  <table id="datatable-barang" data-diskon_id="<?= $diskon->id; ?>" class="w-100">
    <thead>
      <tr>
        <th scope="col" align="center">No.</th>
        <th scope="col">Nama</th>
        <th scope="col">Stok</th>
        <th scope="col">Harga jual</th>
        <th scope="col">Status</th>
        <th scope="col"></th>
      </tr>
    </thead>
  </table>
</div>
<script>
  $(document).ready(function() {
    const datatable_barang = $("#datatable-barang").DataTable({
      "dom": '<"row"<"col-6"l><"col-6"f>><"clear">rt<"bottom"i><"clear">p',
      columns: [{
          data: 'urut',
          name: 'id'
        },
        {
          data: 'nama',
          name: 'nama'
        },
        {
          data: 'stok',
          name: 'stok'
        },
        {
          data: 'harga_jual',
          name: 'harga_jual'
        },
        {
          data: 'status',
          orderable: false
        },
        {
          data: 'action',
          orderable: false
        }
      ],
      "columnDefs": [{
        "width": "38px",
        className: 'dt-body-center text-center',
        "targets": [0, 2]
      }, {
        "width": "108px",
        className: 'dt-head-left dt-head-right',
        "targets": 2
      }],
      processing: true,
      "pageLength": 10,
      serverSide: true,
      "searching": true,
      "order": [
        [0, "asc"]
      ],
      ajax: {
        url: baseUrl + "admin/diskon/barang/" + $("#datatable-barang").data("diskon_id"),
        type: 'POST'
      },
    });
    $("#datatable-barang").on("click", ".btn-pilih-barang,.btn-hapus-barang", async function(e) {
      let data = $("#datatable-barang").DataTable().row($(this).parents('tr')).data();
      let me = $(this)[0];
      me.disabled = true;
      const htmlDefault = me.innerHTML;
      me.innerHTML = `<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>`;
      await fetch(baseUrl + `admin/diskon/set_barang_diskon/${data.diskon_id}/${data.id}/` + me.getAttribute("tipe"));
      $("#datatable-barang").DataTable().ajax.reload();
    })
  })
</script>