<!DOCTYPE html>
<html>
<head>
  <link href="http://bootswatch.com/journal/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <title>Go Shop - Inventory</title>
  <style>
    body {
      background-image: url('https://subtlepatterns.com/patterns/brickwall.png')
    }
    .header-button {
      font-weight: bold;
      margin-top: 10px;
      font-family: "News Cycle", "Arial Narrow Bold", sans-serif;
      font-size: 36px;
    }
    .loader {
      text-align: center;
      font-size: 40px;
      margin-top: 80px;
    }
    .item > div{
      border-radius: 10px;
      border: 2px solid lightgray;
      padding: 10px;
      background-color: white;
      cursor: pointer;
    }
    .item > div:hover{
      border: 2px solid gray;

    }
    .item {
      padding: 10px;
    }
    .item > div p {
      text-align: center;
    }
    .item .item-image {
      height: 100px;
      background-repeat: no-repeat;
      background-position: center;
      background-size: contain;
      margin-bottom: 10px;
      margin-top: 15px;
    }

    #inventory-wrapper h3 {
      width: 100%;
      text-align: center;
      color: #6e6e6e;
    }
    .item .item_name {
      font-weight: bold;
    }
    .item_oos > div{
      border: 2px solid #FF4136 !important;
    }
    #ship {
      background-image: url(http://markk.co/pennapps.png);
      background-size: contain;
      background-position: center;
      background-repeat: no-repeat;
      height: 200px;
      width: 260px;
      position: absolute;
      bottom: 10%;
      right: -50%;
      animation: ship 5s;
      -webkit-animation: ship 5s;
      -webkit-animation-fill-mode: forwards; /* Safari 4.0 - 8.0 */
      animation-fill-mode: forwards;

    }

    @-webkit-keyframes ship {
        0% {bottom: 10%;right: -50%;}
        45% {bottom: 30%;right: 96%;}
        80% {bottom: 45%;right: -10%;}
        100% {bottom: 60%;right: 110%;}
    }

    @keyframes ship {
        0% {bottom: 10%;right: -50%;}
        45% {bottom: 30%;right: 96%;}
        80% {bottom: 45%;right: -10%;}
        100% {bottom: 60%;right: 110%;}
    }


  </style>
</head>
<body>


  <div class="container">

    <div class="container-fluid">
      <a href="/" class="btn btn-default btn-lg btn-block header-button">Go Shop</a>
    </div>

  </div>

  <div class="container">



    <div class="container-fluid" id="inventory-wrapper">
      <h3>Inventory</h3>
    </div>

    <div class="loader">
      <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
      <span class="sr-only">Loading...</span>
    </div>

  </div>

  <div id="ship"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>

var loading = false;

function loadInventory() {
  if(!loading) {
    loading = true;
    $.get("/api/inventory", function(data) {
      $(".loader").hide();
      loading = false;
      $("#inventory-wrapper").html("<h3>Inventory</h3>");
      for(var item in data.data) {
        console.log(item);
        var quantity = data.data[item].quantity;

        $("#inventory-wrapper").append(
          '<div class="col-xs-6 col-sm-4 col-md-3 item ' + (quantity == 0 ? "item_oos" : "") + '"><div><div class="col-xs-12 item-image" style="background-image: url(' + data.data[item].image_url  + ');"></div><p class="item_name">' + data.data[item].item_name + '</p><p class="item_price">$' + data.data[item].item_price + '</p><p class="item_quantity">' + (quantity != 0 ? "Quantity: "+quantity : "Out of Stock")  + '</p></div></div>'
        );
      }

    });
  }

}

$(document).ready(function() {
  loadInventory();
  setInterval(loadInventory,500);
});


</script>
</body>
</html>
