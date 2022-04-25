<?php

namespace Pendella\SpeedTest\Data;

use Pendella\SpeedTest\DB;

class DBData
{
    const SQL_FILES = [
        'companies.sql', 'products.sql', 'urls.sql'
    ];

    private $em;

    public function load()
    {
        $this->em = DB::getEntityManager();
        foreach (self::SQL_FILES as $file) {
            $this->loadSQLFileData($file);
        }
    }

    /**
     * @param string $filename
     * @throws \Doctrine\DBAL\DBALException
     */
    private function loadSQLFileData($filename)
    {
        $path = dirname(__FILE__).'/sql/'.$filename;
        print "Loading $filename\r\n";
        if (!file_exists($path)) {
            return;
        }

        $sql = file_get_contents($path);
        $this->runQuery($sql);
    }

    private function runQuery($sql)
    {
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
    }
}
