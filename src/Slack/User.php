<?php

namespace Phpmg\Slack;

use Respect\Validation\Validator;

class User
{
    protected $name;

    protected $email;

    protected $validator;

    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
        $this->validator = new Validator;
    }

    /**
     * @return Validator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function isValid()
    {
        $validator = $this->getValidator();

        return $validator->stringType()->notEmpty()->validate($this->getName()) and
            $validator->email()->validate($this->getEmail());
    }


}