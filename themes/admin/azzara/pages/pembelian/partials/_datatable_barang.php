<table id="datatable-keranjang_pembelian" class="table table-hover display table table-striped table-hover w-100">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"></th>
      <th scope="col">Nama</th>
      <th scope="col"></th>
      <th scope="col">Jumlah</th>
      <th scope="col">Total</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<script>
  const datatable_keranjang = $("#datatable-keranjang_pembelian").DataTable({
    "columnDefs": [{
      "width": "33px",
      className: 'dt-body-center text-center py-0 my-0',
      "targets": [0, 1]
    }, {
      "width": "30%",
      className: 'dt-body-center text-center py-0 my-0',
      "targets": 3
    }],
    processing: true,
    "pageLength": 10,
    serverSide: true,
    "searching": true,
    "order": [
      [0, "desc"]
    ],
    ajax: {
      url: baseUrl + "admin/pembelian/keranjang/datatable",
      type: 'POST',
      dataSrc: function(data) {
        $("[name=total]").val(data.total_belanja);
        AutoNumeric.set('#total', data.total_belanja);
        AutoNumeric.set('#GrandTotal', data.total_belanja);
        return data.data;
      }
    },
    columns: [{
        data: 'urut',
        name: "created_at"
      }, {
        data: 'delete',
        orderable: false
      },
      {
        data: 'nama_barang',
        name: 'barangs.nama'
      },
      {
        data: 'action',
        orderable: false
      },
      {
        data: 'jumlahset',
        name: 'jumlah'
      },
      {
        data: 'total_harga',
        name: '(keranjang_pembelian.harga_beli*jumlah)'
      }
    ],
    "drawCallback": function(settings) {
      applyAutoNumeric();
    },
  });
  datatable_keranjang.on('xhr.dt', function(e, settings, json, xhr) {
    applyAutoNumeric();
  })


  function applyAutoNumeric() {
    $('input.rupiah:not([type=number])').each(function(i, obj) {
      if (AutoNumeric.getAutoNumericElement(obj))
        return;
      var options = {
        currencySymbol: 'Rp ',
        decimalCharacter: ',',
        digitGroupSeparator: '.',
        decimalPlaces: 0
      }
      new AutoNumeric(obj, options);
    });
  }
  // event
  $("#datatable-keranjang_pembelian").on("change", "[name=jumlah],[name=harga_jual],[name=harga_beli]", function(e) {
    e.preventDefault();
    let elClosesTr = $(this).parents('tr');
    changeKeranjang(elClosesTr);
  })
  $("#datatable-keranjang_pembelian").on("click", ".ubahJumlah", function(e) {
    e.preventDefault();
    ubahJumlahBarang($(this))
  })

  function ubahJumlahBarang(elUbah) {
    let elClosesTr = elUbah.parents("tr");
    let elJumlah = elClosesTr.find("[name=jumlah]");
    if (elUbah.attr("jenis") == "delete") {
      let keranjang = datatable_keranjang.row(elClosesTr).data();
      return deleteKeranjang(keranjang.id);
    } else if (elUbah.attr("jenis") == "kurang")
      elJumlah.val(parseInt(elJumlah.val()) - 1);
    else elJumlah.val(parseInt(elJumlah.val()) + 1);
    changeKeranjang(elClosesTr)
  }

  function deleteKeranjang(id_keranjang = null) {
    $("[name=total]").val(0);
    AutoNumeric.set('#total', 0);
    AutoNumeric.set('#GrandTotal', 0);
    return $.ajax({
      url: baseUrl + `admin/pembelian/keranjang/delete/${id_keranjang}`,
      type: 'DELETE',
      success: function(result) {
        datatable_keranjang.ajax.reload();
      }
    });
  }

  function changeKeranjang(elClosesTr) {
    let keranjang = datatable_keranjang.row(elClosesTr).data();
    let elTR = elClosesTr[0];
    if (elTR.querySelector('[name=jumlah]').value < 1) {
      alert("Jumlah Barang Minimal 1");
      elTR.querySelector('[name=jumlah]').value = 1;
      return elTR.querySelector('[name=jumlah]').focus();
    }
    $.ajax({
      type: "POST",
      url: baseUrl + "admin/pembelian/keranjang/ubah/" + keranjang.id,
      data: {
        harga_beli: AutoNumeric.getNumber(elTR.querySelector('[name=harga_beli]')),
        harga_jual: AutoNumeric.getNumber(elTR.querySelector('[name=harga_jual]')),
        jumlah: elTR.querySelector('[name=jumlah]').value
      },
      success: function(res) {
        if (!res.status)
          alert(res.message)
        datatable_keranjang.ajax.reload();
      },
    });
  }
</script>