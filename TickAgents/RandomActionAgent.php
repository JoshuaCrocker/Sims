<?php
class RandomActionAgent extends PopulationTickAgent {

    private $actions = [

    ];

    public function __construct() {
        $this->actions[] = new ActionChat();
        $this->actions[] = new ActionHit();
        $this->actions[] = new ActionClub();
        $this->actions[] = new ActionHeal();
    }

    private $action_chance = 0.7;

    public function tick($members) {
        // output('NOTE: The default tick agent doesn\'t do anything.');

        foreach ($members as $im => $member) {
            if ($this->random() <= $this->action_chance) {
                $action = $this->actions[mt_rand(0, count($this->actions)-1)];

                $target = $im;

                while ($target == $im) {
                    $target = mt_rand(0, count($members)-1);
                }

                $target = $members[$target];

                $action->act($member, $target);

            }
        }
    }

    private function random() {
        return mt_rand() / mt_getrandmax();
    }

}
