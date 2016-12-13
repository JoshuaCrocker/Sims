<?php
    
/**
 * Action Club Class
 *
 * Defines the club action
 *
 * @author   Joshua Crocker
 * @category Action
 * @version  1.0.0
 */
class ActionClub extends Action {
    
    /**
     * @var string $name Name of the action 
     */
    protected $name = 'Club';
    
    /**
     * @var integer The Stat that this action effects
     */
    protected $acts_on = Person::STAT_GENERIC;
    
    /**
     * @var integer The multiplier for this action
     */
    protected $action_points = -20;
}
