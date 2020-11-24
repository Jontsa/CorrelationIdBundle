<?php
declare(strict_types=1);

namespace Jontsa\Bundle\CorrelationIdBundle\Factory;

use Jontsa\Bundle\CorrelationIdBundle\Model\CorrelationIdInterface;

interface CorrelationIdFactoryInterface
{

    public function __invoke() : CorrelationIdInterface;

}