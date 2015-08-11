<?php
namespace Weew\Http;

/**
 * Parser for authorization headers.
 *
 * Class BasicAuthParser
 */
interface IBasicAuthParser {
    /**
     * @param IHttpHeaders $headers
     *
     * @return string
     */
    function getHeader(IHttpHeaders $headers);

    /**
     * @param IHttpHeaders $headers
     * @param $header
     */
    function setHeader(IHttpHeaders $headers, $header);

    /**
     * @param IHttpHeaders $headers
     *
     * @return null|string
     */
    function getToken(IHttpHeaders $headers);

    /**
     * @param IHttpHeaders $headers
     * @param $token
     */
    function setToken(IHttpHeaders $headers, $token);

    /**
     * @param IHttpHeaders $headers
     *
     * @return array
     */
    function getCredentials(IHttpHeaders $headers);

    /**
     * @param IHttpHeaders $headers
     * @param $username
     * @param $password
     */
    function setCredentials(IHttpHeaders $headers, $username, $password);

    /**
     * @param IHttpHeaders $headers
     *
     * @return string
     */
    function getUsername(IHttpHeaders $headers);

    /**
     * @param IHttpHeaders $headers
     * @param $username
     */
    function setUsername(IHttpHeaders $headers, $username);

    /**
     * @param IHttpHeaders $headers
     *
     * @return string
     */
    function getPassword(IHttpHeaders $headers);

    /**
     * @param IHttpHeaders $headers
     * @param $password
     */
    function setPassword(IHttpHeaders $headers, $password);

    /**
     * @param IHttpHeaders $headers
     *
     * @return bool
     */
    function hasBasicAuth(IHttpHeaders $headers);
}
