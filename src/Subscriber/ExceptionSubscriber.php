<?php

declare(strict_types=1);

namespace App\Subscriber;

use App\Exception\InvalidEntityException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['processException', -10],
        ];
    }

    public function processException(ExceptionEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $uri = $event->getRequest()->getRequestUri();
        if (!preg_match('/^\/api\//', $uri)) {
            return;
        }

        $throwable = $event->getThrowable();
        if ($throwable instanceof InvalidEntityException) {
            $body = [
                'message' => $throwable->getMessage(),
                'errors' => $throwable->getErrors(),
            ];
            $statusCode = Response::HTTP_BAD_REQUEST;
        } else {
            $body = [
                'message' => 'internal server error',
                'error' => $throwable->getMessage().' '.$throwable->getFile().' '.$throwable->getLine(),
                'trace' => $throwable->getTrace()[0],
            ];
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $response = new Response(
            json_encode($body, JSON_THROW_ON_ERROR),
            $statusCode
        );
        $response->headers->set('Content-Type', 'application/json');

        $event->setResponse(
            $response
        );
    }
}
