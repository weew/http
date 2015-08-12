<?php

namespace Weew\Http;

class Cookie implements ICookie {
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var int
     */
    protected $maxAge;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var bool
     */
    protected $secure;

    /**
     * @var bool
     */
    protected $httpOnly;

    /**
     * @param $string
     * @param ICookieParser $parser
     *
     * @return static
     */
    public static function createFromString($string, ICookieParser $parser = null) {
        if ( ! $parser instanceof ICookieParser) {
             $parser = new CookieParser();
        }

        return $parser->parse($string);
    }

    /**
     * @param null $name
     * @param null $value
     */
    public function __construct($name = null, $value = null) {
        $this->setDefaults();

        if ($name !== null) {
            $this->setName($name);
        }

        if ($value !== null) {
            $this->setValue($value);
        }
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function hasName() {
        return $this->getName() !== null;
    }

    /**
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value) {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function hasValue() {
        return $this->getValue() !== null;
    }

    /**
     * @return int
     */
    public function getMaxAge() {
        return $this->maxAge;
    }

    /**
     * @param int $maxAge
     */
    public function setMaxAge($maxAge) {
        $this->maxAge = $maxAge;
    }

    /**
     * @return bool
     */
    public function hasMaxAge() {
        return $this->getMaxAge() !== null;
    }

    /**
     * @return int
     */
    public function getExpires() {
        if ( ! $this->hasMaxAge()) {
            return null;
        }

        return time() + $this->getMaxAge();
    }

    /**
     * @return string
     */
    public function getExpiresDate() {
        if ( ! $this->hasMaxAge()) {
            return null;
        }

        return gmdate('D, d-M-Y H:i:s \G\M\T', $this->getExpires());
    }

    /**
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path) {
        $this->path = $path;
    }

    /**
     * @return bool
     */
    public function hasPath() {
        return ! in_array($this->getPath(), ['/', null]);
    }

    /**
     * @return string
     */
    public function getDomain() {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain($domain) {
        $this->domain = $domain;
    }

    /**
     * @return bool
     */
    public function hasDomain() {
        return $this->getDomain() !== null;
    }

    /**
     * @return bool
     */
    public function getSecure() {
        return $this->secure;
    }

    /**
     * @return bool
     */
    public function isSecure() {
        return $this->getSecure() == true;
    }

    /**
     * @param bool $secure
     */
    public function setSecure($secure) {
        $this->secure = $secure;
    }

    /**
     * @return bool
     */
    public function getHttpOnly() {
        return $this->httpOnly;
    }

    /**
     * @return bool
     */
    public function isHttpOnly() {
        return $this->getHttpOnly() == true;
    }

    /**
     * @param bool $httpOnly
     */
    public function setHttpOnly($httpOnly) {
        $this->httpOnly = $httpOnly;
    }

    /**
     * Send response.
     */
    public function send() {
        if ( ! headers_sent()) {
            setcookie(
                $this->getName(),
                $this->getValue(),
                $this->getExpires(),
                $this->getPath(),
                $this->getDomain(),
                $this->getSecure(),
                $this->getHttpOnly()
            );
        }
    }

    /**
     * @return string
     */
    public function toString() {
        $string = s('%s=%s;', $this->getName(), $this->getValue());

        if ($this->hasMaxAge()) {
            $string .= s(' expires=%s;', $this->getExpiresDate());
            $string .= s(' max-age=%s;', $this->getMaxAge());
        }

        $string .= s(' path=%s;', $this->getPath());

        if ($this->hasDomain()) {
            $string .= s(' domain=%s;', $this->getDomain());
        }

        if ($this->isSecure()) {
            $string .= ' secure;';
        }

        if ($this->isHttpOnly()) {
            $string .= ' httpOnly';
        }

        return $string;
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'name' => $this->getName(),
            'value' => $this->getValue(),
            'expires' => $this->getExpiresDate(),
            'max-age' => $this->getMaxAge(),
            'path' => $this->getPath(),
            'domain' => $this->getDomain(),
            'secure' => $this->getSecure(),
            'httpOnly' => $this->getHttpOnly(),
        ];
    }

    /**
     * Provide new cookie instance with sensible defaults.
     * Feel free to override it with your own defaults.
     */
    protected function setDefaults() {
        $this->setPath('/');
        $this->setSecure(false);
        $this->setHttpOnly(true);
    }
}
