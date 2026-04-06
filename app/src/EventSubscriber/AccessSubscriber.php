<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class AccessSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly UrlGeneratorInterface $urlGenerator)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $route = (string) $request->attributes->get('_route', '');
        if ($route === '' || str_starts_with($route, '_')) {
            return;
        }

        $publicRoutes = ['intro', 'auth_login', 'auth_signup', 'auth_logout'];
        if (in_array($route, $publicRoutes, true)) {
            return;
        }

        $session = $request->getSession();
        $role = strtolower((string) $session->get('auth_role', ''));
        $isLoggedIn = (int) $session->get('auth_user_id', 0) > 0;

        if ($route === 'home' || str_starts_with($route, 'management_')) {
            if (!$isLoggedIn || $role !== 'user') {
                $event->setResponse(new RedirectResponse($this->urlGenerator->generate('auth_login', ['mode' => 'user'])));
            }

            return;
        }

        if ($route === 'admin_home' || str_starts_with($route, 'admin_')) {
            if (!$isLoggedIn || $role !== 'admin') {
                $event->setResponse(new RedirectResponse($this->urlGenerator->generate('auth_login', ['mode' => 'admin'])));
            }
        }
    }
}