<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<style>
#imgContainer {
    width:300px;
    height:300px;
    overflow:hidden; /* part of image outside this div should be hidden */
    border-width:2px;
    border-style:solid;
    border-color:#000000
}
</style>
<body>
<div id="imgContainer">
    <img src="contractor/image/images.jpg" style="position:relative;top:0px;left:0px;" id="imgMy" />
</div>
<form method="POST" action="crop.php">
    <input type="hidden" value="100px" name="locationX" id="locationX" />
    <input type="hidden" value="100px" name="locationY" id="locationY" />
    <input type="submit" value="Save" />
</form>
</body>
<script type="text/javascript">
    jQuery(document).ready(function ($) {               
        $( "#imgMy" ).draggable({
            drag: function( event, ui ) {
                $("#locationX").val($("#imgMy").css('left'));
                $("#locationY").val($("#imgMy").css('top'));
            }
        });
    });           
</script>