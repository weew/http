<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Tests\Weew\Http\Stubs\ArrayableItem;
use Weew\Http\ContentTypeDataMatcher;
use Weew\Http\CookieJar;
use Weew\Http\Data\JsonData;
use Weew\Http\Data\UrlEncodedData;
use Weew\Http\HttpBasicAuth;
use Weew\Http\HttpHeaders;
use Weew\Http\HttpProtocol;
use Weew\Http\HttpRequest;
use Weew\Http\HttpRequestMethod;
use Weew\Http\IContentTypeDataMatcher;
use Weew\Http\ICookieJar;
use Weew\Http\IHttpBasicAuth;
use Weew\Http\IHttpData;
use Weew\Http\IHttpHeaders;
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
        $data = new UrlEncodedData($request, ['foo' => 'bar']);
        $request->setData($data);
        $this->assertTrue($request->getData() instanceof IHttpData);
        $this->assertEquals('bar', $request->getData()->get('foo'));
    }

    public function test_get_and_set_content_type_data_matcher() {
        $request = new HttpRequest();
        $this->assertTrue(
            $request->getContentTypeDataMatcher() instanceof IContentTypeDataMatcher
        );
        $matcher = new ContentTypeDataMatcher();
        $request->setContentTypeDataMatcher($matcher);
        $this->assertTrue($matcher === $request->getContentTypeDataMatcher());
    }

    public function test_uses_matcher_for_data_creation() {
        $request = new HttpRequest();
        $request->setContentType('application/json');
        $this->assertTrue($request->getData() instanceof JsonData);

        $request = new HttpRequest();
        $this->assertTrue($request->getData() instanceof UrlEncodedData);
    }

    public function test_get_and_set_basic_auth() {
        $request = new HttpRequest();
        $this->assertTrue($request->getBasicAuth() instanceof IHttpBasicAuth);
        $basicAuth = new HttpBasicAuth($request, 'foo', 'bar');
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
        $jar = new CookieJar($request);

        $this->assertTrue($request->getCookieJar() instanceof ICookieJar);
        $request->setCookieJar($jar);
        $this->assertTrue($jar === $request->getCookieJar());
    }

    public function test_to_array() {
        $request = new HttpRequest(
            HttpRequestMethod::PATCH,
            new Url('/foo'),
            new HttpHeaders(['yolo' => 'swag'])
        );
        $request->setBasicAuth(new HttpBasicAuth($request, 'xx', 'aa'));
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
                'query' => $request->getUrl()->getQuery()->toArray(),
                'cookies' => $request->getCookieJar()->toArray(),
                'content' => $request->getContent(),
            ], $actual
        );
    }

    public function test_has_content() {
        $request = new HttpRequest();
        $this->assertFalse($request->hasContent());
        $request->setContent('foo');
        $this->assertTrue($request->hasContent());
    }

    public function test_is_secure() {
        $request = new HttpRequest();
        $this->assertFalse($request->isSecure());
        $request->setProtocol(HttpProtocol::HTTPS);
        $this->assertTrue($request->isSecure());
    }

    public function test_set_complex_content() {
        $response = new HttpRequest();
        $response->setContent([new ArrayableItem('foo'), new ArrayableItem('bar')]);
        $this->assertEquals([['id' => 'foo'], ['id' => 'bar']], $response->getData()->toArray());
    }
}
