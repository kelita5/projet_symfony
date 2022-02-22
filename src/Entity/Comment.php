<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity()
 */
class Comment {
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @Assert\NotBlank(message="Le commentaire ne doit pas être vide!")
     * @Assert\Length(
     *      min = 10,
     *      max = 255,
     *      minMessage = "Le commentaire est trop court",
     *      maxMessage = "Le commentaire est trop long"
     * )
     * @ORM\Column(type="string")
     */
    private string $content;
    
    /**
     * @Assert\NotBlank(message="L'auteur ne doit pas être vide!")
     * @Assert\Length(
     *      min = 1,
     *      max = 70,
     *      minMessage = "L'auteur saisie est trop court",
     *      maxMessage = "L'auteur saisie est trop long"
     * )
     * @ORM\Column(type="string")
     */
    private string $author;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="comments")
     * @ORM\JoinColumn(onDelete = "CASCADE")
     */

    private string $article;

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
     * Get min = 10,
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set min = 10,
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get min = 1,
     */ 
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set min = 1,
     *
     * @return  self
     */ 
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get the value of article
     */ 
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set the value of article
     *
     * @return  self
     */ 
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }
}