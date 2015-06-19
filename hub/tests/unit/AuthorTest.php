<?php

use FP\Larmo\Domain\ValueObject\Author;

class AuthorTest extends PHPUnit_Framework_TestCase
{

    private $author;
    private $authorFullName = 'Somebody\'s Name';
    private $authorNickName = 'testname';
    private $authorEmail = 'testname@future-processing.com';

    public function setup()
    {
        $this->author = new Author($this->authorFullName, $this->authorNickName, $this->authorEmail);
    }

    /**
     * @test
     */
    public function checkIfFullNameIsSet()
    {
        $this->assertEquals($this->authorFullName, $this->author->getDisplayName());
    }

    /**
     * @test
     */
    public function checkIfEmailIsSet()
    {
        $this->assertEquals($this->authorEmail, $this->author->getEmail());
    }


    public function displayNameProvider()
    {
        return [
            ["Adrian", "adddi", "", "Adrian"],
            ["", "mwojcik", "mwojcik@future-processing.com", "mwojcik"],
            ["Mateusz", "", "mksiazek@future-processing.com", "Mateusz"],
            ["Adrian", "", "", "Adrian"],
            ["", "mateo", "", "mateo"],
            ["", "", "mksiazek@future-processing.com", "mksiazek@future-processing.com"],
            ["Adrian", "apietka", "apietka@future-processing.com", "Adrian"],
            ["", "", "", Author::DEFAULT_DISPLAY_NAME],
        ];
    }

    /**
     * @test
     * @dataProvider displayNameProvider
     */
    public function displayNamePriorityOrder($fullName, $nickName, $email, $expected)
    {
        $author = new Author($fullName, $nickName, $email);
        $this->assertEquals($expected, $author->getDisplayName());
    }

}