<?php
declare(strict_types=1);

namespace Jontsa\Bundle\CorrelationIdBundle\Model;

interface CorrelationIdInterface
{

    public function getCorrelationId(): string;

    public function setParent(CorrelationId $correlationId) : void;

    public function getParentId() : ?string;

}