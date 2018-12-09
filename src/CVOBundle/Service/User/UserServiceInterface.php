<?php

namespace CVOBundle\Service\User;


use CVOBundle\Entity\User;

interface UserServiceInterface
{

    public function register(User $user, string $roleName);

    public function login();

    public function checkUser($username);

    public function checkIfUsers();
}