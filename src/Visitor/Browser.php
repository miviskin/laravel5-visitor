<?php

namespace Miviskin\Visitor;

/**
 * Class Browser
 *
 * @package Miviskin\Visitor
 *
 * @property-read string $userAgent
 * @property-read string $platform
 * @property-read string $device
 * @property-read string $robot
 * @property-read string $name
 */
class Browser implements BrowserInterface
{
    use PropertyReadableTrait;

    /**
     * Browser user agent.
     *
     * @var string
     */
    protected $userAgent;

    /**
     * Uses platform.
     *
     * @var string
     */
    protected $platform;

    /**
     * Uses device.
     *
     * @var string
     */
    protected $device;

    /**
     * Robot name.
     *
     * @var string
     */
    protected $robot;

    /**
     * Browser name.
     *
     * @var string
     */
    protected $name;

    /**
     * Browser constructor.
     *
     * @param string $userAgent
     * @param array  $rules
     */
    public function __construct($userAgent, array $rules)
    {
        foreach ($rules as $property => $rules) {
            $this->$property = $this->findFirstMatch($userAgent, $rules);
        }

        $this->userAgent = $userAgent;
    }

    /**
     * Create new Browser instance.
     *
     * @param string $userAgent
     * @param array  $rules
     *
     * @return static
     */
    public static function create($userAgent, array $rules)
    {
        return new static($userAgent, $rules);
    }

    /**
     * Find first match in given string.
     *
     * @param string $string
     * @param array  $rules
     *
     * @return null|string
     */
    protected function findFirstMatch($string, array $rules)
    {
        if (strlen($string)) {
            foreach ($rules as $name => $regexp) {
                if (preg_match('/' . addcslashes($regexp, '/') . '/i', $string)) {
                    return $name;
                }
            }
        }
    }

    /**
     * Determine if browser is search robot.
     *
     * @return bool
     */
    public function isRobot()
    {
        return $this->robot !== null;
    }

    /**
     * Determine if browser is desktop version
     *
     * @return bool
     */
    public function isDesktop()
    {
        return 'desktop' === strtolower($this->device);
    }

    /**
     * Determine if browser is mobile version.
     *
     * @return bool
     */
    public function isMobile()
    {
        return 'mobile' === strtolower($this->device);
    }

    /**
     * Determine if browser is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->platform && $this->device && $this->name;
    }

    /**
     * Convert to string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name ?: 'Unknown';
    }
}
