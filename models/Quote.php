<?php
    // Quote class for creating and reading quotes
    class Quote{
        // variables
        private $conn;
        private $table = 'quotes';

        public $id;
        public $quote;
        public $category_id;
        public $author_id;
        public $author;
        public $category;

        // create db connection
        public function __construct ($db) {
            $this->conn = $db;
        }

        // read function for all quotes
        public function read(){
                
                // if the author and cat are set, create query 
                if (isset($this->author_id) && isset($this->category_id)) {
                    $query = "SELECT
                          q.id, 
                            q.quote,
                            a.author as author,
                            c.category as category                
                            FROM " . $this->table ." q
                            INNER JOIN authors a on q.author_id = a.id
                            INNER JOIN categories c on q.category_id = c.id 
                            WHERE a.id = :author_id AND c.id = :category_id";
                    }
                // if just author is set create query
                else if (isset($this->author_id)){
                    $query = "SELECT
                            q.id, 
                            q.quote,
                            a.author as author,
                            c.category as category                 
                             FROM " . $this->table ." q
                            INNER JOIN authors a on q.author_id = a.id
                            INNER JOIN categories c on q.category_id = c.id 
                            WHERE a.id = :author_id";
                } 
                // if just category set create query
                else if (isset($this->category_id))  
                    {
                        $query = "SELECT
                            q.id, 
                            q.quote,
                            a.author as author,
                            c.category as category                
                            FROM " . $this->table ." q
                            INNER JOIN authors a on q.author_id = a.id
                            INNER JOIN categories c on q.category_id = c.id 
                            WHERE c.id = :category_id";
                    }
                // otherwise create query for all
                else {
                        $query = "SELECT
                            q.id, 
                            q.quote,
                            a.author as author,
                            c.category as category              
                            FROM " . $this->table ." q
                            INNER JOIN authors a on q.author_id = a.id
                            INNER JOIN categories c on q.category_id = c.id 
                            ORDER BY q.id ASC";
                }
            // create statement
            $stmt = $this->conn->prepare($query);
            // set variables
            if($this->author_id) $stmt->bindParam(':author_id', $this->author_id);
            if($this->category_id) $stmt->bindParam(':category_id', $this->category_id);
            // execute stmt
            $stmt->execute();
        
             //return results
             return $stmt;
        }

        // read_single to read a single quote
        public function read_single() {
            // create a query
            $query = "SELECT
                            q.id, 
                            q.quote,
                            a.author as author,
                            c.category as category               
                    FROM " . $this->table ." q
                    INNER JOIN authors a on q.author_id = a.id
                    INNER JOIN categories c on q.category_id = c.id 
                    WHERE q.id = :id
                    LIMIT 1 OFFSET 0";
           
        // create stmt, bind variables, run query    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        // get data from row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // if data set variables
        if ($row){
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->category = $row['category'];
            return true;
        }
        // no data return false
        else {
            return false;
        }

    }
        // create a new quote
        public function create() {
            // create a query
            $query = "INSERT INTO ".$this->table." (quote, author_id, category_id) VALUES(
                :quote,:author_id,:category_id)";
            
            // create stmt and execute
            $stmt = $this->conn->prepare($query);
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind variables
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            // if successfully create return true, otherwise return false
            if ($stmt->execute())   
                { return true;}     
            else {
                    printf("Error: %s. \n", $stmt->error);
                    return false;
            }     
                
        }

        // update function to update quotes
        public function update() {
            //create query
            $query ="UPDATE ".$this->table." SET 
                id = :id,
                quote = :quote,
                author_id = :author_id,
                category_id = :category_id
                WHERE id = :id";

            //create stmt and execute
            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind variables  
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            // If successful and rows return true, if no rows return false, if error return false
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

        // delete function for deleting quotes
        public function delete() {
            // create query
            $query ="DELETE FROM ".$this->table." WHERE id = :id";
         
            // create stmt
            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            
            //bind variables
            $stmt->bindParam(':id', $this->id);

            //execute and if row return success return true, else return false.  If error return false
            if ($stmt->execute())   
            { 
                if ($stmt->rowCount() == 0){
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

    }