<?php
	class Database
		{
			private static $mysql_host = 'localhost'	/*'mysql5.000webhost.com:3306'*/ ;
		    private static $mysql_database = 'train' 	/*'a4126787_train'*/;
		    private static $mysql_user = 'root'			/*'a4126787_root'*/;
		    private static $mysql_password = ''			/*'password123'*/; 
		    private static $connection  = null;
		    
		    
     
		    public function __construct() {
		    }
		     
		     
		    public static function createConnection()
		    {
				self::$connection = mysqli_connect(self::$mysql_host, self::$mysql_user, self::$mysql_password, self::$mysql_database);
				if (mysqli_connect_error(self::$connection)) 
					echo(mysqli_connect_error());
					
				return self::$connection;
			}
		     
		     
		    public static function closeConnection()
		    {
		        self::$connection = null;
		    }
	}
?>