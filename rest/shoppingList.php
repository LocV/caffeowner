<?php include "../connection.php"; /** calling of connection.php that has the connection code **/ 
    header("Access-Control-Allow-Origin: *");

    // products array
    $ShoppingLists=array();
    $ListItems=array();

    $shoppingListId = $_GET['listId'];
    $itemId         = $_GET['itemId'];
    $itemAmount     = $_GET['itemAmount'];

    if ($shoppingListId == '')
    {
    // No ID present: Return list of shopping lists

        $result = $mysqli->query("SELECT id, dateCreated, name, description, status FROM ShoppingList
                                                      ORDER BY dateCreated DESC
                                                      LIMIT 3");
    
        while($data = $result->fetch_object()){
         //   extract($data);

            $ShoppingList=array(
                "id" => $data->id,
                "name" => $data->name,
                "description" => $data->description,
                "status" => $data->status,
            );

            array_push($ShoppingLists, $ShoppingList);

        }

        echo json_encode($ShoppingLists);

    }
    elseif ($itemId >= 1)
    {
    //
        // make sure this item does not already exist
        $itemCheck = $mysqli->query("Select * from  ShoppingList_Item
            where idShoppingList = '$shoppingListId'
            and idItem = '$itemId'");
        if ($itemCheck->num_rows == 0)
        {
            // insert new item
            if($result = $mysqli->query("INSERT INTO ShoppingList_Item(idShoppingList, idItem) 
                VALUES('$shoppingListId','$itemId')") != true)
            {
                die(mysql_error()); /*** execute the insert sql code **/
            } else {
                echo "Item $itemId successfully added to shoppinglist $shoppingListId"; /** success message **/
            }
            
            // Add to ItemHistory
            if($result = $mysqli->query("INSERT INTO ItemHistory(idItem, action, idShoppingList) 
                                         VALUES('$itemId', '$IH_ADDTOLIST', '$shoppingListId')") != true)
            {
                die(mysql_error()); /*** execute the insert sql code **/
            } else {
                echo "Item $itemId successfully added to shopping history $shoppingListId "; /** success message **/
            }
        }else {
         // item already exists in list so we will increment the list quanity.
            $data = $itemCheck->fetch_object();
            
            if($result = $mysqli->query("UPDATE ShoppingList_Item 
                                         SET quantity = quantity + 1
                                         Where id = '$data->id' ") != true)
            {
                die(mysql_error()); /*** execute the insert sql code **/
            } 
            else 
            {
                echo "Item $itemId quantity to shopping list $shoppingListId"; /** success message **/
            }
        }
    } else {
    // We have an shoppingListId present in the URL, return the contents of the shopping list
        $result = $mysqli->query("SELECT ShoppingList_Item.`id`, Item.idItem, ShoppingList_Item.status, urgency, Item.`item`, ShoppingList_Item.`quantity`
            FROM `Item`, `ShoppingList_Item`
            WHERE ShoppingList_Item.`idShoppingList` = '$shoppingListId' 
            AND Item.`idItem` = ShoppingList_Item.`idItem`
            order by ShoppingList_Item.status ASC, Item.`item`");

          while($data = $result->fetch_object())
          {

            $products = $mysqli->query("SELECT price, supplier 
                FROM `Product`, `Supplier` 
                WHERE idItem = '$data->idItem'
                AND `product`.`idSupplier`= `Supplier`.`idSupplier`");
                
                $product = $products->fetch_object();

                $ListItem=array(
                    "item" => $data->item,
                    "idItem" => $data->idItem,
                    "quantity" => $data->quantity,
                    "price" => $product->price,
                    "supplier" => $product->supplier
                );

                array_push($ListItems, $ListItem);
            }

        echo json_encode($ListItems);

    }












  