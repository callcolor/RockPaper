<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * A round of the classic game Rock, Paper, Scissors
 * Rounds are played by a Player and accessed through the Player Entity
 */
class Round
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $action;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $counter;

    /**
     * @ORM\Column(type="boolean")
     */
    private $winner;

    /**
     * @ORM\Column(type="boolean")
     */
    private $loser;

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
     * Set action
     *
     * @param string $action
     * @return Round
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string 
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set counter
     *
     * @param string $counter
     * @return Round
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;

        return $this;
    }

    /**
     * Get counter
     *
     * @return string 
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * Set winner
     *
     * @param boolean $winner
     * @return Round
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner
     *
     * @return boolean 
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Set loser
     *
     * @param boolean $loser
     * @return Round
     */
    public function setLoser($loser)
    {
        $this->loser = $loser;

        return $this;
    }

    /**
     * Get loser
     *
     * @return boolean 
     */
    public function getLoser()
    {
        return $this->loser;
    }
}
