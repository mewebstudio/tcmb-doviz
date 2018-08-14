<?php

require '../vendor/autoload.php';

try {
    $currency = new \Mews\Tcmb\Currency('http://www.tcmb.gov.tr/kurlar/today.xml');
} catch (\Mews\Tcmb\Exceptions\CurrencyClientException $e) {
    var_dump($e->getCode(), $e->getMessage());
    exit();
}

echo '<h3>Tablo olarak tüm kurlar:</h3>';
include 'view/table.php';

echo '<br><hr><h3>Tümünü listeme:</h3>';

$items = $currency->getItems();
foreach($currency->getItems() as $item) {
    echo $item->CurrencyCode . ' / ' . $item->CurrencyName . ': Alış: ' . $item->ForexBuying . ' - Satış: ' . $item->ForexBuying . '<br>';
}

echo '<hr><h3>Tek bir kuru isteme:</h3>';

var_dump($currency->getItem('USD'));

echo '<hr>';
echo 'USD // Forex Buying: ' . $currency->getItem('USD')->ForexBuying . ' - Forex Selling: ' . $currency->getItem('USD')->ForexSelling;

echo '<hr><h3>İstenen kur kodu olmadığında hata yakalama:</h3>';
try {
    var_dump($currency->getItem('XXX'));
} catch (\Mews\Tcmb\CurrencyItemException $e) {
    echo $e;
}
