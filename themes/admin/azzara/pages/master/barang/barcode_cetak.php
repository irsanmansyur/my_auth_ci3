<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view($thema_load . "partials/_head.php"); ?>
  <link rel="stylesheet" href="<?= base_url("assets/vendor/select2/css/select2.min.css"); ?>">
</head>

<body>
  <div class="wrapper">
    <?php $this->load->view($thema_load . "partials/_main_header.php"); ?>
    <?php $this->load->view($thema_load . "partials/_sidebar.php"); ?>

    <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>

    <div class="main-panel">
      <div class="content">
        <div class="page-inner">
          <h1>Cetak Barcode</h1>
          <hr>
          <div class="row">
            <div class="col-12 col-lg-6">
              <div class="card card-body">
                <div class="d-flex justify-content-between">
                  <h3>Pilih Produk</h3>
                  <button class="btn btn-success btn-lg mb-3" data-toggle="modal" data-target="#modal-barang">
                    <i class="fa fa-search"></i></i> Cari Produk
                  </button>
                </div>
                <div class="table-responsive border-top pt-2">
                  <?php $this->load->view($thema_load . "pages/master/keranjang/partials/_datatable_barang_barcode"); ?>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="card">
                <div class="card-body">
                  <h3 class="title-card">Cetak Barcode</h3>
                  <hr>
                  <div id="list-print">

                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <?php $this->load->view($thema_load . "partials/_footer.php"); ?>
      </div>
    </div>

    <!-- Modal Brang -->
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Barang Modal" aria-hidden="true" id="modal-barang">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="card card-body">
            <?php $this->load->view($thema_load . "pages/master/barang/partials/_datatable_pilih_barang"); ?>
          </div>
        </div>
      </div>
    </div>


    <!-- Custom template | don't include it in your project! -->
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>
    <!-- End Custom template -->
  </div>

  <script>
    $("#datatable-pilih_barang").on('click', ".btn-pilih", function(e) {
      const obj = document.createElement("audio");
      obj.src = `${baseUrl}assets/audio/beep.mp3`;
      obj.play();
      $("#modal-barang").modal("hide");
      let barang = datatable_pilih_barang.row($(this).parents('tr')).data();
      tambah_keranjang(barang);
    })
    $("#datatable-barang_barcode").on('click', ".btn-hapus", function(e) {
      $("#modal-barang").modal("hide");
      let keranjang = datatable_barang_barcode.row($(this).parents('tr')).data();
      hapus_keranjang(keranjang.id);
    })
    datatable_barang_barcode.on('xhr.dt', function(e, settings, json, xhr) {
      load_list();
    })

    function load_list() {
      $.ajax({
        url: baseUrl + `admin/barang/barcode/list`,
        success: function(html) {
          $("#list-print").html(html);
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

    function tambah_keranjang(barang) {
      $.ajax({
        url: baseUrl + `admin/barang/keranjang/tambah`,
        type: "POST",
        data: {
          "barang_id": barang.id,
          "jenis": "cetak barcode"
        },
        success: function(res) {
          if (res.status) {
            return datatable_barang_barcode.ajax.reload();
          }
          alert(res.message)
        },
        'error': function(xmlhttprequest, textstatus, message) {
          if (textstatus === "timeout") {
            alert("request timeout");
          } else {
            alert("request timeout");
          }
        }
      });
    }

    function hapus_keranjang(keranjang_id = "semua") {
      $.ajax({
        url: baseUrl + `admin/barang/keranjang/hapus/${keranjang_id}`,
        type: "DELETE",
        data: {
          "keranjang_id": keranjang_id,
          "jenis": "cetak barcode"
        },
        success: function(res) {
          if (res.status) {
            return datatable_barang_barcode.ajax.reload();
          }
          alert(res.message)
        },
        'error': function(xmlhttprequest, textstatus, message) {
          if (textstatus === "timeout") {
            alert("request timeout");
          } else {
            alert("request timeout");
          }
        }
      });
    }
  </script>
</body>

</html>