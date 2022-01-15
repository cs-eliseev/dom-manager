<?php

declare(strict_types=1);

namespace cse\DOMManager\Exceptions;

class EmptyContentException extends AbstractDomManageException
{
    /**
     * @return string
     */
    protected function message(): string
    {
        return 'Content is empty';
    }

    /**
     * @return int
     */
    protected function code(): int
    {
        return 1;
    }
}
