<?php

namespace Miviskin\Visitor;

class IP implements IPInterface
{
    use PropertyReadableTrait;

    /**
     * IP value.
     *
     * @var string
     */
    protected $ip;

    /**
     * IP version.
     *
     * @var int
     */
    protected $version;

    /**
     * IP constructor.
     *
     * @param string $ip
     */
    public function __construct($ip)
    {
        if (preg_match(static::getIPv4Pattern(), $ip = trim($ip))) {
            $this->ip      = $ip;
            $this->version = 4;
        } else if (preg_match(static::getIPv6Pattern(), $ip)) {
            $this->ip      = $ip;
            $this->version = 6;
        }
    }

    /**
     * Get IPv4 regexp pattern.
     *
     * @return string
     */
    public static function getIPv4Pattern()
    {
        return '~^(?:(?:25[0-5]|(?:2[0-4]|1[0-9]|[1-9]?)[0-9])[.]){3}(?:25[0-5]|(?:2[0-4]|1[0-9]|[1-9]?)[0-9])$~';
    }

    /**
     * Get IPv6 regexp pattern.
     *
     * @return string
     */
    public static function getIPv6Pattern()
    {
        return '~^(
            ([a-f0-9]{1,4}:){7}[a-f0-9]{1,4}|               # 1:2:3:4:5:6:7:8
            ([a-f0-9]{1,4}:){1,7}:|                         # 1::                                 1:2:3:4:5:6:7::
            ([a-f0-9]{1,4}:){1,6}:[a-f0-9]{1,4}|            # 1::8               1:2:3:4:5:6::8   1:2:3:4:5:6::8
            ([a-f0-9]{1,4}:){1,5}(:[a-f0-9]{1,4}){1,2}|     # 1::7:8             1:2:3:4:5::7:8   1:2:3:4:5::8
            ([a-f0-9]{1,4}:){1,4}(:[a-f0-9]{1,4}){1,3}|     # 1::6:7:8           1:2:3:4::6:7:8   1:2:3:4::8
            ([a-f0-9]{1,4}:){1,3}(:[a-f0-9]{1,4}){1,4}|     # 1::5:6:7:8         1:2:3::5:6:7:8   1:2:3::8
            ([a-f0-9]{1,4}:){1,2}(:[a-f0-9]{1,4}){1,5}|     # 1::4:5:6:7:8       1:2::4:5:6:7:8   1:2::8
            [a-f0-9]{1,4}:((:[a-f0-9]{1,4}){1,6})|          # 1::3:4:5:6:7:8     1::3:4:5:6:7:8   1::8
            :((:[a-f0-9]{1,4}){1,7}|:)|                     # ::2:3:4:5:6:7:8    ::2:3:4:5:6:7:8  ::8       ::
            fe80:(:[a-f0-9]{1,4}){0,4}%[a-z0-9]+|           # fe80::7:8%eth0     fe80::7:8%1  (link-local IPv6 addresses with zone index)
            ::(ffff(:0{1,4}){0,1}:){0,1}
            ((25[0-5]|(2[0-4]|1[0-9]|[1-9]?)[0-9])[.]){3}
            (25[0-5]|(?:2[0-4]|1[0-9]|[1-9]?)[0-9])|        # ::255.255.255.255  ::ffff:255.255.255.255  ::ffff:0:255.255.255.255 (IPv4-mapped IPv6 addresses and IPv4-translated addresses)
            ([a-f0-9]{1,4}:){1,4}:
            ((25[0-5]|(2[0-4]|1[0-9]|[1-9]?)[0-9])[.]){3}
            (25[0-5]|(?:2[0-4]|1[0-9]|[1-9]?)[0-9])         # 2001:db8:3:4::192.0.2.33  64:ff9b::192.0.2.33 (IPv4-Embedded IPv6 Address)
            )$~ix';
    }

    /**
     * Determine if IP is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->ip !== null;
    }

    /**
     * Convert to string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->ip;
    }
}
