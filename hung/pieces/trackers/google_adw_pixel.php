<?php
$counter_info = explode('/', $pixel_id);
$counterId = $counter_info[0];
if (count($counter_info) == 2) {
    $convLabel = $counter_info[1];
}
?>

<script async src="https://www.googletagmanager.com/gtag/js?id=AW-<?= $counterId ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'AW-<?= $counterId ?>');
</script>

<?php if ($lead): ?>
    <script>
        gtag('event', 'conversion', {
            'send_to': 'AW-<?= $counterId ?>/<?= $convLabel ?>',
            'transaction_id': ''
        });
    </script>
<?php endif ?>
