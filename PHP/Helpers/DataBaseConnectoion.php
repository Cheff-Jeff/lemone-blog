<?php
declare(strict_types=1);

namespace PHP\Helpers;

use PDO;
use PDOException;

class DataBaseConnectoion
{
    public PDO|null $database = null;

    public function connect(): void
    {
        try {
            $conn = new PDO(
                'mysql:host=127.0.0.1;port=3306;dbname=lemoneBlogDB;charset=utf8',
                'root',
                'root_password'
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->database = $conn;
        }catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function disconnect(): void
    {
        $this->database = null;
    }
}