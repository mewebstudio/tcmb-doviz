<?php

namespace Mews\Tcmb;


/**
 * Class CurrencyItemException
 * @package Mews\Tcmb
 */
class CurrencyItemException extends \Exception
{
    /**
     * CurrencyItemException constructor.
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = 1001, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
