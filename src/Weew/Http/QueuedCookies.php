<?php

namespace Weew\Http;

class QueuedCookies implements IQueuedCookies {
    /**
     * @var array
     */
    protected $cookies = [];

    /**
     * @var IHttpHeaders
     */
    private $headers;

    /**
     * @param IHttpHeaders $headers
     */
    public function __construct(IHttpHeaders $headers) {
        $this->headers = $headers;
    }

    /**
     * Cloning this object should also clone
     * all of its cookies.
     */
    public function __clone() {
        $cookies = [];

        foreach ($this->cookies as $name => $cookie) {
            $cookies[$name] = clone($cookie);
        }

        $this->cookies = $cookies;
    }

    /**
     * @param ICookie $cookie
     */
    public function add(ICookie $cookie) {
        array_set($this->cookies, $cookie->getName(), $cookie);
        $this->headers->add($this->getHeaderKey(), $cookie->toString());
    }

    /**
     * @param $key
     *
     * @return ICookie
     */
    public function findByName($key) {
        return array_get($this->cookies, $key);
    }

    /**
     * @param $key
     */
    public function removeByName($key) {
        /** @var ICookie $cookie */
        $cookie = array_get($this->cookies, $key);
        array_remove($this->cookies, $key);

        if ($cookie !== null) {
            $cookie = $cookie->toString();
            $headers = $this->headers->get($this->getHeaderKey());

            foreach ($headers as $index => $header) {
                if ($header == $cookie) {
                    $this->headers->remove(s('%s.%s', $this->getHeaderKey(), $index));
                }
            }
        }
    }

    /**
     * @return array
     */
    public function toArray() {
        $array = [];

        /** @var ICookie $cookie */
        foreach ($this->cookies as $cookie) {
            $array[] = $cookie->toArray();
        }

        return $array;
    }

    /**
     * @return string
     */
    protected function getHeaderKey() {
        return 'set-cookie';
    }
}
