<?php

namespace Miviskin\Visitor;

interface URLInterface
{
    /**
     * Determine if url is empty.
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Determine if url is valid.
     *
     * @return bool
     */
    public function isValid();

    /**
     * Determine if url is real.
     *
     * @return bool
     */
    public function isReal();
}
