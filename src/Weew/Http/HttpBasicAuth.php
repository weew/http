<?php

namespace Weew\Http;

class HttpBasicAuth implements IHttpBasicAuth {
    /**
     * @var IHttpHeaders
     */
    protected $headers;

    /**
     * @var BasicAuthParser
     */
    protected $parser;

    /**
     * @param IHttpHeaders $headers
     * @param null $username
     * @param null $password
     */
    public function __construct(IHttpHeaders $headers, $username = null, $password = null) {
        $this->headers = $headers;
        $this->parser = $this->createParser();

        if ($username !== null) {
            $this->parser->setCredentials($this->headers, $username, $password);
        }
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->parser->getUsername($this->headers);
    }

    /**
     * @param $username
     */
    public function setUsername($username) {
        $this->parser->setUsername($this->headers, $username);
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->parser->getPassword($this->headers);
    }

    /**
     * @param $password
     */
    public function setPassword($password) {
        $this->parser->setPassword($this->headers, $password);
    }

    /**
     * @return null|string
     */
    public function getToken() {
        return $this->parser->getToken($this->headers);
    }

    /**
     * @param $token
     */
    public function setToken($token) {
        $this->parser->setToken($this->headers, $token);
    }

    /**
     * @return bool
     */
    public function hasBasicAuth() {
        return $this->parser->hasBasicAuth($this->headers);
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            'token' => $this->getToken(),
        ];
    }

    /**
     * @return BasicAuthParser
     */
    protected function createParser() {
        return new BasicAuthParser();
    }
}
