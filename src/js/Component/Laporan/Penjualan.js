import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { FormatInRupiah } from '../Format/Number';
import Spinner from '../Spinner';

const Penjualan = () => {
  let today = new Date();
  const [sampaiTanggal, setSampaiTanggal] = useState(`${today.getFullYear()}-${("0" + (today.getMonth() + 1)).slice(-2)}-${today.getDate()}`);
  const [mulaiDari, setMulaiDari] = useState(`${today.getFullYear()}-${("0" + (today.getMonth())).slice(-2)}-${today.getDate()}`);

  const [penjualans, setPenjualans] = useState([]);
  const [jumlah, setJumlah] = useState(0);
  const [loading, setLoading] = useState(true);
  const getData = async () => {
    setLoading(true)
    let res = await axios.get(baseUrl + `laporan/penjualan/getData?mulaiDari=${mulaiDari}&sampaiTanggal=${sampaiTanggal}`);
    let penjs = res.data.data;
    let jT = 0
    penjs.forEach(a => {
      jT += a.jumlah_bayar - (a.diskon ?? 0);
    });
    setJumlah(jT);
    setPenjualans(penjs);
    setLoading(false)
  }

  useEffect(() => {
    getData();
  }, [sampaiTanggal, mulaiDari]);
  return (
    <>
      <div className="card card-body">
        <div className="row">
          <div className="col-md-6">
            <div className="form-group m-0 p-0">
              <label htmlFor="mulaiDari">Mulai Dari</label>
              <input type="date" className="form-control" onChange={e => setMulaiDari(e.target.value)} defaultValue={mulaiDari} name="mulaiDari" id="mulaiDari" />
            </div>
          </div>
          <div className="col-md-6">
            <div className="form-group  m-0 p-0">
              <label htmlFor="sampaiTanggal">Sampai Tanggal</label>
              <input type="date" className="form-control" onChange={e => setSampaiTanggal(e.target.value)} defaultValue={sampaiTanggal} name="sampaiTanggal" id="sampaiTanggal" />
            </div>
          </div>
        </div>
      </div>
      <div className="card card-body">

        <div className="demo">
          {loading ? <Spinner /> :
            penjualans.length > 0 ?
              <table className="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th scope="col" rowSpan="2">#</th>
                    <th scope="col" rowSpan="2">Tanggal</th>
                    <th scope="col" rowSpan="2">Kasir</th>
                    <th scope="col" className="text-center" colSpan="3">Penjualan</th>
                  </tr>
                  <tr>
                    <th scope="col" className="text-center">Terjual</th>
                    <th scope="col" className="text-center">Diskon</th>
                    <th scope="col" className="text-center">Total</th>
                  </tr>
                </thead>
                <tbody>
                  {
                    penjualans.map((penj, i) => {
                      let diskon = penj.diskon ?? 0;
                      let total = penj.jumlah_bayar - diskon;
                      return (
                        <tr key={i}>
                          <td>{i + 1}</td>
                          <td>{penj.tanggal_buat}</td>
                          <td>{penj.kasir.name}</td>
                          <td className="text-right"><FormatInRupiah angka={penj.jumlah_bayar} prefix="Rp._  " /> </td>
                          <td className="text-right"><FormatInRupiah angka={diskon ?? 0} prefix="Rp._  " /> </td>
                          <td className="text-right"><FormatInRupiah angka={total} prefix="Rp._  " /> </td>
                        </tr>
                      );
                    })
                  }
                  <tr>
                    <td className="text-right" colSpan="5"><b>Jumlah Bayar</b> </td>
                    <td className="text-right"><FormatInRupiah angka={jumlah} prefix="Rp._  " /> </td>
                  </tr>
                </tbody>
              </table> : <div className="alert alert-danger">Data Kosong</div>

          }
        </div>
      </div>
    </>
  );
};

export default Penjualan;