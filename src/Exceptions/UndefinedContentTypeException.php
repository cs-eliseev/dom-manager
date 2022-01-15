<?php

declare(strict_types=1);

namespace cse\DOMManager\Exceptions;

class UndefinedContentTypeException extends AbstractDomManageException
{
    /**
     * @return string
     */
    protected function message(): string
    {
        return 'Undefined content type';
    }

    /**
     * @return int
     */
    protected function code(): int
    {
        return 2;
    }

}
