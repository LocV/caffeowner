<?php
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name = "product";
 
    // object properties
    public $id;
    public $dateCreated;
    public $brand;
    public $price;
    public $quantity;
    public $quanityUnit;
    public $idSupplier;
    public $idItem;
    public $idLogin;
    public $note;
     
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

///////////////////    
// read products
///////////////////
function read(){
 
    // select all query
    $query = "SELECT
                id, dateCreated, brand, price, quantity, quantityUnit, idSupplier, idItem, idLogin, note
            FROM
                " . $this->table_name . 
            " ORDER BY
                brand";
#	echo"<p>" . $query . "</p>";
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
///////////////////
// readOne
///////////////////
// used when filling up the update product form
function readOne(){
 
    // query to read single record
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->name = $row['name'];
    $this->price = $row['price'];
    $this->description = $row['description'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];
    
    $this->dateCreated = $row['dateCreated'];
    $this->brand=htmlspecialchars(strip_tags($this->brand));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->quantity=htmlspecialchars(strip_tags($this->quantity));
    $this->quantityUnit=htmlspecialchars(strip_tags($this->quantityUnit));
    $this->idSupplier=htmlspecialchars(strip_tags($this->idSupplier));
    $this->idItem=htmlspecialchars(strip_tags($this->idItem));
    $this->idLogin=htmlspecialchars(strip_tags($this->idLogin));
    $this->note=htmlspecialchars(strip_tags($this->note));
}


///////////////////
// create product
///////////////////
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                dateCreated=:dateCreated, 
                name=:name, 
                price=:price, 
                quantity=:quantity,
                quantityUnit=:quantityUnit,
                idSupplier=:idSupplier,
                idItem=:idItem,
                idLogin=:idLogin,
                note=:note";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->dateCreated=htmlspecialchars(strip_tags($this->dateCreated));
    $this->brand=htmlspecialchars(strip_tags($this->brand));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->quantity=htmlspecialchars(strip_tags($this->quantity));
    $this->quantityUnit=htmlspecialchars(strip_tags($this->quantityUnit));
    $this->idSupplier=htmlspecialchars(strip_tags($this->idSupplier));
    $this->idItem=htmlspecialchars(strip_tags($this->idItem));
    $this->idLogin=htmlspecialchars(strip_tags($this->idLogin));
    $this->note=htmlspecialchars(strip_tags($this->note));
    
 
    // bind values
    $stmt->bindParam(":dateCreated", $this->dateCreated);
    $stmt->bindParam(":brand", $this->brand);
    $stmt->bindParam(":price", $this->price);
    $stmt->bindParam(":quantity", $this->quantity);
    $stmt->bindParam(":quantityUnit", $this->quantityUnit);
    $stmt->bindParam(":idSupplier", $this->idSupplier);
    $stmt->bindParam(":Item", $this->Item);
    $stmt->bindParam(":idLogin", $this->idLogin);
    $stmt->bindParam(":note", $this->note);
    
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

}