<?php
declare(strict_types=1);

namespace Jontsa\Bundle\CorrelationIdBundle\EventListener;

use Jontsa\Bundle\CorrelationIdBundle\Model\CorrelationId;
use Jontsa\Bundle\CorrelationIdBundle\Model\CorrelationIdInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class CorrelationIdRequestListener
{

    const HEADER_NAME = 'x-correlation-id';

    private $correlationId;

    public function __construct(CorrelationIdInterface $correlationId)
    {
        $this->correlationId = $correlationId;
    }

    public function __invoke(RequestEvent $event): void
    {
        if (false === $event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        if (true === $request->headers->has(self::HEADER_NAME)) {
            $this->correlationId->setParent(new CorrelationId($request->headers->get(self::HEADER_NAME)));
        }
    }

}
