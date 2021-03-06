<?php

namespace Weew\Http;

class Cookies implements ICookies {
    /**
     * @var array
     */
    protected $cookies = [];

    /**
     * @var IHttpHeadersHolder
     */
    private $holder;

    /**
     * @param IHttpHeadersHolder $holder
     */
    public function __construct(IHttpHeadersHolder $holder) {
        $this->holder = $holder;
        $this->searchCookiesInHeaders();
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
        $this->storeCookie($cookie);
        $this->holder->getHeaders()->add('set-cookie', $cookie->toString());
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
            $headers = $this->holder->getHeaders()->get('set-cookie');

            foreach ($headers as $index => $header) {
                if ($header == $cookie) {
                    $this->holder->getHeaders()->remove(s('%s.%s', 'set-cookie', $index));
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
     * @param ICookie $cookie
     */
    protected function storeCookie(ICookie $cookie) {
        array_set($this->cookies, $cookie->getName(), $cookie);
    }

    /**
     * Parse headers for cookies.
     */
    protected function searchCookiesInHeaders() {
        $headers = $this->holder->getHeaders()->get('set-cookie');

        foreach ($headers as $header) {
            $cookie = $this->createCookieFromHeader($header);

            if ($cookie !== null) {
                $this->storeCookie($cookie);
            }
        }
    }

    /**
     * @param $header
     *
     * @return ICookie
     */
    protected function createCookieFromHeader($header) {
        return Cookie::createFromString($header);
    }
}
