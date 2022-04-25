<?php

namespace Pendella\SpeedTest;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DB {

    private static $em;

    private static $logger;

    public static function getEntityManager() {
        if(!self::$em) {
            self::bootstrap();
        }
        return self::$em;
    }

    public static function startLogging() {
        self::$logger = new DebugStack();
        self::$em->getConnection()
            ->getConfiguration()
            ->setSQLLogger(self::$logger);
    }

    public static function showLog() {
        return json_encode(self::$logger->queries);
    }

    private static function bootstrap() {
        AnnotationRegistry::registerLoader('class_exists');

        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $config = Setup::createAnnotationMetadataConfiguration(
            array(__DIR__."/entity"), $isDevMode, $proxyDir,
            $cache, $useSimpleAnnotationReader
        );

        // database configuration parameters
        $conn = array(
            'dbname' => 'pendella_test_site',
            'user' => 'root',
            'password' => '',
            'host' => 'localhost:3306',
            'driver' => 'pdo_mysql',
        );

        // obtaining the entity manager
        $entityManager = EntityManager::create($conn, $config);

        self::$em = $entityManager;
    }
}
