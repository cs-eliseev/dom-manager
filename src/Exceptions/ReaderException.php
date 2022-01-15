<?php

declare(strict_types=1);

namespace cse\DOMManager\Exceptions;

use cse\DOMManager\Contracts\IDomManagerExceptionable;

class ReaderException extends \Exception implements IDomManagerExceptionable
{
    /**
     * ReaderException constructor.
     *
     * @param string $message
     * @param null $code
     */
    public function __construct(string $message, $code = null)
    {
        parent::__construct($message, $code ?: 4);
    }
}
