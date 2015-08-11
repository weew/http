<?php

namespace Weew\Http;

class ReceivedHeadersParser implements IReceivedHeadersParser {
    /**
     * @param array|null $source
     * @param array $specialHeaders
     *
     * @return HttpHeaders
     */
    public function parseHeaders(array $source = null, array $specialHeaders = []) {
        if ($source === null) {
            $source = $_SERVER;
        }

        $specialHeaders = $this->getSpecialHeaders($specialHeaders);

        $headers = new HttpHeaders();
        $this->extractPrefixedHeaders($headers, $source);
        $this->extractSpecialHeaders($headers, $source, $specialHeaders);
        $this->extractAuthHeaders($headers, $source);

        return $headers;
    }

    /**
     * @param IHttpHeaders $headers
     * @param array $source
     * @param string $prefix
     */
    public function extractPrefixedHeaders(IHttpHeaders $headers, array $source, $prefix = 'HTTP_') {
        foreach ($source as $header => $value) {
            if (str_starts_with($header, $prefix)) {
                $headers->add(
                    $this->formatHeaderAndRemovePrefix($header, $prefix), $value
                );
            }
        }
    }

    /**
     * @param IHttpHeaders $headers
     * @param array $source
     * @param array $specialHeaders
     */
    public function extractSpecialHeaders(
        IHttpHeaders $headers,
        array $source,
        array $specialHeaders
    ) {
        foreach ($source as $header => $value) {
            if (in_array($header, $specialHeaders)) {
                $headers->add(
                    $this->formatHeader($header), $value
                );
            }
        }
    }

    /**
     * @param IHttpHeaders $headers
     * @param array $source
     */
    public function extractAuthHeaders(IHttpHeaders $headers, array $source) {
        if ( ! $headers->has('authorization')) {
            $this->writeBasicAuthHeaders($headers, $source);
        }

        if ( ! $headers->has('authorization')) {
            $this->writeCommonAuthHeaders($headers, $source);
        }
    }

    /**
     * @param IHttpHeaders $headers
     * @param array $source
     */
    public function writeBasicAuthHeaders(IHttpHeaders $headers, array $source) {
        $username = array_get($source, 'PHP_AUTH_USER');
        $password = array_get($source, 'PHP_AUTH_PW');

        if ($username !== null) {
            new HttpBasicAuth($headers, $username, $password);
        }
    }

    /**
     * @param IHttpHeaders $headers
     * @param array $source
     */
    public function writeCommonAuthHeaders(IHttpHeaders $headers, array $source) {
        $auth = null;

        if (array_has($source, 'HTTP_AUTHORIZATION')) {
            $auth = array_get($source, 'HTTP_AUTHORIZATION');
        } else if (array_has($source, 'REDIRECT_HTTP_AUTHORIZATION')) {
            $auth = array_get($source, 'REDIRECT_HTTP_AUTHORIZATION');
        }

        if ($auth !== null) {
            if (
                str_starts_with($auth, 'basic') or
                str_starts_with($auth, 'digest') or
                str_starts_with($auth, 'bearer')
            ) {
                $headers->set('authorization', $auth);
            }
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
}
