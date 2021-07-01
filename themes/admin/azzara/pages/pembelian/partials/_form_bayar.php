<form action="<?= base_url("admin/pembelian/bayar"); ?>" id="form-pembelian" method="POST">
  <div class="modal-body">
    <div class="d-flex justify-content-between pb-2">
      <div class="col-md-6 pl-0">
        <h5 class="sub">Tanggal</h5>
        <input type="date" class="form-control" name="created_at" value="<?= date("Y-m-d"); ?>">
      </div>
      <div class="col-md-6 pr-0">
        <h5 class="sub">kode Transaksi</h5>
        <input type="text" class="form-control" readonly="" value="<?= $pembelian->getLastId("kode", "BL-" . date("Ymd") . "_"); ?>" name="kode" required="required" placeholder="(Opsional)">
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <h5 class="sub">Status Pembayaran</h5>
        <div class="flex-row form-check form-check-inline justify-content-left mx-0 pb-0 px-0">
          <div class="custom-control custom-radio mr-2 mr-md-3">
            <input type="radio" id="status1" name="status_bayar" class="custom-control-input" value="lunas" checked="">
            <label class="custom-control-label" for="status1">Lunas</label>
          </div>
          <div class="custom-control custom-radio mr-0">
            <input type="radio" id="status2" name="status_bayar" class="custom-control-input" value="kredit">
            <label class="custom-control-label" for="status2">Kredit</label>
          </div>
        </div>
      </div>
      <div class="col-6 d-none" id="form-jatuh_tempo">
        <div class="form-group ">
          <h5 class="sub">Jatuh Tempo</h5>
          <input type="date" name="jatuh_tempo" class="form-control" value="<?= date("Y-m-d"); ?>">
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-header collapsed" id="headingThree" data-toggle="collapse" data-target="#keterangan" aria-expanded="false" aria-controls="collapseThree" role="button">
            <div class="span-title">
              Keterangan <small class="pl-1 text-danger">*Opsional</small>
            </div>
          </div>
          <div id="keterangan" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
              <textarea class="form-control" name="keterangan" style="height:150px;" placeholder="misal : Belanja Stok Barang"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between mt-2 pb-2">
      <div class="col-md-6 pl-0">
        <h5 class="sub">Status Order</h5>
        <select class="form-control" name="status_order">
          <option value="" disabled="" selected="">- pilih status order -</option>
          <option value="Perjalanan">Dalam Perjalanan</option>
          <option value="Selesai">Selesai</option>
        </select>
      </div>
      <div class="col-md-6 pr-0">
        <h5 class="sub">Penginput</h5>
        <div class="input-group">
          <input type="text" class="form-control" name="user_input_id" readonly="" value="<?= $user->name; ?>">
        </div>
      </div>
    </div>

    <div class="row mt-2 pb-2">
      <div class="col-md-6 col-12">
        <h5 class="sub">Suplier <small class="pl-1 text-danger">*Opsional</small></h5>
        <div class="form-group px-0">
          <select class="form-control select2-hidden-accessible" style="width: 100%" id="suplier_id"></select>
        </div>
        <p style="color:red;margin-top:-10px"> * Jika status kredit harap pilih data supplier</p>
      </div>
      <div class="col-md-6 col-12">
        <h5 class="sub">Uang Bayar</h5>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">+</span>
          </div>
          <input type="hidden" name="jumlah_bayar">
          <input type="text" value="0" class="form-control rupiah form-control-lg font-weight-bold text-white px-1 px-md-2 bg-primary " id="jumlah_bayar">
        </div>
      </div>
    </div>
    <div class="row my-1 my-md-2">
      <div class="col-6 ">
        <h5 class="sub">Total Transaksi</h5>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">+</span>
          </div>
          <input type="hidden" name="total">
          <input type="text" value="0" class="form-control rupiah form-control-lg font-weight-bold px-1 px-md-2" id="GrandTotal" readonly="">
        </div>
      </div>
      <div class="col-6">
        <h5 class="sub">Kembalian</h5>
        <div class="input-group">
          <input hidden name="kembalian" value="0">
          <input readonly id="kembalian" class="form-control form-control-lg font-weight-bold rupiah text-danger font-weight-bold">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
    <button type="submit" class="btn btn-primary" id="prosesTransaksi">Save</button>
  </div>
</form>
<script>
  $(document).ready(function() {

    $("#suplier_id").select2({
      placeholder: "Pilih Suplier",
      allowClear: true,
      // minimumInputLength: 1,
      ajax: {
        url: baseUrl + "admin/suplier/data/datatable",
        processResults: function(data, params) {
          params.page = params.page || 1;
          return {
            results: data.data,
            pagination: {
              more: (params.page * 10) < data.recordsFiltered
            }
          };
        },
        data: function(params) {
          let query = {
            search: params.term,
            length: 10,
            page: params.page || 1
          }
          // Query parameters will be ?search=[term]&type=public
          return query;
        }
      },

    });
    $("#suplier_id").on('select2:select', function(e) {
      let data = e.params.data;
    });
    $("#form-pembelian").on("submit", function(e) {
      $("[name=total]").val() == "" ? $("[name=total]").val(0) : "";
      let total_bayar = AutoNumeric.getNumber('#GrandTotal');
      if (total_bayar < 1) {
        e.preventDefault
        alert("Jumlah Transaksi Kurang");
        return false;
      }

      let uang_bayar = AutoNumeric.getNumber('#jumlah_bayar');
      if ($("[name=status_bayar]:checked").val() == 'kredit' && uang_bayar > total_bayar) {
        $("#status1").prop('checked', true);
        $("#form-jatuh_tempo").addClass("d-none")
        e.preventDefault();
        $("#total_bayar").focus();
        return false;
      }

      let kembalian = AutoNumeric.getNumber('#kembalian');
      let status_bayar = $("[name=status_bayar]:checked").val();

      if (uang_bayar < total_bayar && status_bayar == "lunas") {
        e.preventDefault();
        alert("Uang Bayar Tidak Cukup");
        return false;
      }
    })
    $("[name=status_bayar]").on("change", function() {
      let val = $(this).val();
      if (val == "lunas")
        $("#form-jatuh_tempo").addClass("d-none")
      else
        $("#form-jatuh_tempo").removeClass("d-none")

    })
    $("#jumlah_bayar").on("input", function(e) {
      let uang_bayar = AutoNumeric.getNumber('#jumlah_bayar');
      let total_bayar = AutoNumeric.getNumber('#GrandTotal');
      $("[name=jumlah_bayar]").val(uang_bayar);
      if (total_bayar > 0 && uang_bayar >= total_bayar) {
        $("#form-jatuh_tempo").addClass("d-none")
        $("#status1").prop('checked', true);
      }
      let kembalian = AutoNumeric.getNumber('#jumlah_bayar') - AutoNumeric.getNumber('#GrandTotal');
      $("[name=kembalian]").val(kembalian);
      AutoNumeric.set('#kembalian', kembalian)
    });
    $("#status2").click(() => {
      let total_bayar = AutoNumeric.getNumber('#GrandTotal');
      let uang_bayar = AutoNumeric.getNumber('#jumlah_bayar');
      if (uang_bayar > total_bayar) {
        $("#status1").prop('checked', true);
        $("#total_bayar").focus();
        return false;
        $("#form-jatuh_tempo").addClass("d-none")
      }
      $("#form-jatuh_tempo").removeClass("d-none")
    })
  });
</script>