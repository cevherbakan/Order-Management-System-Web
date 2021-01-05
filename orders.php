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
        <td><div id="order-id"></div></td>
        <td><input type="text" id="product_id"  class="form-control" style="width:200px;" placeholder="Ürün Adı"></td>
        <td><input type="text" id="seller_id" class="form-control" style="width:200px;" placeholder="Fiyat"></td>
        <td><input type="text" id="user_id" class="form-control" style="width:200px;" placeholder="SellerId"></td>
        <td><input type="text" id="quantity" class="form-control" style="width:200px;" placeholder="Birim"></td>

        <td><button type="button" name="add" id="add" class="btn btn-info">Yeni Ekle</button></td>
        <td><button type="button" name="remove" id="remove" class="btn btn-info">Kaldır</button></td>
        </tr>

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
                <th>Ürün Id</th>
                <th>Seller Id</th>
                <th>User Id</th>
                <th>Miktar</th>
                <th>Onay</th>
                <th>İptal</th>
                <th>Tarih</th>
                <th>Silinme</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>
            <th>id</th>
                <th>Ürün Id</th>
                <th>Seller Id</th>
                <th>User Id</th>
                <th>Miktar</th>
                <th>Onay</th>
                <th>İptal</th>
                <th>Tarih</th>
                <th>Silinme</th>


            </tr>
        </tfoot>
    </table>
    </div>

   </div>


 <?php include 'footer.php';?>

 <script src="js/check-login.js"></script>
 

<script>
 $('#order').addClass("nav-item active");

 </script>



<script>

$(document).ready(function() {
   var table = $('#example').DataTable();
    
   $('#example tbody').on('click', 'tr', function () {
       var data = table.row( this ).data();

       $('#order-id').html(data[0]);

       $('#product_id').val(data[1]);
       $('#seller_id').val(data[2]);
       $('#user_id').val(data[3]);
       $('#quantity').val(data[4]);


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
      url: '../methods/getAllOrder.php?key=123',
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
            value["product_id"],
            value["seller_id"],
            value["user_id"],
            value["quantity"],
            value["confirmation"],
            value["cancel"],
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
      url: '../methods/getLastOrder.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "admin_id":id ,"admin_token": token} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));
  
          if(obj.result==true){
            //console.log(obj.data);
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
       var product_id= $('#product_id').val();
       var seller_id = $('#seller_id').val();
       var user_id = $('#user_id').val();
       var quantity = $('#quantity').val();

       var id = sessionStorage.getItem('admin_id');
    var token = sessionStorage.getItem('admin_token');
 
      $.ajax({
      url: '../methods/create-order.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "admin_id":id,"admin_token":token,"product_id":product_id ,"seller_id": seller_id, "user_id":user_id, "quantity":quantity} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));

  
          if(obj.result==true){
            $('#order-id').html("");
         $('#product_id').val("");
         $('#seller_id').val("");
         $('#user_id').val("");
         $('#quantity').val("");
   

         $('#alert').addClass("alert alert-primary");
         $('#alert').show().html("başarıyla eklendi");

   

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








$('#remove').on( 'click', function () {
        var id = $('#order-id').html();

       var admin_id = sessionStorage.getItem('admin_id');
       var admin_token = sessionStorage.getItem('admin_token');
 
      $.ajax({
      url: '../methods/deleteOrder.php?key=123',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "admin_id":admin_id,"admin_token":admin_token,"order_id":id} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));

          console.log(obj.result);
  
          if(obj.result==true){
            $('#order-id').html("");
         $('#product_id').val("");
         $('#seller_id').val("");
         $('#user_id').val("");
         $('#quantity').val("");


         $('#alert').addClass("alert alert-primary");
         $('#alert').show().html("başarıyla kaldırıldı");





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

