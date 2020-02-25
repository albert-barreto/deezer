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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

}
