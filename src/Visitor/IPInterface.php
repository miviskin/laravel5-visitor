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

    /**
     * Determine if IP is local.
     *
     * @return bool
     */
    public function isLocal();

    /**
     * Determine if IP is internal.
     *
     * @return bool
     */
    public function isInternal();

    /**
     * Convert to string representation.
     *
     * @return string
     */
    public function __toString();
}
