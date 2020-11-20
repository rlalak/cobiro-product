<?php


namespace App\Controller;


use Interview\Product\Application\Command\CreateProductCommand;
use Interview\Product\Application\Command\RemoveProductCommand;
use Interview\Product\Application\Command\UpdateProductCommand;
use Interview\Product\Application\Query\GetProductQueryInterface;
use Interview\Product\Exception\Infrastructure\ProductNotFoundException;
use Interview\Product\Exception\ProductExceptionInterface;
use JsonException;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController
{
    public function save(Request $request, CommandBus $commandBus, ?string $id) : Response
    {
        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            return $this->getBadDataResponse($exception->getMessage());
        }

        if (!isset($data['name'])) {
            return $this->getBadDataResponse('Product name is required');
        }

        if (!isset($data['priceAmount'])) {
            return $this->getBadDataResponse('Product price amount is required');
        }

        if ($id !== null) {
            $command = new UpdateProductCommand($id, $data['name'], $data['priceAmount']);
        } else {
            $command = new CreateProductCommand($data['name'], $data['priceAmount']);
        }

        $command->priceCurrency = $data['priceCurrency'] ?? null;

        try {
            $commandBus->handle($command);
        } catch (ProductExceptionInterface $exception) {
            return $this->getBadDataResponse($exception->getMessage());
        }

        return new JsonResponse(['status' => 'OK']);
    }

    public function remove(CommandBus $commandBus, string $id) : Response
    {
        try {
            $commandBus->handle(new RemoveProductCommand($id));
        } catch (ProductExceptionInterface $exception) {
            return $this->getBadDataResponse($exception->getMessage());
        }

        return new JsonResponse(['status' => 'OK']);
    }

    public function getAll(GetProductQueryInterface $getProductQuery) : Response
    {
        return new JsonResponse(['status' => 'OK', 'data' => $getProductQuery->getAlProducts()]);
    }

    public function getById(string $id, GetProductQueryInterface $getProductQuery) : Response
    {
        try {
            $product = $getProductQuery->getProduct($id);
        } catch (ProductNotFoundException $exception) {
            return new JsonResponse(['error' => 'Product not found.'], 404);
        }

        return new JsonResponse(['status' => 'OK', 'data' => $product]);
    }

    protected function getBadDataResponse(string $message) : Response
    {
        return new JsonResponse(
            ['error' => 'Bad parameters', 'message' => $message],
            Response::HTTP_BAD_REQUEST
        );
    }
}
