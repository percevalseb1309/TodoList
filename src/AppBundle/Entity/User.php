<?php
/**
 * @contributor Sébastien Rochat <percevalseb@gmail.com>
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Intl\Tests\Data\Util\RingBufferTest;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table("user")
 * @ORM\Entity
 * @UniqueEntity("username", message="Ce nom d'utilisateur existe déjà.")
 * @UniqueEntity("email", message="Cet adresse email existe déjà.")
 *
 * Class User
 * @package AppBundle\Entity
 */
class User implements UserInterface
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
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur.")
     * @Assert\Length(
     *     min=2,
     *     max=25,
     *     minMessage="Votre nom utilisateur doit comporter au moins {{ limit }} caractères.",
     *     maxMessage="Votre nom utilisateur ne peut pas contenir plus de {{ limit }} caractères."
     * )
     *
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Vous devez saisir un mot de passe.")
     * @Assert\Length(
     *     min=2,
     *     max=64,
     *     minMessage="Votre mot de passe doit comporter au moins {{ limit }} caractères.",
     *     maxMessage="Votre mot de passe ne peut pas contenir plus de {{ limit }} caractères."
     * )
     *
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir une adresse email.")
     * @Assert\Length(
     *     max=60,
     *     maxMessage="Votre adresse email ne peut pas contenir plus de {{ limit }} caractères."
     * )
     * @Assert\Email(message="Le format de l'adresse email n'est pas correcte.")
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(name="roles", type="array")
     * @Assert\NotBlank(message="Vous devez cocher au moins un rôle.")
     *
     * @var array
     */
    private $roles = [];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param $roles
     * @return $this
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
    }
}
