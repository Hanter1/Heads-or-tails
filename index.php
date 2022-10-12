<?php

class Player{
    public $name;
    public $coins;

    public function __construct($name, $coins)
    {
        $this->name = $name;
        $this->coins = $coins;
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

    public function start()
    {
        while (true){
            //Подбросить монету
            $flip = rand(0,1) ? "Орел" : "Решка";

            //Если орел, п1 получает монету, п2 теряет монету
            //Если решка, п2 получает монету, п1 теряет монету
            if ($flip == "Орел"){
                $this->player1->coins++;
                $this->player2->coins--;
            }else{
                $this->player1->coins--;
                $this->player2->coins++;
            }

            //Если у кого-то кол-во монет будет равен 0, то игра окончена.
            if ($this->player1->coins == 0 || $this->player2->coins ==0){
                return $this->end();
            }

            $this->flips++;
        }
    }

    public function winner()
    {
        if($this->player1->coins > $this->player2->coins){
            return $this->player1;
        }else{
            return $this->player2;
        }
    }

    public function end()
    {
        // Победитель тот, у кого больше монет.
        echo <<<EOT
            Game over!
            {$this->player1->name}: {$this->player1->coins}
            {$this->player2->name}: {$this->player2->coins}
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