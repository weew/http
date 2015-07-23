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
    function removeBasicAuth() {
        $this->username = null;
        $this->password = null;
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
