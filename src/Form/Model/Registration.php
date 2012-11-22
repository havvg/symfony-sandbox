<?php

namespace Form\Model;

class Registration
{
    /**
     * @var Address
     */
    protected $address;

    /**
     * @var Account
     */
    protected $account;

    /**
     * @var TermsAndConditions
     */
    protected $confirmation;

    /**
     * @param Account $account
     *
     * @return Registration
     */
    public function setAccount($account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param Address $address
     *
     * @return Registration
     */
    public function setAddress($address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param TermsAndConditions $confirmation
     *
     * @return Registration
     */
    public function setConfirmation($confirmation = null)
    {
        $this->confirmation = $confirmation;

        return $this;
    }

    /**
     * @return TermsAndConditions
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }
}
