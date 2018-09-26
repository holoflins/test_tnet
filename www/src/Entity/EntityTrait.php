<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

trait EntityTrait
{
    /** @var int */
    private $id;

    /** @var bool */
    private $deleted = false;

    /** @var DateTime */
    private $createdAt;

    /** @var DateTime */
    private $updatedAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     *
     * @return EntityInterface
     */
    public function setDeleted(bool $deleted): EntityInterface
    {
        $this->deleted = $deleted;

        return $this;
    }
}
