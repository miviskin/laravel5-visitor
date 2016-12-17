<?php

namespace Miviskin\Visitor;

interface IPInterface
{
    /**
     * Determine if IP is valid.
     *
     * @return bool
     */
    public function isValid();
}
