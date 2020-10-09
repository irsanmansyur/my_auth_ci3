<!-- Bootstrap Notify -->
<script src="<?= $thema_folder; ?>assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<?php

$alert = ['danger', 'warning', 'success', 'primary'];
foreach ($alert as $a) {
    if ($this->session->flashdata($a)) : ?>
        <script>
            const content = {
                message: "<?= $this->session->flashdata($a); ?>",
                title: "Notification..!"
            }
            $.notify(content, {
                type: "<?= $a ?>",
                placement: {
                    from: 'top',
                    align: 'right'
                },
                allow_dismiss: true,
                time: 1000,
                delay: 0,
            });
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 3000);
        </script>

<?php break;
    endif;
}; ?>