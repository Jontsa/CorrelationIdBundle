<?php
declare(strict_types=1);

namespace Jontsa\Bundle\CorrelationIdBundle\Tests\Monolog;

use Jontsa\Bundle\CorrelationIdBundle\Model\CorrelationId;
use Jontsa\Bundle\CorrelationIdBundle\Monolog\CorrelationIdProcessor;
use PHPUnit\Framework\TestCase;

class CorrelationIdProcessorTest extends TestCase
{

    /**
     * @param array $record
     * @param CorrelationId $correlationId
     * @param array $expected
     * @test
     * @dataProvider recordProvider
     */
    public function setsExtraAttributes(array $record, CorrelationId $correlationId, array $expected)
    {
        $processor = new CorrelationIdProcessor($correlationId);
        $result = $processor($record);
        $this->assertEquals($expected, $result);
    }

    public function recordProvider() : iterable
    {
        $correlationId = new CorrelationId('foo');
        yield [['extra' => []], $correlationId, ['extra' => ['correlation_id' => 'foo']]];
        yield [['extra' => ['xoo' => 'xer']], $correlationId, ['extra' => ['xoo' => 'xer', 'correlation_id' => 'foo']]];
        yield [['extra' => ['xoo' => 'xer', 'correlation_id' => 'bar']], $correlationId, ['extra' => ['xoo' => 'xer', 'correlation_id' => 'bar']]];
        $correlationId = new CorrelationId('foo');
        $correlationId->setParent(new CorrelationId('crux'));
        yield [['extra' => []], $correlationId, ['extra' => ['correlation_id' => 'foo', 'correlation_parent_id' => 'crux']]];
        yield [['extra' => ['correlation_parent_id' => 'bar']], $correlationId, ['extra' => ['correlation_id' => 'foo', 'correlation_parent_id' => 'bar']]];
        yield [['extra' => ['xoo' => 'xer', 'correlation_id' => 'bar']], $correlationId, ['extra' => ['xoo' => 'xer', 'correlation_id' => 'bar', 'correlation_parent_id' => 'crux']]];
    }
}