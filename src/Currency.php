<?php

namespace Mews\Tcmb;
use Guzzle\Http\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;


/**
 * Class Currency
 * @package Mews\Tcmb
 * @author Muharrem ERİN <me@mewebstudio.com>
 * @licence MIT
 */
class Currency
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var \Guzzle\Http\EntityBodyInterface|string
     */
    protected $body;

    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    protected $crawler;

    /**
     * TCMB webservice URL
     * @var string
     */
    protected $url;

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
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        $this->body = $this->client->get()->send()->getBody(true);

        $this->parse();
    }

    /**
     * @return $this
     */
    protected function parse()
    {
        $this->crawler = new Crawler($this->body);

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
