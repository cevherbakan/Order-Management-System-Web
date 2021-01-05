<div id="deneme">Hoş Geldiniz </div>
<p id="id"></p>
<input type="submit" value="Çıkış" id="exit" />








<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
$(document).ready(function(){
    var id = sessionStorage.getItem('admin_id');
    var token = sessionStorage.getItem('admin_token');
    if(id==null && token==null){
        window.location.replace("login.php");
    }
    $('#id').html(id);

});
</script>

<script>
$(document).ready(function(){
    $('#exit').click(function(){
        sessionStorage.clear();
        window.location.replace("login.php");
    });
});
</script>