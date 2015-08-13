<?php

namespace Weew\Http;

class CookieParser {
    /**
     * @param $string
     *
     * @return Cookie
     */
    public function parse($string) {
        $cookie = $this->createCookie();
        $cookie->setSecure(false);
        $cookie->setHttpOnly(false);

        $parts = explode(';', $string);

        foreach ($parts as $part) {
            $part = trim($part);
            $this->parseFlags($cookie, $part);
            $this->parseProperties($cookie, $part);
        }

        return $cookie;
    }

    /**
     * @param ICookie $cookie
     * @param $string
     */
    protected function parseFlags(ICookie $cookie, $string) {
        if (strlen($string) == 0) {
            return;
        }

        if ($string == 'secure') {
            $cookie->setSecure(true);
        } else if ($string == 'httpOnly') {
            $cookie->setHttpOnly(true);
        }
    }

    /**
     * @param ICookie $cookie
     * @param $string
     */
    protected function parseProperties(ICookie $cookie, $string) {
        if (strpos($string, '=') === false) {
            return;
        }

        list($key, $value) = explode('=', $string);

        $key = trim($key);
        $value = trim($value);

        if (strlen($key) == 0 || strlen($value) == 0) {
            return;
        }

        if ($key == 'max-age') {
            $cookie->setMaxAge(intval($value));
        } else if ($key == 'path') {
            $cookie->setPath($value);
        } else if ($key == 'domain') {
            $cookie->setDomain($value);
        } else if ($key == 'expires') {
            return;
        } else {
            $cookie->setName($key);
            $cookie->setValue($value);
        }
    }

    /**
     * @return Cookie
     */
    protected function createCookie() {
        return new Cookie();
    }
}
