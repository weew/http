<?php

namespace Weew\Http;

interface IHttpBasicAuth {
    /**
     * @return string
     */
    function getUsername();

    /**
     * @param string $username
     */
    function setUsername($username);

    /**
     * @return string
     */
    function getPassword();

    /**
     * @param string $password
     */
    function setPassword($password);

    /**
     * @return bool
     */
    function hasBasicAuth();

    /**
     * @return
     */
    function getBasicAuthToken();

    /**
     * Remove basic authentication.
     */
    function removeBasicAuth();
}
