<?php

/**
 * Name Generator Class
 *
 * Generates a random user's details
 *
 * @author     Joshua Crocker
 * @category   Social
 * @version    1.0.0
 */
class NameGenerator {
    
    /**
     * @const The URL of the API
     */
    const API_URL = 'https://randomuser.me/api/?nat=gb';
    
    /**
     * @var string The seed for the API
     */
    private $seed;

    /**
     * @var integer The gender of the randomly generated user
     */
    private $gender;
    
    /**
     * @var integer The first name of the randomly generated user
     */
    private $firstName;

    /**
     * @var integer The last name of the randomly generated user
     */
    private $lastName;

    /**
     * Name Generator Constructor
     *
     * Generate a seed, if one hasn't been passed in, and
     * generate the first random user.
     *
     * @param null|string $seed The seed for the API
     */
    public function __construct($seed = null) {
        // Remove all ampersands from the seed
        if ($seed != null) {
            $seed = str_replace('&', '', $seed);
        }
        
        // Set the seed
        // Generate a user
        $this->seed = is_null($seed) ? sha1(date('dmY')) : $seed;
        $this->regenerate();
    }

    /**
      * Get Gender
      *
      * @return integer The person's gender
      */
    public function getGender() {
        return $this->gender;
    }

    /**
      * Get Full Name
      *
      * @return string The person's full name
      */
    public function getFullName() {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
      * Get First Name
      *
      * @return integer The person's first name
      */
    public function getFirstName() {
        return $this->firstName;
    }
    
    /**
      * Get Last Name
      *
      * @return integer The person's last anme
      */
    public function getlastName() {
        return $this->lastName;
    }

    /**
      * Regenerate the person
      *
      * Contact the Random User API and collect a new
      * user, using the current seed.
      *
      * @return integer The person's gender
      */
    public function regenerate() {
        // FIXME - At present, the regenrate function will always pull the same user
        // Need to add an incrementor to the seed.
        $json = file_get_contents(NameGenerator::API_URL . '&seed=' . $this->seed);
        $json = json_decode($json);

        $this->gender = $json->results[0]->gender == 'male' ? Person::GENDER_MALE : Person::GENDER_FEMALE;
        $this->firstName = ucfirst($json->results[0]->name->first);
        $this->lastName = ucfirst($json->results[0]->name->last);
    }

    /**
      * Set Seed
      *
      * @param string The new seed
      * @param string $seed
      */
    public function setSeed($seed) {
        $this->seed = $seed;
    }

    /**
      * Get Seed
      *
      * @return string The seed
      */
    public function getSeed() {
        return $this->seed;
    }
}
