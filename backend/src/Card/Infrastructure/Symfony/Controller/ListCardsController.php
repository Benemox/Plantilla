<?php

namespace App\Card\Infrastructure\Symfony\Controller;

use App\Card\Application\Query\ListCards\ListCardsQuery;
use App\Card\Infrastructure\Symfony\Model\Response\CardListSchema;
use App\Shared\Infrastructure\Symfony\Controller\AbstractAPIController;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Get(
    path: "/api/v1/cards",
    summary: "Retrieve all credit cards with sorting options",
    parameters: [
        new OA\Parameter(
            name: "bonusProgram",
            description: "Filter by bonus program (true or false)",
            in: "query",
            required: false,
            schema: new OA\Schema(type: "boolean")
        ),
        new OA\Parameter(
            name: "sortBy",
            description: "Sort by (name, annualFee, transactionFee)",
            in: "query",
            required: false,
            schema: new OA\Schema(type: "string", enum: ["name", "annualFee", "transactionFee"])
        ),
        new OA\Parameter(
            name: "order",
            description: "Sorting order (asc or desc)",
            in: "query",
            required: false,
            schema: new OA\Schema(type: "string", enum: ["asc", "desc"])
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "List of credit cards",
            content: new OA\JsonContent(ref: new Model(type: CardListSchema::class))
        )
    ]
)]
#[OA\Tag(name: 'Cards')]
#[Route('/api/v1/cards', name: 'list_cards', methods: ['GET'])]
class ListCardsController extends AbstractAPIController
{
    public function __invoke(Request $request): JsonResponse
    {
        $bonusProgram = $request->query->get('bonusProgram');
        $sortBy = $request->query->get('sortBy', 'name');
        $order = $request->query->get('order', 'asc');

        if ($bonusProgram !== null) {
            $bonusProgram = filter_var($bonusProgram, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        }

        $envelope = $this->dispatch(new ListCardsQuery($bonusProgram, $sortBy, $order));

        $handledStamp = $envelope->last(HandledStamp::class);
        if (!$handledStamp) {
            throw new \RuntimeException("No handler returned a response.");
        }

        $cards = $handledStamp->getResult();

        return $this->json($cards);
    }
}
