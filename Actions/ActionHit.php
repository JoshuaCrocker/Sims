<?php
    
/**
  * Action Hit Class
  *
  * Defines the hit action
  *
  * @author   Joshua Crocker
  * @category Action
  * @version  1.0.0
  */
class ActionHit extends Action {
    
    /**
      * @var string $name Name of the action 
      */
    protected $name = 'Hit';
    
    /**
      * @var integer The Stat that this action effects
      */
    protected $acts_on = Person::STAT_GENERIC;
    
    /**
      * @var integer The multiplier for this action
      */
    protected $action_points = -2;
}
