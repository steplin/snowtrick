<?php

/*
 * This file is part of the Symfony package.
 * (c) Stéphane BRIERE <stephanebriere@gdpweb.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User.
 *
 * @ORM\Table(name="sp_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Cette adresse mail est déjà utilisée par un autre compte")
 */
class User implements UserInterface, Serializable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\Length(min=6,minMessage="Votre identifiant doit contenir au moins 6 caractères")
     */
    private $username;
    /**
     * @var string
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;
    /**
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\Length(
     *     min=6,
     *     minMessage="Votre mot de passe doit contenir au moins 6 caractères"
     * )
     */
    private $password;
    /**
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;
    /**
     * @var bool
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive = false;

    /**
     * @var string
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @var string
     * @ORM\Column(name="date_token", type="datetime", nullable=true)
     */
    private $dateToken;

    /**
     * @ORM\JoinColumn(name="image_id", nullable=true)
     * @ORM\OneToOne(
     *     targetEntity="AppBundle\Entity\Image",
     *     cascade={"persist", "remove"}
     *     )
     * @Assert\Valid()
     */
    private $image;

    public function __construct()
    {
        $this->addRole('ROLE_DEFAULT');

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRoles()
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    /**
     * @param $role
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
    }

    public function setRoles(array $roles)
    {
        $mergeRoles = array_merge($this->roles, $roles);
        $this->roles = $mergeRoles;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return null|string
     */
    public function getSalt()
    {
        $this->salt = sha1(uniqid(mt_rand()));

        return $this->salt;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getDateToken()
    {
        return $this->dateToken;
    }

    public function setDateToken(\DateTime $dateToken)
    {
        $this->dateToken = $dateToken;
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(
            [
                $this->id,
                $this->username,
                $this->password,
            ]
        );
    }

    public function unserialize($serialized)
    {
        list(
            $this->id, $this->username, $this->password
            ) = unserialize($serialized);
    }

    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage(Image $image = null)
    {
        $this->image = $image;
    }
}
