<?php
abstract class Action {
    protected $name = 'Generic';
    protected $acts_on = Person::STAT_GENERIC;
    protected $action_points = 1;

    public function act($performer, $performee) {
        $performer_stat = $performer->getStat($this->acts_on);
        $performee_stat = $performee->getStat($this->acts_on);

        $performer_multiplier = 2 * $performer_stat / Person::STAT_MAX;
        $new_stat = $performee_stat + ($this->action_points * $performer_multiplier);

        if ($new_stat > Person::STAT_MAX) {
            $new_stat = Person::STAT_MAX;
        }

        $performee->setStat($this->acts_on, $new_stat);

        $stat_diff = $new_stat - $performee_stat;
        $relationship = $performee->getRelationship($performer->getID());

        if ($stat_diff < 0) {
            $relationship_multiplier = -1;
        } else {
            $relationship_multiplier = 1;
        }

        $new_relationship = $relationship_multiplier * ($relationship + ($stat_diff / 2));

        $performee->setRelationship($performer->getID(), $new_relationship);

        output($performer->getName() . ' performed ' . $this->name . ' on ' . $performee->getName() . ' making their stat change from ' . $performee_stat . ' to ' . $new_stat);
        output($performee->getName() . '\'s relationship with ' . $performer->getName() . ' changed from ' . $relationship . ' to ' . $new_relationship);
        output();
    }
}
