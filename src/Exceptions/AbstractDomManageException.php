<?php

declare(strict_types=1);

namespace cse\DOMManager\Exceptions;

use cse\DOMManager\Contracts\IDomManagerExceptionable;

abstract class AbstractDomManageException extends \Exception implements IDomManagerExceptionable
{
    /**
     * AbstractDomManageException constructor.
     */
    public function __construct()
    {
        parent::__construct($this->message(), $this->code());
    }

    /**
     * @return string
     */
    abstract protected function message(): string;

    /**
     * @return int
     */
    abstract protected function code(): int;
}
