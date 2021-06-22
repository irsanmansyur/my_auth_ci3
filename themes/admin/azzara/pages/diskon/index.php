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
                <a href="#">Diskon</a>
              </li>
            </ul>
          </div>
          <div class="card" id="parentContent">
            <div class="card-header  d-flex justify-content-between">
              <div class="card-title"><?= $page_title; ?></div>
              <a href="<?= base_url('admin/diskon/tambah'); ?>" class="btn btn-primary tambah-diskon">Tambah</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="datatable-diskon" class="table table-hover display table table-striped table-hover" endpoint="<?= base_url("admin/diskon/datatable"); ?>">
                  <thead>
                    <tr>
                      <th scope="col" align="center">No.</th>
                      <th scope="col">Nama</th>
                      <th scope="col">Jumlah</th>
                      <th scope="col">Dibuat Pada</th>
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

  <div class="modal" tabindex="-1" role="dialog" id="modal-barang" data-id="">
    <div class="modal-dialog model-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pilih Barangs untuk Diskon <span class="diskon-name text-danger"></span></h5>
          <input type="hidden" name="diskon_id" hidden>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-1">

        </div>
      </div>
    </div>
  </div>
  <!-- Sweet Alert -->
  <script src="<?= $thema_folder; ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>
  <script>
    $(document).ready(function() {

      const datatable_diskon = $('#datatable-diskon').DataTable({
        "columnDefs": [{
          "width": "38px",
          className: 'dt-body-center text-center',
          "targets": 0
        }, {
          "width": "108px",
          className: 'dt-head-left dt-head-right',
          "targets": 2
        }],

        processing: true,
        "pageLength": 10,
        serverSide: true,
        "searching": true,
        "order": [
          [0, "asc"]
        ],
        ajax: {
          url: $('#datatable-diskon').attr('endpoint'),
          type: 'POST',
          "dataSrc": function(json) {
            return json.data.map((res) => {
              res.statusBadge = `<span class="badge badge-${res.status == "1" ? "success" : 'danger'}">${res.status == "1" ? "Aktif" : 'Tidak Aktif'}</span>`;
              res.action = `<button type="button" class="btn btn-primary btn-sm rounded btn-pilih-diskon" data-id="${res.id}" data-toggle="modal" data-target="#modal-barang"><i class="fas fa-box-open"></i></button> <a type="button" href="${baseUrl}admin/diskon/edit/${res.id}" class="btn btn-success btn-sm rounded edit-diskon"><i class='far fa-edit'></i></a>  <a href="${baseUrl}admin/diskon/delete/${res.id}" class="delete btn btn-danger btn-sm rounded"><i class='fas fa-trash'></i></a>`;
              return res;
            })
          }
        },
        columns: [{
            data: 'urut',
            name: 'id'
          },
          {
            data: 'name',
            name: 'name'
          },
          {
            data: 'nilai_diskon',
            name: 'value'
          },
          {
            data: 'dibuat_pada',
            name: 'created_at'
          },
          {
            data: "action",
            name: 'action',
            orderable: false,
            searchable: false
          }
        ]
      });

      $("#datatable-diskon").on("click", ".btn-pilih-diskon", function(e) {
        let data = datatable_diskon.row($(this).parents('tr')).data();
        $(".diskon-name").text(data.name);
        load_content_modal(data.id);
      })

      const load_content_modal = async (diskon_id) => {
        $("#modal-barang").find(".modal-body").html( /* html */ `<center><img src="/assets/img/loading.gif"/></center>`);
        $.get(baseUrl + `admin/diskon/load_datatable_barang/${diskon_id}`, function(data) {
          $("#modal-barang").find(".modal-body").html(data);
        });
      }
    });
  </script>
</body>

</html>