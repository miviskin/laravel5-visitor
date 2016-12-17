<?php

namespace Miviskin\Visitor;

interface BrowserInterface
{
    /**
     * Determine if browser is search robot.
     *
     * @return bool
     */
    public function isRobot();

    /**
     * Determine if browser is desktop version
     *
     * @return bool
     */
    public function isDesktop();

    /**
     * Determine if browser is mobile version.
     *
     * @return bool
     */
    public function isMobile();

    /**
     * Determine if browser is valid.
     *
     * @return bool
     */
    public function isValid();

    /**
     * Convert to string representation.
     *
     * @return string
     */
    public function __toString();
}
