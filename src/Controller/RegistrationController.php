<?php

namespace App\Controller;

use App\Factory\UserFactory;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route(
        '/registration',
        name: 'registration',
        methods: 'POST',
        format: 'application/json'
    )]
    public function registration(Request $request, UserFactory $userFactory, UserRepository $userRepository): Response
    {
        $data = new ParameterBag($request->toArray());
        $user = $userFactory->create(
            $data->get('email', ''),
            $data->get('password', ''),
            $data->get('username', ''),
        );
        $userRepository->save($user, true);

        return $this->json(['message' => 'User created'], 201);
    }
}
