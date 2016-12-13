<?php

/**
  * Action Abstract Class
  *
  * Defines the basic functionality of an action
  *
  * @author   Joshua Crocker
  * @category Action
  * @version  1.0.0
  */
abstract class Action {
    
    /**
      * @var string Name of the Action
      */
    protected $name = 'Generic';
    
    /**
      * @var integer The Stat that this action effects
      */
    protected $acts_on = Person::STAT_GENERIC;
    
    /**
      * @var integer The multiplier for this action
      */
    protected $action_points = 1;

    /**
      * Action Act Method
      *
      * Performs the action on another Person, modifying stats and relationships as necessary.
      *
      * @param Person $performer The Person performing the action
      * @param Person $performee The Person being acted upon
      *
      * @return null
      */
    public function act($performer, $performee) {
        // Get Perfomer and Performee stats
        $performer_stat = $performer->getStat($this->acts_on);
        $performee_stat = $performee->getStat($this->acts_on);
        
        // Calculate values
        $performer_multiplier = 2 * $performer_stat / Person::STAT_MAX;
        $new_stat = $performee_stat + ($this->action_points * $performer_multiplier);

        if ($new_stat > Person::STAT_MAX) {
            $new_stat = Person::STAT_MAX;
        }
        
        // Apply values
        $performee->setStat($this->acts_on, $new_stat);

        $stat_diff = $new_stat - $performee_stat;
        $relationship = $performee->getRelationship($performer->getID());

        if ($stat_diff < 0) {
            $relationship_multiplier = -1;
        } else {
            $relationship_multiplier = 1;
        }
        
        // Relationship stuff
        $new_relationship = $relationship_multiplier * ($relationship + ($stat_diff / 2));

        $performee->setRelationship($performer->getID(), $new_relationship);

        // Output
        Output::getInstance()->addOutput($performer->getName() . ' performed ' . $this->name . ' on ' . $performee->getName() . ' making their stat change from ' . $performee_stat . ' to ' . $new_stat);
        Output::getInstance()->addOutput($performee->getName() . '\'s relationship with ' . $performer->getName() . ' changed from ' . $relationship . ' to ' . $new_relationship);
        
    }
}
