<?php

namespace Zephyr\CoursBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="unit")
 * @ORM\Entity(repositoryClass="Zephyr\CoursBundle\Entity\UnitRepository")
 */
class Unit
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @ORM\JoinColumn(nullable=false)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Zephyr\CoursBundle\Entity\Subject", inversedBy="units")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     */
    protected $subject;

    /**
     * @ORM\ManyToOne(targetEntity="Zephyr\CoursBundle\Entity\Classe", inversedBy="units")
     * @ORM\JoinColumn(name="classe", referencedColumnName="id")
     */
    protected $classe;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Unit
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set subject
     *
     * @param \Zephyr\CoursBundle\Entity\Subject $subject
     * @return Unit
     */
    public function setSubject(\Zephyr\CoursBundle\Entity\Subject $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \Zephyr\CoursBundle\Entity\Subject 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    public function getUnit()
    {
        return $this->name;
    }

    /**
     * Set classe
     *
     * @param \Zephyr\CoursBundle\Entity\Classe $classe
     * @return Unit
     */
    public function setClasse(\Zephyr\CoursBundle\Entity\Classe $classe = null)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return \Zephyr\CoursBundle\Entity\Classe 
     */
    public function getClasse()
    {
        return $this->classe;
    }

    public function __toString()
    {
        return $this->name;
    }
}
