<?php

namespace Miviskin\Visitor;

/**
 * Class URL
 *
 * @package Miviskin\Visitor
 *
 * @property-read string $source
 * @property-read string $url
 * @property-read string $scheme
 * @property-read string $authority
 * @property-read string $userinfo
 * @property-read string $username
 * @property-read string $password
 * @property-read string $host
 * @property-read string $domain
 * @property-read string $port
 * @property-read string $uri
 * @property-read string $path
 * @property-read string $query
 * @property-read string $fragment
 */
class URL implements URLInterface
{
    use PropertyReadableTrait;

    /**
     * Source URL.
     *
     * @var string
     */
    protected $source;

    /**
     * Parsed URL.
     *
     * @var string
     */
    protected $url;

    /**
     * URL scheme.
     *
     * @var string
     */
    protected $scheme;

    /**
     * Authority.
     *
     * @var string
     */
    protected $authority;

    /**
     * Userinfo.
     *
     * @var string
     */
    protected $userinfo;

    /**
     * Username.
     *
     * @var string
     */
    protected $username;

    /**
     * Password for username.
     *
     * @var string
     */
    protected $password;

    /**
     * Host.
     *
     * @var string
     */
    protected $host;

    /**
     * Domain.
     *
     * @var string
     */
    protected $domain;

    /**
     * Port.
     *
     * @var string
     */
    protected $port;

    /**
     * Uri.
     *
     * @var string
     */
    protected $uri;

    /**
     * Path.
     *
     * @var string
     */
    protected $path;

    /**
     * Query.
     *
     * @var string
     */
    protected $query;

    /**
     * Fragment.
     *
     * @var string
     */
    protected $fragment;

    /**
     * URL constructor.
     *
     * @param string $url
     */
    public function __construct($url)
    {
        if (preg_match(static::getUrlPattern(), $this->source = trim($url), $matches)) {
            foreach ($matches as $property => $value) {
                if (is_string($property)) {
                    $this->$property = $value;
                }
            }
        }
    }

    /**
     * Get url regexp pattern.
     *
     * @return string
     */
    public static function getUrlPattern()
    {
        return '~^
            (?P<url>
                (?:
                    (?: (?P<scheme> [^:]+ ): )?
                    //
                    (?P<authority>
                        (?: (?P<userinfo> (?P<username> [^:]+ ) (?: [:](?P<password> [^@]+ ) )? )[@] )?
                        (?P<host>
                            (?P<domain> (?: (?: (?<![/@])[.] )? [a-z0-9][a-z0-9-]*[a-z0-9] )+ ) # Domain (IDN | Punycode)
                            |
                            (?: (?: (?<![/@])[.] ) (?: 25[0-5] | (?: 2[0-4] | 1[0-9] | [1-9]? ) [0-9] ) ){4} # IPv4
                        )
                        (?: [:](?P<port> [1-9][0-9]* ) )?
                    )
                )?
                (?P<uri>
                    (?P<path> (?: [/][a-z0-9\~%!@$&\'()*+,;:=._-]* )+ )
                    (?: [?](?P<query> [a-z0-9\~%!@$&\'()*+,;:=._/?-]* ) )?
                )
                (?: [#](?P<fragment> [a-z0-9\~%!@$&\'()*+,;:=._/?-]* ) )?
            )$~uix';
    }

    /**
     * Determine if url is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->source === '';
    }

    /**
     * Determine if url is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->isEmpty() || $this->source === $this->url;
    }

    /**
     * Determine if url is real.
     *
     * @return bool
     */
    public function isReal()
    {
        return $this->isValid() && $this->domain && dns_check_record($this->domain, 'ANY');
    }

    /**
     * Convert to string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->url;
    }
}
