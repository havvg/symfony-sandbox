<?php

require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'          => array(__DIR__.'/../vendor/symfony/src', __DIR__.'/../vendor/bundles'),
    'Doctrine\Common'  => __DIR__.'/../vendor/doctrine-common/lib',
    'Monolog'          => __DIR__.'/../vendor/monolog/src',
    'Assetic'          => __DIR__.'/../vendor/assetic/src',
    'Metadata'         => __DIR__.'/../vendor/metadata/src',
    'Geocoder'         => __DIR__.'/../vendor/Geocoder/src',
    'Gaufrette'        => __DIR__.'/../vendor/Gaufrette/src',
    'Knp\Menu'         => __DIR__.'/../vendor/KnpMenu/src',
    'Knp\Component'    => __DIR__.'/../vendor/knp-components/src',
    'Buzz'             => __DIR__.'/../vendor/Buzz/lib',
    'Imagine'          => __DIR__.'/../vendor/Imagine/lib',

    // Behat
    'Behat\Gherkin'    => __DIR__.'/../vendor/behat/gherkin/src',
    'Behat\Behat'      => __DIR__.'/../vendor/behat/behat/src',
    'Behat\Mink'       => __DIR__.'/../vendor/behat/mink/src',
    'Behat\Mink\Driver' => array(
        __DIR__.'/../vendor/behat/drivers/MinkBrowserKitDriver/src',
        __DIR__.'/../vendor/behat/drivers/MinkSelenium2Driver/src',
    ),
    'Behat\CommonContexts' => __DIR__.'/../vendor/behat/common-contexts',
    'Behat\MinkExtension' => __DIR__.'/../vendor/behat/extensions/MinkExtension/src',
    'Behat\Symfony2Extension' => __DIR__.'/../vendor/behat/extensions/Symfony2Extension/src',
    'WebDriver' => __DIR__.'/../vendor/instaclick/php-webdriver/lib',
));
$loader->registerPrefixes(array(
    'Twig_Extensions_' => __DIR__.'/../vendor/twig-extensions/lib',
    'Twig_'            => __DIR__.'/../vendor/twig/lib',
));

$prefixFallbacks = array();

// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';

    $prefixFallbacks[] = __DIR__.'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs';
}

if (!interface_exists('SessionHandlerInterface')) {
    require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/HttpFoundation/Resources/stubs/SessionHandlerInterface.php';
}

$loader->registerNamespaceFallbacks(array(
    __DIR__.'/../src',
    __DIR__.'/../vendor/bundles',
    __DIR__.'/../vendor',
));
$loader->registerPrefixFallbacks($prefixFallbacks);
$loader->register();

// Swiftmailer needs a special autoloader to allow
// the lazy loading of the init file (which is expensive)
require_once __DIR__.'/../vendor/swiftmailer/lib/swift_required.php';
