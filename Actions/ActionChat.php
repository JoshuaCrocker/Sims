<?php
    
/**
  * Action Chat Class
  *
  * Defines the chat action
  *
  * @author   Joshua Crocker
  * @category Action
  * @version  1.0.0
  */
class ActionChat extends Action {
    
    /**
      * @var string $name Name of the action 
      */
    protected $name = 'Chat';
    
    /**
      * @var integer The Stat that this action effects
      */
    protected $acts_on = Person::STAT_GENERIC;
    
    /**
      * @var integer The multiplier for this action
      */
    protected $action_points = 2;
}
