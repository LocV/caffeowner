<?php include "../connection.php"; /** calling of connection.php that has the connection code **/ 

    // products array
    $suppliers=array();

    $result = $mysqli->query("SELECT idSupplier, supplier, type, contactName, email, phone, comment
                    FROM supplier ORDER BY supplier ASC");
    
    while($data = $result->fetch_object()){
     //   extract($data);

        $supplier=array(
            "id" => $data->idSupplier,
            "supplier" => $data->supplier,
            "type" => $data->type,
            "contactName" => $data->contactName,
            "email" => $data->email,
            "phone" => $data->phone,
            "comment" => $data->comment,
        );

        array_push($suppliers, $supplier);

    }

    echo json_encode($suppliers);
  