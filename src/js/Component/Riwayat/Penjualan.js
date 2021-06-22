import Axios from 'axios';
import React, { useEffect, useState } from 'react';
import { useRecoilState, useRecoilValue, useSetRecoilState } from 'recoil';
import { refreshTipe } from '../../Store/CRUD';
import Delete from '../Delete';
import { FormatInRupiah } from '../Format/Number';
import DetailJual from './Detail';
import { detailModal, settingsState, userState } from './variable/data';

const RiwayatPenjualan = () => {
  const refresh = useRecoilValue(refreshTipe);
  const setUser = useSetRecoilState(userState);
  const setSettings = useSetRecoilState(settingsState);
  const [penjualans, setPenjualans] = useState([]);
  const [showDetail, setShowDetail] = useRecoilState(detailModal);
  const [detail, setDetail] = useState({});


  const getData = async () => {
    let res = await Axios.get(baseUrl + `admin/riwayat/penjualan/dataTable`);
    setPenjualans(res.data.data);

    setUser(res.data.user);
    setSettings(res.data.settings);
  }
  let start = 0;
  const refrehThis = () => {
    if (refresh === "riwayat" || start == 0) { start++; getData(); }
  }

  useEffect(() => {
    refrehThis();
  }, [refresh]);

  const handleModal = (data) => {
    setDetail(data)
    setShowDetail(true)
  }


  return (
    <div className="card card-body">
      <table className="table table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Invoice</th>
            <th scope="col">Nama Pelanggan</th>
            <th scope="col">Uang Bayar</th>
            <th scope="col">Total Bayar</th>
            <th scope="col">Kembalian</th>
            <th scope="col" className="w-auto"></th>
          </tr>
        </thead>
        <tbody>
          {
            penjualans.map((penj, index) => {
              return (
                <tr key={index}>
                  <th scope="row">{index + 1}</th>
                  <td>
                    <a href="#" onClick={e => handleModal(penj)} className="text-primary">{penj.no_invoice}</a>
                  </td>
                  <td>{penj.pelanggan.name}</td>
                  <td>{<FormatInRupiah angka={penj.uang_bayar} prefix="Rp. " />}</td>
                  <td>{<FormatInRupiah angka={penj.jumlah_bayar} prefix="Rp. " />}</td>
                  <td>{<FormatInRupiah angka={penj.kembalian} prefix="Rp. " />}</td>
                  <td className="w-auto text-center">
                    <Delete endpoint={baseUrl + "api/penjualan/softDelete/" + penj.no_invoice} tipe="riwayat" />
                  </td>
                </tr>
              )
            })
          }
        </tbody>
      </table>
      {
        showDetail && <DetailJual data={detail} />
      }
    </div>

  );
};

export default RiwayatPenjualan;
