import React from 'react';
import ReactDOM from 'react-dom';

import { RecoilRoot } from 'recoil';
import Penjualan from './Penjualan';

const Laporan = () => {
  return (
    <RecoilRoot>
      <Penjualan />
    </RecoilRoot>
  );
};

export default Laporan;

if (document.querySelector('#reactLaporan')) {
  let elLaporan = document.querySelector('#reactLaporan');
  ReactDOM.render(<Laporan />, elLaporan);
}