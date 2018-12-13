<?php

namespace CVOBundle\Service\User;


use CVOBundle\Entity\Role;
use CVOBundle\Entity\User;
use CVOBundle\Repository\RoleRepository;
use CVOBundle\Repository\UserRepository;

class UserService implements UserServiceInterface
{
    private $userRepository;
    private $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function register(User $user, string $roleName)
    {
        /** @var Role $userRole */
        $userRole = $this->roleRepository->findOneBy(['name' => $roleName]);
        $user->addRole($userRole);
        $this->userRepository->save($user);
    }

    public function checkUser($username)
    {
        return $this->userRepository->findBy(['username' => $username]);
    }

    public function checkIfUsers()
    {
        return $usersFromDB = $this->userRepository->findAll();
    }

    public function getAllUsers()
    {
        return $this->userRepository->findAll();
    }
}