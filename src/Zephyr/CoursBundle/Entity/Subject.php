<?php

namespace Zephyr\CoursBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="subject")
 * @ORM\Entity(repositoryClass="Zephyr\CoursBundle\Entity\SubjectRepository")
 */
class Subject
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
     * @ORM\OneToMany(targetEntity="Zephyr\CoursBundle\Entity\Unit", mappedBy="subject", cascade={"remove", "persist"})
     */
    protected $units;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->units = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Subject
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
     * Add units
     *
     * @param \Zephyr\CoursBundle\Entity\Unit $units
     * @return Subject
     */
    public function addUnit(\Zephyr\CoursBundle\Entity\Unit $units)
    {
        $this->units[] = $units;

        return $this;
    }

    /**
     * Remove units
     *
     * @param \Zephyr\CoursBundle\Entity\Unit $units
     */
    public function removeUnit(\Zephyr\CoursBundle\Entity\Unit $units)
    {
        $this->units->removeElement($units);
    }

    /**
     * Get units
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnits()
    {
        return $this->units;
    }

    public function getSubject()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
