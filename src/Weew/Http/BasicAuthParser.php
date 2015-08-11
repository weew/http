<?php

namespace Weew\Http;

/**
 * Parser for authorization headers.
 *
 * Class BasicAuthParser
 */
class BasicAuthParser implements IBasicAuthParser {
    /**
     * @param IHttpHeaders $headers
     *
     * @return string
     */
    public function getHeader(IHttpHeaders $headers) {
        return $headers->find('authorization');
    }

    /**
     * @param IHttpHeaders $headers
     * @param $header
     */
    public function setHeader(IHttpHeaders $headers, $header) {
        $headers->set('authorization', $header);
    }

    /**
     * @param IHttpHeaders $headers
     *
     * @return null|string
     */
    public function getToken(IHttpHeaders $headers) {
        $header = $this->getHeader($headers);

        return $this->parseHeader($header);
    }

    /**
     * @param IHttpHeaders $headers
     * @param $token
     */
    public function setToken(IHttpHeaders $headers, $token) {
        $header = $this->createHeader($token);
        $this->setHeader($headers, $header);
    }

    /**
     * @param IHttpHeaders $headers
     *
     * @return array
     */
    public function getCredentials(IHttpHeaders $headers) {
        $token = $this->getToken($headers);

        return $this->parseToken($token);
    }

    /**
     * @param IHttpHeaders $headers
     * @param $username
     * @param $password
     */
    public function setCredentials(IHttpHeaders $headers, $username, $password) {
        $token = $this->createToken($username, $password);
        $this->setToken($headers, $token);
    }

    /**
     * @param IHttpHeaders $headers
     *
     * @return string
     */
    public function getUsername(IHttpHeaders $headers) {
        return $this->getCredentials($headers)[0];
    }

    /**
     * @param IHttpHeaders $headers
     * @param $username
     */
    public function setUsername(IHttpHeaders $headers, $username) {
        $this->setCredentials($headers, $username, $this->getPassword($headers));
    }

    /**
     * @param IHttpHeaders $headers
     *
     * @return string
     */
    public function getPassword(IHttpHeaders $headers) {
        return $this->getCredentials($headers)[1];
    }

    /**
     * @param IHttpHeaders $headers
     * @param $password
     */
    public function setPassword(IHttpHeaders $headers, $password) {
        $this->setCredentials($headers, $this->getUsername($headers), $password);
    }

    /**
     * @param IHttpHeaders $headers
     *
     * @return bool
     */
    public function hasBasicAuth(IHttpHeaders $headers) {
        return $this->parseHeader($this->getHeader($headers)) !== null;
    }

    /**
     * @param $username
     * @param $password
     *
     * @return string
     */
    public function createToken($username, $password) {
        return base64_encode(s('%s:%s', $username, $password));
    }

    /**
     * @param $token
     *
     * @return array
     */
    public function parseToken($token) {
        $token = base64_decode($token);
        $parts = explode(':', $token, 2);

        return [array_get($parts, 0), array_get($parts, 1)];
    }

    /**
     * @param $token
     *
     * @return string
     */
    public function createHeader($token) {
        return s('basic %s', $token);
    }

    /**
     * @param $header
     *
     * @return null|string
     */
    public function parseHeader($header) {
        if (str_starts_with($header, 'basic')) {
            return trim(substr($header, strlen('basic')));
        }

        return null;
    }
}
