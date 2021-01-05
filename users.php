<?php include 'header.php';?>

<link href="css/style.css" rel="stylesheet">

</head>
<?php include 'menu.php';?>


<div style="margin-left:3%; margin-right:2%;">

   <br />
 
   <br />
    <div style="align:center;">

    </div>
    <table class="display" style="margin:2%;"> 
        <tr>
        <td><div id="user-id"></div></td>
        <td><input type="text" id="firstname"  class="form-control" style="width:200px;" placeholder="Ad"></td>
        <td><input type="text" id="lastname" class="form-control" style="width:200px;" placeholder="Soyad"></td>
        <td><input type="text" id="email" class="form-control" style="width:200px;" placeholder="Email"></td>
        <td><input type="text" id="phone" class="form-control" style="width:200px;" placeholder="Telefon"></td>
        <td><input type="text" id="password" class="form-control" style="width:200px;" placeholder="Parola"></td>
        <td><select id="countries" title="Pick a number" class="form-control"><option>Ülke...</option></td>
        <td><select id="cities" title="Pick a number" class="form-control"><option>Şehir...</option></select></td>
        <td><select id="districts" title="Pick a number" class="form-control"><option>İlçe...</option></select></td>

        <td><textarea type="text" id="address" class="form-control" style="width:200px;height:50px;" placeholder="Adres"></textarea></td>
        <td><button type="button" name="add" id="add" class="btn btn-info">Yeni Ekle</button></td>
        <td><button type="button" name="update" id="update" class="btn btn-info">Güncelle</button></td>
        <td><button type="button" name="remove" id="remove" class="btn btn-info">Kaldır</button></td>
        </tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td><p id="country">   </p></td><td><p id="city">   </p></td><td><p id="district">  </p></td></tr>
    </table>
</div>
    <br/>
    <div id="alert" style="display:none;" role="alert">
</div>

<div style="margin:2%;">

    <table id="example" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>id</th>
                <th>Adı</th>
                <th>Soyadı</th>
                <th>Token</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Password</th>
                <th>LocationId</th>
                <th>Address</th>
                <th>Tarih</th>
                <th>Silinme</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>
            <th>id</th>
                <th>Adı</th>
                <th>Soyadı</th>
                <th>Token</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Password</th>
                <th>LocationId</th>
                <th>Address</th>
                <th>Tarih</th>
                <th>Silinme</th>


            </tr>
        </tfoot>
    </table>
    </div>

   </div>


 <?php include 'footer.php';?>

 <script src="js/location.js"></script>
 <script src="js/check-login.js"></script>
 

<script>
 $('#user').addClass("nav-item active");

 </script>



<script>

$(document).ready(function() {
   var table = $('#example').DataTable();
    
   $('#example tbody').on('click', 'tr', function () {
       var data = table.row( this ).data();

       $('#user-id').html(data[0]);

       $('#firstname').val(data[1]);
       $('#lastname').val(data[2]);
       $('#email').val(data[4]);
       $('#phone').val(data[5]);
       $('#password').val(data[6]);
       
       getOneDistrict(data[7]);
       
       $('#address').val(data[8]);

       //table.row(this).remove().draw( false );
       //alert( 'You clicked on '+data);
       console.log(data);
   } );
} );
</script>



<script>

getData();

function getData(){ 
    var id = sessionStorage.getItem('admin_id');
    var token = sessionStorage.getItem('admin_token');
 
      $.ajax({
      url: '../methods/getAllUser.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "admin_id":id ,"admin_token": token} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));
  
          if(obj.result==true){
            addTable(obj.data);

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


function addTable(response) {
$(document).ready(function() {
    var t = $('#example').DataTable();
 
    $.each(response, function(index, value) {
        t.row.add( [
            value["id"],
            value["firstname"],
            value["lastname"],
            value["token"],
            value["email"],
            value["phone"],
            value["password"],
            value["location_id"],
            value["address"],
            value["reg_date"],
            value["remove"]
        ] ).draw( false ); 

    } );
 

} );

}

function getLastData(){
    var id = sessionStorage.getItem('admin_id');
    var token = sessionStorage.getItem('admin_token');
 
      $.ajax({
      url: '../methods/getLastUser.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "admin_id":id ,"admin_token": token} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));
  
          if(obj.result==true){
            addTable(obj.data);

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




 
$('#add').on( 'click', function () {
       var name= $('#firstname').val();
       var lastname = $('#lastname').val();
       var email = $('#email').val();
       var phone = $('#phone').val();
       var password = $('#password').val();
       var location = $('#districts').val();
       var address = $('#address').val();
 
      $.ajax({
      url: '../methods/create-user.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "firstname":name ,"lastname": lastname, "email":email, "phone":phone, "password":password,"location_id":location,"address":address} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));

          console.log(obj.result);
  
          if(obj.result==true){
         $('#firstname').val("");
         $('#lastname').val("");
         $('#email').val("");
         $('#phone').val("");
         $('#password').val("");
         $('#address').val("");
         $('#countries').empty();
         $('#cities').empty();
         $('#districts').empty();
         $('#user-id').html("");
         $('#country').html("");
         $('#city').html("");
         $('#district').html("");

         $('#alert').addClass("alert alert-primary");
         $('#alert').show().html("başarıyla eklendi");

           getCountries();

            getLastData();


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



$('#update').on( 'click', function () {
        var id = $('#user-id').html();
       var name= $('#firstname').val();
       var lastname = $('#lastname').val();
       var email = $('#email').val();
       var phone = $('#phone').val();
       var password = $('#password').val();
       var location = $('#districts').val();
       var address = $('#address').val();
       var admin_id = sessionStorage.getItem('admin_id');
    var admin_token = sessionStorage.getItem('admin_token');

    console.log(location);
 
      $.ajax({
      url: '../methods/updateUser.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "user_id":id,"admin_id":admin_id,"admin_token":admin_token,"firstname":name ,"lastname": lastname, "email":email, "phone":phone, "password":password,"location_id":location,"address":address} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));

          console.log(obj.result);
  
          if(obj.result==true && id !=null){
        $('#user-id').html("");
         $('#firstname').val("");
         $('#lastname').val("");
         $('#email').val("");
         $('#phone').val("");
         $('#password').val("");
         $('#address').val("");
         $('#countries').empty();
         $('#cities').empty();
         $('#districts').empty();
         $('#country').html("");
         $('#city').html("");
         $('#district').html("");

         $('#alert').addClass("alert alert-primary");
         $('#alert').show().html("başarıyla güncellendi");

         getCountries();



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


$('#remove').on( 'click', function () {
        var id = $('#user-id').html();

       var admin_id = sessionStorage.getItem('admin_id');
       var admin_token = sessionStorage.getItem('admin_token');
 
      $.ajax({
      url: '../methods/deleteUser.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "user_id":id,"admin_id":admin_id,"admin_token":admin_token} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));

          console.log(obj.result);
  
          if(obj.result==true && id !=null){
        $('#user-id').html("");
         $('#firstname').val("");
         $('#lastname').val("");
         $('#email').val("");
         $('#phone').val("");
         $('#password').val("");
         $('#countries').empty();
         $('#cities').empty();
         $('#districts').empty();
         $('#address').val("");
         $('#country').html("");
         $('#city').html("");
         $('#district').html("");

         $('#alert').addClass("alert alert-primary");
         $('#alert').show().html("başarıyla kaldırıldı");


         getCountries();



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

