<?php

namespace Weew\Http;

class ReceivedHeadersParser implements IReceivedHeadersParser {
    /**
     * @param array $server
     * @param array $specialHeaders
     *
     * @return HttpHeaders
     */
    public function parseHeaders(array $server, array $specialHeaders = []) {
        $specialHeaders = $this->getSpecialHeaders($specialHeaders);

        $headers = new HttpHeaders();
        $this->extractPrefixedHeaders($headers, $server);
        $this->extractSpecialHeaders($headers, $server, $specialHeaders);
        $this->extractAuthHeaders($headers, $server);

        return $headers;
    }

    /**
     * @param IHttpHeaders $headers
     * @param array $server
     * @param string $prefix
     */
    public function extractPrefixedHeaders(IHttpHeaders $headers, array $server, $prefix = 'HTTP_') {
        foreach ($server as $header => $value) {
            if (str_starts_with($header, $prefix)) {
                $headers->add(
                    $this->formatHeaderAndRemovePrefix($header, $prefix), $value
                );
            }
        }
    }

    /**
     * @param IHttpHeaders $headers
     * @param array $server
     * @param array $specialHeaders
     */
    public function extractSpecialHeaders(
        IHttpHeaders $headers,
        array $server,
        array $specialHeaders
    ) {
        foreach ($server as $header => $value) {
            if (in_array($header, $specialHeaders)) {
                $headers->add(
                    $this->formatHeader($header), $value
                );
            }
        }
    }

    /**
     * @param IHttpHeaders $headers
     * @param array $server
     */
    public function extractAuthHeaders(IHttpHeaders $headers, array $server) {
        if ( ! $headers->has('authorization')) {
            $this->writeBasicAuthHeaders($headers, $server);
        }

        if ( ! $headers->has('authorization')) {
            $this->writeCommonAuthHeaders($headers, $server);
        }
    }

    /**
     * @param IHttpHeaders $headers
     * @param array $server
     */
    public function writeBasicAuthHeaders(IHttpHeaders $headers, array $server) {
        $username = array_get($server, 'PHP_AUTH_USER');
        $password = array_get($server, 'PHP_AUTH_PW');

        if ($username !== null) {
            new HttpBasicAuth(new HttpRequest(null, null, $headers), $username, $password);
        }
    }

    /**
     * @param IHttpHeaders $headers
     * @param array $server
     */
    public function writeCommonAuthHeaders(IHttpHeaders $headers, array $server) {
        $auth = $this->findAuthHeader($server);

        if ($this->authIsValid($auth)) {
            $headers->set('authorization', $auth);
        }
    }

    /**
     * @param string $header
     *
     * @return string
     */
    public function formatHeader($header) {
        return str_replace('_', '-', mb_strtolower($header, 'UTF-8'));
    }

    /**
     * @param string $header
     * @param string $prefix
     *
     * @return string
     */
    public function formatHeaderAndRemovePrefix($header, $prefix = 'HTTP_') {
        if (str_starts_with($header, $prefix)) {
            $header = substr($header, strlen($prefix));
        }

        return $this->formatHeader($header);
    }

    /**
     * @param array $specialHeaders
     *
     * @return array
     */
    public function getSpecialHeaders(array $specialHeaders = []) {
        return array_merge(
            $specialHeaders,
            ['CONTENT_LENGTH', 'CONTENT_MD5', 'CONTENT_TYPE']
        );
    }

    /**
     * @param array $server
     *
     * @return string|null
     */
    protected function findAuthHeader(array $server) {
        if (array_has($server, 'HTTP_AUTHORIZATION')) {
            return array_get($server, 'HTTP_AUTHORIZATION');
        } else if (array_has($server, 'REDIRECT_HTTP_AUTHORIZATION')) {
            return array_get($server, 'REDIRECT_HTTP_AUTHORIZATION');
        }

        return null;
    }

    /**
     * @param $auth
     *
     * @return bool
     */
    protected function authIsValid($auth) {
        if ($auth !== null &&
            preg_match('/^basic|digest|bearer/', $auth)
        ) {
            return true;
        }

        return false;
    }
}
