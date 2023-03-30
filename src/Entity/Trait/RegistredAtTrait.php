<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait RegistredAtTrait
{
    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $registreredAt = null;

    public function getRegistreredAt(): ?\DateTimeImmutable
    {
        return $this->registreredAt;
    }

    public function setRegistreredAt(?\DateTimeImmutable $registreredAt): self
    {
        $this->registreredAt = $registreredAt;

        return $this;
    }
}