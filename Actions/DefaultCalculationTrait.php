<?php

/**
 * Default Calculation Trait
 */
trait DefaultCalculationTrait {    
    /**
     * Calculate Stat Method
     * 
     * @access private
     * @param mixed $performer_stat The stat of the performer
     * @param mixed $performee_stat The stat of the performee
     * @return float
     */
    private function calculateStat($performer_stat, $performee_stat) {
        $performer_multiplier = 2 * $performer_stat / Person::STAT_MAX;
        $new_stat = $performee_stat + ($this->action_points * $performer_multiplier);
        
        if ($new_stat > Person::STAT_MAX) {
            $new_stat = Person::STAT_MAX;
        }
        
        return $new_stat;
    }
    
    /**
     * Calculate Relationship Method
     * 
     * @access private
     * @param mixed $relationship The performee's relationship
     * @param mixed $stat_diff The stat difference
     * @return float
     */
    private function calculateRelationship($relationship, $stat_diff) {
        if ($stat_diff < 0) {
            $relationship_multiplier = -1;
        } else {
            $relationship_multiplier = 1;
        }
        
        $new_relationship = $relationship_multiplier * ($relationship + ($stat_diff / 2));
        
        return $new_relationship;
    }
}