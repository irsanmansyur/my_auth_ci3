<?php

$alert = ['danger', 'warning', 'success', 'primary', 'secondary', 'info', 'light'];
foreach ($alert as $a) {

    if ($this->session->flashdata($a)) : ?>
        <div class="alert alert-<?= $a ?>" role="alert">
            <button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 1033;">×</button>
            <?= $this->session->flashdata($a); ?>
        </div>
<?php endif;
}; ?>