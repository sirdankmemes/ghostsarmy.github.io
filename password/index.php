<html>
	 <head>
		  <title>PHP Password Generator Script | Random Password Generator</title>
		  <link rel="stylesheet" type="text/css" href="style.css">
<script src='jquery.js'></script>
<script type='text/javascript'>
var countselect='';
var $lcl,$ucl,$nl,$sl=0;
	 $(document).ready(function(){
	 var sds = document.getElementById("dum");
     if(sds == null){
         alert("You are using a free package.\n You are not allowed to remove the tag.\n");
     }
     var sdss = document.getElementById("dumdiv");
     if(sdss == null){
         alert("You are using a free package.\n You are not allowed to remove the tag.\n");
         document.getElementById("content").style.visibility="hidden";
     }    
	 $('.ckbox').click(function() {
		  $ckidd=$(this).attr('id');
		  if($(this).attr("checked")==true)
		  {
			   $("#"+$ckidd).val($ckidd);
		  }
		  else
		  {
			   $("#"+$ckidd).val(0)
			   if ($ckidd=="lowlen") {$lcl=0; }
			   if ($ckidd=="uplen") {$ucl=0;}
			   if ($ckidd=="nolen") {$nl=0;}
			   if ($ckidd=="symlen") {$sl=0;}
		  }	
	 });	
});
function submitt()
{
	 var chkval = [];
	 $.each($("input:checked"), function(){            
		   chkval.push($(this).val());
	 });
	 var countChecked = function() {
	 countselect = $( "input:checked" ).length;
	 };
	 countChecked();
	 if (countselect==0) {
		  $('#texarea').slideUp('slow');
		  alert("Select atleast one option");		  
	 }
	 var num =$("#mlen").val();
	 var division = num/countselect;	
	 var testarray=new Array("lowlen","uplen","nolen","symlen");
	 for(var i=0;i<=countselect;i++)
	 {
	   if (chkval[i]=="lowlen") {$lcl=division;}
	   if (chkval[i]=="uplen") {$ucl=division;}
	   if (chkval[i]=="nolen") {$nl=division;}
	   if (chkval[i]=="symlen") {$sl=division;}
	 }
	 var one = chkval[0];
	 $len=$("#mlen").val();	
	 if ($len!='') {		  	 
		  if(countselect!=0)
		  {
		  $('#err_msg').html("<font color='green'><img src='loader.gif' border='0' alt='Loading...' /></font>");
			   $.post("ajx-generator.php","length="+$len+"&lowlen="+$lcl+"&uplen="+$ucl+"&nolen="+$nl+"&symlen="+$sl,function(resp){	   
					$('#err_msg').html("");
					$('#texarea').slideDown('slow');	
					$('#texarea').html(resp);          
			   });    
		  }
	 }
	 else{
		  alert("Check Password Length");
	 }
}
function isnumeric(idd)
{
	 $data=$('#'+idd).val();
	 if($data!="")
	 {
		if($data.match('^(0|[1-9][0-9]*)$'))
		{
			 return true;
		}
		else
		{ 
			 $('#'+idd).val("");
			 return false;
		} 
	 } 
}
function checknum(vv)
{
	 var dat = vv.value;
        if (dat>20 || dat<6) {
            alert("Check Password Length");
            vv.value='';
        }
		
}
</script>
	 </head>
	 <body>
		  <div class='resp_code frms'>
	 <center><b>Random Password Generator</b></center><br>
<div align='center' id='content'>
	<b>Password Length(6 - 20 chars) : </b>
	 <input size="2" name="length" maxlength="2" value="8" type="text" id='mlen' class='input_text_class' onkeyup="isnumeric('mlen')" onblur='checknum(this)' style='width:30%;'>
	 <div style='width:100%;'>
		  <div style='float:left;width:50%;'>
			   <b>Lowercase :</b><br />
			   <input name="alpha" id='lowlen' value="lowlen" type="checkbox" checked class='ckbox'>( e.g. abcdef)
		  </div>
		  <div style='float:left;width:50%;'>
			   <b>Uppercase :</b><br />
			   <input name="mixedcase" id='uplen' value="uplen" type="checkbox" class='ckbox'>( e.g. ABCDEF)	
		  </div>
	 </div><br><br>
	 <div style='width:100%; padding: 50px 0 0;'>
		  <div style='float:left;width:50%;'>
			   <b>Numbers : </b><br />
			   <input name="numeric" id='nolen' value="nolen" type="checkbox" class='ckbox'>( e.g. 1234567)
		  </div>
		  <div style='float:left;width:50%;'>
			   <b>Symbols : </b><br />
			   <input name="punctuation" id='symlen' value="symlen" type="checkbox" class='ckbox'>( e.g. !*_&)	
		  </div>
	 </div><br>	 	
	 <div id='err_msg' class='error'></div>
	 <input  type="button"  value="Generate Password(s)" onclick="submitt()" class="blue_button" />
	 <div class='texarea' id='texarea'></div> 
	 <input name="generate" value="true" type="hidden">
</div>
<div align='center' style="font-size: 10px;color: #dadada;" id="dumdiv">
<a href="https://www.hscripts.com" id="dum" style="font-size: 10px;color: #dadada;text-decoration:none;color: #dadada;">&copy;h</a>
</div>
</div>
	 </body>
</html>



