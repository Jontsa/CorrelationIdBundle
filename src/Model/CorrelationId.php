<?php
declare(strict_types=1);

namespace Jontsa\Bundle\CorrelationIdBundle\Model;

final class CorrelationId implements CorrelationIdInterface
{

    private $correlationId;

    private $parentId;

    public function __construct(string $correlationId)
    {
        $this->correlationId = $correlationId;
    }

    /**
     * @return string
     */
    public function getCorrelationId(): string
    {
        return $this->correlationId;
    }

    public function setParent(CorrelationId $correlationId) : void
    {
        $this->parentId = $correlationId->getCorrelationId();
    }

    public function getParentId() : ?string
    {
        return $this->parentId;
    }

}