<?php

namespace MA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Project
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MA\MainBundle\Entity\ProjectRepository")
 */
class Project
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="completedAt", type="datetime", nullable=true)
     */
    private $completedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="totalAmount", type="integer")
     */
    private $totalAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="currentAmount", type="integer", nullable=true)
     */
    private $currentAmount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deliveryAt", type="datetime", nullable=true)
     */
    private $deliveryAt;

    /**
     * @ORM\ManyToOne(targetEntity="MA\MainBundle\Entity\Person")
     * @ORM\JoinColumn(nullable=true)
     */
    private $forPerson;


    /*   *********      construct  *************  */

    public function __construct()
    {
        $this->createdAt        = new \Datetime;
        $this->updatedAt        = new \Datetime;
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
     * Set title
     *
     * @param string $title
     * @return Project
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Project
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Project
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set completedAt
     *
     * @param \DateTime $completedAt
     * @return Project
     */
    public function setCompletedAt($completedAt)
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    /**
     * Get completedAt
     *
     * @return \DateTime 
     */
    public function getCompletedAt()
    {
        return $this->completedAt;
    }

    /**
     * Set totalAmount
     *
     * @param integer $totalAmount
     * @return Project
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return integer 
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set currentAmount
     *
     * @param integer $currentAmount
     * @return Project
     */
    public function setCurrentAmount($currentAmount)
    {
        $this->currentAmount = $currentAmount;

        return $this;
    }

    /**
     * Get currentAmount
     *
     * @return integer 
     */
    public function getCurrentAmount()
    {
        return $this->currentAmount;
    }

    /**
     * Set deliveryAt
     *
     * @param \DateTime $deliveryAt
     * @return Project
     */
    public function setDeliveryAt($deliveryAt)
    {
        $this->deliveryAt = $deliveryAt;

        return $this;
    }

    /**
     * Get deliveryAt
     *
     * @return \DateTime 
     */
    public function getDeliveryAt()
    {
        return $this->deliveryAt;
    }

    /**
     * Set forPerson
     *
     * @param \MA\MainBundle\Entity\Person $forPerson
     * @return Project
     */
    public function setForPerson(\MA\MainBundle\Entity\Person $forPerson = null)
    {
        $this->forPerson = $forPerson;

        return $this;
    }

    /**
     * Get forPerson
     *
     * @return \MA\MainBundle\Entity\Person 
     */
    public function getForPerson()
    {
        return $this->forPerson;
    }
}
