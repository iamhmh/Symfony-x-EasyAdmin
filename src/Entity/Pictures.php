<?php

namespace App\Entity;

use Serializable;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PicturesRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PicturesRepository::class)]
#[Vich\Uploadable]
class Pictures implements Serializable
{
    public function __toString()
    {
        return $this->imageName;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    //je met deux nouvelles propriétés pour les images 
    //la première propriété pour le nom du fichier
    //la deuxième propriété pour le fichier lui même
    #[ORM\Column(length: 255)]
    private ?string $imageName = null;

    #[Vich\UploadableField(mapping: 'product', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    //suivant la documentation de VichUploaderBundle, j'ai besoin d'avoir un uploadedAt
    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    //taille de nos images 
    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(length: 255)]
    private ?string $Alt = null;

    #[ORM\ManyToOne(inversedBy: 'Pictures')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Product $Product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlt(): ?string
    {
        return $this->Alt;
    }

    public function setAlt(string $Alt): self
    {
        $this->Alt = $Alt;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->Product;
    }

    public function setProduct(?Product $Product): self
    {
        $this->Product = $Product;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    
    public function serialize(): string
    {
        return serialize(
            array(
                $this->id,
                $this->imageName,
                $this->Alt,
            )
        );
    }

    public function unserialize(string $serialized)
    {
        list (
            $this->id,
            $this->imageName,
            $this->Alt,
            ) = unserialize($serialized, array('allowed_classes' => false));
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    
}
