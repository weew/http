<?php

namespace Weew\Http;

/**
 * 1xx: Informational - Request received, continuing process
 * 2xx: Success - The action was successfully received, understood, and accepted
 * 3xx: Redirection - Further action must be taken in order to complete the request
 * 4xx: Client Error - The request contains bad syntax or cannot be fulfilled
 * 5xx: Server Error - The server failed to fulfill an apparently valid request
 */
class HttpStatusCode {
    /**
     * This interim response indicates that everything so far is OK and that
     * the client should continue with the request or ignore it if it is
     * already finished.
     */
    const CONTINUE_REQUEST = 100;

    /**
     * This code is sent in response to an Upgrade: request header by the
     * client, and indicates that the protocol the server is switching too.
     * It was introduced to allow migration to an incompatible protocol version,
     * and is not in common use.
     */
    const SWITCHING_PROTOCOLS = 101;

    /**
     * As a WebDAV request may contain many sub-requests involving file
     * operations, it may take a long time to complete the request.
     * This code indicates that the server has received and is processing
     * the request, but no response is available yet.
     */
    const PROCESSING = 102;

    /**
     * The request has succeeded.
     * The meaning of a success varies depending on the HTTP method:
     *     - GET:   The resource has been fetched and is transmitted
     *              in the message body.
     *     - HEAD:  The entity headers are in the message body.
     *     - POST:  The resource describing the result of the action is
     *              transmitted in the message body.
     *     - TRACE: The message body contains the request message as received
     *              by the server
     */
    const OK = 200;

    /**
     * The request has succeeded and a new resource has been created as a
     * result of it. This is typically the response sent after a PUT request.
     */
    const CREATED = 201;

    /**
     * The request has been received but not yet acted upon.
     * It is non-committal, meaning that there is no way in HTTP to later
     * send an asynchronous response indicating the outcome of processing
     * the request. It is intended for cases where another process or server
     * handles the request, or for batch processing.
     */
    const ACCEPTED = 202;

    /**
     * This response code means returned meta-information set is not exact set
     * as available from the origin server, but collected from a local or a
     * third party copy. Except this condition, 200 OK response should be
     * preferred instead of this response.
     */
    const NON_AUTHORITATIVE_INFORMATION = 203;

    /**
     * There is no content to send for this request, but the headers may
     * be useful. The user-agent may update its cached headers for this
     * resource with the new ones.
     */
    const NO_CONTENT = 204;

    /**
     * This response code is sent after accomplishing request to tell user
     * agent reset document view which sent this request.
     */
    const RESET_CONTENT = 205;

    /**
     * This response code is used because of range header sent by the client
     * to separate download into multiple streams.
     */
    const PARTIAL_CONTENT = 206;

    /**
     * The message body that follows is an XML message and can contain a number
     * of separate response codes, depending on how many sub-requests were made.
     */
    const MULTI_STATUS = 207;

    /**
     * The members of a DAV binding have already been enumerated in a previous
     * reply to this request, and are not being included again.
     */
    const ALREADY_REPORTED = 208;

    /**
     * The server has fulfilled a request for the resource, and the response is
     * a representation of the result of one or more instance-manipulations
     * applied to the current instance.
     */
    const IM_USED = 226;

    /**
     * The request has more than one possible responses. User-agent or user
     * should choose one of them. There is no standardized way to choose one
     * of the responses.
     */
    const MULTIPLE_CHOICES = 300;

    /**
     * This response code means that URI of requested resource has been changed.
     * Probably, new URI would be given in the response.
     */
    const MOVED_PERMANENTLY = 301;

    /**
     * This response code means that URI of requested resource has been changed
     * temporarily. New changes in the URI might be made in the future.
     * Therefore, this same URI should be used by the client in future requests.
     */
    const FOUND = 302;

    /**
     * Server sent this response to directing client to get requested resource
     * to another URI with an GET request.
     */
    const SEE_OTHER = 303;

