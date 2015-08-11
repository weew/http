<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpBasicAuth;
use Weew\Http\ReceivedCookies;
use Weew\Http\HttpData;
use Weew\Http\HttpHeaders;
use Weew\Http\HttpProtocol;
use Weew\Http\HttpQuery;
use Weew\Http\HttpRequest;
use Weew\Http\HttpRequestMethod;
use Weew\Http\IHttpBasicAuth;
use Weew\Http\IReceivedCookies;
use Weew\Http\IHttpData;
use Weew\Http\IHttpHeaders;
use Weew\Http\IHttpQuery;
use Weew\Url\IUrl;
use Weew\Url\Url;

class HttpRequestTest extends PHPUnit_Framework_TestCase {
    public function test_create_default_request() {
        $request = new HttpRequest();
        $this->assertTrue($request->getHeaders() instanceof IHttpHeaders);
        $this->assertTrue($request->getUrl() instanceof IUrl);
        $this->assertTrue($request->getBasicAuth() instanceof IHttpBasicAuth);
    }

    public function test_get_and_set_headers() {
        $request = new HttpRequest();
        $headers = new HttpHeaders(['foo' => 'bar']);
        $request->setHeaders($headers);
        $this->assertEquals('bar', $request->getHeaders()->find('foo'));
        $this->assertNull($request->getHeaders()->find('bar'));
        $request->getHeaders()->set('bar', 'foo');
        $this->assertEquals('foo', $request->getHeaders()->find('bar'));
        $this->assertEquals('yolo', $request->getHeaders()->find('swag', 'yolo'));
    }

    public function test_get_and_set_request_method() {
        $request = new HttpRequest();
        $this->assertEquals(HttpRequestMethod::GET, $request->getMethod());

        $request->setMethod(HttpRequestMethod::POST);
        $this->assertEquals(HttpRequestMethod::POST, $request->getMethod());
    }

    public function test_provide_and_set_url() {
        $request = new HttpRequest(HttpRequestMethod::GET, new Url('foo'));
        $this->assertTrue($request->getUrl() instanceof IUrl);

        $request->setUrl(new Url('bar'));
        $this->assertTrue($request->getUrl() instanceof IUrl);
    }

    public function test_get_and_set_accept() {
        $request = new HttpRequest();

        $this->assertEquals(
            null, $request->getAccept()
        );

        $request->setAccept('text/html');

        $this->assertEquals(
            'text/html', $request->getAccept()
        );
    }

    public function test_get_and_set_data() {
        $request = new HttpRequest();
        $this->assertTrue($request->getData() instanceof IHttpData);
        $data = new HttpData($request, ['foo' => 'bar']);
        $request->setData($data);
        $this->assertTrue($request->getData() instanceof IHttpData);
        $this->assertEquals('bar', $request->getData()->get('foo'));
    }

    public function test_get_and_set_basic_auth() {
        $request = new HttpRequest();
        $this->assertTrue($request->getBasicAuth() instanceof IHttpBasicAuth);
        $basicAuth = new HttpBasicAuth($request->getHeaders(), 'foo', 'bar');
        $request->setBasicAuth($basicAuth);
        $this->assertTrue($basicAuth === $request->getBasicAuth());
    }

    public function test_get_and_set_content_type() {
        $request = new HttpRequest();
        $this->assertEquals(null, $request->getContentType());
        $request->setContentType('foo/bar');
        $this->assertEquals('foo/bar', $request->getContentType());
    }

    public function test_get_and_set_protocol() {
        $request = new HttpRequest();
        $this->assertEquals(
            HttpProtocol::HTTP, $request->getProtocol()
        );
        $this->assertEquals(
            HttpProtocol::CURRENT_VERSION, $request->getProtocolVersion()
        );

        $request->setProtocol('foo');
        $this->assertEquals(
            'foo', $request->getProtocol()
        );
        $request->setProtocolVersion('bar');
        $this->assertEquals(
            'bar', $request->getProtocolVersion()
        );
    }

    public function test_get_and_set_cookie_jar() {
        $request = new HttpRequest();
        $jar = new ReceivedCookies($request->getHeaders());

        $this->assertTrue($request->getReceivedCookies() instanceof IReceivedCookies);
        $request->setReceivedCookies($jar);
        $this->assertTrue($jar === $request->getReceivedCookies());
    }

    public function test_to_array() {
        $request = new HttpRequest(
            HttpRequestMethod::PATCH,
            new Url('/foo'),
            new HttpHeaders(['yolo' => 'swag'])
        );
        $request->setBasicAuth(new HttpBasicAuth($request->getHeaders(), 'xx', 'aa'));
        $request->getData()->setData(['foo' => 'bar']);
        $actual = $request->toArray();

        $this->assertEquals(
            [
                'protocol' => $request->getProtocol(),
                'version' => $request->getProtocolVersion(),
                'method' => $request->getMethod(),
                'url' => $request->getUrl()->toString(),
                'headers' => $request->getHeaders()->toArray(),
                'data' => $request->getData()->toArray(),
                'cookies' => $request->getReceivedCookies()->toArray(),
                'content' => $request->getContent(),
            ], $actual
        );
    }
}
