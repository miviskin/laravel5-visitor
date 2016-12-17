<?php

namespace Miviskin\Visitor;

use Illuminate\Http\Request;

class Visitor implements VisitorInterface
{
    use PropertyReadableTrait;

    /**
     * Request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * Browser instance.
     *
     * @var BrowserInterface
     */
    protected $browser;

    /**
     * Referer instance.
     *
     * @var URLInterface
     */
    protected $referer;

    /**
     * URL  instance.
     *
     * @var URLInterface
     */
    protected $url;

    /**
     * IP instance.
     *
     * @var IPInterface
     */
    protected $ip;

    /**
     * Proxy headers.
     *
     * @var array
     */
    protected $proxyHeaders = [
        'HTTP_VIA',
        'HTTP_FORWARDED',
        'HTTP_X_FORWARDED',
        'HTTP_COMING_FROM',
        'HTTP_X_COMING_FROM',
        'HTTP_FORWARDED_FOR',
        'HTTP_X_FORWARDED_FOR',
    ];

    /**
     * Visitor constructor.
     *
     * @param Request          $request
     * @param BrowserInterface $browser
     * @param URLInterface     $referer
     * @param URLInterface     $url
     * @param IPInterface      $ip
     */
    public function __construct(
        Request $request,
        BrowserInterface $browser,
        URLInterface $referer,
        URLInterface $url,
        IPInterface $ip
    ) {
        $this->request = $request;
        $this->browser = $browser;
        $this->referer = $referer;
        $this->url     = $url;
        $this->ip      = $ip;
    }

    /**
     * Get visitor browser.
     *
     * @return BrowserInterface
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * Get visitor referer url.
     *
     * @return URLInterface
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * Get visitor request url.
     *
     * @return URLInterface
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get visitor IP.
     *
     * @return IPInterface
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Get visitor platform.
     *
     * @return string
     */
    public function getPlatform()
    {
        return $this->browser->platform;
    }

    /**
     * Get visitor device.
     *
     * @return string
     */
    public function getDevice()
    {
        return $this->browser->device;
    }

    /**
     * Get robot.
     *
     * @return string
     */
    public function getRobot()
    {
        return $this->isRobot()
            ? $this->browser->robot
            : $this->browser->name;
    }

    /**
     * Determine if visitor is search robot.
     *
     * @return bool
     */
    public function isRobot()
    {
        return $this->browser->isRobot();
    }

    /**
     * Determine if visitor uses desktop.
     *
     * @return bool
     */
    public function usesDesktop()
    {
        return $this->browser->isDesktop();
    }

    /**
     * Determine if visitor uses mobile.
     *
     * @return bool
     */
    public function usesMobile()
    {
        return $this->browser->isMobile();
    }

    /**
     * Determine if visitor uses proxy.
     *
     * @return bool
     */
    public function usesProxy()
    {
        if ($this->ip->isValid()) {
            $ip = (string)$this->ip;

            foreach ($this->proxyHeaders as $key) {
                $proxy = $this->request->server($key);

                if ($proxy && $proxy !== $ip) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Dynamically get property.
     *
     * @param string $property
     *
     * @return null|mixed
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        if (method_exists($this, $method = 'get' . ucfirst($property))) {
            return $this->$method();
        }
    }

    /**
     * Dynamically isset property.
     *
     * @param string $property
     *
     * @return bool
     */
    public function __isset($property)
    {
        return property_exists($this, $property) || method_exists($this, 'get' . ucfirst($property));
    }
}
