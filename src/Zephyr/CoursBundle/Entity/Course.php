<?php
//Entité inverse
namespace Zephyr\CoursBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="course")
 * @ORM\Entity(repositoryClass="Zephyr\CoursBundle\Entity\CourseRepository")
 */
class Course
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
    private $subject;

    /**
     * @ORM\Column(type="string", length=50)
     * @ORM\JoinColumn(nullable=false)
     */
    private $unit;

    /**
    * @ORM\Column(name="date", type="datetime")
    * @ORM\JoinColumn(nullable=false)
    *
    * @var \DateTime
    */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity="Zephyr\CoursBundle\Entity\Student", inversedBy="students")
     */
    private $students;

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
     * @return Course
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
     * @return Course
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
     * @return Course
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
     * Constructor
     */
    public function __construct()
    {
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add students
     *
     * @param \Zephyr\CoursBundle\Entity\Course $students
     * @return Course
     */
    public function addStudent(\Zephyr\CoursBundle\Entity\Course $students)
    {
        $this->students[] = $students;

        return $this;
    }

    /**
     * Remove students
     *
     * @param \Zephyr\CoursBundle\Entity\Course $students
     */
    public function removeStudent(\Zephyr\CoursBundle\Entity\Course $students)
    {
        $this->students->removeElement($students);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStudents()
    {
        return $this->students;
    }
}
