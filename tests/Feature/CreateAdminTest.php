<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateAdminTest extends TestCase
{
    /**
     * controls that should the password and password_confirmation match or not
     * @var bool
     */
    private $matchPassword = false;

    /**
     * controls that should the email must be valid email or not
     * @var bool
     */
    private $incorrectEmail = false;

    /**
     * register admin with invalid email and unmatched password and password_confirmation
     */
    public function testRegisteringAdminWithIncorrectEmailAndPassword(){
        $this->matchPassword = false;
        $this->incorrectEmail = true;
        $command = $this->artisan('register:admin');
        $command = $this->enterUserName($command);
        $command->expectsOutput('The email must be a valid email address.')
                ->expectsOutput('The password confirmation does not match.')
                ->doesntExpectOutput('Admin registered successfully.')
                ->doesntExpectOutput('Please go to your company email and confirm.')
                ->assertExitCode(0);
    }

    /**
     * register admin with invalid email
     */
    public function testRegisteringAdminWithIncorrectEmail(){
        $this->matchPassword = true;
        $this->incorrectEmail = true;
        $command = $this->artisan('register:admin');
        $command = $this->enterUserName($command);
        $command->expectsOutput('The email must be a valid email address.')
            ->doesntExpectOutput('Admin registered successfully.')
            ->doesntExpectOutput('Please go to your company email and confirm.')
            ->assertExitCode(0);
    }

    /**
     * register admin with unmatched password and password_confirmation
     */
    public function testRegisteringAdminWithIncorrectPassword(){
        $this->matchPassword = false;
        $this->incorrectEmail = false;
        $command = $this->artisan('register:admin');
        $command = $this->enterUserName($command);
        $command->expectsOutput('The password confirmation does not match.')
            ->doesntExpectOutput('Admin registered successfully.')
            ->doesntExpectOutput('Please go to your company email and confirm.')
            ->assertExitCode(0);
    }

    /**
     * register admin with valid email and matched password and password_confirmation
     */
    public function testRegisteringAdminWithCorrectEmailAndPassword(){
        $this->matchPassword = true;
        $this->incorrectEmail = false;
        $command = $this->artisan('register:admin');
        $command = $this->enterUserName($command);
        $command->doesntExpectOutput('The email must be a valid email address.')
            ->doesntExpectOutput('The password confirmation does not match.')
            ->expectsOutput('Admin registered successfully.')
            ->expectsOutput('Please go to your company email and confirm.')
            ->assertExitCode(0);
    }

    /**
     * try to register second admin
     */
    public function testRegisteringAdminAgain(){
        $this->matchPassword = true;
        $this->incorrectEmail = false;
        $command = $this->artisan('register:admin');
        $command->doesntExpectOutput('The email must be a valid email address.')
            ->doesntExpectOutput('The password confirmation does not match.')
            ->doesntExpectOutput('Admin registered successfully.')
            ->doesntExpectOutput('Please go to your company email and confirm.')
            ->expectsOutput('Admin already exit! You can\'t register more than one Admin in your company.')
            ->assertExitCode(0);
    }

    /**
     * try to execute the command with inappropriate input and check the next question
     * finally execute the command with appropriate input and return the command
     *
     * @param $command
     * @param $question
     * @param $answer
     * @param string $falseAnswer
     * @param bool $password
     * @return mixed
     */
    private function executeCommand($command, $question, $answer, $falseAnswer='', $password=false){
        if(!$password)
            $command->expectsQuestion($question, '')
                ->expectsQuestion('please '. strtolower($question), $falseAnswer)
                ->expectsQuestion('please '. strtolower($question), $falseAnswer)
                ->expectsQuestion('please '. strtolower($question), $falseAnswer)
                ->expectsQuestion('please '. strtolower($question), $answer);

        else
            $command->expectsQuestion($question, '')
                ->expectsQuestion('password must be at least 8 characters:', $falseAnswer)
                ->expectsQuestion('password must be at least 8 characters:', $falseAnswer)
                ->expectsQuestion('password must be at least 8 characters:', $falseAnswer)
                ->expectsQuestion('password must be at least 8 characters:', $answer);

        return $command;
    }

    /**
     * try to fill the user name when the artisan command asks
     *
     * @param $command
     * @return mixed
     */
    private function enterUserName($command){
        $command = $this->executeCommand($command, 'Enter user name:', 'nani');
        return $this->enterFirstName($command);
    }

    /**
     * try to fill the first name when the artisan command asks
     *
     * @param $command
     * @return mixed
     */
    private function enterFirstName($command){
        $command = $this->executeCommand($command, 'Enter first name:', 'henok');
        return $this->enterLastName($command);
    }

    /**
     * try to fill the last name when the artisan command asks
     *
     * @param $command
     * @return mixed
     */
    private function enterLastName($command){
        $command = $this->executeCommand($command, 'Enter last name:', 'fekade');
        return $this->enterEmail($command);
    }

    /**
     * try to fill the email when the artisan command asks
     *
     * @param $command
     * @return mixed
     */
    private function enterEmail($command){
        $email = $this->incorrectEmail ? 'email_test' : 'henok@gmail.com';
        $command = $this->executeCommand($command, 'Enter company email:', $email);
        return $this->enterPassword($command);
    }

    /**
     * try to fill the password when the artisan command asks
     *
     * @param $command
     * @return mixed
     */
    private function enterPassword($command){
        $password = !$this->matchPassword ? 'landfalls5487' : '12345678';
        $command = $this->executeCommand($command,
            'Enter password:', $password,
            'dada', true);
        return $this->enterReenterPassword($command);
    }

    /**
     * try to fill the reenter when the artisan command asks
     *
     * @param $command
     * @return mixed
     */
    private function enterReenterPassword($command){
        $password = !$this->matchPassword ? 'j495falloff' : '12345678';
        $command = $this->executeCommand($command,
            'Reenter password:', $password,
            'dana', true);
        return $command;
    }
}
