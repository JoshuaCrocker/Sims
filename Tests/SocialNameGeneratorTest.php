<?php
use PHPUnit\Framework\TestCase;

class SocialNameGeneratorTest extends TestCase {
    public function testAutoSeed() {
        $generator = new NameGenerator();
        $seed = sha1(date('dmY'));

        $this->assertEquals($seed, $generator->getSeed());
    }

    public function testSeedInConstructor() {
        $seed = 'namegeneratorseed';
        $generator = new NameGenerator($seed);

        $this->assertEquals($seed, $generator->getSeed());
    }

    public function testSetGetSeed() {
        $generator = new NameGenerator();
        $seed = sha1(date('dmY'));
        $new_seed = 'seeded_generator';

        $this->assertEquals($seed, $generator->getSeed());
        $generator->setSeed($new_seed);
        $this->assertEquals($new_seed, $generator->getSeed());
    }

    public function testSeededResponse() {
        $seed = 'testseed';
        $generator = new NameGenerator($seed);

        $response = file_get_contents('https://randomuser.me/api/?nat=gb&seed=' . $seed);
        $response = json_decode($response);

        $name = ucfirst($response->results[0]->name->first) . ' ' . ucfirst($response->results[0]->name->last);
        $gender = $response->results[0]->gender == 'male' ? Person::GENDER_MALE : Person::GENDER_FEMALE;

        $this->assertEquals($seed, $response->info->seed);

        $this->assertEquals(ucfirst($response->results[0]->name->first), $generator->getFirstName());
        $this->assertEquals(ucfirst($response->results[0]->name->last), $generator->getLastName());
        $this->assertEquals($name, $generator->getFullName());
        $this->assertEquals($gender, $generator->getGender());

    }

    public function testAmpersandRemoval() {
        $generator = new NameGenerator('seed&ampersand');

        $this->assertEquals('seedampersand', $generator->getSeed());
    }
}
