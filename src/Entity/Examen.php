<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/**
 * Examen
 *
 * @ORM\Table(name="examen")
 * @ORM\Entity
 */
class Examen
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_examen", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idExamen;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="module", type="string", length=255, nullable=false)
     */
    private $module;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateex", type="date", nullable=false)
     */
    private $dateex;

    /**
     * @var string
     *
     * @ORM\Column(name="examen", type="string", length=255, nullable=false)
     */
    private $examen;

    /**
     * @var string
     *
     * @ORM\Column(name="correction", type="string", length=255, nullable=false)
     */
    private $correction;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $fileexamen;

    /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $filecorrection;

    /**
     * @return mixed
     */
    public function getFileexamen()
    {
        return $this->fileexamen;
    }

    /**
     * @param mixed $fileexamen
     */
    public function setFileexamen($fileexamen): void
    {
        $this->fileexamen = $fileexamen;
    }

    /**
     * @return mixed
     */
    public function getFilecorrection()
    {
        return $this->filecorrection;
    }

    /**
     * @param mixed $filecorrection
     */
    public function setFilecorrection($filecorrection): void
    {
        $this->filecorrection = $filecorrection;
    }





    public function getIdExamen(): ?int
    {
        return $this->idExamen;
    }

    public function getModule(): ?string
    {
        return $this->module;
    }

    public function setModule(string $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getDateex(): ?\DateTimeInterface
    {
        return $this->dateex;
    }

    public function setDateex(\DateTimeInterface $dateex): self
    {
        $this->dateex = $dateex;

        return $this;
    }

    public function getExamen(): ?string
    {
        return $this->examen;
    }

    public function setExamen(string $examen): self
    {
        $this->examen = $examen;

        return $this;
    }

    public function getCorrection(): ?string
    {
        return $this->correction;
    }

    public function setCorrection(string $correction): self
    {
        $this->correction = $correction;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }




    public function getWebpath(){


        return null === $this->examen ? null : $this->getUploadDir().'/'.$this->examen;
    }
    protected  function  getUploadRootDir(){

        return __DIR__.'/../../../ESkills/public/Upload'.$this->getUploadDir();
    }
    protected function getUploadDir(){

        return'';
    }
    public function getUploadFile(){
        if (null === $this->getFileexamen()) {
            $this->examen = "3.jpg";
            return;
        }


        $this->getFileexamen()->move(
            $this->getUploadRootDir(),
            $this->getFileexamen()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->examen = $this->getFileexamen()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->fileexamen = null;
    }






    public function getWebpathCorrection(){


        return null === $this->correction ? null : $this->getUploadDir().'/'.$this->correction;
    }

    protected function getUploadDirCorrection(){

        return'';
    }
    public function getUploadFileCorrection(){
        if (null === $this->getFilecorrection()) {
            $this->correction = "3.jpg";
            return;
        }


        $this->getFilecorrection()->move(
            $this->getUploadRootDir(),
            $this->getFilecorrection()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->correction = $this->getFilecorrection()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->filecorrection = null;
    }


}
