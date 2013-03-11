<?php

namespace Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Translation\TranslatorInterface;

class MenuBuilder
{
    protected $factory;

    protected $securityContext;
    protected $isLoggedIn;
    protected $username;
    protected $translator;

    public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext, TranslatorInterface $translator)
    {
        $this->factory = $factory;

        $this->securityContext = $securityContext;
        $this->isLoggedIn = $this->securityContext->isGranted('IS_AUTHENTICATED_FULLY');
        $this->username = $this->securityContext->getToken()->getUsername();

        $this->translator = $translator;
    }

    public function createAnonymousMenu()
    {
        $menu = $this->factory->createItem('Symfony2 Sandbox');
        $menu->setChildrenAttribute('class', 'nav');

        return $menu;
    }

    public function createMainMenu()
    {
        if (!$this->isLoggedIn) {
            return $this->createAnonymousMenu();
        }

        $menu = $this->factory->createItem('Symfony2 Sandbox');
        $menu->setChildrenAttribute('class', 'nav');

        return $menu;
    }

    /**
     * Translates the given message.
     *
     * @param string $id
     * @param array  $parameters
     * @param string $domain
     * @param string $locale
     *
     * @return string
     */
    protected function trans($id, array $parameters = array(), $domain = 'menu', $locale = null)
    {
        return $this->translator->trans($id, $parameters, $domain, $locale);
    }
}
