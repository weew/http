<?php

namespace Weew\Http;

class HttpBasicAuth implements IHttpBasicAuth {
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @param null $username
     * @param null $password
     */
    public function __construct($username = null, $password = null) {
        if ($username !== null) {
            $this->setUsername($username);
            $this->setPassword($password);
        }
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function hasBasicAuth() {
        return $this->username !== null;
    }

    /**
     * @return string
     */
    public function getBasicAuthToken() {
        return base64_encode(s('%s:%s', $this->getUsername(), $this->getPassword()));
    }

    /**
     * Remove basic authentication.
     */
    public function removeBasicAuth() {
        $this->setUsername(null);
        $this->setPassword(null);
    }

    /**
     * Write basic auth headers.
     *
     * @param IHttpHeaders $headers
     */
    public function writeHeaders(IHttpHeaders $headers) {
        if ($this->hasBasicAuth()) {
            $headers->set($this->getHeaderKey(), $this->getHeaderValue());
        }
    }

    /**
     * @return string
     */
    public function getHeaderKey() {
        return 'Authorization';
    }

    /**
     * @return string
     */
    public function getHeaderValue() {
        return s('Basic %s', $this->getBasicAuthToken());
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            'token' => $this->getBasicAuthToken(),
        ];
    }
}
