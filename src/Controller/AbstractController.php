<?php

namespace Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

abstract class AbstractController extends Controller
{
    /**
     * @return SessionInterface
     */
    public function getSession()
    {
        return $this->get('session');
    }
}
