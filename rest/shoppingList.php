<?php include "../connection.php"; /** calling of connection.php that has the connection code **/ 

    // products array
    $ShoppingLists=array();

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
  