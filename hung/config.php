<?php

define('LANDING_DIR', '');

$apiKey = 'TIvzIGZQqB1ktIorISCFihDe582DpRoLOernOno9iwBRNKyUsDxd2d';          // Ключ доступа к API
$offer_id = 4402;         // для каждого оффера свой айди, надо уточнять его в админке или у суппортов
$stream_hid = 'OzEUMQEP';     // id потока
$landKey = '2401d2543e5e196bd6d5ad008182fc2d';

$default_main_site = 'http://api.cpa.tl';
$apiSendLeadUrl = 'http://api.cpa.tl/api/lead/send_archive';
$apiGetLeadUrl = 'http://api.cpa.tl/api/lead/feed';

$dataOffers = '{"18132":{"id":18132,"name":"Tactic pants","country":{"code":"RO","name":"\u0420\u0443\u043c\u044b\u043d\u0438\u044f"},"price":"209","price2":"418","currency":{"code":"RON","name":"RON"}},"19637":{"id":19637,"name":"Tactic pants","country":{"code":"BG","name":"\u0411\u043e\u043b\u0433\u0430\u0440\u0438\u044f"},"price":"89","price2":"178","currency":{"code":"BGN","name":"\u043b\u0435\u0432"}},"19638":{"id":19638,"name":"Tactic pants","country":{"code":"CZ","name":"\u0427\u0435\u0445\u0438\u044f"},"price":"1090","price2":"2180","currency":{"code":"CZK","name":"K\u010d"}},"19639":{"id":19639,"name":"Tactic pants","country":{"code":"SK","name":"\u0421\u043b\u043e\u0432\u0430\u043a\u0438\u044f"},"price":"45","price2":"90","currency":{"code":"EUR","name":"\u20ac"}},"19640":{"id":19640,"name":"Tactic pants","country":{"code":"IT","name":"\u0418\u0442\u0430\u043b\u0438\u044f"},"price":"59","price2":"118","currency":{"code":"EUR","name":"\u20ac"}},"19641":{"id":19641,"name":"Tactic pants","country":{"code":"HU","name":"\u0412\u0435\u043d\u0433\u0440\u0438\u044f"},"price":"12990","price2":"25980","currency":{"code":"HUF","name":"Ft"}}}';
$dataOffer = '{"id":19641,"name":"Tactic pants","country":{"code":"HU","name":"\u0412\u0435\u043d\u0433\u0440\u0438\u044f"},"price":"12990","price2":"25980","currency":{"code":"HUF","name":"Ft"}}';
$is_geo_detect = '';
$productName = 'Tactic pants';
$invoice = 'index.php';
$push_link = '';
$language = 'hu';
$companyInfo = array('address' => '603140, Нижегородская область, г. Нижний Новгород, пер. Мотальный, д. 4, офис 301', 'detail' => 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "РК-ТРЕЙД" ОГРН: 1215200002918 ИНН: 5260476009 КПП: 525801001');
$companyInfoEN = array('address' => '129090, Moscow, pereulok Zhivarev, house 8, stroenie 3, flat 16 email: ostrov.prodazh@mail.com Skype: ostrov.prodazh@mail.com', 'detail' => 'OOO "OSTROV PRODAZH" OGRN: 1197746695530 VAT: 7708365555');

$_debug = False; // установите True для вывода дополнительной информации для отладки и поиска ошибок
$pixels = [
    'fb_pixel', 'google_pixel', 'google_adw_pixel', 'tiktok_pixel', 'topmail_pixel', 'vk_pixel', 'yandex_metrika'
];

if(!$apiKey){
    echo 'Ключ доступа к API не определен. Получите в личном кабинете или обратитесь в службу поддержки';
    die;
}

if(!$offer_id){
    echo 'ID оффера не определен';
    die;
}
