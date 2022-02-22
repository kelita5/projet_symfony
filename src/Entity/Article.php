<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use DateTime; 

/**
 * @ORM\Entity()
 */
class Article {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @Assert\NotBlank(message="Le titre ne doit pas être vide!")
     * @Assert\Length(
     *      min = 5,
     *      max = 70,
     *      minMessage = "Le titre est trop court",
     *      maxMessage = "Le titre est trop long"
     * )
     * @ORM\Column(type="string")
     */
    private string $title;
    
    /**
     * @Assert\NotBlank(message="Le contenu ne doit pas être vide!")
     * @Assert\Length(
     *      min = 10,
     *      max = 5000,
     *      minMessage = "Le contenu est trop court",
     *      maxMessage = "Le contenu est trop long"
     * )
     * @ORM\Column(type="text")
     */
    private string $content;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="article")
     */
    private $comments;
    
    /**
     * @ORM\Column(type="date")
     */

    private DateTime $createdAt;

    /**
     * @ORM\Column(type="string")
     */
    private $brochureFilename;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of comments
     */ 
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set the value of comments
     *
     * @return  self
     */ 
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get the value of brochureFilename
     */ 
    public function getBrochureFilename()
    {
        return $this->brochureFilename;
    }

    /**
     * Set the value of brochureFilename
     *
     * @return  self
     */ 
    public function setBrochureFilename($brochureFilename)
    {
        $this->brochureFilename = $brochureFilename;

        return $this;
    }
}

?>