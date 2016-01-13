<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Tests\Weew\Http\Stubs\StringableItem;
use Weew\Http\ContentTypeDataMatcher;
use Weew\Http\Cookie;
use Weew\Http\Cookies;
use Weew\Http\HttpHeaders;
use Weew\Http\HttpJsonData;
use Weew\Http\HttpProtocol;
use Weew\Http\HttpResponse;
use Weew\Http\HttpStatusCode;
use Weew\Http\HttpUrlEncodedData;
use Weew\Http\IContentTypeDataMatcher;
use Weew\Http\ICookies;
use Weew\Http\IHttpData;
use Weew\Http\IHttpHeaders;

class HttpResponseTest extends PHPUnit_Framework_TestCase {
    public function test_create_new_response() {
        new HttpResponse();
    }

    public function test_set_and_get_status_code() {
        $response = new HttpResponse(null);

        $this->assertEquals(
            HttpStatusCode::OK, $response->getStatusCode()
        );

        $response->setStatusCode(HttpStatusCode::MOVED_PERMANENTLY);

        $this->assertEquals(
            HttpStatusCode::MOVED_PERMANENTLY, $response->getStatusCode()
        );
    }

    public function test_get_and_set_headers() {
        $response = new HttpResponse();
        $this->assertTrue($response->getHeaders() instanceof IHttpHeaders);

        $headers = new HttpHeaders();
        $headers->set('foo', 'bar');
        $response->setHeaders($headers);
        $this->assertTrue($response->getHeaders() instanceof IHttpHeaders);
        $this->assertEquals(
            $headers->find('foo'),
            $response->getHeaders()->find('foo')
        );

        $this->assertEquals($headers->find('foo'), $response->getHeaders()->find('foo'));
        $this->assertEquals('yolo', $response->getHeaders()->find('swag', 'yolo'));
        $response->getHeaders()->set('swag', 'yolo');
        $this->assertEquals('yolo', $response->getHeaders()->find('swag'));
    }

    public function test_get_protocol_and_version() {
        $response = new HttpResponse();
        $this->assertEquals(HttpProtocol::HTTP, $response->getProtocol());
        $this->assertEquals(HttpProtocol::CURRENT_VERSION, $response->getProtocolVersion());
    }

    public function test_get_status_text() {
        $response = new HttpResponse(HttpStatusCode::INTERNAL_SERVER_ERROR);
        $this->assertEquals(
            HttpStatusCode::getStatusText(HttpStatusCode::INTERNAL_SERVER_ERROR),
            $response->getStatusText()
        );
    }

    public function test_set_and_get_content_type() {
        $response = new HttpResponse();
        $this->assertEquals(null, $response->getContentType());
        $response->setContentType('text/html');
        $this->assertEquals('text/html', $response->getContentType());
    }

    public function test_get_and_set_content() {
        $response = new HttpResponse();
        $this->assertFalse($response->hasContent());
        $response->setContent('foo');
        $this->assertTrue($response->hasContent());
        $this->assertEquals('foo', $response->getContent());
    }

    public function test_is_ok() {
        $response = new HttpResponse();
        $this->assertTrue($response->isOk());
        $response->setStatusCode(HttpStatusCode::CREATED);
        $this->assertTrue($response->isOk());
        $response->setStatusCode(HttpStatusCode::NOT_FOUND);
        $this->assertFalse($response->isOk());
    }

    public function test_is_redirect() {
        $response = new HttpResponse();
        $this->assertFalse($response->isRedirect());
        $response->setStatusCode(HttpStatusCode::PERMANENTLY_REDIRECT);
        $this->assertTrue($response->isRedirect());
    }

    public function test_is_client_error() {
        $response = new HttpResponse();
        $this->assertFalse($response->isClientError());
        $response->setStatusCode(HttpStatusCode::NOT_FOUND);
        $this->assertTrue($response->isClientError());
    }

    public function test_is_server_error() {
        $response = new HttpResponse();
        $this->assertFalse($response->isServerError());
        $response->setStatusCode(HttpStatusCode::INTERNAL_SERVER_ERROR);
        $this->assertTrue($response->isServerError());
    }

    public function test_is_error() {
        $response = new HttpResponse();
        $this->assertFalse($response->isError());
        $response->setStatusCode(HttpStatusCode::NOT_FOUND);
        $this->assertTrue($response->isError());
        $response->setStatusCode(HttpStatusCode::INTERNAL_SERVER_ERROR);
        $this->assertTrue($response->isError());
    }

