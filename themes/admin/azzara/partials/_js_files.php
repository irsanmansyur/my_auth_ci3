<!--   Core JS Files   -->
<script src="<?= $thema_folder; ?>assets/js/core/jquery.3.2.1.min.js"></script>
<script src="<?= $thema_folder; ?>assets/js/core/popper.min.js"></script>
<script src="<?= $thema_folder; ?>assets/js/core/bootstrap.min.js"></script>
<!-- jQuery UI -->
<script src="<?= $thema_folder; ?>assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="<?= $thema_folder; ?>assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
<!-- Bootstrap Toggle -->
<script src="<?= $thema_folder; ?>assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<!-- jQuery Scrollbar -->
<script src="<?= $thema_folder; ?>assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<!-- Datatable -->
<script src="<?= $thema_folder; ?>assets/js/plugin/datatables/datatables.min.js"></script>
<!-- Azzara JS -->
<script src="<?= $thema_folder; ?>assets/js/ready.min.js"></script>
<!-- Azzara DEMO methods, don't include it in your project! -->
<script src="<?= $thema_folder; ?>assets/js/setting-demo.js"></script>
<?php $this->load->view($thema_load . "partials/_notify.php"); ?>


<script>
  function ready(callbackFunc) {
    if (document.readyState !== "loading") {
      callbackFunc();
    } else if (document.addEventListener) {
      document.addEventListener("DOMContentloaded", callbackFunc());
    } else
      document.attachEvent('onreadystatechange', function() {
        if (document.readyState == 'complete')
          callbackFunc();
      })
  }

  const baseUrl = "<?= base_url() ?>";

  ready(() => {
    let path = window.location.href;
    path = path.indexOf("#") > 0 ? path.substring(0, path.indexOf("#")) : path;
    path = path.indexOf("?") > 0 ? path.substring(0, path.indexOf("?")) : path;
    path.indexOf("index.php") > 0 ? [console.log("Ada  index"), path = path.replace("/index.php", "")] : console.log("tdk ada index");
    path = path.toLowerCase().toString();

    let elLinkSubmenus = document.querySelectorAll(`li.s-menu>a`);
    elLinkSubmenus.forEach(elLinkSubmenu => {
      let link = elLinkSubmenu.getAttribute("href");
      if (link.toLowerCase().toString() == path.toLowerCase().toString()) {
        elLinkSubmenu.closest("li") && elLinkSubmenu.closest("li").classList.add("active");
        elLinkSubmenu.closest(".collapse") && elLinkSubmenu.closest(".collapse").classList.add("show");
        elLinkSubmenu.closest(".nav-item") && elLinkSubmenu.closest(".nav-item").classList.add('active', 'submenu');
      }
    });

  })

  $('#basic-datatables').DataTable();
</script>