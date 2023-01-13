<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ProfileController extends AbstractController
{
    #[Route(
        '/profile',
        name: 'get_profile',
        methods: 'GET',
        format: 'application/json'
    )]
    public function get_profile(#[CurrentUser] ?User $user): Response
    {
        return $this->json($user, context: ['groups' => 'user:read']);
    }
}
