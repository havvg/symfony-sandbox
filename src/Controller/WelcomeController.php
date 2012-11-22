<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Response;

class WelcomeController extends AbstractController
{
    public function index()
    {
        return $this->render(':Welcome:index.html.twig');
    }
}
