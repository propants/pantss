<?php

require_once('config.php');
require_once('lib/app.php');
$dbg_mod = is_debug($_debug);
$data_post = $_POST;
$error = '';

if( !isset($data_post['phone']) || !isset($data_post['name']) || !isset($data_post['country'])){
    $error_message = 'Получены не все данные. Вернитесь и заполните форму.';
    require ('error.php');
    die;
}

$tech_comments = array_get($_POST, 'tech_comments', '');
if ( isset($_POST['fieldJson']) ){
    $fieldJson = $_POST['fieldJson'];
    // формируем дополнительные данные для передачи в tech_comments
    $other = array();
    $data_other = array_get($_POST, 'other', array());
    if($fieldJson == 'other') {
        foreach ($data_other as $field_name => $field_val) {
            $other['other['.$field_name.']'] = $field_val;
        }
    } else {
        $other = $data_other;
    }
    if (!empty($other)) {
        $tech_comments = json_encode($other);
    }

}

// объединяем данные в одно поле из нескольких
$formFields = isset($data_post['formFields']) ? json_decode(urldecode($data_post['formFields']), true) : array();
$fieldsCheck = ['name', 'phone', 'address', 'comments', 'tech_comments'];
$dataField = array(
    'name' => array_get($_POST, 'name', ''),
    'phone' => array_get($_POST, 'phone', ''),
    'address' => array_get($_POST, 'address', ''),
    'email' => array_get($_POST, 'email', ''),
    'comments' => array_get($_POST, 'comments', ''),
    'tech_comments' => $tech_comments,
);
foreach ($fieldsCheck as $field_name) {
    $field = array_get($formFields, $field_name, array());
    $new_data = array();
    foreach ($field as $key => $field_list) {
        $new_data[] = array_get($_POST, $field_list);
    }
    if ($new_data) {
        $dataField[$field_name] = implode(" ", $new_data);
    }
}

$data = array(
    'key' => $apiKey,
    'id' => microtime(true), // тут лучше вставить значение, по которому вы сможете индетифицировать свой лид; можно оставить microtime если у вас нет своей crm
    'offer_id' => $offer_id,
    'stream_hid' => $stream_hid,
    'name' => @$dataField['name'],
    'phone' => @$dataField['phone'],
    'email' => @$dataField['email'],
    'comments' => @$dataField['comments'],
    'tech_comments' => $dataField['tech_comments'],
    'country' => @$data_post['country'],    // код страны покупателя (RU, UA и т.п.)
    'address' => $dataField['address'],
    'tz' => (isset($data_post['timezone_int'])?$data_post['timezone_int']:3),
    'web_id' => '', // id вебмастера в вашей системе
    'ip_address' => (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']),
    'user_agent' => $_SERVER['HTTP_USER_AGENT'],

    "utm_source" => @$data_post['utm_source'],
    "utm_medium" => @$data_post['utm_medium'],
    "utm_campaign" => @$data_post['utm_campaign'],
    "utm_content" => @$data_post['utm_content'],
    "utm_term" => @$data_post['utm_term'],

    "sub1" => @$data_post['sub1'],
    "sub2" => @$data_post['sub2'],
    "sub3" => @$data_post['sub3'],
    "sub4" => @$data_post['sub4'],
    "sub5" => @$data_post['sub5'],
);

$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'ignore_errors' => 1,
        'timeout' => 30,
        'content' => http_build_query($data),
    )
);

display_debug_info('send data', $data);
$result = curl($apiSendLeadUrl, $data);
display_debug_info('result', $result);
$obj = json_decode($result);

$apiErrors = array(
    'incorrect customer phone' => 'Не корректный телефон',
    'customer name too long' => 'Слишком длинное имя',
    'country is a required field' => 'Страна, обязательное поле',
    'offer not found' => 'оффер не найден или нет гео совпадающего с переданным в country',
    'incorrect IP-address' => 'не корректный IP-address',
    'incorrect country code; should be ISO2 or ISO3 format' => 'не корректный код страны передаваемый в поле country',
    'customer phone is a required field' => 'поле phone (телефон) обязательно для сохранения заявки',
    'incorrect timezone' => 'поле tz (таймзона) не верный формат',
);

if (null === $obj) {
    // Ошибка в полученном ответе
    $error_message = 'Ошибка в полученном ответе';
    $error_info = '';
    require ('error.php');
    die;
} elseif (!empty($obj->errmsg)) {
    // Ошибка в отправленом запросе
    $error_message = (isset($apiErrors[$obj->errmsg]) ? $apiErrors[$obj->errmsg] : '');
    $error_info = $obj->errmsg;
    require ('error.php');
    die;
}

if ($obj->order_id) {

    $order_id = $obj->order_id;
    $order_name = $data_post['name'];
    $order_phone = $data_post['phone'];

    setcookie("order_id", $order_id);
    setcookie("order_name", $order_name);
    setcookie("order_phone", $order_phone);
    setcookie("product_name", $productName);

    $check_pixel = False;
    foreach ($pixels as $pixel_name) {
        if (isset($data_post[$pixel_name])) {
            $pixel_id = $data_post[$pixel_name];
            setcookie($pixel_name, $pixel_id);
            $check_pixel = True;
        } else {
            setcookie($pixel_name);
        }
    }
    if ($check_pixel) {
        $price = null;
        $currency = null;
        $offers = json_decode($dataOffers, true);
        foreach($offers as $struct) {
            if ($data_post['country'] == $struct['country']['code']) {
                $price = $struct['price'];
                $currency = $struct['currency']['code'];
                setcookie("product_price", $price);
                setcookie("product_currency", $currency);
                break;
            }
        }
    }

//    if (isset($data_post['fb_pixel'])) {
//        $fb_pixel = $data_post['fb_pixel'];
//        setcookie("fb_pixel", $fb_pixel);
//
//        $price = null;
//        $currency = null;
//        $offers = json_decode($dataOffers, true);
//
//        foreach($offers as $struct) {
//            if ($data_post['country'] == $struct['country']['code']) {
//                $price = $struct['price'];
//                $currency = $struct['currency']['code'];
//                setcookie("product_price", $price);
//                setcookie("product_currency", $currency);
//                break;
//            }
//        }
//    } else {
//        setcookie("fb_pixel");
//    }

    if (isset($obj->prepayment_link)){
        header('Location: '.$obj->prepayment_link);
        die();
    }

    header('Location: order.php?id='.$order_id);
    die();
}

function curl($url, $post = null, $head=0){

    $isCurlEnabled = function(){
        return function_exists('curl_version');
    };
    if (!$isCurlEnabled) {
        echo "pls install curl";
        die;
    }

    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    if($head){
        curl_setopt($ch,CURLOPT_HTTPHEADER, $head);
    }else{
        curl_setopt($ch,CURLOPT_HEADER, 0);
    }

    if($post){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    $response = curl_exec($ch);

    if ($response === false) {
        echo curl_error($ch);
    }

    $header_data = curl_getinfo($ch);
    curl_close($ch);
    return $response;

}
