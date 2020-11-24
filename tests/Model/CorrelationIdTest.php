<?php
declare(strict_types=1);

namespace Jontsa\Bundle\CorrelationIdBundle\Tests\Model;

use Jontsa\Bundle\CorrelationIdBundle\Model\CorrelationId;
use PHPUnit\Framework\TestCase;

class CorrelationIdTest extends TestCase
{

    /**
     * @test
     */
    public function initializes() : CorrelationId
    {
        $model = new CorrelationId('foobar');
        $this->assertEquals('foobar', $model->getCorrelationId());
        $this->assertNull($model->getParentId());
        return $model;
    }

    /**
     * @param CorrelationId $model
     * @test
     * @depends initializes
     */
    public function setsParent(CorrelationId $model)
    {
        $model2 = new CorrelationId('barfoo');
        $model->setParent($model2);
        $this->assertEquals('barfoo', $model->getParentId());
    }

}