<?php
    // Category class with methods for retrieving and setting categories
    class Category{
        // variables
        private $conn;
        private $table = 'categories';

        public $id;
        public $category;

        // create connection
        public function __construct ($db) {
            $this->conn = $db;
        }

        // read function for reading all categories
        public function read(){
            // create query
            $query = "SELECT
                    id,
                    category
                    FROM ".$this->table."
                    ORDER BY id ASC";
        
        // create and execute statement
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        
        // return data
        return $stmt;
        }

        // read a single category
        public function read_single() {
                // create a query
            $query = "SELECT
                      id,
                      category
                      FROM ".$this->table."
                      WHERE id = :id
                      LIMIT 1 OFFSET 0";
            
            // create and exectute statement
            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();

            // retieve stmt data
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // set data to variables return true, unless failed return false
            if($row)
            {
                $this->id = $row['id'];
                $this->category = $row['category'];
                return true;
            }
            else {
                return false;
            }
    

        }    

        // create function for creating categories
        public function create() {
            // create a category
            $query = "INSERT INTO ".$this->table." (category) VALUES(:category)";
         
            // create and execute stmt
            $stmt = $this->conn->prepare($query);
            $this->category = htmlspecialchars(strip_tags($this->category));
            $stmt->bindParam(':category', $this->category);

            // if created return true else return false
            if ($stmt->execute())   
                { return true;}     
            else {
                    printf("Error: %s. \n", $stmt->error);
                    return false;
            }     
                
        }
        
        // update function for updating category
        public function update() {
            // create query
            $query ="UPDATE ".$this->table." SET category = :category WHERE id = :id";
         
            // create and execute stmt
            $stmt = $this->conn->prepare($query);
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind variables
            $stmt->bindParam(':category', $this->category);
            $stmt->bindParam(':id', $this->id);
            
            // if successful return true, if there are no categories return false, if error return false
            if ($stmt->execute())   
               { 
                  if ($stmt->rowCount() == 0)
                   { 
                      return false;
                   }
                 else {
                       return true;
                 }   
            }  
            else {
                    printf("Error: %s. \n", $stmt->error);
                    return false;
             }  
                
        }

        // delete function for deleting categories
        public function delete() {
            // create query
            $query ="DELETE FROM ".$this->table." WHERE id = :id";
         
            // create and execute stmt
            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(':id', $this->id);

            // if successful return true else return false
            if ($stmt->execute())   
                { return true;}     
            else {
                    printf("Error: %s. \n", $stmt->error);
                    return false;
            }                     
        }

    }