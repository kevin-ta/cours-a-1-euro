<?php

namespace Zephyr\CoursBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="cours")
 * @ORM\Entity(repositoryClass="Zephyr\CoursBundle\Entity\CoursRepository")
 */
class Cours
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
    private $subject;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $unit;

    /**
    * @ORM\Column(name="date", type="datetime")
    *
    * @var \DateTime
    */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Zephyr\CoursBundle\Entity\Student", inversedBy="cours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;


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
     * Set subject
     *
     * @param string $subject
     * @return Cours
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set unit
     *
     * @param string $unit
     * @return Cours
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Cours
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set student
     *
     * @param \Zephyr\CoursBundle\Entity\Student $student
     * @return Cours
     */
    public function setStudent(\Zephyr\CoursBundle\Entity\Student $student)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \Zephyr\CoursBundle\Entity\Student 
     */
    public function getStudent()
    {
        return $this->student;
    }
}
