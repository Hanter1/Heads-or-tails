<?php

class Player{
    public $name;
    public $coins;

    public function __construct($name, $coins)
    {
        $this->name = $name;
        $this->coins = $coins;
    }

    public function point(Player $player)
    {
        $this->coins++;
        $player->coins--;
    }

    public function bankrupt()
    {
        return $this->coins == 0;
    }

    public function bank()
    {
        return $this->coins;
    }

    public function odds(Player $player)
    {
        return round($this->bank() / ($this->bank() + $player->bank()), 2) * 100 . '%';
    }
}

class Game {
    protected $player1;
    protected $player2;
    protected $flips = 1;

    public function __construct(Player $player1, Player $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    public function flip()
    {
        return rand(0,1) ? "Орел" : "Решка";
    }

    public function start()
    {
        echo <<<EOT
           {$this->player1->name}: шансы {$this->player1->odds($this->player2)}
           {$this->player2->name}: шансы {$this->player2->odds($this->player1)}
            
        EOT;

        $this->play();
    }

    public function play()
    {
        while (true){
            if ($this->flip() == "Орел"){
                $this->player1->point($this->player2);
            }else{
                $this->player2->point($this->player1);
            }

            if ($this->player1->bankrupt() || $this->player2->bankrupt()){
                return $this->end();
            }

            $this->flips++;
        }
    }

    public function winner(): Player
    {
        return $this->player1->bank() > $this->player2->bank() ? $this->player1 : $this->player2;
    }

    public function end()
    {
        echo <<<EOT
            Game over!
            {$this->player1->name}: {$this->player1->bank()}
            {$this->player2->name}: {$this->player2->bank()}
            Победитель: {$this->winner()->name}
            Кол-во подбрасываний: {$this->flips}
        EOT;

    }
}

$game = new Game(
    new Player("ALEX", 100),
    new Player("DMITRY", 100)
);

$game->start();