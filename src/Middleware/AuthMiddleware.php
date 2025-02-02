<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AuthMiddleware implements EventSubscriberInterface
{
    public function __construct(private string $authToken)
    {
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        $authToken = $request->headers->get('Authorization');

        if (!$authToken || $authToken !== 'Bearer ' . $this->authToken) {
            $event->setResponse(new Response('Unauthorized', 401));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}





