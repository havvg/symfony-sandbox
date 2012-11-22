<?php

namespace Tests;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

abstract class AbstractFunctionalTest extends AbstractTest
{
    protected static $isWebTestCase = true;

    /**
     * Creates a Kernel.
     *
     * Available options:
     *
     *  * environment
     *  * debug
     *
     * @param array $options An array of options
     *
     * @return HttpKernelInterface A HttpKernelInterface instance
     */
    protected static function createKernel(array $options = array())
    {
        if (null === static::$class) {
            require_once __DIR__.'/../app/AppKernel.php';

            static::$class = 'AppKernel';
        }

        return new static::$class(
            isset($options['environment']) ? $options['environment'] : 'test_functional',
            isset($options['debug']) ? $options['debug'] : true
        );
    }

    public static function assertRedirect(Response $response, $location = null, $code = null)
    {
        self::assertTrue($response->isRedirect($location),
            'The response contains the correct redirect.');

        if ($code) {
            self::assertEquals($code, $response->getStatusCode(),
                'The specific status code is set.');
        }
    }

    /**
     * Assert that the response is successful and contains valid JSON.
     *
     * @param Response $response
     *
     * @return mixed The decoded JSON content.
     */
    public static function assertSuccessfulJsonResponse(Response $response)
    {
        self::assertTrue($response->isSuccessful(),
            'The request was successful.');

        return self::assertJsonResponse($response);
    }

    /**
     * Assert that the response contains valid JSON.
     *
     * @param Response $response
     *
     * @return mixed The decoded JSON content.
     */
    public static function assertJsonResponse(Response $response)
    {
        self::assertEquals('application/json', $response->headers->get('Content-Type'),
            'The response contains JSON.');

        $content = json_decode($response->getContent());
        self::assertEquals(JSON_ERROR_NONE, json_last_error(),
            'The response is valid JSON.');

        return $content;
    }
}
