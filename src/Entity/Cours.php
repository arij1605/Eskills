<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Cours
 *
 * @ORM\Table(name="cours", indexes={@ORM\Index(name="formation_id", columns={"formation_id"})})
 * @ORM\Entity
 */
class Cours
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcours", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcours;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nomcours", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $nomcours = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="descriptioncours", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $descriptioncours = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="cours", type="string", length=255, nullable=false)
     */
    private $cours;

    /**
     * @var \Formation
     *
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="formation_id", referencedColumnName="idformation")
     * })
     */
    private $formation;
    /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $filecours;

    public function getCours(): ?string
    {
        return $this->cours;
    }

    public function setCours(string $cours): self
    {
        $this->cours = $cours;

        return $this;
    }
    public function getIdcours(): ?int
    {
        return $this->idcours;
    }
    /**
     * @return mixed
     */
    public function getFilecours()
    {
        return $this->filecours;
    }

    /**
     * @param mixed $filecours
     */
    public function setFilecours($filecours)
    {
        $this->filecours = $filecours;
    }

    public function getNomcours(): ?string
    {
        return $this->nomcours;
    }

    public function setNomcours(?string $nomcours): self
    {
        $this->nomcours = $nomcours;

        return $this;
    }

    public function getDescriptioncours(): ?string
    {
        return $this->descriptioncours;
    }

    public function setDescriptioncours(?string $descriptioncours): self
    {
        $this->descriptioncours = $descriptioncours;

        return $this;
    }

    public function getFormation()
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function getWebpathCours()
    {
        return null === $this->cours ? null : $this->getUploadDir().'/'.$this->cours;
    }
    protected  function  getUploadRootDir(){

        return __DIR__.'/../../../Eskills/public/Upload'.$this->getUploadDir();
    }
    protected function getUploadDir(){

        return'';
    }
    public function getUploadFile(){
        if (null === $this->getFilecours()) {
            $this->cours = "3.jpg";
            return;
        }


        $this->getFilecours()->move(
            $this->getUploadRootDir(),
            $this->getFilecours()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->cours = $this->getFilecours()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->filecours= null;
    }
}
