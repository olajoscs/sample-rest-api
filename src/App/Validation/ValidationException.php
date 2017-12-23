<?php

namespace App\Validation;

/**
 * Class ValidationException
 *
 * Exception for validation errors
 */
class ValidationException extends \Exception
{
    /**
     * Create a new ValidationException object
     *
     * @param array $messages
     */
    public function __construct(array $messages)
    {
        $message = array_map(function (array $m) {
            return implode('; ', $m);
        }, $messages);

        $message = implode('; ', $message);

        parent::__construct($message);
    }
}
