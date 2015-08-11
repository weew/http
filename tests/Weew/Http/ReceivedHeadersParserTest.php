<?php

namespace tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpBasicAuth;
use Weew\Http\HttpHeaders;
use Weew\Http\ReceivedHeadersParser;

class ReceivedHeadersParserTest extends PHPUnit_Framework_TestCase {
    public function test_format_header() {
        $parser = new ReceivedHeadersParser();
        $this->assertEquals(
            'http-foo-bar', $parser->formatHeader('HTTP_FOO_BAR')
        );
    }

    public function test_format_header_and_remove_prefix() {
        $parser = new ReceivedHeadersParser();
        $this->assertEquals(
            'foo-bar', $parser->formatHeaderAndRemovePrefix('HTTP_FOO_BAR')
        );
        $this->assertEquals(
            'foo-bar', $parser->formatHeaderAndRemovePrefix('FOO_BAR')
        );
    }

    public function write_common_auth_headers_provider() {
        return [
            [['authorization' => 'basic foo'], ['HTTP_AUTHORIZATION' => 'basic foo']],
            [['authorization' => 'digest foo'], ['HTTP_AUTHORIZATION' => 'digest foo']],
            [['authorization' => 'bearer foo'], ['REDIRECT_HTTP_AUTHORIZATION' => 'bearer foo']],
        ];
    }

    /**
     * @dataProvider write_common_auth_headers_provider
     */
    public function test_write_common_auth_headers(array $expected, array $source) {
        $headers = new HttpHeaders();
        $parser = new ReceivedHeadersParser();
        $parser->writeCommonAuthHeaders($headers, $source);

        $this->assertEquals(
            $expected, $headers->toDistinctArray()
        );
    }

    public function test_write_username_and_password() {
        $headers = new HttpHeaders();
        $parser = new ReceivedHeadersParser();
        $source = ['PHP_AUTH_USER' => 'foo', 'PHP_AUTH_PW' => 'bar'];
        $parser->writeBasicAuthHeaders($headers, $source);

        $expectedHeaders = new HttpHeaders();
        new HttpBasicAuth($expectedHeaders, 'foo', 'bar');

        $this->assertEquals(
            $expectedHeaders->toDistinctArray(), $headers->toDistinctArray()
        );
    }

    public function test_extract_auth_headers() {
        $parser = new ReceivedHeadersParser();
        $headers = new HttpHeaders();

        $this->assertFalse($headers->has('authorization'));
        $parser->extractAuthHeaders($headers, ['HTTP_AUTHORIZATION' => 'bearer foo']);
        $this->assertEquals('bearer foo', $headers->find('authorization'));
        $parser->extractAuthHeaders($headers, ['HTTP_AUTHORIZATION' => 'bearer bar']);
        $this->assertEquals('bearer foo', $headers->find('authorization'));
    }

    public function test_extract_special_headers() {
        $headers = new HttpHeaders();
        $parser = new ReceivedHeadersParser();
        $specialHeaders = ['FOO_BAR', 'BAR_FOO'];
        $source = [
            'FOO_BAR' => 'bar',
            'BAR_FOO' => 'foo',
        ];

        $parser->extractSpecialHeaders($headers, $source, $specialHeaders);
        $this->assertEquals(
            ['foo-bar' => 'bar', 'bar-foo' => 'foo'],
            $headers->toDistinctArray()
        );
    }

    public function test_extract_prefixed_headers() {
        $headers = new HttpHeaders();
        $parser = new ReceivedHeadersParser();
        $source = [
            'HTTP_FOO_BAR' => 'foo',
            'HTTP_BAR_FOO' => 'bar',
            'BAR_FOO' => 'baz'
        ];

        $parser->extractPrefixedHeaders($headers, $source);
        $this->assertEquals(
            ['foo-bar' => 'foo', 'bar-foo' => 'bar'], $headers->toDistinctArray()
        );
    }

    public function test_get_special_headers() {
        $parser = new ReceivedHeadersParser();

        $this->assertEquals(
            ['foo', 'CONTENT_LENGTH', 'CONTENT_MD5', 'CONTENT_TYPE'],
            $parser->getSpecialHeaders(['foo'])
        );
    }

    public function test_parse_headers() {
        $source = [
            'HTTP_AUTHORIZATION' => 'basic foo',
            'FOO_BAR' => 'foo',
            'CONTENT_LENGTH' => 1337,
            'HTTP_SWAG' => 'swag',
            'HTTP_YOLO' => 'yolo',
            'BAR_FOO' => 'bar'
        ];
        $specialHeaders = ['FOO_BAR'];
        $expected = [
            'authorization' => 'basic foo',
            'foo-bar' => 'foo',
            'content-length' => 1337,
            'swag' => 'swag',
            'yolo' => 'yolo',
        ];

        $parser = new ReceivedHeadersParser();

        $this->assertEquals(
            $expected,
            $parser->parseHeaders($source, $specialHeaders)->toDistinctArray()
        );

        $server = $_SERVER;

        $_SERVER = $source;
        $this->assertEquals(
            $expected,
            $parser->parseHeaders(null, $specialHeaders)->toDistinctArray()
        );

        $_SERVER = $server;
    }
}
