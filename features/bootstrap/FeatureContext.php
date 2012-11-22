<?php

use Behat\Behat\Context\BehatContext;
use Behat\Mink\Mink;
use Behat\MinkExtension\Context\MinkAwareInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;

use Symfony\Component\HttpKernel\KernelInterface;

class FeatureContext extends BehatContext implements KernelAwareInterface, MinkAwareInterface
{
    /**
     * @var KernelInterface
     */
    protected $kernel = null;

    /**
     * @var Mink
     */
    protected $mink = null;
    protected $minkParameters = array();

    public function __construct(array $parameters)
    {
        $this->useContext('mink', new \Behat\MinkExtension\Context\MinkContext());
        $this->useContext('symfony_mailer', new \Behat\CommonContexts\SymfonyMailerContext());
        $this->useContext('mink_redirect', new \Behat\CommonContexts\MinkRedirectContext());
        $this->useContext('mink_extra', new \Behat\CommonContexts\MinkExtraContext());
    }

    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function setMink(Mink $mink)
    {
        $this->mink = $mink;
    }

    public function setMinkParameters(array $parameters)
    {
        $this->minkParameters = $parameters;
    }
}
