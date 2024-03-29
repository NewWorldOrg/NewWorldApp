<?php

declare(strict_types=1);

namespace Domain\MedicationHistory;

use Courage\CoInt\CoPositiveInteger;

class MedicationHistoryId extends CoPositiveInteger
{
    public function __construct(int $value)
    {
        parent::__construct($value);
    }
}
