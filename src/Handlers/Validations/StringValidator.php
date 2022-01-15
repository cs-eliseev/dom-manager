<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\Validations;

use cse\DOMManager\Exceptions\EmptyContentException;

class StringValidator
{
    /**
     * @param string $content
     *
     * @return StringValidator
     *
     * @throws EmptyContentException
     */
    public function notEmptyString(string $content): StringValidator
    {
        if ($content === '') {
            throw new EmptyContentException();
        }

        return $this;
    }
}
