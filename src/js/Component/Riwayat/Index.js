import React from 'react';
import ReactDOM from 'react-dom';

import { RecoilRoot } from 'recoil';
import RiwayatPenjualan from './Penjualan';

const Riwayat = () => {
  return (
    <RecoilRoot>
      <RiwayatPenjualan />
    </RecoilRoot>
  );
};

export default Riwayat;

if (document.querySelector('#reactRiwayat')) {
  let elRiwayat = document.querySelector('#reactRiwayat');
  ReactDOM.render(<Riwayat />, elRiwayat);
}