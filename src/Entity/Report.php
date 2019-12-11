<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="reports")
 * @ORM\Entity(repositoryClass="App\Repository\ReportRepository")
 */
class Report
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reports")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=12)
     */
    private $edrpou;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $nreg;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $file;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $publicDt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return UserInterface|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getEdrpou(): string
    {
        return $this->edrpou;
    }

    /**
     * @param string $edrpou
     */
    public function setEdrpou(string $edrpou): void
    {
        $this->edrpou = $edrpou;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isNreg(): bool
    {
        return $this->nreg;
    }

    /**
     * @param bool $nreg
     */
    public function setNreg(bool $nreg): void
    {
        $this->nreg = $nreg;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    /**
     * @return \DateTime
     */
    public function getPublicDt(): \DateTime
    {
        return $this->publicDt;
    }

    /**
     * @param \DateTime $publicDt
     */
    public function setPublicDt(\DateTime $publicDt): void
    {
        $this->publicDt = $publicDt;
    }
}
