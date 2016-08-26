# TCMB Güncel Döviz Kurları
TCMB webservisini (http://www.tcmb.gov.tr/kurlar/today.xml) kullanarak güncel döviz kurlarını almaya yarar.

## Kurulum
```
git clone git://github.com/mewebstudio/tcmb-doviz
cd tcmb-doviz
composer install
cd example
php -S localhost:8000
```

## Kullanım
```
$currency = new \Mews\Tcmb\Currency(new Guzzle\Http\Client('http://www.tcmb.gov.tr/kurlar/today.xml'));

// Tümünü listeme:
$items = $currency->getItems();
foreach($items as $item) {
    echo $item->CurrencyCode . ' / ' . $item->CurrencyName . ': Alış: ' . $item->ForexBuying . ' - Satış: ' . $item->ForexBuying . '<br>';
}

// Bir kurun verisine erişim:
// USD alış:
echo $currency->getItem('USD')->ForexBuying;
// USD satış:
echo $currency->getItem('USD')->ForexSelling;

// Tüm parametrelerin dökümü:
var_dump($currency->getItem('USD'));
```

## Örnek
Örnek kodlar `example/index.php` dosyasında yer almaktadır.

## Lisans
MIT
