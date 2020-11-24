<?php
declare(strict_types=1);

namespace Jontsa\Bundle\CorrelationIdBundle\Tests\Messenger\Stamp;

use Jontsa\Bundle\CorrelationIdBundle\Messenger\Stamp\CorrelationIdStamp;
use PHPUnit\Framework\TestCase;

class CorrelationIdStampTest extends TestCase
{

    /**
     * @test
     */
    public function initializes()
    {
        $stamp = new CorrelationIdStamp('foobar');
        $this->assertEquals('foobar', $stamp->getCorrelationId());
    }

}