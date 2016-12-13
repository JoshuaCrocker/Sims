<?php
    
/**
 * Population Tick Agent class
 *
 * @author      Joshua Crocker
 * @category    System
 * @version     1.0.0
 */
class PopulationTickAgent {
    
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
        Output::getInstance()->warning('The default tick agent doesn\'t perform any action.');
    }

}
