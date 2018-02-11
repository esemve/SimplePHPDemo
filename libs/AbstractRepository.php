<?php

namespace Libs;

use Libs\Exceptions\NotFoundException;

abstract class AbstractRepository
{

    /**
     * @var EntityFactoryInterface
     */
    private $entityFactory;

    abstract protected function getEntityClass(): string;

    abstract protected function getTable(): string;

    /**
     * @var DatabaseInterface
     */
    private $database;

    public function __construct(DatabaseInterface $database, EntityFactoryInterface $entityFactory)
    {
        $this->database = $database;
        $this->entityFactory = $entityFactory;
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

    public function createNewEntity(): AbstractEntity
    {
        return $this->entityFactory->create($this->getEntityClass());
    }

    public function save(AbstractEntity $entity): AbstractEntity
    {
        if ($entity->getId()) {
            return $this->update($entity);
        }

        return $this->insert($entity);
    }

    public function insert(AbstractEntity $entity): AbstractEntity
    {
        $sth = $this->database->getPdo()->prepare(
            sprintf('INSERT INTO %s (%s) VALUES (%s)',
                $this->getTable(),
                implode(',', $entity->getFieldList()),
                ':'.implode(',:', $entity->getFieldList())
            )
        );

        $sth->execute($entity->getArray(':'));
        $entity->setId($this->database->getPdo()->lastInsertId());

        return $entity;
    }

    public function update(AbstractEntity $entity): AbstractEntity
    {
        $fields = [];

        foreach ($entity->getFieldList() as $fieldName) {
            $fields[] = $fieldName.' = :'.$fieldName;
        }

        $sth = $this->database->getPdo()->prepare(
            sprintf('UPDATE %s SET %s WHERE id=:id',
                $this->getTable(),
                implode(',', $fields)
            )
        );

        $sth->execute(
            array_merge([':id' => $entity->getId()],$entity->getArray(':'))
        );

        return $entity;
    }
}