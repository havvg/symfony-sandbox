<?php

namespace Controller;

use Symfony\Component\HttpFoundation\Request;
use Form\Model\Registration;

class RegistrationController extends AbstractController
{
    public function register(Request $request)
    {
        $registration = new Registration();

        /* @var $flow \Registration\FormFlow */
        $flow = $this->get('form.flow.registration');
        $flow->bind($registration);

        $form = $flow->createForm($registration);
        if ($request->isMethod('POST')) {
            if ($flow->isValid($form)) {
                $flow->saveCurrentStepData();

                if ($flow->nextStep()) {
                    $form = $flow->createForm($registration);
                } else {
                    return $this->redirect('welcome');
                }
            }
        }

        return $this->render(':Registration:register.html.twig', array(
            'flow' => $flow,
            'form' => $form->createView(),
        ));
    }
}
