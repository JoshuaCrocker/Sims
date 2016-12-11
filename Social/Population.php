<?php
class Population {
    private $members = [];
    private $population_tick_agent = null;

    public function addMember(Person $person) {
        // output('Adding ' . $person->getName() . ' to the population.');
        Output::getInstance()->addOutput('Adding ' . $person->getName() . ' to the population.');
        $this->members[] = $person;
    }

    public function assignPopulationTickAgent(PopulationTickAgent $agent) {
        $this->population_tick_agent = $agent;
    }

    public function tick() {
        $this->population_tick_agent->tick($this->members);
    }

    public function save(Database $db) {
        foreach ($this->members as $member) {
            $member->save($db);
        }
    }

    public function load(Database $db) {
        $people = $db->query('SELECT * FROM people;');

        while ($person = $people->fetch()) {
            $this->addMember(Person::load($person['id'], $person['data']));
        }
    }

    public function getMembers() {
        return $this->members;
    }

}
