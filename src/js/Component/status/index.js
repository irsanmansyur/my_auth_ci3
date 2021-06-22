import Axios from 'axios';
import React, { useState } from 'react';
import ReactDOM from 'react-dom';

const Status = ({ data, endpoint }) => {
  const [aktif, setAktif] = useState(parseInt(data));
  const [loading, setLoading] = useState(false);
  const change = async () => {
    console.log(aktif);
    setLoading(true)
    try {
      let dt = aktif === 1 ? 2 : 1;
      console.log(dt);
      let res = await Axios.put(endpoint, { status: dt });
      if (res.data.status)
        setAktif(dt)
      console.log(res);
    } catch (error) {
      console.log(error.response);
    }
    setLoading(false)
  }
  return (
    aktif === 1 ? <>
      <span className="mr-2 btn btn-sm disable  disabled btn-success">Aktif</span>
      {
        loading ?
          <div className="spinner-border" role="status" >
            <span className="sr-only">Loading...</span>
          </div>
          :
          <button className="btn btn-sm disable btn-sm btn-outline-danger" onClick={change}>Nonaktifkan</button>
      }
    </> :
      <>
        { loading ? <div className="spinner-border" role="status" >
          <span className="sr-only">Loading...</span>
        </div> :
          <button className="btn btn-sm btn-outline-success" onClick={change}>Aktifkan</button>
        }
        <span className="ml-2 btn btn-sm btn-danger disabled ">Non Aktif</span>
      </>

  );
};

export default Status;
if (document.querySelectorAll('.status')) {
  let statusNodes = document.querySelectorAll('.status');
  statusNodes.forEach(statusNode => {
    ReactDOM.render(<Status data={statusNode.getAttribute("data")} endpoint={statusNode.getAttribute("endpoint")} />, statusNode);
  })
}