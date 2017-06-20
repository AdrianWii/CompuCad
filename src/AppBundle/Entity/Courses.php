<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * courses
 *
 * @ORM\Table(name="Courses")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CoursesRepository")
 */
class Courses
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="course", type="string", length=40)
     *
     * @ORM\OneToMany(targetEntity="Excercise", mappedBy="course")
     */
    private $course;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set course
     *
     * @param string $course
     *
     * @return courses
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return string
     */
    public function getCourse()
    {
        return $this->course;
    }
    
        public function __construct()
    {
        $this->course = new ArrayCollection();
    }
    
}
