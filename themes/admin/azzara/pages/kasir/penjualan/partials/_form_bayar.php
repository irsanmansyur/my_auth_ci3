<div class="row">
  <div class="col-lg-4 col-md-12">
    <div class="card border border-primary">
      <div class="card-header text-white bg-primary">Informasi Pelanggan</div>
      <div class="card-body p-2">
        <form action="<?= base_url("kasir/keranjang/tambah"); ?>" method="POST">
          <div class="form-group p-0">
            <div class="d-flex justify-content-between">
              <label class="mb-0 mb-sm-2" for="selectPelanggan">Nama Pelanggan</label>
              <!-- <a id="newPelanggan" href="#">
                            <span class="text-primary link text-right"><span class="d-none d-md-inline">Tambah </span>Pelanggan ?</span>
                          </a> -->
            </div>
            <select endpoint="<?= base_url("api/user"); ?>" class="js-data-example-ajax form-control p-1" id="selectPelanggan" name="selectPelanggan"></select>
          </div>
          <div class="form-group  p-0">
            <label class="mb-0 mb-sm-2" for="emailPelanggan">Email</label>
            <input class="form-control  p-1" disabled id="emailPelanggan" name="emailPelanggan">
          </div>
          <div class="form-group  p-0">
            <label class="mb-0 mb-sm-2" for="no_hp">No HP/Telephone</label>
            <input class="form-control  p-1" disabled id="no_hp" name="no_hp">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="form-group py-0 ">
  <label class="mb-0 mb-sm-2" for="kasir">Kasir</label>
  <input class="form-control  p-1" value="<?= $user->name ?>" disabled id="kasir" name="kasir">
</div>
<div class="row">
  <div class="col-6">
    <div class="form-group py-0">
      <label class="mb-0 mb-sm-2" for="no_invoice">No Invoice/Nota</label>
      <input type="text" class="form-control p-1" id="no_invoice" name="no_invoice" value="<?= $penjualan->getLastId("no_invoice", "INV-" . date("Ymd") . "-"); ?>" readonly>
    </div>
  </div>
  <div class="col-6">
    <div class="form-group py-0 ">
      <label class="mb-0 mb-sm-2" for="tgl_invoice">Tanggal</label>
      <input type="date" class="form-control  p-1" value="<?= date("Y-m-d"); ?>" id="tgl_invoice" name="tgl_invoice">
    </div>
  </div>
</div>
<hr>
<input class="hidden" name="pelanggan_id" hidden>
<div class="form-group">
  <label class="sr-only" for="uangBayar">0</label>
  <div class="input-group mb-2">
    <div class="input-group-prepend">
      <div class="input-group-text">Rp.</div>
    </div>
    <input value="<?= set_value("uangBayar"); ?>" class="rupiah form-control form-control-lg text-right" name="uangBayar" min="0" placeholder="Rp. 00">
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="jumlah_bayar">Jumlah Bayar</label>
      <input type="text" class="form-control form-control-lg text-right" id="jumlah_bayar" value="" readonly name="jumlah_bayar">
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="kembalian">Kembalian</label>
      <input type="text" class="form-control form-control-lg text-right" id="kembalian" value="" readonly name="kembalian">
    </div>
  </div>
</div>