<?php

declare(strict_types=1);

namespace App\UI\EventListener;

use App\Domain\Exception\ValidationViolationException;
use App\Infrastructure\ReadModel\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof ValidationViolationException) {
            $response = $this->handleValidationViolationException($exception);
        } else if ($exception instanceof NotFoundException) {
            $response = $this->handleNotFoundException($exception);
        } else {
            $response = $this->handleOtherException($exception);
        }
        $event->setResponse($response);
    }

    protected function handleValidationViolationException(ValidationViolationException $exception)
    {
        $responseData['data']['violations'] = $exception->getViolations();

        return new JsonResponse($responseData, JsonResponse::HTTP_BAD_REQUEST);
    }

    protected function handleOtherException(\Throwable $exception)
    {
        $responseData = $responseData = [
            'data' => [
                'message' => $exception->getMessage(),
            ],
        ];

        return new JsonResponse($responseData, $this->getStatus($exception));
    }

    private function getStatus(\Throwable $exception)
    {
        if ($exception instanceof HttpException) {
            return $exception->getStatusCode();
        }

        return JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
    }

    private function handleNotFoundException(\Throwable $exception)
    {
        return new JsonResponse(null, JsonResponse::HTTP_NOT_FOUND);
    }
}
