<?php

namespace Zephyr\CoursBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="unit")
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
     */
    private $name;

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
