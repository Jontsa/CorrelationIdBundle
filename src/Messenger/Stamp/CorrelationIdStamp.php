<?php
declare(strict_types=1);

namespace Jontsa\Bundle\CorrelationIdBundle\Messenger\Stamp;

use Symfony\Component\Messenger\Stamp\StampInterface;

final class CorrelationIdStamp implements StampInterface
{

    private $correlationId;

    public function __construct(string $correlationId)
    {
        $this->correlationId = $correlationId;
    }

    public function getCorrelationId() : string
    {
        return $this->correlationId;
    }
}
