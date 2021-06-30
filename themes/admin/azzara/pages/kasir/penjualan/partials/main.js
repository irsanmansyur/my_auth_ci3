$(document).ready(function () {
  $("#inputKode").select2({
    placeholder: "Input Kode",
    allowClear: true,
    minimumInputLength: 1,
    ajax: {
      url: baseUrl + "admin/barang/data/datatable",
      processResults: function (data, params) {
        params.page = params.page || 1;
        return {
          results: data.data,
          pagination: {
            more: (params.page * 10) < data.recordsFiltered
          }
        };
      },
      data: function (params) {
        let query = {
          search: params.term,
          stok: "ready",
          length: 8,
          page: params.page || 1
        }
        console.log(query);

        // Query parameters will be ?search=[term]&type=public
        return query;
      }
    },

  });
  $("#inputKode").on('select2:select', function (e) {
    let data = e.params.data;
    $("[name=kode_barang]").val(data.kode);
    $('#inputKode').val(null).trigger('change');
    tambahKeranjang();
  });
  $('#inputKode').select2('open');
  $(this).keydown(async function (e) {
    if (e.keyCode === 27) {
      e.preventDefault();
      $('#inputKode').select2('open');
    } else if (e.keyCode === 115) {
      e.preventDefault();
      await deleteBarangKeranjang();
      $('#inputKode').select2('open');
    } else if (e.keyCode === 119) {
      e.preventDefault();
      tampil_modal_bayar();
    }
  })




  $('#modalBayar').on('shown.bs.modal', function (e) {
    $("[name=uangBayar]").focus();
  })
});



$("form#submitBarang").on("submit", function (e) {
  e.preventDefault();
  tambahKeranjang();
});

const tambahKeranjang = async kodeBarang => {
  const elFormTambahKeranjang = document.querySelector("form#submitBarang");
  const elInputKode = elFormTambahKeranjang.querySelector("[name=kode_barang]");
  let formData = new FormData(elFormTambahKeranjang);
  for (let i in formData) {
    formData.append(i, formData[i])
  }

  const obj = document.createElement("audio");
  obj.src = `${baseUrl}assets/audio/beep.mp3`;
  obj.play();
  return fetch(elFormTambahKeranjang.getAttribute('action'), {
    method: "POST",
    body: formData
  })
    .then(res => res.json())
    .then(res => {
      if (!res.status)
        return swal(res.message, {
          buttons: {
            confirm: {
              className: 'btn btn-danger'
            }
          }
        }).then((Confirm) => {
        });
      dataTableKeranjang.ajax.reload();
      elInputKode.value = "";
    });

}

const dataTableKeranjang = $('#keranjang-datatable').DataTable({
  "columnDefs": [{
    "width": "20px",
    "targets": 0
  }, {
    "width": "20px",
    className: 'text-center',
    "targets": 1
  }],
  processing: true,
  "bPaginate": false,
  serverSide: true,
  "searching": false,
  "order": [[1, "DESC"]],
  ajax: {
    url: $('#keranjang-datatable').attr('endpoint'),
    type: 'POST',
    data: {
      "jenis": "keranjang kasir"
    },
    "dataSrc": function (json) {
      let JumlahBayar = 0;
      let data = json.data.map(res => {
        JumlahBayar += parseInt(res.jumlah_barang) * parseInt(res.harga_jual);
        return res;
      })
      setPembayaran(JumlahBayar);
      return data;
    }
  },
  columns: [
    {
      data: "delete",
      orderable: false,
    },
    {
      data: 'urut',
      name: 'created_at'
    },
    {
      data: 'nama_barang',
      name: 'barangs.nama'
    },
    {
      data: 'jumlahset',
      name: 'jumlah_barang'
    },
    {
      data: "total_detail",
      searchable: false
    },
  ]
});

