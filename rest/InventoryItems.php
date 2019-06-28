<?php include "../connection.php"; /** calling of connection.php that has the connection code **/ 
    header("Access-Control-Allow-Origin: *");

    // products array
    $items=array();

    $result = $mysqli->query("SELECT idItem, item, description, par, department, category, frequency
                    FROM Item
                    ORDER BY item");
    
    while($data = $result->fetch_object()){
     //   extract($data);

        $item=array(
            "id" => $data->idItem,
            "item" => $data->item,
            "description" => $data->description,
            "par" => $data->par,
            "department" => $data->department,
            "category" => $data->category,
            "frequency" => $data->frequency,
        );

        array_push($items, $item);

    }

    echo json_encode($items);