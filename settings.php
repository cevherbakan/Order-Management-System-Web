<?php include 'header.php';?>

<link href="css/style.css" rel="stylesheet">

</head>
<?php include 'menu.php';?>


<div style="margin-left:30%;margin-top:5%; ">

   <br />
 
   <br />
    <div style="align:center;">

    </div>
    <table class="display" style="margin:100%;"> 
        <tr>

        <tr>Ad:<input type="text" id="firstname"  class="form-control" style="width:400px;height:50px;" placeholder="Ad"></tr>


        <tr>Soyad:<input type="text" id="lastname" class="form-control" style="width:400px;height:50px;" placeholder="Soyad"></tr>


        <tr>Email:<input type="text" id="email" class="form-control" style="width:400px;height:50px;" placeholder="Email"></tr>

        <tr>Telefon:<input type="text" id="phone" class="form-control" style="width:400px;height:50px;" placeholder="Telefon"></tr>

        <tr>Parola:<input type="text" id="password" class="form-control" style="width:400px;height:50px;" placeholder="Parola"></tr>
        <br>



        <tr><button type="button" name="update" id="update" class="btn btn-info">Güncelle</button></tr>
        </tr>

    </table>
</div>
    <br/>
    <div id="alert" style="display:none;" role="alert">
</div>



   </div>


 <?php include 'footer.php';?>

 <script src="js/check-login.js"></script>
 

<script>
 $('#setting').addClass("nav-item active");

 </script>



<script>

getData();

function getData(){ 
    var id = sessionStorage.getItem('admin_id');
    var token = sessionStorage.getItem('admin_token');
 
      $.ajax({
      url: '../methods/getAdmin.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "admin_id":id ,"admin_token": token} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));
  
          if(obj.result==true){
            $('#firstname').val(obj.data["firstname"]);
            $('#lastname').val(obj.data["lastname"]);
            $('#email').val(obj.data["email"]);
            $('#phone').val(obj.data["phone"]);
            $('#password').val(obj.data["password"]);

          }
          else{
              sessionStorage.clear();
              window.location.replace("login.php");
          }
      },
      error: function( jqXhr, textStatus, errorThrown ){
          console.log( errorThrown );

      }  

    });
}



$('#update').on( 'click', function () {
       var name= $('#firstname').val();
       var lastname = $('#lastname').val();
       var email = $('#email').val();
       var phone = $('#phone').val();
       var password = $('#password').val();

       var admin_id = sessionStorage.getItem('admin_id');
    var admin_token = sessionStorage.getItem('admin_token');


 
      $.ajax({
      url: '../methods/updateAdmin.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "admin_id":admin_id,"upd_admin_id":admin_id,"admin_token":admin_token,"firstname":name ,"lastname": lastname, "email":email, "phone":phone, "password":password} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));


  
          if(obj.result==true){

         $('#alert').addClass("alert alert-primary");
         $('#alert').show().html("başarıyla güncellendi");



          }
          else{
            $('#alert').addClass("alert alert-danger");
          }
      },
      error: function( jqXhr, textStatus, errorThrown ){
          console.log( errorThrown );

      }  

    });
 

    } );
 

</script>


 <script src="js/main.js"></script>


 </body>

</html>

