<script>
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
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-83285766-2', 'auto');
    ga('send', 'pageview');

</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-5160425267148118",
        enable_page_level_ads: true
    });
</script>
<?php
if (false) {
    wp_enqueue_script('jquery'); /* connect jQuery */
    global $post;
    $views_id = intval($post->ID);
    $site_url = get_stylesheet_directory_uri();
    if (is_single() || is_page()) {
        echo '<script type="text/javascript">' . "\n";
        echo '/* <![CDATA[ */' . "\n";
        echo "jQuery.ajax({type:'GET',url:'" . $site_url . "/view.php',data:'views_id=" . $views_id . "',cache:false});" . "\n";
        echo '/* ]]> */' . "\n";
        echo '</script>' . "\n";
    }
}
//        $rows = get_field('js_code_in_head', 'option');
//        if ($rows && !empty($rows) && count($rows) != 0) {
//            foreach ($rows as $row) {
//                echo $row['code'];
//            }
//        }
if(false){
?>
<!-- Facebook Pixel Code -->
<script>
    !function (f, b, e, v, n, t, s)
    {
        if (f.fbq)
            return;
        n = f.fbq = function () {
            n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq)
            f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '238983833351004');
    fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
               src="https://www.facebook.com/tr?id=238983833351004&ev=PageView&noscript=1"
               /></noscript>
<!-- End Facebook Pixel Code -->

<script>
    fbq('track', 'ViewContent');
</script>
<?php }?>
<script data-ad-client="ca-pub-5160425267148118" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>