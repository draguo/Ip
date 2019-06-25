<?php
/**
 * author: draguo
 */

namespace Draguo\Ip\Exceptions;

use Throwable;

class BadGateway extends \Exception
{
    public function __construct(array $results = [], $code = 0, Throwable $previous = null)
    {
        $message = '';
        foreach ($results as $result) {
            $message .= "{$result['gateway']}:{$result['exception']};";
        }

        parent::__construct($message, $code, $previous);
    }
}