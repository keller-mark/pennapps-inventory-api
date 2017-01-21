<?

  require_once("init.php");

  // WHERE OUR CODE GOES

  Flight::route('/api', function(){
      $data = array(
        "success" => true,
        "message" => "Welcome to our PennApps API!"
      );
      echo json_encode($data);
  });

  Flight::route('/api/inventory', function(){
      $data = array(
        "success" => true,
        "message" => "Successfully found inventory.",
        "data" => array()
      );

      foreach(Items::findAll() as $item) {
        $data["data"][] = array(
          "id" => intval($item->get('id')),
          "item_name" => $item->get('item_name'),
          "item_price" => dollar_format($item->get('item_price')),
          "quantity" => intval($item->get('quantity'))
        );

      }
      echo json_encode($data);
  });


  Flight::route('POST /api/checkout', function(){

    if(isset($_POST["items"])) {

      $data = array(
        "success" => true,
        "message" => "Successfully checked out items.",
        "data" => array(
          "receipt" => array(),
          "checkout_total" => 0.0
        )
      );

      $items = json_decode($_POST["items"]);
      $checkout_total = 0.0;

      if(is_array($items)) {
        foreach($items as $item) {
          if(isset($item->id) && isset($item->quantity)) {
            $item_object = Items::find(intval($item->id));
            $num_bought = $item_object->buy($item->quantity);
            $checkout_total += $num_bought*$item_object->get('item_price');
            $item_object->save();

            $data["data"]["receipt"][] = array(
              "num_purchased" => intval($num_bought),
              "unit_price" => dollar_format($item_object->get('item_price')),
              "id" => intval($item_object->get('id')),
              "item_name" => $item_object->get('item_name')
            );


          }

        }
      }
      $data["data"]["checkout_total"] = dollar_format($checkout_total);
      echo json_encode($data);
    }
  });

  Flight::route('POST /api/restock', function(){

    if(isset($_POST["items"])) {

      $data = array(
        "success" => true,
        "message" => "Successfully restocked items.",
        "data" => array()
      );

      $items = json_decode($_POST["items"]);

      if(is_array($items)) {
        foreach($items as $item) {
          if(isset($item->id) && isset($item->quantity)) {
            $item_object = Items::find(intval($item->id));
            $num_bought = $item_object->restock($item->quantity);
            $item_object->save();
          }
        }
      }
      echo json_encode($data);
    }
  });



  Flight::start();