    /**
     * This is used for caching purposes. It is telling to client that response
     * has not been modified. So, client can continue to use same cached
     * version of response.
     */
    const NOT_MODIFIED = 304;

    /**
     * This means requested response must be accessed by a proxy.
     * This response code is not largely supported because security reasons.
     */
    const USE_PROXY = 305;

    /**
     * This response code is no longer used, it is just reserved currently.
     * It was used in a previous version of the HTTP 1.1 specification.
     */
    const RESERVED = 306;

    /**
     * Server sent this response to directing client to get requested resource
     * to another URI with same method that used prior request. This has the
     * same semantic than the 302 Found HTTP response code, with the exception
     * that the user agent must not change the HTTP method used: if a POST was
     * used in the first request, a POST must be used in the second request.
     */
    const TEMPORARY_REDIRECT = 307;

    /**
     * This means that the resource is now permanently located at another URI,
     * specified by the Location: HTTP Response header. This has the same
     * semantics as the 301 Moved Permanently HTTP response code, with the
     * exception that the user agent must not change the HTTP method used: if a
     * POST was used in the first request, a POST must be used in the second
     * request.
     */
    const PERMANENTLY_REDIRECT = 308;

    /**
     * This response means that server could not understand the request due to
     * invalid syntax.
     */
    const BAD_REQUEST = 400;

    /**
     * Authentication is needed to get requested response.
     * This is similar to 403, but in this case, authentication is possible.
     */
    const UNAUTHORIZED = 401;

    /**
     * This response code is reserved for future use. Initial aim for creating
     * this code was using it for digital payment systems however this is not
     * used currently.
     */
    const PAYMENT_REQUIRED = 402;

    /**
     * Client does not have access rights to the content so server is rejecting
     * to give proper response.
     */
    const FORBIDDEN = 403;

    /**
     * Server can not find requested resource. This response code probably is
     * most famous one due to its frequency to occur in web.
     */
    const NOT_FOUND = 404;

    /**
     * The request method is known by the server but has been disabled and
     * cannot be used. The two mandatory methods, GET and HEAD, must never be
     * disabled and should not return this error code.
     */
    const METHOD_NOT_ALLOWED = 405;

    /**
     * This response is sent when the web server, after performing
     * server-driven content negotiation, doesn't find any content following
     * the criteria given by the user agent.
     */
    const NOT_ACCEPTABLE = 406;

    /**
     * This is similar to 401 but authentication is needed to be done by a proxy.
     */
    const PROXY_AUTHENTICATION_REQUIRED = 407;

    /**
     * This response is sent on an idle connection by some servers, even
     * without any previous request by the client. It means that the server
     * would like to shut down this unused connection. This response is used
     * much more since some browsers, like Chrome or IE9, use HTTP preconnection
     * mechanisms to speed up surfing (see bug 881804, which tracks the future
     * implementation of such a mechanism in Firefox). Also note that some
     * servers merely shut down the connection without sending this message.
     */
    const REQUEST_TIMEOUT = 408;

    /**
     * This response would be sent when a request conflict with current
     * state of server.
     */
    const CONFLICT = 409;

    /**
     * This response would be sent when requested content has been
     * deleted from server.
     */
    const GONE = 410;

    /**
     * Server rejected the request because the Content-Length header
     * field is not defined and the server requires it.
     */
    const LENGTH_REQUIRED = 411;

    /**
     * The client has indicated preconditions in its headers which
     * the server does not meet.
     */
    const PRECONDITION_FAILED = 412;

    /**
     * Request entity is larger than limits defined by server; the server
     * might close the connection or return an Retry-After header field.
     */
    const REQUEST_ENTITY_TOO_LARGE = 413;

    /**
     * The URI requested by the client is too long for the server to handle.
     */
    const REQUEST_URI_TOO_LONG = 414;

    /**
     * The media format of the requested data is not supported by the server,
     * so the server is rejecting the request.
     */
    const UNSUPPORTED_MEDIA_TYPE = 415;

