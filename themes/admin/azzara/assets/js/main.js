document.addEventListener("click", function (e) {
  let me = e.target;
  const del = me.classList.contains(".delete") ? me : (me.closest(".delete") ?? null);
  if (del) {
    e.preventDefault();
    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      buttons: {
        cancel: {
          visible: true,
          text: 'No, cancel!',
          className: 'btn btn-danger'
        },
        confirm: {
          text: 'Yes, delete it!',
          className: 'btn btn-success'
        }
      }
    }).then(async (willDelete) => {
      if (willDelete) {
        let res = await fetch(del.getAttribute('href'), {
          method: "delete"
        }).then(res => res);
        if (res) {
          del.closest("tr").remove();
          swal("Success  deleted!", {
            buttons: {
              confirm: {
                className: 'btn btn-success'
              }
            }
          });
          if (typeof dataTableDiagnosaPasien !== 'undefined') dataTableDiagnosaPasien.ajax.reload();
        }
      }
    });
  }
});

function headers(options) {
  options = options || {}
  options.headers = options.headers || {}
  options.headers['X-Requested-With'] = 'XMLHttpRequest'
  return options
}
/* Adds Element BEFORE NeighborElement */
Element.prototype.appendBefore = function (element) {
  element.parentNode.insertBefore(this, element);
}, false;

/* Adds Element AFTER NeighborElement */
Element.prototype.appendAfter = function (element) {
  element.parentNode.insertBefore(this, element.nextSibling);
}, false;

