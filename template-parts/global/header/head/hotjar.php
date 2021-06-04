<?php
/**
 * Hotjar
 */
$hotjar_tracking = get_field('hotjar_tracking', 'option');
$hotjar_id = get_field('hotjar_id', 'option');
if ($hotjar_tracking && $hotjar_id) { ?>
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:<?php echo $hotjar_id ?>,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
<?php }
