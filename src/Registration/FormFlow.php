<?php

namespace Registration;

use Craue\FormFlowBundle\Form\FormFlow as BaseFormFlow;

class FormFlow extends BaseFormFlow
{
    protected $maxSteps = 3;
    protected $allowDynamicStepNavigation = true;

    protected function loadStepDescriptions()
    {
        return array(
            'registration.flow_step.address',
            'registration.flow_step.account',
            'registration.flow_step.confirm',
        );
    }

    public function getFormOptions($formData, $step, array $options = array())
    {
        $options['flowStep'] = $step;

        return $options;
    }
}
