<?php session_start();?>
<?php ///phpinfo(); ?>
<html>
<head>
<title>Open Learning Exchange - Ghana</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../stylesheet/img/devil-icon.png">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../js/jquery.js"></script>

<style type="text/css">
#upReadable {
	border:double;
	border-style:double;
	height: 600px;
	width: 530px;
}
#vbookQuest {
	margin-top:5px;
	border:double;
	border-style:double;
	min-height: 250px;
	width: 530px;
}
#audQuest {
	background-color: #693;
	height: 400px;
	width: 530px;
	display:none;
}
</style>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script><script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../includes/ice/ice.js" type="text/javascript"></script>

<?php
global $couchUrl;
$couchUrl = 'http://pi@raspberry@192.168.0.111:5984';
////$couchUrl = 'http://pi:raspberry@127.0.0.1:5984';
include "lib/couch.php";
include "lib/couchClient.php";
include "lib/couchDocument.php";
$resources = new couchClient($couchUrl, "radio_resources");

if(isset($_POST['title']))
{
	global $couchUrl;
	$doc = new stdClass();
	$docType = end(explode(".", $_FILES['uploadedfile']['name']));
	$doc->category=$_POST['resType'];
	$doc->kind='radioAudio';
	$doc->description=$_POST['discription'];
	$doc->title=$_POST['title'];
	$doc->approved_by=$_POST['approvedBy'];
	$doc->author=$_POST['author'];
	$doc->created=$_POST['systemDateForm'];
	$doc->play_length="";
	$responce = $resources->storeDoc($doc);
	print_r($responce);
	try {
		// add attached to document with specified id from response
		$fileName = $responce->id.'.'.end(explode(".", $_FILES['uploadedfile']['name']));
		echo "<br>New Filename ".$fileName."<br>";
		echo "Name is ".$_FILES['uploadedfile']['tmp_name']."<br>";
$resources->storeAttachment($resources->getDoc($responce->id),$_FILES['uploadedfile']['tmp_name'], mime_content_type($_FILES['uploadedfile']['tmp_name']),$fileName);			
		///$resources->storeAttachment($resources->getDoc($responce->id),$_FILES['uploadedfile']['tmp_name'], mime_content_type($_FILES['uploadedfile']['tmp_name']));

	} catch ( Exception $e ) {
		print ("No Resource to uploaded<br> ".$e);
	}
	$resDoc = $resources->getDoc($responce->id);
	$resDoc->legacy->id = $responce->id;
	$resources->storeDoc($resDoc);	
///   recordAction($_SESSION['name'],"Uploaded resources... res title : ".$_POST['RTitle']);
	echo '<script type="text/javascript">alert("Successfully Uploaded '.$_POST['title'].'");</script>';
  die("<br><br><br><br>Successfully saved - ".$_POST['title']."");
  
}
?>
<script type="text/javascript">
/*$(document).ready(function(){
	$('#upResID').click(function () {
    	$("#upReadable").slideDown("slow");
		$("#vbookQuest").slideUp("slow");
		$("#audQuest").slideUp("slow");
	});
	$('#AddVBookID').click(function () {
    	$("#upReadable").slideUp("slow");
		$("#vbookQuest").slideDown("slow");
		$("#audQuest").slideUp("slow");
	});
	$('#AddAudID').click(function () {
    	$("#upReadable").slideUp("slow");
		$("#vbookQuest").slideUp("slow");
		$("#audQuest").slideDown("slow");
	});
	requestLoadLanguage();
});
*/
</script>
</head>
<body  style="background-color:#FFF">
<div id="wrapper" style="background-color:#FFF; width:500px;">
  <div id="rightContent" style="float:none; margin-left:auto; margin-right:auto; width:550px; margin-left:auto; margin-right:auto;"><span style="font-size: 14px; color: #00C;"><strong>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;</strong><strong><!--<a href="#"  id="AddAudID">Add Audio Question</a></strong>--></span><br>
    <br>
  <div id="upReadable">
    <form action="" method="post" enctype="multipart/form-data" name="form1">
      <table width="99%" align="center">
        <tr>
          <td colspan="2" align="center" style="font-size: 46px; color: #903;"><strong><br>
            Upload Resource<br>
            <br>
          </strong></td>
          </tr>
        <tr>
          <td width="163"><b>Resource Type</b></td>
          <td><select name="resType" id="resType">
             <option value="conversation">Conversation</option>
                        <option value="conversationQuestions">Conversation with Questions</option>
                      <option value="phonicsSongs">Phonic Songs</option>
                      <option value="stroryTelling">Story Telling</option>
                      <option value="stroryTellingQuestions">Story Telling with Questions</option>
          </select></td>
        </tr>
        <tr>
          <td><b>Resource Title</b></td>
          <td>
            <label for="RTitle"></label>
            <span id="sprytextfield2">
              <label for="title"></label>
              <input type="text" name="title" id="title">
              </td>
        </tr>
        <tr>
          <td><b>Author</b></td>
          <td><label for="author"></label>
            <label for="author2"></label>
            <input type="text" name="author" id="author">
            </td>
        </tr>
        <tr>
          <td><b>Remark / Discription</b></td>
          <td ice:editable="*">
            <label for="discription"></label>
            <textarea name="discription" id="discription" cols="45" rows="4" style="height:100px;"></textarea>
          
          <input type="hidden" name="auploadedby" id="auploadedby" value="<?php echo "OLE Admin";?>"></td>
        </tr>
        <tr>
          <td><b>Approved By</b></td>
          <td><label for="approvedBy"></label>
            <select name="approvedBy" id="approvedBy">
              <option value="OLE Team">OLE Team</option>
              <option value="Government">Government</option>
              <option value="School">School</option>
            </select></td>
        </tr>
        <tr>
          <td><b>Browse for file</b></td>
          <td><input name="uploadedfile" type="file" /></td>
        </tr>
        <tr>
          <td></td>
          <td><input type="submit" class="button" value="Submit">
            <input type="reset" class="button" value="Reset">
            <input type="hidden" name="systemDateForm" id="systemDateForm"></td>
        </tr>
      </table>
    </form>
    </div> 
 <div id="audQuest"></div>
 
