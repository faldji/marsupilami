<?php

namespace CoreBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     * @Assert\NotBlank(message="Entrer votre age.", groups={"Registration", "Profile"})
     * @Assert\Range(
     *     min=1,
     *     max=10,
     *     minMessage="essaye encore.",
     *     maxMessage="aucun marsupilami ne peut avoir cet age.",
     *     groups={"Registration", "Profile"}
     * )
     */

    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="famille", type="string", length=255, nullable=true)
     */
    private $famille;

    /**
     * @var string
     *
     * @ORM\Column(name="race", type="string", length=255, nullable=true)
     */
    private $race;

    /**
     * @var string
     *
     * @ORM\Column(name="nourriture", type="string", length=255, nullable=true)
     */
    private $nourriture;

    /**
     * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\User", mappedBy="myFriends")
     *
     */
    private $friendsWithMe;

    /**
     * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\User", inversedBy="friendsWithMe")
     * @ORM\JoinTable(name="carnetAdresse",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="carnetAdresse_user_id", referencedColumnName="id")}
     *      )
     */
    private $myFriends;

    private $tmpFriend;

    public function __construct() {
        $this->friendsWithMe = new \Doctrine\Common\Collections\ArrayCollection();
        $this->myFriends = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set age.
     *
     * @param int|null $age
     *
     * @return User
     */
    public function setAge($age = null)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age.
     *
     * @return int|null
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set famille.
     *
     * @param string|null $famille
     *
     * @return User
     */
    public function setFamille($famille = null)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get famille.
     *
     * @return string|null
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Set race.
     *
     * @param string|null $race
     *
     * @return User
     */
    public function setRace($race = null)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Get race.
     *
     * @return string|null
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Set nourriture.
     *
     * @param string|null $nourriture
     *
     * @return User
     */
    public function setNourriture($nourriture = null)
    {
        $this->nourriture = $nourriture;

        return $this;
    }

    /**
     * Get nourriture.
     *
     * @return string|null
     */
    public function getNourriture()
    {
        return $this->nourriture;
    }

    /**
     * Add friendsWithMe.
     *
     * @param \CoreBundle\Entity\User $friendsWithMe
     *
     * @return User
     */
    public function addFriendsWithMe(\CoreBundle\Entity\User $friendsWithMe)
    {
        $this->friendsWithMe[] = $friendsWithMe;

        return $this;
    }

    /**
     * Remove friendsWithMe.
     *
     * @param \CoreBundle\Entity\User $friendsWithMe
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFriendsWithMe(\CoreBundle\Entity\User $friendsWithMe)
    {
        return $this->friendsWithMe->removeElement($friendsWithMe);
    }

    /**
     * Get friendsWithMe.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriendsWithMe()
    {
        return $this->friendsWithMe;
    }

    /**
     * Add myFriend.
     *
     * @param \CoreBundle\Entity\User $myFriend
     *
     * @return User
     */
    public function addMyFriend(\CoreBundle\Entity\User $myFriend)
    {
        foreach ($this->myFriends as $item) {
            if ($item == $myFriend){
                return 0;
            }
        }
        $this->myFriends[] = $myFriend;

        return $this;
    }

    /**
     * Remove myFriend.
     *
     * @param \CoreBundle\Entity\User $myFriend
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMyFriend(\CoreBundle\Entity\User $myFriend)
    {
        return $this->myFriends->removeElement($myFriend);
    }

    /**
     * Get myFriends.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMyFriends()
    {
        return $this->myFriends;
    }

    /**
     * @return mixed
     */
    public function getTmpFriend()
    {
        return $this->tmpFriend;
    }

    /**
     * @param mixed $tmpFriend
     */
    public function setTmpFriend($tmpFriend)
    {
        $this->tmpFriend = $tmpFriend;
    }

}
