<?php

namespace Weew\Http;

use Weew\Foundation\Interfaces\IArrayable;

interface IHttpBasicAuth extends IArrayable {
    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param $username
     */
    public function setUsername($username);

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param $password
     */
    public function setPassword($password);

    /**
     * @return bool
     */
    public function hasBasicAuth();

    /**
     * @return string
     */
    public function getToken();

    /**
     * @param $token
     */
    public function setToken($token);
}
