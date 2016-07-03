<?php

class Inventory
{
    /**
     * @var string Type of used database
     */
    private $db_type = "mysql";

    /**
     * @var object Database connection
     */
    private $db_connection = null;

    /**
     * @var string FOR MYSQL DB CONNECTIONS ONLY OR ANYTHING ELSE
     */
    private $db_host = 'localhost';
    private $db_name = 'php_test_1';
    private $db_user = 'root';
    private $db_pass = '';

    /**
     * @var string System messages, likes errors, notices, etc.
     */
    public $feedback = array();


    /**
     * STARTING UP!!
     * Does necessary checks for PHP version and PHP password compatibility library and runs the application
     */
    public function __construct() // CONSTRUCTOR!!
    {
    	// $view = new View();
        if ($this->performMinimumRequirementsCheck()) {
        	$this->doStartSession();
        	$this->createDatabaseConnection(); // db check
            $this->runApplication();
        }
    }

    /**
     * Performs a check for minimum requirements to run this application.
     * Does not run the further application when PHP version is lower than 5.3.7
     * Does include the PHP password compatibility library when PHP version lower than 5.5.0
     * (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
     * @return bool Success status of minimum requirements check, default is false
     */
    private function performMinimumRequirementsCheck()
    {
        if (version_compare(PHP_VERSION, '5.3.7', '<')) {
            echo "Sorry, Simple PHP Login does not run on a PHP version older than 5.3.7 !";
        } elseif (version_compare(PHP_VERSION, '5.5.0', '<')) {
            require_once("libraries/password_compatibility_library.php");
            return true;
        } elseif (version_compare(PHP_VERSION, '5.5.0', '>=')) {
            return true;
        }
        // default return
        return false;
    }

    /**
     * Creates a PDO database connection
     * @return bool Database creation success status, false by default
     */
    private function createDatabaseConnection()
    {
        try {
		    // generate a database connection, using the PDO connector
		    // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
		    $this->db_connection = new PDO($this->db_type .':host=' . $this->db_host .';dbname=' . $this->db_name .';charset=' . 'utf8', $this->db_user, $this->db_pass);
            // $this->db_connection = new PDO($this->db_type . ':' . $this->db_sqlite_path); // for sqlite
            // $this->feedback[] = "DB CONNECTED";
            return true;
        } catch (PDOException $e) {
            $this->feedback[] = "PDO database connection problem: " . $e->getMessage();
        } catch (Exception $e) {
            $this->feedback[] = "General problem: " . $e->getMessage();
        }
        return false;
    }

    /**
     * This is basically the controller that handles the entire flow of the application.
     */
    public function runApplication()
    {
    	$this->loadFeedback();
        // check is user wants to see register page (etc.)
        if (isset($_GET["action"])) {
        	switch ($_GET["action"]) {
        		case 'delete':
        			$this->deleteItem($_GET['id']);
        			header('location: index.php'); // php redirect using http header
        			break;
    			default:
    				View::render('view/default.php'); // render from View Class, lol
    				break;
        	}
        } else if (isset($_GET["filter"])) {
            $data = $this->loadItemsFiltered();
			View::render('view/list.php', $data);
        } else {
        	$data = $this->loadItems();
            View::render('view/list.php', $data);
        }
    }

    /**
     * Simply starts the session.
     * It's cleaner to put this into a method than writing it directly into runApplication()
     */
    private function doStartSession()
    {
        if(session_status() == PHP_SESSION_NONE) session_start();
    }

    public function loadFeedback()
    {
    	// foreach ($this->feedback as $fb) {
    	// 	echo '<p>'.$fb.'</p>';
    	// }
    	View::loadFeedback($this->feedback);
    }

    private function loadItems()
    {
        // remember: the user can log in with username or email address
        $sql = "SELECT * FROM inventory ORDER BY datetime ASC";
        $query = $this->db_connection->prepare($sql);
        $query->execute();
        // Btw that's the weird way to get num_rows in PDO with SQLite:
        // count($query->fetchAll(PDO::FETCH_NUM))
        $result = $query->fetchAll();
        if (!empty($result)) {
        	$this->feedback[] = "Got Results"; return $result;
        } else {
            $this->feedback[] = "Result empty.";
        }
        // default return
        return false;
    }

    /**
     * @return array|bool
     */
    private function loadItemsFiltered()
    {
        // remember: the user can log in with username or email address
        $sql = "SELECT * FROM inventory ".
                "WHERE name LIKE :name AND datetime LIKE :date
                ORDER BY datetime ASC";
                // "WHERE name LIKE :name";
        $query = $this->db_connection->prepare($sql);
        $query->bindValue(':name', '%'.$_GET['name'].'%');
        $query->bindValue(':date', '%'.$_GET['date'].'%');
        $query->execute();

        // $query->debugDumpParams(); // debug sql

        // Btw that's the weird way to get num_rows in PDO:
        // count($query->fetchAll(PDO::FETCH_NUM))
        $result = $query->fetchAll();
        if (!empty($result)) {
        	// var_dump($result);
        	$this->feedback[] = "Got Search Results.";
        	$this->feedback[] = "<a href='index.php'>Go Back</a>";
            return $result;
        } else {
            $this->feedback[] = "Result empty.";
            $this->feedback[] = "<a href='index.php'>Go Back</a>";
        }
        // default return
        return false;
    }

    /**
     * @return array|bool
     */
    private function loadItemsFilteredWDate()
    {
        // remember: the user can log in with username or email address
        $sql = "SELECT * FROM inventory
                WHERE name LIKE :name AND (datetime BETWEEN :from_date AND :to_date)
                ORDER BY datetime ASC";
        $query = $this->db_connection->prepare($sql);
        $query->bindValue(':name', $_GET['name']);
        $query->bindValue(':from_date', $_GET['from_date']);
        $query->bindValue(':to_date', $_GET['to_date']);
        $query->execute();

        // Btw that's the weird way to get num_rows in PDO with SQLite:
        // count($query->fetchAll(PDO::FETCH_NUM))
        $result = $query->fetchAll();
        if (!empty($result)) {
        	// haha
        	echo 'saas';
        	var_dump($result);
            return true;
        } else {
            $this->feedback[] = "Result empty";
        }
        // default return
        return false;
    }

    private function deleteItem($id)
    {
    	$sql = "DELETE FROM inventory
                WHERE id = :id";
        $query = $this->db_connection->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();

        $count = $query->rowCount();
        if ($count) {
        	$this->feedback[] = "Item #".$id." deleted."; return true;
        } else {
        	$this->feedback[] = "Unable to delete item #".$id; return false;
        }
    }

}
