<?php

namespace MA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Person
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MA\MainBundle\Entity\PersonRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Person
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="origin", type="string", length=255, nullable=true)
     */
    private $origin;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="bgColor", type="string", length=255, nullable=true)
     */
    private $bgColor;

    /**
     * @var integer
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;

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
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

    private $file;

    private $tempFilename;




    /*   *********      construct  *************  */

    public function __construct()
    {
        $this->createdAt        = new \Datetime;
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
     * @return Person
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
     * Set origin
     *
     * @param string $origin
     * @return Person
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return string 
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return Person
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Person
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
     * @return Person
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

    /*   *********     File  *************  */

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif)
        if (null === $this->file) {
          return;
        }

        // Le nom du fichier est son id, on doit juste stocker également son extension
        $this->url = $this->file->guessExtension();

        // Et on génère l'attribut 'alt' de la balise, à la valeur du nom du fichier sur le PC de l'internaute
        $this->alt = $this->file->getClientOriginalName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif)
        if (null === $this->file) {
          return;
        }

        // Si on avait un ancien fichier, on le supprime
        if (null !== $this->tempFilename) {
          $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
          if (file_exists($oldFile)) {
            unlink($oldFile);
          }
        }

        // On déplace le fichier envoyé dans le répertoire de notre choix
        $this->file->move(
          $this->getUploadRootDir(), // Le répertoire de destination
          $this->id.'.'.$this->url   // Le nom du fichier à créer, ici "id.extension"
        );
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        // On sauvegarde temporairement le nom du fichier car il dépend de l'id
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
        if (file_exists($this->tempFilename)) {
          // On supprime le fichier
          unlink($this->tempFilename);
        }
    }

    public function getUploadDir()
    {
        // On retourne le chemin relatif vers l'image pour un navigateur
        return 'img/besoins/photos';
    }

    protected function getUploadRootDir()
    {
        // On retourne le chemin absolu vers l'image pour notre code PHP
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
    }

    /**
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    public function setFile($file)
    {
        $this->file = $file;

        // On vérifie si on avait déjà un fichier pour cette entité
        if (null !== $this->url) {
          // On sauvegarde l'extension du fichier pour le supprimer plus tard
          $this->tempFilename = $this->url;

          // On réinitialise les valeurs des attributs url et alt
          $this->url = null;
          $this->alt = null;
        }
    }

    public function getFile()
    {
        return $this->file;
    }

    /*   *********   End  File  *************  */

    /**
     * Set color
     *
     * @param string $color
     * @return Person
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set bgColor
     *
     * @param string $bgColor
     * @return Person
     */
    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    /**
     * Get bgColor
     *
     * @return string 
     */
    public function getBgColor()
    {
        return $this->bgColor;
    }
}
