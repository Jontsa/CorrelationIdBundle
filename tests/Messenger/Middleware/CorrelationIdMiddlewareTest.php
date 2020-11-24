<?php
declare(strict_types=1);

namespace Jontsa\Bundle\CorrelationIdBundle\Tests\Messenger\Middleware;

use Jontsa\Bundle\CorrelationIdBundle\Messenger\Middleware\CorrelationIdMiddleware;
use Jontsa\Bundle\CorrelationIdBundle\Messenger\Stamp\CorrelationIdStamp;
use Jontsa\Bundle\CorrelationIdBundle\Model\CorrelationId;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;

class CorrelationIdMiddlewareTest extends TestCase
{

    private $correlationId;

    private $middleware;

    public function setUp() : void
    {
        $this->correlationId = new CorrelationId('foobar');
        $this->middleware = new CorrelationIdMiddleware($this->correlationId);
    }

    /**
     * @test
     */
    public function setsStamp()
    {
        $envelope = new Envelope(new \stdClass());

        $next = $this->createMock(MiddlewareInterface::class);
        $stack = $this->createStack($next);
        $next
            ->expects($this->once())
            ->method('handle')
            ->with($this->callback(function(Envelope $envelope) {
                /** @var CorrelationIdStamp|null $stamp */
                $stamp = $envelope->last(CorrelationIdStamp::class);
                $this->assertNotNull($stamp);
                return $stamp->getCorrelationId() === $this->correlationId->getCorrelationId();
            }), $stack)
            ->willReturnArgument(0);
        $this->middleware->handle($envelope, $stack);
    }

    /**
     * @test
     */
    public function handleMessageWithStamp()
    {
        $envelope = (new Envelope(new \stdClass()))
            ->with(new ReceivedStamp('transport'))
            ->with(new CorrelationIdStamp('xooxer'));

        $next = $this->createMock(MiddlewareInterface::class);
        $stack = $this->createStack($next);
        $next
            ->expects($this->once())
            ->method('handle')
            ->with($envelope, $stack)
            ->willReturnArgument(0);

        $this->middleware->handle($envelope, $stack);
        $this->assertEquals('xooxer', $this->correlationId->getParentId());
    }

    /**
     * @test
     */
    public function handleMessageWithoutStamp()
    {
        $envelope = (new Envelope(new \stdClass()))
            ->with(new ReceivedStamp('transport'));

        $next = $this->createMock(MiddlewareInterface::class);
        $stack = $this->createStack($next);
        $next
            ->expects($this->once())
            ->method('handle')
            ->with($envelope, $stack)
            ->willReturnArgument(0);

        $this->middleware->handle($envelope, $stack);
        $this->assertNull($this->correlationId->getParentId());
    }

    private function createStack(MiddlewareInterface $next) : StackInterface
    {
        $stack = $this->createMock(StackInterface::class);
        $stack
            ->expects($this->once())
            ->method('next')
            ->willReturn($next);
        return $stack;
    }

}