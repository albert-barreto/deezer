<?php


namespace Deezer\Domain\User;


class User
{
    private $id;
    private $name;
    private $password;
    private $type;

    /**
     * User constructor.
     * @param $id
     * @param $name
     * @param $password
     * @param $type
     */
    public function __construct($id = null, $name = null, $password = null, $type = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

}
