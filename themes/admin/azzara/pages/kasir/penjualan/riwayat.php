<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view($thema_load . "partials/_head.php"); ?>
  <link rel="stylesheet" href="<?= base_url("dist/css/app.css?" . time()); ?>">
</head>

<body endpoint="<?= base_url(); ?>">
  <div class="wrapper">

    <?php $this->load->view($thema_load . "partials/_main_header.php"); ?>
    <?php $this->load->view($thema_load . "partials/_sidebar.php"); ?>
    <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>

    <div class="main-panel">
      <div class="content">
        <div class="page-inner">
          <div class="page-header">
            <h4 class="page-title"><?= $page_title; ?></h4>
            <ul class="breadcrumbs">
              <li class="nav-home">
                <a href="<?= base_url(); ?>">
                  <i class="flaticon-home"></i>
                </a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <a href=<?= base_url('dashboard'); ?>>Dashboard</a>
              </li>

              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">Riwayat Pesanan</a>
              </li>
            </ul>
          </div>

          <div class="card" id="parentContent">
            <div class="card-header  d-flex justify-content-between">
              <div class="card-title"><?= $page_title; ?></div>
            </div>
            <div class="card-body">
              <div id="filter-riwayat">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Mulai Tanggal</label>
                      <div class="input-group">
                        <input type="date" class="form-control" id="mulai_tanggal" name="mulai_tanggal">
                        <div class="input-group-append">
                          <span class="input-group-text">
                            <i class="fa fa-calendar"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Sampai Tanggal</label>
                      <div class="input-group">
                        <input type="date" class="form-control" id="sampai_tanggal" name="sampai_tanggal">
                        <div class="input-group-append">
                          <span class="input-group-text">
                            <i class="fa fa-calendar-check"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <table id="datatable-riwayat-penjualan" class="table table-striped table-bordered table-hover" style="width:100%" endpoint="<?= base_url("kasir/penjualan/datatable"); ?>">
                  <thead>
                    <tr>
                      <th scope="col"></th>
                      <th scope="col">#</th>
                      <th scope="col">Invoice</th>
                      <th scope="col">Nama Pelanggan</th>
                      <th scope="col">Uang Bayar</th>
                      <th scope="col">Jumlah Bayar</th>
                      <th scope="col">Kembalian</th>
                      <th scope="col">Dibuat Pada</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>
  </div>
  <div class="modal fade bd-example-modal-lg" id="details-penjualan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="details-penjualan-label text-center">DETAILS PESANAN</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        </div>
      </div>
    </div>
  </div>
  <script>
    const dataTableRiwayat = $('#datatable-riwayat-penjualan').DataTable({
      "columnDefs": [{
        "width": "90px",
        className: 'dt-body-center text-center py-0 my-0',
        "targets": 0
      }],
      processing: true,
      "pageLength": 10,
      serverSide: true,
      "searching": true,
      "order": [
        [1, "DESC"]
      ],
      ajax: {
        url: $('#datatable-riwayat-penjualan').attr('endpoint'),
        type: 'POST',
        data: function(params) {
          params.jenis = "Kasir";
          params.mulai_tanggal = $('[name=mulai_tanggal]').val();
          params.sampai_tanggal = $('[name=sampai_tanggal]').val();
        }
      },
      columns: [{
          data: 'action',
          orderable: false,
        }, {
          data: 'urut',
          name: 'created_at'
        }, {
          data: 'no_invoice',
          name: 'no_invoice'
        },
        {
          data: 'nama_pelanggan',
          name: 'users.name'
        },
        {
          data: 'jumlah_bayar',
          name: 'jumlah_bayar'
        },
        {
          data: 'uang_bayar',
          name: 'uang_bayar'
        },
        {
          data: 'kembalian',
          name: 'kembalian'
        },
        {
          data: 'dibuat_pada',
          name: 'created_at'
        }
      ]
    });
    $('[name=mulai_tanggal],[name=sampai_tanggal]').on("change", function(e) {
      dataTableRiwayat.ajax.reload();
    });
    $('#datatable-riwayat-penjualan tbody').on('click', 'tr td .details-control', function(e) {
      e.preventDefault();
      let tr = $(this).closest('tr');
      let penjualan = dataTableRiwayat.row(tr).data();
      $.get(baseUrl + `kasir/penjualan/details/${penjualan.id}`, function(res) {
        $(".modal#details-penjualan .modal-body").html(res);
        $(".modal#details-penjualan").modal('show');
      })
    });
  </script>

</body>

</html>