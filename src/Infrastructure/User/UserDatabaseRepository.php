<?php

namespace Deezer\Infrastructure\User;

use PDO;
use Deezer\Domain\User\User;
use Deezer\Domain\User\UserRepository;

class UserDatabaseRepository implements UserRepository
{

    protected $logger;
    private $table = 'user';

    /** @var PDO $pdoConnection */
    private $pdoConnection;

    public function __construct(PDO $pdoConnection, $logger)
    {
        $this->logger        = $logger;
        $this->pdoConnection = $pdoConnection;
    }

    public function findAll()
    {
        $statement = $this->pdoConnection->query('SELECT * FROM ' . $this->table);
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($resultSet as $resultRow) {
            $users[] = $this->mapRow($resultRow);
        }

        return $users;
    }

    public function findById(int $id): User
    {
        $statement = $this->pdoConnection->prepare('SELECT * FROM ' . $this->table . ' WHERE id_user=?');
        $statement->execute([$id]);
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $this->mapRow($resultSet[0]);
    }

    public function findByEmail(string $email): User
    {
        $statement = $this->pdoConnection->prepare('SELECT * FROM ' . $this->table . ' WHERE email=?');
        $statement->execute([$email]);
        return $this->mapRow($statement->fetchAll(PDO::FETCH_ASSOC)[0]);
    }

    public function insert(User $user): void
    {
        $input_parameters = [
            'name' => $user->getName(),
            'password' => md5($user->getPassword()),
            'type' => $user->getType()
        ];

        $sql = 'INSERT INTO ' . $this->table . '(name, password, type) VALUES (:name, :password, :type)';
        $this->pdoConnection->prepare($sql)->execute($input_parameters);
        //$this->logger->info('Executed user insert:' . json_encode($user));
    }

    public function update(User $user): void
    {
        $input_parameters = [
            'id'        => $user->getId(),
            'name'      => $user->getName(),
            'password'  => md5($user->getPassword()),
            'type'      => $user->getType()
        ];

        $sql = 'UPDATE '. $this->table . ' SET name = :name, password = :password, type = :type WHERE id_user = :id';
        $this->pdoConnection->prepare($sql)->execute($input_parameters);
        //$this->logger->info('Executed user update:' . json_encode($user));
    }

    public function delete(int $id): void
    {
        $this->pdoConnection->prepare('DELETE FROM ' . $this->table . ' WHERE id = ?')->execute([$id]);
        //$this->logger->info('Deleted user id:'. $id);
    }

    private function mapRow($resultRow): User
    {
        return new User(
            $resultRow['id_user'],
            $resultRow['name'],
            $resultRow['password'],
            $resultRow['type']
        );
    }
}
