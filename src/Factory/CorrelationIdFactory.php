<?php
declare(strict_types=1);

namespace Jontsa\Bundle\CorrelationIdBundle\Factory;

use Jontsa\Bundle\CorrelationIdBundle\Model\CorrelationId;
use Jontsa\Bundle\CorrelationIdBundle\Model\CorrelationIdInterface;
use Ramsey\Uuid\Uuid;

class CorrelationIdFactory implements CorrelationIdFactoryInterface
{

    public function __invoke() : CorrelationIdInterface
    {
        if (true === \class_exists(Uuid::class)) {
            $correlationId = Uuid::uuid4()->toString();
        } else {
            throw new \RuntimeException(sprintf("%s requires %s to create unique id values.", \get_class($this), Uuid::class));
        }
        return new CorrelationId($correlationId);
    }

}