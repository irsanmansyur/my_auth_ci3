const dataTableSatuan = $('#satuan-datatabe').DataTable({
  processing: true,
  "pageLength": 10,
  serverSide: true,
  "searching": true,
  "order": [[0, "asc"]],
  ajax: {
    url: $('#satuan-datatabe').attr('endpoint'),
    type: 'POST',
    "dataSrc": function (json) {
      return json.data.map(res => {
        res.delete = ` <button type="button" data-id="${res.id}" data-toggle="modal" data-target=".modal.satuan" endpoint="${baseUrl}admin/satuan/edit/${res.id}" class="btn btn-success btn-sm rounded edit-satuan">Edit</button> || <a href="${baseUrl}admin/satuan/delete/${res.id}" class="delete btn btn-danger btn-sm rounded">Delete</a>`;
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
const elFromModal = document.querySelector("form.modal-content");
elFromModal.addEventListener("submit", async function (e) {
  e.preventDefault();
  const formdata = new FormData(elFromModal);
  let res = await fetch(elFromModal.getAttribute("action"), headers({
    method: 'POST',
    body: formdata,
    redirect: 'follow'
  }))
    .then(response => response.json())
    .catch(error => console.log('error', error));
  setErrorsElement(res.errors ?? false)
  createAlert(res)
  if (res.status) {
    swal(res.message, {
      buttons: {
        confirm: {
          className: 'btn btn-success'
        }
      }
    }).then(res => {
      $(".modal").modal('hide')
    });
    dataTableSatuan.ajax.reload()
  }
});
const createAlert = ({ message, status }) => {
  let alertMes = elFromModal.querySelector(".alert-satuan");
  if (!status)
    return alertMes.innerHTML = `
    <div class="alert alert-warning alert-dismissible show" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
      <div class="message">${message ?? ''}</div>
    </div > `;
  return alertMes.innerHTML = '';
}
const setInputSatuan = async ({ urlAction, textTitle, textSubmit, ...props }) => {
  elFromModal.querySelector("[type=submit]").disabled = true;
  elFromModal.setAttribute("action", urlAction ?? baseUrl);
  elFromModal.querySelector(".modal-title").textContent = textTitle ?? 'Tambah Data Master';
  elFromModal.querySelector("[type=submit]").textContent = textSubmit ?? "Tambahkan";
  let inHTML = elFromModal.querySelector(".modal-body").innerHTML;
  elFromModal.querySelector(".modal-body").innerHTML = '';
  let satuan = await fetch(baseUrl + "admin/satuan/show" + (props.id ? "/" + props.id : ''), headers()).then(res => res.json());
  elFromModal.querySelector(".modal-body").innerHTML = inHTML;
  elFromModal.querySelector("[type=submit]").disabled = false;
  let elNama = elFromModal.querySelector("[name='nama']");
  let elKode = elFromModal.querySelector("[name='kode']");
  elNama.value = satuan.nama ?? '';
  elKode.value = satuan.kode ?? '';
};
const setErrorsElement = (errors) => {
  elFromModal.querySelectorAll("input[name]").forEach(erEl => {
    erEl.classList.contains("is-invalid") && erEl.classList.remove("is-invalid");
    erMes = erEl.nextElementSibling
    if (erMes && erMes.classList.contains("text-danger")) {
      erMes.remove();
    }
  })
  if (errors)
    for (let e in errors) {
      let elError = elFromModal.querySelector(`[name = "${e}"]`);
      elError && elError.classList.add("is-invalid");

      /* Typical Creation and Setup A New Orphaned Element Object */
      let erMes = document.createElement('span');
      erMes.textContent = errors[e];
      erMes.className = 'text-danger d-block text-sm';
      elError && erMes.appendAfter(elError);
    }
}

const elTambah = document.querySelector(".tambah-satuan");
const elTableData = document.querySelector("table");


elTambah.addEventListener("click", async function (e) {
  let urlAction = elTambah.getAttribute("endpoint");
  let data = { urlAction, textTitle: "Tambah Master Satuan", textSubmit: "Tambahkan" }
  setInputSatuan(data);

})
$('.modal.satuan').on('hidden.bs.modal', function (e) {
  setErrorsElement(false)
  createAlert({ message: '', status: true })
})

elTableData.addEventListener("click", async function (e) {
  if (e.target.classList.contains("edit-satuan")) {
    let elSatuan = e.target;
    let id = elSatuan.dataset.id;
    let urlAction = elSatuan.getAttribute("endpoint");
    let data = { id, urlAction, textTitle: "Edit Master Satuan", textSubmit: "Edit" }
    setInputSatuan(data);
  }
})