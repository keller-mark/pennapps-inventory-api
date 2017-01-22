<!DOCTYPE html>
<html>
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
<body>

  Swipe key card or input ID<br>
  <input type="text" id ="employeeID" name="Employee no." placeholder="xxx-xxx-xxx">
  <button onclick = parseName()>Submit</button>
  <br>

<script type="text/javascript">
  function parseName(){
  	regex = /^[A-Za-z]/
    var name = (document.getElementById('employeeID').value);
    if(name != "%E?;627451392716026?+E?" && name != 114609755){
    	alert("wrong Employee");
    	window.location.replace("http://sample-env.xivebmwhig.us-west-2.elasticbeanstalk.com/sign-in");
    }
    else{
    alert("welcome MARK KELLER");
window.location.replace("http://sample-env.xivebmwhig.us-west-2.elasticbeanstalk.com");}
  }
</script>

</body>
</html>