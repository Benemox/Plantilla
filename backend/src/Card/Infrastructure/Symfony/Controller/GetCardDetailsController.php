<?php

namespace App\Card\Infrastructure\Symfony\Controller;

use App\Card\Application\Query\GetCardDetails\GetCardDetailsQuery;
use App\Card\Infrastructure\Symfony\Model\Response\CardDetailsSchema;
use App\Shared\Infrastructure\Symfony\Controller\AbstractAPIController;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Get(
    description: 'Retrieve details of a specific card by ID',
    summary: 'Get Card Details',
    parameters: [
        new OA\Parameter(
            name: 'cardId',
            description: 'The unique identifier of the card',
            in: 'path',
            required: true,
            schema: new OA\Schema(type: 'integer')
        ),
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Successfully retrieved card details',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'result',
                        ref: new Model(type: CardDetailsSchema::class),
                        type: 'object'
                    ),
                ]
            )
        ),
        new OA\Response(response: 404, description: 'Card not found'),
    ]
)]
#[OA\Tag(name: 'Cards')]
#[Route('/api/v1/cards/{cardId}', name: 'get_card_details', methods: ['GET'])]
class GetCardDetailsController extends AbstractAPIController
{
    public function __invoke(int $cardId): JsonResponse
    {
        try {
            $envelope = $this->dispatch(new GetCardDetailsQuery($cardId));
            $handledStamp = $envelope->last(HandledStamp::class);
            $result = $handledStamp->getResult();

            return $this->json($result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
