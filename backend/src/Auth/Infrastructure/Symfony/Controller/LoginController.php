<?php

namespace App\Auth\Infrastructure\Symfony\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/v1/login', name: 'api_login_check', methods: ['POST'])]
#[IsGranted('PUBLIC_ACCESS')]
class LoginController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['message' => 'JWT login successful'], JsonResponse::HTTP_OK);
    }
}
