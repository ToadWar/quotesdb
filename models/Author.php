<?php
    // Author class with functions for getting authors
    class Author{
        //create variables
        private $conn;
        private $table = 'authors';

        public $id;
        public $author;
        
        // create database connection
        public function __construct ($db) {
            $this->conn = $db;
        }

        // function read.  Reads all authors.  Returns and array
        public function read(){
            //create read query
            $query = "SELECT
                    id,
                    author
                    FROM ".$this->table."
                    ORDER BY id ASC";
        
        // prepare  and execute query
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt; // return query result
        }

        // read a single author 
        public function read_single() {
                // create quert
                $query = "SELECT
                        id,
                        author
                        FROM ".$this->table."
                        WHERE id = :id
                        LIMIT 1 OFFSET 0";                    
            
            // create connection send query
            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();

            // Retrieve data from query set into variables
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                $this->id = $row['id'];
                $this->author = $row['author'];
                return true;
            }
            // if failed return false
            else {
                return false;
            }

        }
        //create a new author functions returns the id and info of the new author  
        public function create() {
            // create query
            $query = "INSERT INTO ".$this->table." (author) VALUES(:author)";
            
            // create statement and send query
            $stmt = $this->conn->prepare($query);
            $this->author = htmlspecialchars(strip_tags($this->author));
            $stmt->bindParam(':author', $this->author);
            
            //return true if successful and false if not
            if ($stmt->execute())   
            { return true;}     
              else {
              printf("Error: %s. \n", $stmt->error);
              return false;
                }             
        }
        
        //update function for author
        public function update() {
            //create query 
            $query ="UPDATE ".$this->table." SET author = :author WHERE id = :id";
         
            //create stmt and execute query
            $stmt = $this->conn->prepare($query);
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // bind variables
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':id', $this->id);

            // if works return true unless there are no updates in all other cases return false
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

        // delete function to delete an author
        public function delete() {
            // create query
            $query ="DELETE FROM ".$this->table." WHERE id = :id";
         
            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            // bind variables
            $stmt->bindParam(':id', $this->id);
            
            // if deleted return true, else return false
            if ($stmt->execute())   
                { return true;}     
            else {
                    printf("Error: %s. \n", $stmt->error);
                    return false;
             }     
                
        }


    }