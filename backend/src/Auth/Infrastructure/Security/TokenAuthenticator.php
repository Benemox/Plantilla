<?php

namespace App\Auth\Infrastructure\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TokenAuthenticator extends AbstractAuthenticator
{
    private string $apiToken;

    public function __construct(ParameterBagInterface $params)
    {
        $this->apiToken = $params->get('API_SECRET_TOKEN');
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): Passport
    {
        $authorizationHeader = $request->headers->get('Authorization');

        if (!$authorizationHeader || !preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            throw new AuthenticationException('No token found');
        }

        $providedToken = $matches[1];

        if ($providedToken !== $this->apiToken) {
            throw new AuthenticationException('Invalid API token');
        }

        return new SelfValidatingPassport();
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?JsonResponse
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return new JsonResponse(['error' => 'Authentication Failed'], JsonResponse::HTTP_UNAUTHORIZED);
    }
}
