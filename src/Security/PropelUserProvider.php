<?php

namespace Security;

use Model\User;
use Model\UserQuery;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class PropelUserProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        $user = UserQuery::create()->findOneByEmail($username);

        if (!$user) {
            throw new UsernameNotFoundException(sprintf('There is no user with email "%s".', $username));
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if ($user instanceof User) {
            $user->reload();
        } else {
            throw new UnsupportedUserException('The user is not supported. Please provide a "Model\User".');
        }
    }

    public function supportsClass($class)
    {
        return ($class === 'Model\User');
    }
}
