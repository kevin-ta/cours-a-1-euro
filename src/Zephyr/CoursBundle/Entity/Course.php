<?php
//Entité propriétaire
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
     * @ORM\JoinColumn(nullable=true)
     */
    private $classe;

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
     * @ORM\ManyToMany(targetEntity="Zephyr\CoursBundle\Entity\Student", mappedBy="courses")
     */
    private $students;

    /**
     * @ORM\Column(type="string", length=50)
     * @ORM\ManyToOne(targetEntity="Zephyr\CoursBundle\Entity\Student")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prof;

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

    public function addStudent(Student $student)
    {
        $student->addCourse($this);
        $this->students[] = $student;

        return $this;
    }

    public function removeStudent(Student $student)
    {
        $this->students->removeElement($student);
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

    /**
     * Set classe
     *
     * @param string $classe
     * @return Course
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return string 
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * Set prof
     *
     * @param string $prof
     * @return Course
     */
    public function setProf($prof)
    {
        $this->prof = $prof;

        return $this;
    }

    /**
     * Get prof
     *
     * @return string 
     */
    public function getProf()
    {
        return $this->prof;
    }
}