    public function test_set_stringable_content() {
        $item = new StringableItem();
        $response = new HttpResponse();

        $this->assertFalse($response->hasContent());
        $response->setContent($item);
        $this->assertTrue($response->hasContent());
        $this->assertEquals($item->toString(), $response->getContent());
    }

    public function test_extend() {
        $headers = new HttpHeaders(['foo-bar' => 'baz']);
        $cookie = new Cookie('foo', 'bar');

        $httpResponse = new HttpResponse(
            HttpStatusCode::NOT_FOUND, 'yolo',$headers
        );
        $httpResponse->getCookies()->add($cookie);
        $customResponse = new HttpResponse();
        $customResponse->extend($httpResponse);
        $this->assertEquals(
            $httpResponse->getStatusCode(), $customResponse->getStatusCode()
        );
        $this->assertEquals(
            $httpResponse->getProtocol(), $customResponse->getProtocol()
        );
        $this->assertEquals(
            $httpResponse->getProtocolVersion(), $customResponse->getProtocolVersion()
        );
        $this->assertEquals(
            $httpResponse->getContent(), $customResponse->getContent()
        );
        $this->assertEquals(
            $httpResponse->getContentType(), $customResponse->getContentType()
        );
        $this->assertEquals(
            'baz', $customResponse->getHeaders()->find('foo-bar')
        );
        $this->assertFalse(
            $customResponse->getHeaders() === $headers
        );
        $this->assertEquals(
            'bar', $customResponse->getCookies()->findByName('foo')->getValue()
        );
        $this->assertFalse(
            $customResponse->getCookies()->findByName('foo') === $cookie
        );
    }

    public function test_create() {
        $httpResponse = new HttpResponse();
        $httpResponse->setContent('foo');
        $httpResponse->setContentType('bar');
        $customResponse = HttpResponse::create($httpResponse);

        $this->assertEquals('foo', $customResponse->getContent());
        $this->assertEquals('bar', $customResponse->getContentType());
    }

    public function test_cookies() {
        $response = new HttpResponse();
        $cookies = new Cookies($response);
        $this->assertTrue($response->getCookies() instanceof ICookies);
        $response->setCookies($cookies);
        $this->assertTrue($cookies === $response->getCookies());
    }

    public function test_to_array() {
        $response = new HttpResponse(HttpStatusCode::GONE, 'foo', new HttpHeaders(['foo' => 'bar']));

        $this->assertEquals(
            [
                'protocol' => $response->getProtocol(),
                'version' => $response->getProtocolVersion(),
                'statusCode' => $response->getStatusCode(),
                'statusCodeText' => $response->getStatusText(),
                'headers' => $response->getHeaders()->toArray(),
                'content' => $response->getContent(),
            ],
            $response->toArray()
        );
    }

    public function test_is_secure() {
        $response = new HttpResponse();
        $this->assertFalse($response->isSecure());
        $response->setProtocol(HttpProtocol::HTTPS);
        $this->assertTrue($response->isSecure());
    }

    public function test_get_and_set_data() {
        $response = new HttpResponse();
        $this->assertTrue($response->getData() instanceof IHttpData);
        $data = new HttpUrlEncodedData($response, ['foo' => 'bar']);
        $response->setData($data);
        $this->assertTrue($response->getData() instanceof IHttpData);
        $this->assertEquals('bar', $response->getData()->get('foo'));
    }

    public function test_get_and_set_content_type_data_matcher() {
        $response = new HttpResponse();
        $this->assertTrue(
            $response->getContentTypeDataMatcher() instanceof IContentTypeDataMatcher
        );

        $matcher = new ContentTypeDataMatcher();
        $response->setContentTypeDataMatcher($matcher);
        $this->assertTrue($matcher === $response->getContentTypeDataMatcher());
    }

    public function test_uses_matcher_for_data_creation() {
        $request = new HttpResponse();
        $request->setContentType('application/json');
        $this->assertTrue($request->getData() instanceof HttpJsonData);

        $request = new HttpResponse();
        $this->assertTrue($request->getData() instanceof HttpUrlEncodedData);
    }

    /**
     * @runInSeparateProcess
     */
    public function test_sending_response() {
        $response = new HttpResponse();
        ob_start();
        $response->send();
        $result = ob_get_clean();
        $this->assertNotNull($result);

        // todo: control result
    }
}
