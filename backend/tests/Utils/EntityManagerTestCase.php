<?php


namespace App\Tests\Utils;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;
use PHPUnit\Framework\TestCase;
use Slim\App;


class EntityManagerTestCase extends TestCase {
    /**
     * @var App
     */
    protected static $app;

    /**
     * @var EntityManager
     */
    protected static $em;

    /**
     * @var SchemaTool
     */
    protected static $tool;

    /**
     * @var ClassMetadata[]
     */
    protected static $schema;

    /**
     * {@inheritDoc}
     */
    public static function setUpBeforeClass() {
        self::$app = $GLOBALS['cnt']->get(App::class);
        self::$em = self::$app->getContainer()->get(EntityManager::class);
        self::$schema = self::$em->getMetadataFactory()->getAllMetadata();
        self::$tool = new SchemaTool(self::$em);
    }

    /**
     * {@inheritDoc}
     * @throws ToolsException
     */
    protected function setUp() {
        self::$tool->dropSchema(self::$schema);
        self::$tool->createSchema(self::$schema);
    }
}