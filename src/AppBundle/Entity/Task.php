<?php
/**
 * @contributor Sébastien Rochat <percevalseb@gmail.com>
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table("task")
 * @ORM\Entity
 * @UniqueEntity("title", message="Ce nom de tâche existe déjà.")
 *
 * Class Task
 * @package AppBundle\Entity
 */
class Task
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;


    /**
     *
     * @ORM\Column(type="datetime")
     *
     * @var \Datetime
     */
    private $createdAt;


    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank(message="Vous devez saisir un titre.")
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     minMessage="Votre titre doit comporter au moins {{ limit }} caractères.",
     *     maxMessage="Votre titre ne peut pas contenir plus de {{ limit }} caractères."
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous devez saisir du contenu.")
     *
     * @var string
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    private $isDone;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var User
     */
    private $user;


    /**
     * Task constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->createdAt = new \Datetime('NOW', new \DateTimeZone('Europe/Paris'));
        $this->isDone = false;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return bool
     */
    public function isDone()
    {
        return $this->isDone;
    }

    /**
     * @param $flag
     */
    public function toggle($flag)
    {
        $this->isDone = $flag;
    }


    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
}
