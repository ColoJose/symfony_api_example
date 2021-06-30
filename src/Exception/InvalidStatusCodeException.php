<?php


namespace App\Exception;

use Throwable;

/**
 * An exception which should be raised when construct a GeneralErrorResponse with a
 * a status code different of 4xx or 5xx
 *
 * Class InvalidStatusCodeException
 * @package App\Exception
 *
 */
class InvalidStatusCodeException extends \Exception {

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}