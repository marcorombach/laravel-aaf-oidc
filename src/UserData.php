<?php

namespace Marcorombach\LaravelAafOIDC;

class UserData
{
    /**
     * @var string username
     */
    private $username;

    /**
     * @var string email
     */
    private $email;

    /**
     * @var string givenname and familyname
     */
    private $fullname;

    /**
     * @var string givenname
     */
    private $givenname;

    /**
     * @var string familyname
     */
    private $familyname;

    /**
     * @param $username string|null optional
     * @param $email string|null optional
     * @param $fullname string|null optional
     * @param $givenname string|null optional
     * @param $familyname string|null optional
     */
    function __construct(string $username = null, string $email = null, string $fullname = null, string $givenname = null, string $familyname = null){
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setFullname($fullname);
        $this->setGivenname($givenname);
        $this->setFamilyname($familyname);
    }

    /**
     * @return bool
     */
    public function checkData(): bool
    {
        if(!isset($this->username) && !isset($this->email)){
            throw new \ErrorException('UserData not set correctly.');
        }
        return true;
    }

    /**
     * @return string
     */
    public function getFamilyname(): string
    {
        if(!isset($this->familyname)){
            return "";
        }
        return $this->familyname;
    }

    /**
     * @param string $familyname
     */
    public function setFamilyname(string $familyname = null): void
    {
        $this->familyname = $familyname;
    }

    /**
     * @return string
     */
    public function getGivenname(): string
    {
        if(!isset($this->givenname)){
            return "";
        }
        return $this->givenname;
    }

    /**
     * @param string $givenname
     */
    public function setGivenname(string $givenname = null): void
    {
        $this->givenname = $givenname;
    }

    /**
     * @return string
     */
    public function getFullname(): string
    {
        if(!isset($this->fullname)){
            if(!isset($this->givenname) && !isset($this->familyname)){
                return "";
            }else{
                return $this->givenname .  " " . $this->familyname;
            }
        }
        return $this->fullname;
    }

    /**
     * @param string $fullname
     */
    public function setFullname(string $fullname = null): void
    {
        $this->fullname = $fullname;
    }

    /**
     * @return string
     * @throws \ErrorException
     */
    public function getEmail(): string
    {
        $this->checkData();
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email = null): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     * @throws \ErrorException
     */
    public function getUsername(): string
    {
        $this->checkData();
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username = null): void
    {
        $this->username = $username;
    }
}
