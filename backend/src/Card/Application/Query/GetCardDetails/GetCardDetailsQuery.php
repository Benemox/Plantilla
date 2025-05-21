<?php

namespace App\Card\Application\Query\GetCardDetails;

use App\Shared\Domain\Bus\QueryMessageInterface;

class GetCardDetailsQuery implements QueryMessageInterface
{
    public function __construct(public string $cardId)
    {
    }
}
