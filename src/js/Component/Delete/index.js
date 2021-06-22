import Axios from 'axios';
import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import { useSetRecoilState } from 'recoil';
import Swal from 'sweetalert2'
import { refreshTipe } from '../../Store/CRUD';


const Delete = ({ endpoint, tipe = null }) => {
  const setRefresh = useSetRecoilState(refreshTipe);
  const [isDelete, setIsDelete] = useState(false)
  const deleteMe = (e) => {
    Swal.fire({
      title: 'Apakah Kamu Yakin?',
      text: "Kamu Ingin Menghapus data!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then(async (result) => {
      if (result.isConfirmed) {
        setIsDelete(true)
        try {
          let res = await Axios.delete(endpoint);
          if (res.data.status) {
            Swal.fire(
              'Deleted!',
              'Data Telah Di Hapus.',
              'success'
            )
            if (tipe !== null)
              setRefresh(tipe)
          } else {
            Swal.fire(
              'Gagal!',
              'Tidak Bisa Menghapus.',
              'error'
            )
          }
          setIsDelete(false)
        } catch (error) {
          Swal.fire(
            'Gagal!',
            error.message,
            'error'
          )
        }
      }
    })

  }
  return (
    isDelete ?
      <div className="spinner-border text-danger" role="status">
        <span className="sr-only">Loading...</span>
      </div> :
      <button type="button" className="btn btn-danger btn-circle btn-xl" onClick={deleteMe}><i className="fa fa-times" /></button>
  );
};

export default Delete;

if (document.querySelectorAll('.delete')) {
  let deletesNode = document.querySelectorAll('.delete');
  deletesNode.forEach(deleteNode => {
    ReactDOM.render(<Delete endpoint={deleteNode.getAttribute("endpoint")} />, deleteNode);
  })
}