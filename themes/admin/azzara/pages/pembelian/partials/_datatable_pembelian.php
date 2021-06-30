<div class="table-responsive">
  <table id="datatable-pembelian" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th></th>
        <th>#</th>
        <th>Kode Pembelian</th>
        <th>Status Order</th>
        <th>Status Bayar</th>
        <th>Total</th>
        <th>Jumlah Bayar</th>
        <th>Kembalian</th>
      </tr>
    </thead>
  </table>
</div>
<div class="modal fade" role="dialog" aria-labelledby="Modal Bayar" aria-hidden="true" id="modal-details">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-check"></i> Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="card-header">
        <?php $this->load->view($thema_load . "pages/pembelian/partials/_details_pembelian"); ?>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    const datatable_pembelian = $('#datatable-pembelian').DataTable({
      "columnDefs": [{
        "width": "33px",
        className: 'dt-body-center text-center py-0 my-0',
        "targets": [0, 1]
      }],
      processing: true,
      "pageLength": 10,
      serverSide: true,
      "searching": true,
      "order": [
        [1, "desc"]
      ],
      ajax: {
        url: baseUrl + "admin/pembelian/data/datatable",
        type: 'POST',
      },
      columns: [{
          data: 'action',
          orderable: false
        }, {
          data: 'urut',
          name: "created_at"
        },
        {
          data: 'kode',
          name: 'kode'
        },
        {
          data: 'status_order',
          name: "status_order"
        },
        {
          data: 'status_bayar',
          name: 'status_bayar'
        },
        {
          data: 'total_rp',
          name: 'total'
        },
        {
          data: 'jumlah_bayar_rp',
          name: 'jumlah_bayar'
        },
        {
          data: 'kembalian_rp',
          name: 'kembalian'
        }
      ]
    });
    $('#datatable-pembelian').on('click', ".btn-detail", function(e) {
      e.preventDefault();
      let elClosesTr = $(this).parents('tr');
      let pembelian = datatable_pembelian.row(elClosesTr).data();
      show_details(pembelian);
    })
  });

  function show_details(pembelian) {
    $.ajax({
      url: baseUrl + `admin/pembelian/data/details/${pembelian.id}`,
      success: function(html) {
        $("#modal-details").find(".card-header").html(html)
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