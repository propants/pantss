<?php
global $companyInfoEN, $landings_default_domain, $default_main_site;
global $prepaid_info_html;
$doclinks = isset($doclinks) ? $doclinks : true;
$pplink = isset($pplink) ? $pplink : true;
if (array_key_exists('pplink', $_GET) && $_GET['pplink'] == '0') {
  $pplink = false;
}
$linksPosition = isset($linksPosition) ? $linksPosition : 'column';
$policy = isset($policy) ? $policy : true;

$company_detail = isset($companyInfoEN['detail']) ? $companyInfoEN['detail'] : 'OOO "OSTROV PRODAZH" OGRN: 1197746695530 VAT: 7708365555';
$company_address = isset($companyInfoEN['address']) ? $companyInfoEN['address'] : '129090, Moscow, pereulok Zhivarev, house 8, stroenie 3, flat 16';
?>
<p><?= $company_detail ?></p>
<p><?= $company_address ?></p> 

<?php if($linksPosition == 'line'): ?>

    <p class="tlight-link">

      <?php if($doclinks): ?>
        <a class="nav-link"  href="" onclick="window.open('policy_en.php'); return false;">Privacy Policy</a>
        <a class="nav-link"  href="" onclick="window.open('terms_en.php'); return false;">Terms & Conditions</a>
      <?php endif ?>
    </p>

<?php else: ?>

    <?php if($doclinks): ?>

      <?php if ($policy): ?>
      <p class="conf-link doclinks">
        <a class="nav-link"  href="" onclick="window.open('policy_en.php'); return false;">Privacy Policy</a>
          |
        <a class="nav-link"  href="" onclick="window.open('terms_en.php'); return false;">Terms & Conditions</a>
      </p>
      <?php endif ?>

    <?php endif ?>

<?php endif ?>
