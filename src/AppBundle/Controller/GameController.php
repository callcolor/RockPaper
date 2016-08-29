<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * GameController class
 * Plays Rock, Paper, Scissors and variations on the classic game.
 */
class GameController extends Controller
{
    private $actions = [
        "rock" => [
            "key" => "rock",
            "name" => "Rock",
            "beats" => ["lizard", "scissors"],
        ],
        "lizard" => [
            "key" => "lizard",
            "name" => "Lizard",
            "beats" => ["spock", "paper"],
        ],
        "paper" => [
            "key" => "paper",
            "name" => "Paper",
            "beats" => ["rock", "spock"],
        ],
        "spock" => [
            "key" => "spock",
            "name" => "Spock",
            "beats" => ["rock", "scissors"],
        ],
        "scissors" => [
            "key" => "scissors",
            "name" => "Scissors",
            "beats" => ["paper", "lizard"],
        ],
    ];

    private $player;

    /**
     * Determine if action defeats counter-action
     *
     * @return boolean
     */
    private function isWinner($playAction, $compAction)
    {
        if (in_array($compAction["key"], $playAction["beats"]))
        {
            return true;
        }
        return false;
    }

    /**
     * Persist round results
     */
    private function recordRound($action, $counter, $winner, $loser)
    {
        $em = $this->getDoctrine()->getManager();
        $round = new \AppBundle\Entity\Round;
        $round->setAction($action["key"]);
        $round->setCounter($counter["key"]);
        $round->setWinner($winner);
        $round->setLoser($loser);
        $this->player->addRound($round);
        $em->persist($round);
        $em->flush();
    }

    /**
     * Count wins
     *
     * @return integer
     */
    public function countWins()
    {
        $wins = 0;
        foreach ($this->player->getRounds() as $round)
        {
            if (true === $round->getWinner())
            {
                $wins++;
            }
        };
        return $wins;
    }

    /**
     * Count losses
     *
     * @return integer
     */
    public function countLosses()
    {
        $losses = 0;
        foreach ($this->player->getRounds() as $round)
        {
            if (true === $round->getLoser())
            {
                $losses++;
            }
        };
        return $losses;
    }

    /**
     * Count actions
     *
     * @return integer
     */
    public function countActions($actions)
    {
        foreach ($actions as &$action)
        {
            $action['player_play_count'] = 0;
            $action['computer_play_count'] = 0;
            foreach ($this->player->getRounds() as $round)
            {
                if ($action["key"] === $round->getAction())
                {
                    $action['player_play_count']++;
                }
                if ($action["key"] === $round->getCounter())
                {
                    $action['computer_play_count']++;
                }
            }
        }
        return $actions;
    }

    /**
     * @Route("/")
     *
     */
    public function indexAction(Request $request)
    {
        // Only one player.
        $this->player = $this->getDoctrine()->getRepository('AppBundle:Player')->find(1);

        $action = false;
        $counter = false;
        $winner = false;
        $loser = false;

        $actionKey = $request->request->get('action');
        if ($actionKey)
        {
            $action = $this->actions[$actionKey];
            $counter = $this->actions[array_rand($this->actions)];
            $winner = $this->isWinner($action, $counter);
            $loser = $this->isWinner($counter, $action);
            $this->recordRound($action, $counter, $winner, $loser);
        }

        return $this->render('game/index.html.twig', [
            "action" => $action,
            "counter" => $counter,
            "winner" => $winner,
            "loser" => $loser,
            "actions" => $this->countActions($this->actions),
            "wins" => $this->countWins(),
            "losses" => $this->countLosses(),
        ]);
    }
}
