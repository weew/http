<?php

namespace Weew\Http;

class HttpBasicAuth implements IHttpBasicAuth {
    /**
     * @var IHttpHeadersHolder
     */
    protected $holder;

    /**
     * @var BasicAuthParser
     */
    protected $parser;

    /**
     * @param IHttpHeadersHolder $holder
     * @param null $username
     * @param null $password
     */
    public function __construct(IHttpHeadersHolder $holder, $username = null, $password = null) {
        $this->holder = $holder;
        $this->parser = $this->createParser();

        if ($username !== null) {
            $this->parser->setCredentials($this->holder->getHeaders(), $username, $password);
        }
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->parser->getUsername($this->holder->getHeaders());
    }

    /**
     * @param $username
     */
    public function setUsername($username) {
        $this->parser->setUsername($this->holder->getHeaders(), $username);
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->parser->getPassword($this->holder->getHeaders());
    }

    /**
     * @param $password
     */
    public function setPassword($password) {
        $this->parser->setPassword($this->holder->getHeaders(), $password);
    }

    /**
     * @return null|string
     */
    public function getToken() {
        return $this->parser->getToken($this->holder->getHeaders());
    }

    /**
     * @param $token
     */
    public function setToken($token) {
        $this->parser->setToken($this->holder->getHeaders(), $token);
    }

    /**
     * @return bool
     */
    public function hasBasicAuth() {
        return $this->parser->hasBasicAuth($this->holder->getHeaders());
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
