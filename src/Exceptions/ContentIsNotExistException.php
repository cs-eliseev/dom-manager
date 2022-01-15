<?php

declare(strict_types=1);

namespace cse\DOMManager\Exceptions;

class ContentIsNotExistException extends AbstractDomManageException
{
    /**
     * @return string
     */
    protected function message(): string
    {
        return 'Content is not exist';
    }

    /**
     * @return int
     */
    protected function code(): int
    {
        return 3;
    }
}
