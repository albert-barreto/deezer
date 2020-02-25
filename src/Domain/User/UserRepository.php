<?php


namespace Deezer\Domain\User;


interface UserRepository
{
    public function findAll(): array;

    public function findById(int $id): User;

    public function findByEmail(string $email): User;

    public function insert(User $user): void;

    public function update(User $user): void;

    public function delete(int $id): void;

}
