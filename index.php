<?

  require_once("init.php");

  // WHERE OUR CODE GOES

  Flight::route('/api', function(){
    header('Content-Type: application/json');
      $data = array(
        "success" => true,
        "message" => "Welcome to our PennApps API!"
      );


      echo json_encode($data);
  });

  Flight::route('/api/inventory', function(){
    header('Content-Type: application/json');
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
          "quantity" => intval($item->get('quantity')),
          "image_url" => $item->get('image_url')
        );

      }
      echo json_encode($data);
  });


  Flight::route('POST /api/checkout/@customer_id', function($customer_id){
    header('Content-Type: application/json');

    if(isset($_POST["items"]) && $customer_id != NULL) {

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
            $num_bought = $item_object->buy($item->quantity, $customer_id);
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
    header('Content-Type: application/json');

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

  Flight::route('/api/merchant_info', function(){
    header('Content-Type: application/json');

      $data = array(
        "success" => true,
        "message" => "Successfully found merchant info.",
        "data" => array()
      );

      $ch = curl_init();

  		curl_setopt($ch, CURLOPT_URL,"http://api.reimaginebanking.com/merchants?lat=28.273426&lng=-41.695313&rad=50&key=b1ce1c6f1d2ff56d0ac730b6136b623b");
  		//curl_setopt($ch, CURLOPT_POST, 1);
  		//curl_setopt($ch, CURLOPT_POSTFIELDS, $capitalOneDataString);
  		// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  		// 		'Content-Type: application/json',
  		// 		'Content-Length: ' . strlen($capitalOneDataString))
  		// );

  		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  		$server_output = curl_exec ($ch);

  		curl_close ($ch);

      $server_output = json_decode($server_output);

      $data["data"] = $server_output->data;


      echo json_encode($data);

  });

  Flight::route('/api/customers(/@customer_id)', function($customer_id){
    header('Content-Type: application/json');

    if($customer_id != NULL) {

      $data = array(
        "success" => true,
        "message" => "Successfully found the specified customer.",
        "data" => array()
      );

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL,"http://api.reimaginebanking.com/customers/" . $customer_id . "/accounts?key=b1ce1c6f1d2ff56d0ac730b6136b623b");
      //curl_setopt($ch, CURLOPT_POST, 1);
      //curl_setopt($ch, CURLOPT_POSTFIELDS, $capitalOneDataString);
      // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      // 		'Content-Type: application/json',
      // 		'Content-Length: ' . strlen($capitalOneDataString))
      // );

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $server_output = curl_exec ($ch);

      curl_close ($ch);

      $data["data"] = json_decode($server_output);

    } else {

        $data = array(
          "success" => true,
          "message" => "Successfully found customers.",
          "data" => array()
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"http://api.reimaginebanking.com/customers?key=b1ce1c6f1d2ff56d0ac730b6136b623b");
        //curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $capitalOneDataString);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        // 		'Content-Type: application/json',
        // 		'Content-Length: ' . strlen($capitalOneDataString))
        // );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        curl_close ($ch);

        $data["data"] = json_decode($server_output);
    }


      echo json_encode($data);

  });







  include_once('frontend.php');






  Flight::start();
