<div class="form-group">
  <label for="pilih_barang">Pilih Nama Barang</label>
  <select class="js-data-example-ajax form-control p-1" id="pilih_barang" name="pilih_barang">
    <?php if ($restok->barang_id) : ?>
      <option value="<?= $restok->barang_id; ?>" selected><?= $restok->barang->nama; ?></option>
    <?php endif; ?>
  </select>
</div>

<div class="form-group form-group-default">
  <label for="nama">Nama barang</label>
  <input class="form-control" id="barang_id" hidden name="barang_id" readonly value="<?= $restok->barang_id ?>" />
  <input class="form-control" id="nama" readonly value="<?= $restok->barang_id ? $restok->barang->nama : ''; ?>" />
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="satuan">Satuan</label>
      <input class="form-control" id="satuan" readonly value="<?= $restok->barang_id ? $restok->barang->satuan->nama : ''; ?>" />
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="stock_awal">Stok Barang</label>
      <input class="form-control" name="stock_awal" id="stock_awal" readonly value="<?= $restok->barang_id ? $restok->barang->stok : ''; ?>" />
      <?= form_error('stock_awal', '<small class="text-danger">', '</small>'); ?>

    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="suplier_id_" class="mb-2">Suplier</label>
      <input type="hidden" name="jenis" id="jenis" hidden value="<?= $restok->jenis; ?>">
      <input type="hidden" name="suplier_id" id="suplier_id" hidden value="<?= $restok->suplier_id; ?>">
      <select class="js-data-example-ajax form-control p-1" id="suplier_id_" name="suplier_id_">
        <?php if ($restok->suplier_id) : ?>
          <option value="<?= $restok->suplier_id; ?>" selected><?= $restok->suplier->nama; ?></option>
        <?php else : ?>
          <option value="" selected disabled>-Pilih Suplier-</option>
        <?php endif; ?>
      </select>
      <?= form_error('suplier_id', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group form-group-default">
      <label for="jumlah">Stok Tambah</label>
      <input class="form-control" value="<?= $restok->jumlah; ?>" type="number" name="jumlah" id="jumlah" />
      <?= form_error('jumlah', '<small class="text-danger">', '</small>'); ?>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    $("#pilih_barang").select2({
      ajax: {
        url: baseUrl + "admin/barang/data/datatable",
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
            with: "satuan",
            page: params.page || 1
          }
          // Query parameters will be ?search=[term]&type=public
          return query;
        }
      }

    });

    $("#pilih_barang").on('select2:select', function(e) {
      let barang = e.params.data;
      set_barang(barang)
    });

    $("#suplier_id_").select2({
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
            page: params.page || 1
          }
          // Query parameters will be ?search=[term]&type=public
          return query;
        }
      }
    });
    $('#suplier_id_').on('select2:select', function(e) {
      let suplier = e.params.data;
      $("#suplier_id").val(suplier.id);
    });

    let suplier_id = $("#suplier_id").val();
    if (suplier_id)
      $('#suplier_id_').val(suplier_id).change();

    function set_barang(barang) {
      $("#nama").val(barang.nama);
      $("#barang_id").val(barang.id);
      $("#satuan").val(barang.satuan.nama);
      $("#stock_awal").val(barang.stok);
    }
  });
</script>