<?php

namespace FP\Larmo\Domain\ValueObject;

use FP\Larmo\Domain\Service\UniqueIdGenerator;

class UniqueId {
    private $uniqueId;

    /**
     * @param mixed $uniqueId
     */
    public function __construct($uniqueId)
    {
        $this->uniqueId = $uniqueId;

        if($uniqueId instanceof UniqueIdGenerator) {
            $this->uniqueId = $uniqueId->generate();
        }
    }

    public function getId()
    {
        return $this->uniqueId;
    }
}