<div class="clear"></div>
  </div>
</div>
<script type="text/javascript">
var now = new Date()
	///now = now.toGMTString();
	var fmat= now.getFullYear()+'-'+ (now.getMonth()+1)+'-'+(now.getDay()+10)+' '+(now.getHours())+':'+(now.getMinutes())+':'+(now.getSeconds());
	document.getElementById('systemDateForm').value = fmat;
</script>
<script type="text/javascript">
$(document).ready(function(){
$("#addButton").click(function () {
	 var counter = 1;
	for(cnt=1;cnt<20;cnt++)
	{
		 $("#TextBoxDiv" + cnt).remove();
	}
	while(counter<=(document.getElementById("VBNoOfQuestions").value))
	{
		//var newTextBoxDiv = $(document.createElement('div')).attr("id", 'TextBoxDiv' + counter);
//		newTextBoxDiv.after().html('<label>Textbox #'+ counter + ' : </label>' +'<input type="text" name="textbox' + counter + 
//		 '" id="textbox' + counter + '" value="" >');
//		newTextBoxDiv.appendTo("#TextBoxesGroup");
		
		var newTextBoxDiv = $(document.createElement('div')).attr("id", 'TextBoxDiv' + counter);
		newTextBoxDiv.after().html('<table width="495" border="0">'+
		'<tr>'+
		'<td width="99">Question No '+counter+'</td>' +
            '<td colspan="3"><textarea name="quen'+counter+'" style="height:50px; width:350px;" cols="2" rows="2"></textarea></td>'+
            '</tr>'+
          '<tr>'+
            '<td>&nbsp;</td>'+
            '<td width="151">a.<input name="q'+counter+'_pos1" type="textbox" id="pos'+counter+'_" style="width:100px" >'+
            '<input type="radio" name="questAns'+counter+'" value="1" checked="CHECKED" id="questAns'+counter+'_0"></td>'+
            '<td width="45">&nbsp;</td>'+
            '<td width="182">c.<input name="q'+counter+'_pos3" type="textbox" id="pos'+counter+'_" style="width:100px" >'+
            '<input type="radio" name="questAns'+counter+'" value="3" id="questAns'+counter+'_2"></td>'+
          '</tr>'+
          '<tr>'+
            '<td>&nbsp;</td>'+
            '<td>b.<input name="q'+counter+'_pos2" type="textbox" id="pos'+counter+'_" style="width:100px" >'+
            '<input type="radio" name="questAns'+counter+'" value="2" id="questAns'+counter+'_1">'+
            '</td>'+
            '<td>&nbsp;</td>'+
            '<td>d.<input name="q'+counter+'_pos4" type="textbox" id="pos'+counter+'_" style="width:100px" >'+
            '<input type="radio" name="questAns'+counter+'" value="4" id="questAns'+counter+'_3"></td>'+
          '</tr>'+
      '</table>');
		newTextBoxDiv.appendTo("#TextBoxesGroup");
		counter++;
	}
});
$("#removeButton").click(function () {
    for(cnt=1;cnt<=(document.getElementById("VBNoOfQuestions").value);cnt++)
	{
		 $("#TextBoxDiv" + cnt).remove();
	}
});

  });
function requestLoadLanguage(){
	var groupId = document.getElementById("level").value;
	var lang = document.getElementById("Language").value;
	var lev;
	$.getJSON("../functions/getVBookByLangLevel.php?grade="+groupId+"",function (data){
		$.each(data.gobackArr, function(i,gback){
			$("#res1").load("../functions/getVBookByLangLevel.php?lang="+lang+"&level="+gback.level+"");
		})
	});
}
function getQuestions(){
	var resID = document.getElementById("vBook").value;
	if(resID!="none"){
		$("#descriptionDisp").load("../functions/getDiscription.php?id="+resID+"");
	}else{
		$("#descriptionDisp").load("blank.php");
	}
}
</script>
</body>
</html>
