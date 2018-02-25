<?php

namespace Test\Libs;

use App\Entity\BlogPost;
use App\Repository\BlogRepository;
use Libs\Test\DBTestCase;
use PHPUnit\DbUnit\DataSet\ArrayDataSet;
use PHPUnit\DbUnit\DataSet\IDataSet;

class BlogPostTest extends DBTestCase
{
    protected $fixtures;

    public function testFindAllDefault(): void
    {
        $blogFixtures = $this->getFixtures()['blog'];

        /**
         * @var BlogPost[] $all
         */
        $all = $this->getBlogRepository()->findAll();
        $this->assertCount(count($this->getFixtures()['blog']), $all);

        $this->checkAsserts($blogFixtures[1], $all[0]);
        $this->checkAsserts($blogFixtures[0], $all[1]);
    }

    public function testFindAllModifiedOrder(): void
    {
        $blogFixtures = $this->getFixtures()['blog'];
        $all = $this->getBlogRepository()->findAll('id', 'ASC');
        $this->assertCount(count($this->getFixtures()['blog']), $all);

        $this->checkAsserts($blogFixtures[0], $all[0]);
        $this->checkAsserts($blogFixtures[1], $all[1]);
    }

    /**
     * @dataProvider insertDataProvider
     */
    public function testInsert(string $title, string $content, string $lead): void
    {
        $blogPost = new BlogPost();
        $blogPost->setTitle($title);
        $blogPost->setLead($lead);
        $blogPost->setContent($content);

        $this->assertNull($blogPost->getId());
        $entity = $this->getBlogRepository()->insert($blogPost);

        $this->assertEquals(3, $entity->getId());
        $this->assertEquals(3, $this->getConnection()->getRowCount('blog'));

        $row = $this->getConnection()->createQueryTable('blog', 'SELECT * FROM blog')->getRow(2);
        $this->assertEquals($title, $row['title']);
        $this->assertEquals($content, $row['content']);
        $this->assertEquals($lead, $row['lead']);
    }

    public function insertDataProvider(): array
    {
        return [
            [
                'InsertTest1',
                'InsertContent1',
                'InsertLead1',
            ],
            [
                'InsertTest2',
                'InsertContent2',
                'InsertLead2',
            ],
        ];
    }


    public function getBlogRepository(): BlogRepository
    {
        return $this->getContainer()->get('app.repository.blog');
    }
    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        return new ArrayDataSet(
            $this->getFixtures()
        );
    }

    protected function getFixtures(): array
    {
        if (null === $this->fixtures) {
            $this->fixtures = require __DIR__ . '/fixtures/dataset.php';
        }

        return $this->fixtures;
    }

    private function checkAsserts(array $fixturesRowContent, BlogPost $value): void
    {
        $this->assertEquals($fixturesRowContent['id'], $value->getId());
        $this->assertEquals($fixturesRowContent['title'], $value->getTitle());
        $this->assertEquals($fixturesRowContent['content'], $value->getContent());
        $this->assertEquals($fixturesRowContent['lead'], $value->getLead());
    }
}