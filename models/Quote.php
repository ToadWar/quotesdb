<?php
    class Quote{
        private $conn;
        private $table = 'quotes';

        public $id;
        public $quote;
        public $category_id;
        public $author_id;
        public $author;
        public $category;


        public function __construct ($db) {
            $this->conn = $db;
        }

        public function read(){
                
                if ($this->author_id && $this->category_id) {
                    $query = "SELECT
                          q.id, 
                            q.quote,
                            a.id as author_id,
                            c.id as category_id                 
                            FROM " . $this->table ." q
                            INNER JOIN authors a on q.author_id = a.id
                            INNER JOIN categories c on q.category_id = c.id 
                            WHERE a.id = :author_id AND c.id = :category_id";
                    }
                else if ($this->author_id){
                    $query = "SELECT
                            q.id, 
                            q.quote,
                            a.id as author_id,
                            c.id as category_id                  
                             FROM " . $this->table ." q
                            INNER JOIN authors a on q.author_id = a.id
                            INNER JOIN categories c on q.category_id = c.id 
                            WHERE a.id = :author_id";
                    } 
                else if ($this->category_id)  
                    {
                        $query = "SELECT
                            q.id, 
                            q.quote,
                            a.id as author_id,
                            c.id as category_id                
                            FROM " . $this->table ." q
                            INNER JOIN authors a on q.author_id = a.id
                            INNER JOIN categories c on q.category_id = c.id 
                            WHERE c.id = :category_id";
                    }
                else {
                        $query = "SELECT
                            q.id, 
                            q.quote,
                            a.id as author_id,
                            c.id as category_id               
                            FROM " . $this->table ." q
                            INNER JOIN authors a on q.author_id = a.id
                            INNER JOIN categories c on q.category_id = c.id 
                            ORDER BY q.id ASC";
                }
    
            $stmt = $this->conn->prepare($query);
            
            if($this->author_id) $stmt->bindParam(':author_id', $this->author_id);
            if($this->category_id) $stmt->bindParam(':category_id', $this->category_id);

            $stmt->execute();

        return $stmt;
        }

        public function read_single() {
          
            $query = "SELECT
                            q.id, 
                            q.quote,
                            a.id as author_id,
                            c.id as category_id                
                    FROM " . $this->table ." q
                    INNER JOIN authors a on q.author_id = a.id
                    INNER JOIN categories c on q.category_id = c.id 
                    WHERE q.id = :id
                    LIMIT 1 OFFSET 0";
           

        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row){
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->category = $row['category'];
        }

        }

        public function create() {
            $query = "INSERT INTO ".$this->table." (quote, author_id, category_id) VALUES(
                :quote,:author_id,:category_id)";
         
                $stmt = $this->conn->prepare($query);
                $this->quote = htmlspecialchars(strip_tags($this->quote));
                $this->author_id = htmlspecialchars(strip_tags($this->author_id));
                $this->category_id = htmlspecialchars(strip_tags($this->category_id));

                $stmt->bindParam(':quote', $this->quote);
                $stmt->bindParam(':author_id', $this->author_id);
                $stmt->bindParam(':category_id', $this->category_id);

                if ($stmt->execute())   
                { return true;}     
                else {
                    printf("Error: %s. \n", $stmt->error);
                    return false;
                }     
                
        }

        public function update() {
            $query ="UPDATE ".$this->table." SET 
                id = :id,
                quote = :quote,
                author_id = :author_id,
                category_id = :category_id
                WHERE id = :id";
         
                $stmt = $this->conn->prepare($query);
                $this->id = htmlspecialchars(strip_tags($this->id));
                $this->quote = htmlspecialchars(strip_tags($this->quote));
                $this->author_id = htmlspecialchars(strip_tags($this->author_id));
                $this->category_id = htmlspecialchars(strip_tags($this->category_id));

                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':quote', $this->quote);
                $stmt->bindParam(':author_id', $this->author_id);
                $stmt->bindParam(':category_id', $this->category_id);

                if ($stmt->execute())   
                { return true;}     
                else {
                    printf("Error: %s. \n", $stmt->error);
                    return false;
                }          
                
        }

        public function delete() {
            $query ="DELETE FROM ".$this->table." WHERE id = :id";
         
                $stmt = $this->conn->prepare($query);
                $this->id = htmlspecialchars(strip_tags($this->id));

                $stmt->bindParam(':id', $this->id);

                if ($stmt->execute())   
                { return true;}     
                else {
                    printf("Error: %s. \n", $stmt->error);
                    return false;
                }     
                
        }


    }