    /**
     * The range specified by the Range header field in the request can't be
     * fulfilled; it's possible that the range is outside the size of
     * the target URI's data.
     */
    const REQUESTED_RANGE_NOT_SATISFIABLE = 416;

    /**
     * This response code means the expectation indicated by the Expect
     * request header field can't be met by the server.
     */
    const EXPECTATION_FAILED = 417;

    /**
     * The request was well-formed but was unable to be followed due to
     * semantic errors.
     */
    const UNPROCESSABLE_ENTITY = 422;

    /**
     * The resource that is being accessed is locked.
     */
    const LOCKED = 423;

    /**
     * The request failed due to failure of a previous request.
     */
    const FAILED_DEPENDENCY = 424;

    /**
     * The client should switch to a different protocol such as TLS/1.0,
     * given in the Upgrade header field.
     */
    const UPGRADE_REQUIRED = 426;

    /**
     * The origin server requires the request to be conditional. Intended to
     * prevent "the 'lost update' problem, where a client GETs a resource's
     * state, modifies it, and PUTs it back to the server, when meanwhile a
     * third party has modified the state on the server,
     * leading to a conflict.".
     */
    const PRECONDITION_REQUIRED = 428;

    /**
     * The user has sent too many requests in a given amount of time.
     * Intended for use with rate limiting schemes.
     */
    const TOO_MANY_REQUESTS = 429;

    /**
     * The server is unwilling to process the request because either an
     * individual header field, or all the header fields collectively,
     * are too large.
     */
    const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;

    /**
     * The server has encountered a situation it doesn't know how to handle.
     */
    const INTERNAL_SERVER_ERROR = 500;

    /**
     * The request method is not supported by the server and cannot be handled.
     * The only methods that servers are required to support
     * (and therefore that must not return this code) are GET and HEAD.
     */
    const NOT_IMPLEMENTED = 501;

    /**
     * This error response means that the server, while working as a gateway
     * to get a response needed to handle the request, got an invalid response.
     */
    const BAD_GATEWAY = 502;

    /**
     * The server is not ready to handle the request. Common causes are a
     * server that is down for maintenance or that is overloaded. Note that
     * together with this response, a user-friendly page explaining the problem
     * should be sent. This responses should be used for temporary conditions and
     * the Retry-After: HTTP header should, if possible, contain the estimated
     * time before the recovery of the service. The webmaster must also take
     * care about the caching-related headers that are sent along with this
     * response, as these temporary condition responses should usually
     * not be cached.
     */
    const SERVICE_UNAVAILABLE = 503;

    /**
     * This error response is given when the server is acting as a gateway
     * and cannot get a response in time.
     */
    const GATEWAY_TIMEOUT = 504;

    /**
     * The HTTP version used in the request is not supported by the server.
     */
    const VERSION_NOT_SUPPORTED = 505;

    /**
     * Transparent content negotiation for the request
     * results in a circular reference.
     */
    const VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;

    /**
     * The server is unable to store the representation
     * needed to complete the request.
     */
    const INSUFFICIENT_STORAGE = 507;

    /**
     * The server detected an infinite loop while processing the request
     * (sent in lieu of 208 Already Reported).
     */
    const LOOP_DETECTED = 508;

    /**
     * Further extensions to the request are required for
     * the server to fulfil it.
     */
    const NOT_EXTENDED = 510;

    /**
     * The client needs to authenticate to gain network access. Intended for u
     * se by intercepting proxies used to control access to the network
     * (e.g., "captive portals" used to require agreement to Terms of Service
     * before granting full Internet access via a Wi-Fi hotspot).
     */
    const NETWORK_AUTHENTICATION_REQUIRED = 511;

    /**
     * @var array
     */
    public static $statusTexts = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Reserved for WebDAV advanced collections expired proposal',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates (Experimental)',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

    /**
     * @param $statusCode
     *
     * @param string $defaultText
     *
     * @return mixed
     */
    public static function getStatusText(
        $statusCode,
        $defaultText = 'Unknown status code'
    ) {
        return array_get(static::$statusTexts, $statusCode, $defaultText);
    }
}
