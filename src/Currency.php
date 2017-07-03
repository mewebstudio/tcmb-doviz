<?php

namespace Mews\Tcmb;

use GuzzleHttp\Client;
use Mews\Tcmb\Exceptions\CurrencyClientException;
use Mews\Tcmb\Exceptions\CurrencyItemException;
use Symfony\Component\DomCrawler\Crawler;

class Currency
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @var string
     */
    protected $date;

    /**
     * @var array
     */
    protected $items = [];

    /**
     * Currency constructor.
     *
     * @param $url
     * @throws CurrencyClientException
     */
    public function __construct($url)
    {
        try {
            $this->client = new Client();
            $this->response = $this->client->get($url, [
                'headers' => [
                    'Accept' => 'application/xml'
                ]
            ]);

            $this->parse($this->response->getBody()->getContents());
        } catch (\Exception $exception) {
            throw new CurrencyClientException('No information available from webservice!');
        }
    }

    /**
     * @param $body
     * @return $this
     */
    protected function parse($body)
    {
        $this->crawler = new Crawler($body);

        $this->setDate();

        $this->setItems();

        return $this;
    }

    /**
     * Currency set date
     */
    protected function setDate()
    {
        $this->date = $this->crawler->filterXPath('//Tarih_Date')->extract('Date')[0];
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set currency items
     */
    protected function setItems()
    {
        $this->crawler->filter('Currency')->each(function (Crawler $row, $i) {
            $code = trim($row->extract('CurrencyCode')[0]);
            $this->items[$code] = (object) array_map('trim', [
                'CurrencyCode'      => $code,
                'CurrencyName'      => $row->filter('CurrencyName')->text(),
                'ForexBuying'       => $row->filter('ForexBuying')->text(),
                'ForexSelling'      => $row->filter('ForexSelling')->text(),
                'BanknoteBuying'    => $row->filter('BanknoteBuying')->text(),
                'BanknoteSelling'   => $row->filter('BanknoteSelling')->text(),
                'CrossRateUSD'      => $row->filter('CrossRateUSD')->text(),
                'CrossRateOther'    => $row->filter('CrossRateOther')->text()
            ]);
        });
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param $code
     * @return mixed
     * @throws CurrencyItemException
     */
    public function getItem($code)
    {
        if (isset($this->items[$code])) {
            return $this->items[$code];
        } else {
            throw new CurrencyItemException('No matching currency code!');
        }
    }
}
