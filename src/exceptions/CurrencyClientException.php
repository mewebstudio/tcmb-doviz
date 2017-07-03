<?php

namespace Mews\Tcmb\Exceptions;

use Exception;

/**
 * Class CurrencyClientException
 * @package Mews\Tcmb
 */
class CurrencyClientException extends Exception
{
    /**
     * CurrencyClientException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = 1004, \Exception $previous = null)
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
