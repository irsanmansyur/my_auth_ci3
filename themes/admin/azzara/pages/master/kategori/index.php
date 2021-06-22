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
                <a href="<?= base_url('admin/dashboard'); ?>">
                  <i class="flaticon-home"></i>
                </a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item active">
                <a href="#">Master Kategori</a>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-header  d-flex justify-content-between">
              <div class="card-title"><?= $page_title; ?></div>
              <a href="<?= base_url('admin/kategori/tambah'); ?>" type="button" class="btn btn-primary tambah-kategori">Tambah</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="kategori-datatabe" class="table table-hover display table table-striped table-hover" endpoint="<?= base_url("admin/kategori/getData"); ?>">
                  <thead>
                    <tr>
                      <th scope="col">Kode</th>
                      <th scope="col">Nama</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
        <?php $this->load->view($thema_load . "partials/_footer.php"); ?>
      </div>
    </div>
    <?php $this->load->view($thema_load . "partials/_custom_templates.php"); ?>
  </div>
  <?php $this->load->view($thema_load . "partials/_js_files.php"); ?>

  <!-- Sweet Alert -->
  <script src="<?= $thema_folder; ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>
  <script>
    const dataTableDiagnosaPasien = $('#kategori-datatabe').DataTable({
      processing: true,
      serverSide: true,
      "searching": true,
      ajax: {
        url: $('#kategori-datatabe').attr('endpoint'),
        "dataSrc": function(json) {
          return json.data.map(res => {
            res.delete = ` <a href="${baseUrl}admin/kategori/edit/${res.id}" class="btn btn-success btn-sm rounded">Edit</a> || <a href="${baseUrl}admin/kategori/delete/${res.id}" class="delete btn btn-danger btn-sm rounded">Delete</a>`;
            return res;
          })
        }
      },
      columns: [{
          data: 'kode',
          name: 'kode'
        },

        {
          data: 'nama',
          name: 'nama'
        },
        {
          data: "delete",
          name: 'nama',
          orderable: false,
          searchable: false
        }
      ]
    });
  </script>
</body>

</html>