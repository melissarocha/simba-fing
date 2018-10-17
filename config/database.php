<?php
class Database{
    private static $dbName = 'id7433672_becas_fing';
    private static $dbHost = 'localhost' ;
    private static $dbUsername = 'id7433672_admin';
    private static $dbUserPassword = 'admin1234';

    private static $cont = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function connect(){
        // One connection through whole application
        if ( null == self::$cont ) {
            try {
                self::$cont = new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
        return self::$cont;
    }

    public static function disconnect(){
        self::$cont = null;
    }
}
?>