// datatable keranjang event
$('#keranjang-datatable tbody').on('click', '.ubahJumlah', function (e) {
  let butt = $(this)[0];
  let data = dataTableKeranjang.row($(this).parents('tr')).data();
  (async () => {
    let url = "tambahi";
    if (butt.getAttribute("jenis") === "kurang") {
      url = "kurangi";
    }
    if (butt.getAttribute("jenis") !== "delete") {
      let res = await fetch(baseUrl + `kasir/keranjang/${url}/${data.id}`, { method: "POST" }).then(res => res.json());
      if (typeof res.status != "undefined" && res.status == false)
        return swal(res.message, "", "error");
      dataTableKeranjang.ajax.reload();
    } else {
      deleteBarangKeranjang(data.id);
    }
  })();
});
$('#keranjang-datatable tbody').on('change', '.jumlah_val', function (e) {
  let el_input = $(this)[0];
  let data = dataTableKeranjang.row($(this).parents('tr')).data();

  (async () => {
    let jumlah = parseInt(el_input.value);
    if (jumlah > 0) {
      let res = await fetch(baseUrl + `kasir/keranjang/ubah/${data.id}/${jumlah}`, { method: "POST" }).then(res => res.json());
      if (typeof res.status != "undefined" && res.status == false) {
        el_input.value = data.jumlah_barang;
        return swal(res.message, "", "error");
      }
      dataTableKeranjang.ajax.reload();
    }
    el_input.value = data.jumlah_barang;
  })();
});

const deleteBarangKeranjang = async (idKeranjang = null) => {
  await swal({
    title: 'yakin?',
    text: idKeranjang ? "akan Menghapus!" : "Menghapus Semua.!",
    type: 'warning',
    buttons: {
      cancel: {
        visible: true,
        text: 'No, cancel!',
        className: 'btn btn-success'
      },
      confirm: {
        text: 'Yes, delete it!',
        className: 'btn btn-danger'
      }
    }
  }).then(async (willDelete) => {
    if (willDelete) {
      let res = await fetch(baseUrl + "kasir/keranjang/delete/" + idKeranjang, {
        method: "post"
      }).then(res => res.json());
      if (res.status) {
        await dataTableKeranjang.ajax.reload();
      }
    }
  });
}



const elModalBayar = document.querySelector("#modalBayar");

const elBtnModal = document.querySelector("#btnBayar");
elBtnModal.addEventListener("click", function (e) {
  $("#modalBayar").modal("show");
})


const setPembayaran = (jumlahBayar = null) => {
  let elFormModal = elModalBayar.querySelector("form"),
    elInputBayar = elFormModal.querySelector("[name=uangBayar]"),
    elButtonBayar = elFormModal.querySelector("[name=bayar]"),
    elKembalian = elFormModal.querySelector("[name=kembalian]"),
    elJumlahBayar = elFormModal.querySelector("[name=jumlah_bayar]");

  if (jumlahBayar !== null) {
    elJumlahBayar.value = formatRupiah(jumlahBayar, "Rp. ");
    $("#jumlah_bayar_text").val(formatRupiah(jumlahBayar, "Rp. "))
  }

  let bayar = toDecimal(elInputBayar.value);
  let jumlah = toDecimal(elJumlahBayar.value);


  if (bayar >= jumlah && jumlah > 0) {
    elKembalian.value = formatRupiah(bayar - jumlah, "Rp. ");
    elButtonBayar.disabled = false;
  } else {
    elKembalian.value = "-" + formatRupiah(bayar - jumlah, "Rp. ");
    elButtonBayar.disabled = true;
  }
  if ($("[name=status_bayar]:checked").val() == 'kredit') {
    if (jumlah < bayar) {
      $("#status1").prop('checked', true);
      $("[name=uangBayar]").focus();
    }
    if (jumlah > 0)
      elButtonBayar.disabled = false;
  }
}

const toDecimal = (rupiahFormat) => {
  rupiahFormat = (rupiahFormat + "").replace(/[^\d.-]/g, '');
  let splitBelakangKoma = rupiahFormat.split(","),
    splitAngka = splitBelakangKoma[0].split(".");
  let number = splitAngka.reduce((a, b) => a + b);
  let sisa = (typeof splitBelakangKoma[1] === 'undefined' ? '' : "," + splitBelakangKoma[1]);
  let hasil = number + sisa;
  return parseInt((hasil == "" ? 0 : hasil));
}
function formatRupiah(angka, prefix) {
  angka += "";
  var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split = number_string.split(','),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }

  rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
  return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
}
let rupiahs = document.querySelectorAll(".rupiah");
rupiahs.forEach(rup => {
  rup.addEventListener("keyup", function (e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    let tmpil = formatRupiah(this.value, "Rp. ");
    setPembayaran();
    rup.value = tmpil;
  });
})