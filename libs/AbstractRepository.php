<?php

namespace Libs;

use Libs\Exceptions\NotFoundException;

abstract class AbstractRepository
{
    /**
     * @var EntityFactoryInterface
     */
    private $entityFactory;

    /**
     * @var string[]
     */
    private $fields;
    /**
     * @var Cache
     */
    private $cache;

    /**
     * Visszaadja a repositoryhoz kapcsolódó entity
     * nevét.
     *
     * @return string
     */
    abstract protected function getEntityClass(): string;

    /**
     * Visszaadja a repository által kezelt tábla nevét
     *
     * @return string
     */
    abstract protected function getTable(): string;

    /**
     * @var DatabaseInterface
     */
    private $database;

    public function __construct(DatabaseInterface $database, EntityFactoryInterface $entityFactory, CacheInterface $client)
    {
        $this->database = $database;
        $this->entityFactory = $entityFactory;
        $this->fields = $this->createNewEntity()->getFieldList();

        if (($key = array_search('id', $this->fields)) !== false) {
            unset($this->fields[$key]);
        }

        ArrayAssert::hasOnlyString($this->fields, true);
        $this->cache = $client;
    }


    /**
     * Tábla mezőinek nevét adja vissza az id nélkül!
     *
     * @return array
     */
    final protected function getFieldList(): array
    {
        return $this->fields;
    }

    /**
     * Minden rekord lekérdezése akár rendezve a táblából.
     * A kimenete entityket tartalmazó tömb
     *
     * @param string $orderBy
     * @param string $order
     * @return AbstractEntity[]
     * @throws \Exception
     */
    public function findAll(string $orderBy = 'id', string $order = 'DESC'): array
    {
        if (!in_array(strtolower($order), ['asc','desc'])) {
            throw new \Exception('FindAll csak ASC vagy DESC lehet!');
        }

        if (!in_array($orderBy, array_merge(['id'], $this->fields))) {
            throw new \Exception(
                sprintf('A %s field nem található a táblában!', $orderBy)
            );
        }

        $sth = $this->database->getPdo()->prepare(
            sprintf('SELECT * FROM %s ORDER BY %s %s',
                $this->getTable(),
                $orderBy,
                $order
            )
        );

        $sth->execute();

        $output = [];
        foreach ($sth->fetchAll(\PDO::FETCH_ASSOC) AS $row) {
            $output[] = $this->createEntityFromDBArray($row);
        }

        return $output;
    }

    /**
     * ID alapján visszaad egy Entityt a db-ből
     *
     * @param int $id
     * @return AbstractEntity
     * @throws NotFoundException
     */
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

    /**
     * Csinál egy új üres entityt, majd beállítja neki értéknek
     * a paraméterből kapott tömbben lévő kulcs => érték párokat
     *
     * @param array $array
     * @return AbstractEntity
     */
    protected function createEntityFromDBArray(array $array): AbstractEntity
    {
        $entity = $this->getEntityClass();
        $entity = new $entity();
        $entity->setFromArray($array);

        return $entity;
    }

    /**
     * Entityfactory -t hívva csinál egy üres olyan entityt
     * ami ehhez a repositoryhoz tartozik
     *
     * @return AbstractEntity
     */
    public function createNewEntity(): AbstractEntity
    {
        return $this->entityFactory->create($this->getEntityClass());
    }

    /**
     * Elmenti a DB-be az átadott entityt.
     * Ha már ott volt updatel, ha még nem akkor insertel.
     *
     * @param AbstractEntity $entity
     * @return AbstractEntity
     */
    public function save(AbstractEntity $entity): AbstractEntity
    {
        if ($entity->getId()) {
            return $this->update($entity);
        }

        return $this->insert($entity);
    }

    /**
     * Beszúr az adatbázisba egy új entityt
     *
     * @param AbstractEntity $entity
     * @return AbstractEntity
     */
    public function insert(AbstractEntity $entity): AbstractEntity
    {
        $sth = $this->database->getPdo()->prepare(
            sprintf('INSERT INTO %s (%s) VALUES (%s)',
                $this->getTable(),
                implode(',', $this->getFieldList()),
                ':'.implode(',:', $this->getFieldList())
            )
        );

        $sth->execute($entity->getArray(':'));
        $entity->setId($this->database->getPdo()->lastInsertId());

        return $entity;
    }


    /**
     * A kapott entityt updateli a DB-ben
     *
     * @param AbstractEntity $entity
     * @return AbstractEntity
     * @throws \Exception
     */
    public function update(AbstractEntity $entity): AbstractEntity
    {
        $fields = [];

        if ($entity->getId()===null) {
            throw new \Exception('Nem sikerült az update!');
        }

        foreach ($this->getFieldList() as $fieldName) {
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

    public function getCache(): Cache
    {
        return $this->cache;
    }
}