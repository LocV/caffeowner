<?php include "../connection.php"; /** calling of connection.php that has the connection code **/ 

    // products array
    $ShoppingLists=array();
    $ListItems=array();

    $shoppingListId=$_GET['listId'];

    if ($shoppingListId == '')
    {

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

    }else{

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












  