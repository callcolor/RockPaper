<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    private function isWinner($playAction, $compAction)
    {
        if (in_array($compAction["key"], $playAction["beats"]))
        {
            return true;
        }
        return false;
    }

    /**
     * @Route("/")
     */

    public function indexAction(Request $request)
    {
        $action = false;
        $counter = false;
        $winner = false;
        $loser = false;

        $actionKey = $request->request->get('action');
        if ($actionKey){
            $action = $this->actions[$actionKey];
            $counter = $this->actions[array_rand($this->actions)];
            $winner = $this->isWinner($action, $counter);
            $loser = $this->isWinner($counter, $action);
        }

        return $this->render('game/index.html.twig', [
            "action" => $action,
            "counter" => $counter,
            "winner" => $winner,
            "loser" => $loser,
            "actions" => $this->actions,
        ]);
    }
}
