<?php

namespace Controller;

use Symfony\Component\Form\FormError;

class SecurityController extends AbstractController
{
    public function login()
    {
        $form = $this->createForm('login');

        if ($this->getSession()->has('_security.last_error')) {
            $form->addError(new FormError($this->getSession()->get('_security.last_error')->getMessage()));

            $this->getSession()->remove('_security.last_error');
        }

        return $this->render(':Security:login.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
