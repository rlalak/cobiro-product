<?php


namespace App\Controller;


use Interview\Product\Application\CreateProductCommand;
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
            $parameters = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            return new JsonResponse(['error' => 'Bad Parameters', 'message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $command = new CreateProductCommand();
        $command->name = $parameters['name'] ?? null;
        $command->priceAmount = $parameters['priceAmount'] ?? null;
        $command->priceCurrency = $parameters['priceCurrency'] ?? null;

        $commandBus->handle($command);

        return new JsonResponse(['OK']);
    }
}
