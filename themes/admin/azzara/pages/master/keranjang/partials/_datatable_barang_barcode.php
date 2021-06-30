<table id="datatable-barang_barcode" class="table table-hover display table table-striped table-hover w-100">
  <thead>
    <tr>
      <th scope="col" width="20px"></th>
      <th scope="col">#</th>
      <th scope="col">Kode</th>
      <th scope="col">Nama Barang</th>
      <th scope="col" style="min-width: 30px!important;">Jumlah</th>
    </tr>
  </thead>
</table>


<script>
  const datatable_barang_barcode = $("#datatable-barang_barcode").DataTable({
    "columnDefs": [{
      "width": "30px",
      "targets": 0
    }, {
      "width": "15px",
      className: 'dt-body-center text-center py-0 my-0',
      "targets": 1
    }],
    processing: true,
    "pageLength": 10,
    serverSide: true,
    "searching": true,
    "order": [
      [1, "desc"]
    ],
    ajax: {
      url: baseUrl + "admin/barang/keranjang/datatable",
      type: 'POST',
      data: {
        "jenis": "cetak barcode"
      }
    },
    columns: [{
        data: 'action',
        orderable: false
      }, {
        data: 'urut',
        name: "created_at"
      },
      {
        data: 'kode',
        name: "barangs.kode"
      }, {
        data: 'nama',
        name: 'barangs.nama'
      },
      {
        data: 'jumlah_barang',
        name: "jumlah_barang"
      }
    ],
  });
  $("#datatable-barang_barcode").on("change", ".jumlah_barang", function(e) {
    e.preventDefault();
    ubah_keranjang($(this));
  })
  $("#datatable-barang_barcode").on("click", ".ubahJumlah", function(e) {
    let elUbah = $(this).parents('tr').find(".jumlah_barang");
    if ($(this).attr("jenis") == "tambah")
      elUbah.val(parseInt(elUbah.val()) + 1);
    else
      elUbah.val(parseInt(elUbah.val()) - 1);
    ubah_keranjang(elUbah);
  })

  function ubah_keranjang(elUbah) {
    let keranjang = datatable_barang_barcode.row(elUbah.parents('tr')).data();
    let jumlah = parseInt(elUbah.val());
    if (jumlah < 1) {
      alert("jumlah minimal 1");
      return elUbah.val(1);
    }
    $.ajax({
      url: baseUrl + `admin/barang/keranjang/ubah`,
      type: "PUT",
      data: {
        "jumlah": jumlah,
        "jenis": "cetak barcode",
        "id_keranjang": keranjang.id
      },
      success: function(res) {
        if (res.status)
          datatable_barang_barcode.ajax.reload();
        else {
          elUbah.val(res.jumlah)
          alert(res.message)
        }
      },
      'error': function(xmlhttprequest, textstatus, message) {
        if (textstatus === "timeout") {
          alert(message);
        } else {
          alert(message);
        }
      }
    });
  }
</script>