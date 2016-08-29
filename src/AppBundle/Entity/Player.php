<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * A Player of the classic game Rock, Paper, Scissors.
 */
class Player
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Round")
     * @ORM\JoinTable(name="players_rounds",
     *      joinColumns={@ORM\JoinColumn(name="player_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="round_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $rounds;

    public function __construct()
    {
        $this->rounds = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add rounds
     *
     * @param \AppBundle\Entity\Round $rounds
     * @return Player
     */
    public function addRound(\AppBundle\Entity\Round $rounds)
    {
        $this->rounds[] = $rounds;

        return $this;
    }

    /**
     * Remove rounds
     *
     * @param \AppBundle\Entity\Round $rounds
     */
    public function removeRound(\AppBundle\Entity\Round $rounds)
    {
        $this->rounds->removeElement($rounds);
    }

    /**
     * Get rounds
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRounds()
    {
        return $this->rounds;
    }
}
