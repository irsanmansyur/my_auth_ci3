<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view($thema_load . "partials/_head.php"); ?>
</head>

<body>
  <div class="wrapper">
    <?php $this->load->view($thema_load . "partials/_main_header.php"); ?>
    <?php $this->load->view($thema_load . "partials/_sidebar.php"); ?>
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
                <a href="#">Daftar Stokout Barang</a>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-header  d-flex justify-content-between">
              <div class="card-title"><?= $page_title; ?></div>
              <a href="<?= base_url('admin/barang/stokout/tambah'); ?>" class="btn btn-primary">Tambah</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="datatabe-stock_out" class="table table-hover display table table-striped table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Barang</th>
                      <th scope="col">Stock Sebelumnya</th>
                      <th scope="col">Stock Out</th>
                      <th scope="col">Catatan</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <?php $this->load->view($thema_load . "partials/_footer.php"); ?>

      </div>
    </div>

    <!-- Custom template | don't include it in your project! -->
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>
    <!-- End Custom template -->
  </div>
  <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>
  <!-- Sweet Alert -->
  <script src="<?= $thema_folder; ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>
  <script>
    const baseurl = "<?= base_url() ?>";
    const dataTableStokcIn = $('#datatabe-stock_out').DataTable({
      "columnDefs": [{
        "width": "33px",
        className: 'dt-body-center text-center py-0 my-0',
        "targets": 0
      }],
      processing: true,
      "pageLength": 10,
      serverSide: true,
      "searching": true,
      "order": [
        [0, "desc"]
      ],
      ajax: {
        url: baseurl + "admin/barang/stokin/datatable",
        type: 'POST',
        "dataSrc": function(json) {
          return json.data.map(res => {
            res.action = `<a href="${baseUrl}admin/barang/stokout/edit/${res.id}" class="btn btn-success btn-sm rounded edit-satuan">Edit</a> || <a href="${baseUrl}admin/barang/stokout/delete/${res.id}" class="delete btn btn-danger btn-sm rounded">Delete</a>`;
            return res;
          })
        },
        'data': {
          // with: ['barang'],
          jenis: "stock_out"
        },
      },
      columns: [{
          data: 'urut',
          name: "created_at"
        },
        {
          data: 'nama_barang',
          name: 'barangs.nama'
        },
        {
          data: 'stock_awal',
          name: 'stock_awal'
        },
        {
          data: 'jumlah',
          name: 'jumlah'
        },
        {
          data: 'catatan',
          name: 'catatan'
        },
        {
          data: "action",
          orderable: false,
          searchable: false
        }
      ]
    });
  </script>
</body>

</html>