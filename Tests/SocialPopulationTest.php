<?php
use PHPUnit\Framework\TestCase;

class SocialPopulationTest extends TestCase {
    public function testSocialPopulationAddMember() {
        $population = new Population();
        $person = new Person('John Doe', Person::GENDER_MALE);

        $population->addMember($person);

        $this->assertEquals(count($population->getMembers()), 1);

        $population->addMember($person);
        $population->addMember($person);

        $this->assertEquals(count($population->getMembers()), 3);

        // TODO Test Removing
    }

    // TODO Test Tick Agent

    // TODO Test Database
}
