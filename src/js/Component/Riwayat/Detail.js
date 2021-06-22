import Axios from "axios";
import { useRecoilState, useRecoilValue } from "recoil";
import { FormatInRupiah } from "../Format/Number";
import PrintThisElemen from "../Print";
import { detailModal, settingsState, userState } from "./variable/data";

const { useState, useEffect } = require("react");
const { Button, Modal } = require("react-bootstrap");

export default function DetailJual({ data }) {
  const [penj, setPenj] = useState(false);
  const user = useRecoilValue(userState)
  const setting = useRecoilValue(settingsState)
  const [modalIS, setModalIS] = useRecoilState(detailModal);
  const [show, setShow] = useState(modalIS);

  const tgl = new Date();
  const handleClose = () => {
    setModalIS(false);
    setShow(false)
  };

  const getData = async () => {
    let res = await Axios.get(baseUrl + `api/penjualan/detail/${data.no_invoice}`);
    setPenj(res.data.data);
  }
  useEffect(async () => {
    await getData();
  }, []);
  const handlePrint = () => {
    let elem = document.getElementById("printThis");
    const htmlElem = elem.innerHTML;
    let $printSection = document.createElement("div");
    $printSection.id = "printSection";
    document.body.appendChild($printSection);
    $printSection.innerHTML = htmlElem;
    window.print();
  }
  return (
    <>
      <Modal size="lg"
        show={show} onHide={handleClose} dialogClassName="modal-90w">
        <Modal.Header closeButton>
          <Modal.Title>Modal heading</Modal.Title>
        </Modal.Header>
        <Modal.Body>

          <iframe id="ifmcontentstoprint" name="ifmcontentstoprint" style={{ height: 0, width: 0, position: 'absolute' }} />

          <div id="invoice" className="printThis" id="printThis">
            <div className="toolbar hidden-print">
              <div className="text-right">
                <button id="printInvoice" onClick={handlePrint} className="btn btn-info mr-2"><i className="fa fa-print" /> Print</button>
                <button className="btn btn-info" disabled><i className="fa fa-file-pdf-o" /> Export as PDF</button>
              </div>
              <hr />
            </div>
            <div className="invoice overflow-auto">
              <div>
                <header>
                  <div className="d-flex justify-content-between">
                    <div className="text-right">
                      <a target="_blank" href="<?= base_url(); ?>">
                        <h2>{setting.name_app}</h2>
                      </a>
                    </div>
                    <div className="company-details text-right">
                      <h2 className="name">
                        <a target="#" href={baseUrl}>Arboshiki</a>
                      </h2>
                      <div>455 Foggy Heights, AZ 85004, US</div>
                      <div>(123) 456-789</div>
                      <div>company@example.com</div>
                    </div>
                  </div>
                </header>
                <main className="">
                  <div>
                    <div className="d-flex justify-content-between border-bottom mb-3 pb-3">
                      <div className="invoice-to">
                        <div className="text-gray-light">Nama Admin:</div>
                        <h2 className="to">{user.name}</h2>
                        <div className="address">Sebagai : Admin</div>
                        <div className="email"><a href={"mailto:" + user.email}>{user.email}</a></div>
                      </div>
                      <div className="invoice-details">
                        <h1 className="invoice-id">{penj.no_invoice}</h1>
                        <div className="date">Tangal Invoice : {penj.dibuat_pada}</div>
                        <div className="date">Tanggal Cetak : {penj.cetak_pada}</div>
                      </div>
                    </div>
                    <table border={0} cellSpacing={0} cellPadding={0}>
                      <thead>
                        <tr>
                          <th width={2}>#</th>
                          <th className="text-left">Barang</th>
                          <th className="text-right">@HARGA</th>
                          <th className="text-right">Jumlah</th>
                          <th className="text-right">TOTAL</th>
                        </tr>
                      </thead>
                      <tbody>
                        {
                          penj ? penj.barangs.map((barang, i) => {
                            return (
                              <tr key={i}>
                                <td className="no">{i + 1}</td>
                                <td className="text-left">
                                  <h2><span>{barang.barang.nama}</span></h2>
                                </td>
                                <td className="text-right unit">{<FormatInRupiah angka={barang.harga} prefix="Rp. " />}</td>
                                <td className="text-right qty">{barang.jumlah}</td>
                                <td className="text-right total">{<FormatInRupiah angka={barang.total_harga} prefix="Rp. " />}</td>
                              </tr>
                            )
                          }) : <></>
                        }

                      </tbody>
                      <tfoot>
                        <tr>
                          <td className="border-top pt-3" colSpan={5} />
                        </tr>
                        <tr>
                          <td colSpan={2} />
                          <td colSpan={2} className="text-right">Jumlah bayar</td>
                          <td className="text-right">{<FormatInRupiah angka={penj.jumlah_bayar} />}</td>
                        </tr>
                        <tr>
                          <td colSpan={2} />
                          <td colSpan={2} className="text-right">Uang Bayar</td>
                          <td className="text-right">{<FormatInRupiah angka={penj.uang_bayar} />}</td>
                        </tr>
                        <tr>
                          <td colSpan={2} />
                          <td colSpan={2} className="text-right">Kembalian</td>
                          <td className="text-right">{<FormatInRupiah angka={penj.kembalian} />}</td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>

                  <div className="thanks">Terima Kasih!</div>
                  <div className="notices">
                    <div>CATATAN:</div>
                    <div className="notice">Harga Barang bisa berubah kapan Saja.</div>
                  </div>
                </main>

              </div>
              {/*DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom*/}
              <div />
            </div>
          </div>

        </Modal.Body>
        <Modal.Footer>
          <Button variant="secondary" onClick={handleClose}>
            Close
          </Button>
          <Button variant="primary" onClick={handleClose}>
            Save Changes
          </Button>
        </Modal.Footer>
      </Modal>
    </>
  );
}