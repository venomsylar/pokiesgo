<?php
/**
 * Google Analytics
 */

$google_analytics = get_field('google_analytics', 'option');
$google_analytics_type = get_field('google_analytics_type', 'option');
$google_analytics_id = get_field('google_analytics_id', 'option');
if ($google_analytics && $google_analytics_id) { ?>
    <?php
    if ($google_analytics_type == 'old') { ?>
        <script type="text/javascript">
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
            ga('create', '<?php echo $google_analytics_id ?>', 'auto');
            ga('send', 'pageview');
        </script>
    <?php } elseif ($google_analytics_type == 'new') { ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $google_analytics_id ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo $google_analytics_id ?>');
        </script>
    <?php }
    ?>
<?php }
