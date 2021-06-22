let elBody = document.querySelector("body");

let endPoint = "http://my_mart.test/";
if (elBody) {
  endPoint = elBody.getAttribute("endpoint");
}
window.baseUrl = endPoint;
require("./Component/Riwayat/Index");
require("./Component/Laporan/Index");