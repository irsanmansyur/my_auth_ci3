<!DOCTYPE html>
<html lang="en">

<head>
    =<?= $this->load->view($thema_load . "partials/_head.php"); ?>

</head>

<body>
    <div class="wrapper">

        <?= $this->load->view($thema_load . "partials/_main_header.php"); ?>
        <?= $this->load->view($thema_load . "partials/_sidebar.php"); ?>

        <div class="main-panel">
            <div class="content">
                <div class="page-inner">
                    <div class="page-header">
                        <h4 class="page-title">Grid System</h4>
                        <ul class="breadcrumbs">
                            <li class="nav-home">
                                <a href="#">
                                    <i class="flaticon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Base</a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Grid System</a>
                            </li>
                        </ul>
                    </div>
                    <?= $theme_content; ?>

                </div>
            </div>
        </div>

        <!-- Custom template | don't include it in your project! -->
        <div class="custom-template">
            <div class="title">Settings</div>
            <div class="custom-content">
                <div class="switcher">
                    <div class="switch-block">
                        <h4>Topbar</h4>
                        <div class="btnSwitch">
                            <button type="button" class="changeMainHeaderColor" data-color="blue"></button>
                            <button type="button" class="selected changeMainHeaderColor" data-color="purple"></button>
                            <button type="button" class="changeMainHeaderColor" data-color="light-blue"></button>
                            <button type="button" class="changeMainHeaderColor" data-color="green"></button>
                            <button type="button" class="changeMainHeaderColor" data-color="orange"></button>
                            <button type="button" class="changeMainHeaderColor" data-color="red"></button>
                        </div>
                    </div>
                    <div class="switch-block">
                        <h4>Background</h4>
                        <div class="btnSwitch">
                            <button type="button" class="changeBackgroundColor" data-color="bg2"></button>
                            <button type="button" class="changeBackgroundColor selected" data-color="bg1"></button>
                            <button type="button" class="changeBackgroundColor" data-color="bg3"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="custom-toggle">
                <i class="flaticon-settings"></i>
            </div>
        </div>
        <!-- End Custom template -->
    </div>
    <?= $this->load->view($thema_load . "partials/_js_files.php"); ?>
    <script>
        // get url 
        var path = window.location.href;
        path = path.indexOf("#") > 0 ? path.substring(0, path.indexOf("#")) : path;
        path = path.indexOf("?") > 0 ? path.substring(0, path.indexOf("?")) : path;
        path.indexOf("index.php") > 0 ? [console.log("Ada  index"), path = path.replace("/index.php", "")] : console.log("tdk ada index");
        path = path.toLowerCase();


        let nodeListMenu = document.querySelectorAll("li.nav-item");
        for (const elMenu of nodeListMenu) {
            let aMenu = elMenu.children[0];

            let linkMenu = aMenu.getAttribute("href");
            linkMenu = linkMenu.toLowerCase();

            if (path === linkMenu) {
                aMenu.classList.add("active");
            } else
                aMenu.classList.remove("active");

            let elSubmenuNodeList = elMenu.querySelectorAll("li");
            let temu = null;
            for (const elSubmenu of elSubmenuNodeList) {

                // get link in submenu
                let aSubMenu = elSubmenu.children[0];
                let link = aSubMenu.getAttribute("href");
                link = link.toLowerCase();

                if (link === path || path.includes(link)) {
                    temu = true;
                    elSubmenu.classList.add('active')
                    elSubmenu.closest("div.collapse").classList.add("show");

                    elMenu.classList.add("active");
                    elMenu.classList.add("submenu");

                    // let liSub = elSubmenu.closest("li");
                    // liSub.classList.add("active");

                }
            }

        }
    </script>

</body>

</html>