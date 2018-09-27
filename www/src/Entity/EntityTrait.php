<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

trait EntityTrait
{
    /** @var int */
    private $id;

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
}
