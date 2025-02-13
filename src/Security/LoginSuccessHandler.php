<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $router;
    private $requestStack;

    public function __construct(RouterInterface $router,  RequestStack $requestStack)
    {
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $roles = $token->getRoleNames();

        /** @var Session $session */
        $session = $this->requestStack->getSession();

        /** @var FlashBag $flashBag */
        $flashBag = $session->getFlashBag();

        if(in_array('DELETED', $roles, true)) {
            // say user is deleted
            // ne fonctionne pas !!!!!!
            $flashBag->add('error', 'Your account has been deleted.');
            // logout
            $response = new RedirectResponse($this->router->generate('app_logout'));
        } else {
                $response = new RedirectResponse($this->router->generate('app_candidate_edit'));
        }

        // if (in_array('ROLE_ADMIN', $roles, true)) {
        //     $response = new RedirectResponse($this->router->generate('admin'));
        // } else {
        //     $response = new RedirectResponse($this->router->generate('app_profile'));
        // }


        return $response;
    }
}
