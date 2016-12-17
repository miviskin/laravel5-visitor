<?php

namespace Miviskin\Visitor;

interface VisitorInterface
{
    /**
     * Get visitor browser.
     *
     * @return BrowserInterface
     */
    public function getBrowser();

    /**
     * Get visitor referer url.
     *
     * @return URLInterface
     */
    public function getReferer();

    /**
     * Get visitor request url.
     *
     * @return URLInterface
     */
    public function getUrl();

    /**
     * Get visitor IP.
     *
     * @return IPInterface
     */
    public function getIp();

    /**
     * Get visitor platform.
     *
     * @return string
     */
    public function getPlatform();

    /**
     * Get visitor device.
     *
     * @return string
     */
    public function getDevice();

    /**
     * Get robot.
     *
     * @return string
     */
    public function getRobot();

    /**
     * Determine if visitor is robot.
     *
     * @return bool
     */
    public function isRobot();

    /**
     * Determine if visitor uses desktop.
     *
     * @return bool
     */
    public function usesDesktop();

    /**
     * Determine if visitor uses mobile.
     *
     * @return bool
     */
    public function usesMobile();

    /**
     * Determine if visitor uses proxy.
     *
     * @return bool
     */
    public function usesProxy();
}
