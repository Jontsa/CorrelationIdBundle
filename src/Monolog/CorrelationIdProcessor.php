<?php
declare(strict_types=1);

namespace Jontsa\Bundle\CorrelationIdBundle\Monolog;

use Jontsa\Bundle\CorrelationIdBundle\Model\CorrelationIdInterface;

class CorrelationIdProcessor
{

    private $correlationId;

    public function __construct(CorrelationIdInterface $correlationId)
    {
        $this->correlationId = $correlationId;
    }

    public function __invoke(array $record) : array
    {
        $extra = ['correlation_id' => $this->correlationId->getCorrelationId()];
        if (null !== $this->correlationId->getParentId()) {
            $extra['correlation_parent_id'] = $this->correlationId->getParentId();
        }

        $record['extra'] = \array_merge($extra, $record['extra'] ?? []);
        return $record;
    }
}