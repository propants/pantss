
<!-- Yandex.Metrika counter -->
<script type="text/javascript">

<?php if (!$lead): ?>

$(document).on('click', 'form', function(e) {
    if ( ! $(this).find('input[name=phone]').length) {
        return;
    }
    
    if (window['yaCounter<?= $pixel_id ?>'] && e.validator === window.orderValidator) {
        window['yaCounter<?= $pixel_id ?>'].reachGoal('FORMCLICK');
    }
});

<?php else: ?>

function yandex_metrika_postinit(ym) {
    ym.reachGoal('ORDER');
}

<?php endif ?>

(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            var y = new Ya.Metrika({
                id: <?= $pixel_id ?>,
                webvisor: false,
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true
            });
            if (w.yandex_metrika_postinit) {
                w.yandex_metrika_postinit(y);
            }
            w['yaCounter<?= $pixel_id ?>'] = y;
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");

</script>

<noscript><div><img src="//mc.yandex.ru/watch/<?= $pixel_id ?>" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter --> 
