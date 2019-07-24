<?php include "../connection.php"; /** calling of connection.php that has the connection code **/ 
    header("Access-Control-Allow-Origin: *"); 

    // products array
    $suppliers=array();

    $result = $mysqli->query("SELECT idSupplier, supplier, type, status, contactName, email, phone, comment
                    FROM supplier ORDER BY supplier ASC");
    
    while($data = $result->fetch_object()){
     //   extract($data);

        $supplier=array(
            "id" => $data->idSupplier,
            "supplier" => $data->supplier,
            "type" => $data->type,
            "status" => $data->status,
            "contactName" => $data->contactName,
            "email" => $data->email,
            "phone" => $data->phone,
            "comment" => $data->comment,
        );

        array_push($suppliers, $supplier);

    }

    echo json_encode($suppliers);
  