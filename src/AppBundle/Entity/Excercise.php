<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Excercise
 *
 * @ORM\Table(name="excercise")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExcerciseRepository")
 */
class Excercise
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
     * @ORM\Column(name="excercise", type="string", length=255)
     */
    private $excercise;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="Courses", inversedBy="course")
     * @ORM\JoinColumn(name="courses_id", referencedColumnName="id")
     */
    private $courses;
    
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
     * Set excercise
     *
     * @param string $excercise
     *
     * @return Excercise
     */
    public function setExcercise($excercise)
    {
        $this->excercise = $excercise;

        return $this;
    }

    /**
     * Get excercise
     *
     * @return string
     */
    public function getExcercise()
    {
        return $this->excercise;
    }

    /**
     * Set courses
     *
     * @param \AppBundle\Entity\Courses $courses
     *
     * @return Excercise
     */
    public function setCourses(\AppBundle\Entity\Courses $courses = null)
    {
        $this->courses = $courses;

        return $this;
    }

    /**
     * Get courses
     *
     * @return \AppBundle\Entity\Courses
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Excercise
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}
