<?php
    
/**
 * Random Action Agent class
 *
 * @extends     PopulationTickAgent
 * @author      Joshua Crocker
 * @category    System
 * @version     1.0.0
 */
class RandomActionAgent extends PopulationTickAgent {
    
    /**
     * Action Array
     * 
     * (default value: [])
     * 
     * @var array
     * @access private
     */
    private $actions = [];

    /**
     * Random Action Agent Constructor
     * 
     * @access public
     * @return void
     */
    public function __construct() {
        $this->actions[] = new ActionChat();
        $this->actions[] = new ActionHit();
        $this->actions[] = new ActionClub();
        $this->actions[] = new ActionHeal();
    }

    /**
     * Action Chance
     *
     * The chance that an action will occur
     * 
     * (default value: 0.7)
     * 
     * @var float
     * @access private
     */
    private $action_chance = 0.7;

    /**
     * Tick Method
     *
     * Execute the next cycle of the simulation.
     * 
     * @access public
     * @param mixed $members
     * @return void
     */
    public function tick($members) {
        // Loop through each member of the array
        foreach ($members as $im => $member) {
            // Generate a random number, if it's greater than the action chance, perform an action
            if ($this->random() <= $this->action_chance) {
                // Get a random action
                $action = $this->actions[mt_rand(0, count($this->actions) - 1)];
                
                // Get a random target
                $target = $im;

                while ($target == $im) {
                    $target = mt_rand(0, count($members) - 1);
                }

                $target = $members[$target];
                
                // Perform action
                $action->act($member, $target);

            }
        }
    }

    /**
     * Random Method
     * 
     * @access private
     * @return float
     */
    private function random() {
        return mt_rand() / mt_getrandmax();
    }

}
