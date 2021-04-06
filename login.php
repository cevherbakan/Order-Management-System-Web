<?php include 'header.php' ?>

<link href="css/login.css" rel="stylesheet">
</head>

<body>
<div class="wrapper fadeInDown">
  <div id="formContent">

    <div class="fadeIn first">
    <h1>Login</h1>
    <br>

    </div>

      <input type="text" id="email" class="form-control fadeIn second" name="email" placeholder="email">

      <input type="text" id="password" class="fadeIn third" name="password" placeholder="password">

      <input type="submit" id="btnPost" class="fadeIn fourth" value="Giriş">

  </div>
</div>



<?php include 'footer.php' ?>

<script>
$(document).ready(function(){
    $("#btnPost").click(function(){
      $.ajax({
      url: '..',
      dataType: 'json',
      type: 'post',
      contentType: 'application/json',
      data: JSON.stringify( { "email": $('#email').val(),"password": $('#password').val()} ),
      processData: false,
      success: function( data, textStatus, jQxhr ){
  
          var obj= jQuery.parseJSON(JSON.stringify(data));
          
          if(obj.result==true){
  
              sessionStorage.setItem('admin_token',obj.token);
              sessionStorage.setItem('admin_id', obj.data['id']);
              window.location.replace("users.php");
          }
          else{
              $('#deneme').html("bir hata oluştu");
          }
      },
      error: function( jqXhr, textStatus, errorThrown ){
          console.log( errorThrown );
      }
  
     });
    });
  });

  $(document).ready(function(){
    var id = sessionStorage.getItem('admin_id');
    var token = sessionStorage.getItem('admin_token');
    if(id!=null && token!=null){
        window.location.replace("users.php");
    }

});
</script>
