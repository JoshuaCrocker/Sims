<?php
use PHPUnit\Framework\TestCase;

class SocialPersonTest extends TestCase {
    public function testSocialPersonNew() {
        $name_male = 'John Doe';
        $gender_male = Person::GENDER_MALE;

        $name_female = 'Jane Doe';
        $gender_female = Person::GENDER_FEMALE;

        $person_male = new Person($name_male, $gender_male);
        $person_female = new Person($name_female, $gender_female);

        // Person should have an ID
        $this->assertNotEmpty($person_male->getID());
        $this->assertNotEmpty($person_female->getID());

        // Person should have a name
        $this->assertEquals($person_male->getName(), $name_male);
        $this->assertEquals($person_female->getName(), $name_female);

        // Person should have a gender
        $this->assertEquals($person_male->getGender(), $gender_male);
        $this->assertEquals($person_female->getGender(), $gender_female);
    }

    public function testSocialPersonUpdate() {
        $name = 'John Doe';
        $gender = Person::GENDER_MALE;

        $new_name = 'Jane Doe';
        $new_gender = Person::GENDER_FEMALE;

        $person = new Person($name, $gender);

        $this->assertEquals($person->getName(), $name);
        $this->assertEquals($person->getGender(), $gender);

        $person->setName($new_name);
        $person->setGender($new_gender);

        $this->assertEquals($person->getName(), $new_name);
        $this->assertEquals($person->getGender(), $new_gender);
    }

    // TODO Person::create test (seed it)

    // TODO Stat Test

    // TODO Relationship Test

    // TODO Save / Load Test

    // TODO test JSON
}
