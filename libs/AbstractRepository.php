<?php

namespace Libs;

use Libs\Exceptions\NotFoundException;

abstract class AbstractRepository
{

    abstract protected function getEntityClass(): string;

    abstract protected function getTable(): string;

    /**
     * @var DatabaseInterface
     */
    private $database;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    public function findAll(string $orderBy = 'id', string $order = 'DESC'): array
    {
        if (!in_array($order, ['ASC','DESC'])) {
            throw new \Exception('FindAll order must be ASC or DESC!');
        }

        $sth = $this->database->getPdo()->prepare(
            sprintf('SELECT * FROM %s ORDER BY id DESC',$this->getTable())
        );
        $sth->execute();

        $output = [];
        foreach ($sth->fetchAll(\PDO::FETCH_ASSOC) AS $row) {
            $output[] = $this->createEntityFromDBArray($row);
        }

        return $output;
    }

    public function findById(int $id): AbstractEntity
    {
        $sth = $this->database->getPdo()->prepare(
            sprintf('SELECT * FROM %s WHERE id=:id LIMIT 1',$this->getTable())
        );
        $sth->execute([':id' => $id]);
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        if (false === $result) {
            throw new NotFoundException(
                sprintf(
                    'ID %s not found in %s table!',
                    $id,
                    $this->getTable()
                )
            );
        }

        return $this->createEntityFromDBArray($result);
    }

    protected function createEntityFromDBArray(array $array): AbstractEntity
    {
        $entity = $this->getEntityClass();
        $entity = new $entity();
        $entity->setFromArray($array);

        return $entity;
    }
}