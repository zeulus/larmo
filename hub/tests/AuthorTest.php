<?php
/**
 * Created by PhpStorm.
 * User: zeulus
 * Date: 15.06.15
 * Time: 16:23
 */

use FP\Larmo\Author;

class AuthorTest  extends PHPUnit_Framework_TestCase {

    private $author;
    private $authorFullName = 'Mateusz';
    private $authorNickName = 'maat';
    private $authorEmail = 'dhfj@future-processing.com';

    public function setup()
    {
        $this->author = new Author($this->authorFullName, $this->authorNickName, $this->authorEmail);
    }

    /**
     * @test
     */
    public function getNameReturnsSetName() {
        $this->assertEquals($this->authorFullName, $this->author->getDisplayName());
    }

    /**
     * @test
     */
    public function getEmailReturnsSetEmail() {
        $this->assertEquals($this->authorEmail, $this->author->getEmail());
    }


    public function displayNameProvider() {
        return [
            ["Adrian", "apietka", "apietka@future-processing.com", "Adrian"],
            ["", "mwojcik", "mwojcik@future-processing.com", "mwojcik"],
            ["", "", "mksiazek@future-processing.com", "mksiazek@future-processing.com"],
            ["", "", "", Author::DEFAULT_DISPLAY_NAME]
        ];
    }

    /**
     * @test
     * @dataProvider displayNameProvider
     */
    public function getDisplayNameOrderIsWellDefined($fullName, $nickName, $email, $expected) {
        $author = new Author($fullName, $nickName, $email);
        $this->assertEquals($expected, $author->getDisplayName());
    }

}