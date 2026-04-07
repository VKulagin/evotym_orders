<?php

declare(strict_types=1);

namespace App\Controller;

use DomainException;
use App\DTO\CreateOrderRequest;
use App\Service\OrderManagerInterface;
use App\Service\OrderResponseFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Route('/orders')]
final class OrderController extends AbstractController
{
    #[Route('', name: 'order_create', methods: ['POST'])]
    public function create(
        Request $request,
        ValidatorInterface $validator,
        OrderManagerInterface $orderService,
        OrderResponseFactoryInterface $responseFactory,
    ): JsonResponse
    {
        $payload = json_decode($request->getContent(), true) ?? [];
        $dto = CreateOrderRequest::fromArray($payload);

        $errors = $validator->validate($dto);

        if (count($errors) > 0) {
            return $this->processErrors($errors);
        }

        try {
            $order = $orderService->create($dto);
        } catch (DomainException $exception) {
            return $this->json(
                ['message' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json(
            $responseFactory->one($order),
            Response::HTTP_CREATED
        );
    }

    #[Route('', name: 'order_list', methods: ['GET'])]
    public function list(
        OrderManagerInterface $orderService,
        OrderResponseFactoryInterface $responseFactory,
    ): JsonResponse
    {
        return $this->json(
            $responseFactory->many($orderService->getAll())
        );
    }

    #[Route('/{id}', name: 'order_get', methods: ['GET'])]
    public function getOne(
        string $id,
        OrderManagerInterface $orderService,
        OrderResponseFactoryInterface $responseFactory,
    ): JsonResponse
    {
        $order = $orderService->getById($id);

        if ($order === null) {
            return $this->json(
                ['message' => 'Order not found'],
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->json($responseFactory->one($order));
    }

    private function processErrors(ConstraintViolationListInterface $errors): JsonResponse
    {
        $errorMessages = [];

        foreach ($errors as $error) {
            $errorMessages[] = [
                'field' => $error->getPropertyPath(),
                'message' => $error->getMessage(),
            ];
        }

        return $this->json(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
    }
}