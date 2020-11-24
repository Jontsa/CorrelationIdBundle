<?php
declare(strict_types=1);

namespace Jontsa\Bundle\CorrelationIdBundle\Messenger\Middleware;

use Jontsa\Bundle\CorrelationIdBundle\Messenger\Stamp\CorrelationIdStamp;
use Jontsa\Bundle\CorrelationIdBundle\Model\CorrelationId;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;

class CorrelationIdMiddleware implements MiddlewareInterface
{

    private $correlationId;

    public function __construct(CorrelationId $correlationId)
    {
        $this->correlationId = $correlationId;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if ($envelope->all(ReceivedStamp::class)) {
            /** @var CorrelationIdStamp|null $stamp */
            $stamp = $envelope->last(CorrelationIdStamp::class);
            if (null !== $stamp) {
                $this->correlationId->setParent(new CorrelationId($stamp->getCorrelationId()));
            }
        } else {
            $envelope = $envelope->with(new CorrelationIdStamp($this->correlationId->getCorrelationId()));
        }
        return $stack->next()->handle($envelope, $stack);
    }

}
