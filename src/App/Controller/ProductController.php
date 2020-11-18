<?php


namespace App\Controller;


use Interview\Product\Application\Command\SaveProductCommand;
use Interview\Product\Exception\ProductExceptionInterface;
use JsonException;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController
{
    public function save(Request $request, CommandBus $commandBus) : Response
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

        $productCode = null;
        if ($request->getMethod() === 'PUT') {
            if (!isset($data['priceAmount'])) {
                return $this->getBadDataResponse('Product code is required');
            }

            $productCode = $data['code'];
        }

        $command = new SaveProductCommand($data['name'], $data['priceAmount']);
        $command->priceCurrency = $data['priceCurrency'] ?? null;
        $command->code = $productCode;

        try {
            $commandBus->handle($command);
        } catch (ProductExceptionInterface $exception) {
            return $this->getBadDataResponse($exception->getMessage());
        }

        return new JsonResponse(['status' => 'OK', 'data' => ['productCode' => $productCode]]);
    }

    protected function getBadDataResponse(string $message) : Response
    {
        return new JsonResponse(
            ['error' => 'Bad parameters', 'message' => $message],
            Response::HTTP_BAD_REQUEST
        );
    }
}
