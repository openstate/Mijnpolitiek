<script>       
<!-- Collapses and expands DIVs -->     

function showhide(id){
if (document.getElementById){
	obj = document.getElementById(id);
	if (obj.style.display == "none"){ obj.style.display = ""; }
	else { obj.style.display = "none"; }
	}
}  							

</script>       
<script>       
function proceed() {
	var myConfirm = confirm("Zeker weten?");
	return myConfirm
}

</script>


<script type="text/javascript" src="/include/lightbox2/js/prototype.js"></script>
<script type="text/javascript" src="/include/lightbox2/js/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="/include/lightbox2/js/lightbox.js"></script>
<link rel="stylesheet" href="/include/lightbox2/css/lightbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/include/gallery.css" type="text/css" />