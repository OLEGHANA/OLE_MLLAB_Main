<!DOCTYPE html>
<html lang="en">
<?php
global $couchUrl;
$couchUrl = 'http://192.168.0.111:5984';
////$couchUrl = 'http://pi:raspberry@127.0.0.1:5984';
include "lib/couch.php";
include "lib/couchClient.php";
include "lib/couchDocument.php";
$resources = new couchClient($couchUrl, "radio_resources");

function _mime_content_type($filename) {
    $result = new finfo();

    if (is_resource($result) === true) {
        return $result->file($filename, FILEINFO_MIME_TYPE);
    }

    return false;
}

if(isset($_POST['title']))
{
$couchUrl = 'http://192.168.0.111:5984';
////$couchUrl = 'http://pi:raspberry@127.0.0.1:5984';
include "lib/couch.php";
include "lib/couchClient.php";
include "lib/couchDocument.php";
$resources = new couchClient($couchUrl, "radio_resources");

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
		$resources->storeAttachment($resources->getDoc($responce->id),$_FILES['uploadedfile']['tmp_name'], mime_content_type($_FILES['uploadedfile']['tmp_name']),$fileName);
			
		///$resources->storeAttachment($resources->getDoc($responce->id),$_FILES['uploadedfile']['tmp_name'], mime_content_type($_FILES['uploadedfile']['tmp_name']));
		
	} catch ( Exception $e ) {
		print ("No Resource to uploaded<br>");
	}
	$resDoc = $resources->getDoc($responce->id);
	$resDoc->legacy->id = $responce->id;
	$resources->storeDoc($resDoc);
	
///   recordAction($_SESSION['name'],"Uploaded resources... res title : ".$_POST['RTitle']);
	echo '<script type="text/javascript">alert("Successfully Uploaded '.$_POST['title'].'");</script>';
  die("<br><br><br><br>Successfully saved - ".$_POST['title']."");
  

}
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OLE OLE_MLLaB</title>

    <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
	<link href="css/bootstrap-select.min.css" rel="stylesheet">
    
    
	<link href="css/bootstrap-duallistbox.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/freelancer.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    


</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#page-top">Open Learning Exchange - MLLaB</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                   <!-- <li class="page-scroll">
                        <a href="#audioList">Audio List</a>
                    </li>-->
                    
                     <li class="page-scroll">
                        <a href="#about">About</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#console">FM Console</a>
                    </li>
                  <!--  <li class="page-scroll">
                        <a href="#uploadResources">Upload Resource</a>
                    </li>-->
                    <li class="page-scroll">
                        <a href="uploadRes.php" target="_blank">Upload Resource</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive" src="img/profile.png" alt="">
                    <div class="intro-text">
                        <span class="name">OLE Mobile Learning Laboratory</span>
                        <hr class="star-light">
                        <span class="skills">Play - Listern - Practice</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Portfolio Grid Section -->
    <section id="about">
       <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>About</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p>Leveraging the audio transmission capabilities of the Raspberry Pi and other low cost technologies, audio resources are broadcast for pupils working in groups around a hub and with the help of fm receivers and headsets they develop their literacy and other vital 21st century skills with the aid of carefully prepared activity worksheets. OLE-MLLaB has been trail tested in schools in Fanteakwa and Sekeyere East and currently being piloted in an e-Learning center in the Western Region.</p>
                </div>
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <a href="http://oleghana.org/" class="btn btn-lg btn-outline">
                        <i class="fa fa-anchor"></i> Visit Our Website
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Console Section -->
    <section class="success" id="console" style="background-image:url(img/console_bg.jpg);background-size:cover">
    <form id="consoleForm" action="#" method="post">
        <div class="container" style="background-color:rgba(0, 0, 0, 0.5);">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>FM Console</h2>
                    <hr / style="width:50%;">
                    <div class="col-lg-12 text-danger">
                        <p>1. Select audio category  display list of all audio files under the selected category. </p>
                        <p>2. Select from the list of audio files the title you want to play. </p>
                        <p>3. Enter a valid transmission frequency.  </p>
                        <p>4. Click on  "Start Transmission". </p><br>
                	</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <select class="selectpicker" data-live-search="true" style="background-color:#FFF;" id="resCategory" onChange="loadresByCategory()">
                        <option value="" selected>Select Category</option>
                          <option value="conversation">Conversation</option>
                        <option value="conversationQuestions">Conversation with Questions</option>
                      <option value="phonicsSongs">Phonic Songs</option>
                      <option value="stroryTelling">Story Telling</option>
                      <option value="stroryTellingQuestions">Story Telling with Questions</option>
                    </select>
<br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <select multiple="multiple" size="10" name="duallistbox_demo2" id="dynamicListbox" class="demo2">
                     
                    </select>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 text-center">
                      <input type="text" class="form-control" style="background-color:#F00;color:#FFF;font-size:18px;text-align:center;" placeholder="Frequency"  name="frequency" id="frequency" required data-validation-required-message="Please enter frequency.">
                </div>                
                <div class="col-lg-6 text-center">
                        <button type="submit" class="btn btn-danger btn-block" id="startTransmission" value="">Start Transmission</button>
                </div>
            </div>
            <div class="row">
                  <div class="col-lg-12">
                </div>
            </div>
                
            </div>
        </div> 
        </form>
    </section>

    <!-- Contact Section -->
    <section id="uploadResources" style="display:none;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Add to resource list</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <form action="index.php" method="post" enctype="multipart/form-data" name="uploadAudio" style="background-color:#FCFAFF;padding:5%;">
                   
                   <div class="row control-group">
                            <div class="form-group col-xs-12  controls"><br>
                                    Resource Title 
                            </div>
                     </div>
                         <div class="row control-group">
                            <div class="form-group col-xs-12  controls">
                                    <select name="resType" id="resType" class="selectpicker">
                                   <option value="conversation">Conversation</option>
                                      <option value="conversationQuestions">Conversation with Questions</option>
                                    <option value="phonicsSongs">Phonic Song</option>
                                    <option value="stroryTelling">Story Telling</option>
                                    <option value="stroryTellingQuestions">Story Telling with Questions</option>
                                    </select>
                                    <p class="help-block text-danger"></p>
                            </div>
                            
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Resource Title</label>
                                <input type="text" class="form-control" placeholder="Title"  name="title" id="title" required data-validation-required-message="Please enter resource title.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Author</label>
                                <input type="text" class="form-control" placeholder="Author"  name="author" id="author" required data-validation-required-message="Please enter author.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Remark / Description</label>
                                <textarea rows="5" class="form-control" placeholder="Description" name="discription" id="discription" required data-validation-required-message="Please enter resource description."></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                    	
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Browse for file</label>
                                <input name="uploadedfile" type="file" />
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                      <div class="row control-group">
                            <div class="form-group col-xs-2  controls"><br>
                                    Approved by
                            </div>
                         </div>
                         <div class="row control-group">
                            <div class="form-group col-xs-2  controls">
                                    <select name="approvedBy" id="approvedBy" class="selectpicker">
                                      <option value="OLE Team" selected>OLE Team</option>
                                      <option value="Government">Government</option>
                                      <option value="School">School</option>
                                      <option value="Other">Other</option>
                                    </select>
                            </div>
                            
                        </div><br><br>
                        
                        
                        <br>
                        <div id="success"></div>
                        <div class="row">
                            <div class="form-group col-xs-12 text-center">
                                <button type="submit" class="btn btn-success btn-lg">Submit To Resource List</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row"></div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; OLE Ghana 2016
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll visible-xs visible-sm">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>
     </div>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/jquery.bootstrap-duallistbox.min.js"></script>
    
    
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    

    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/cbpAnimatedHeader.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/freelancer.js"></script>
<script>
$('.selectpicker').selectpicker();
var demo2 = $('.demo2').bootstrapDualListbox({
	nonSelectedListLabel: 'Non-selected',
	selectedListLabel: 'Selected - Playlist',
	preserveSelectionOnMove: 'moved',
	moveOnSelect: false,
	nonSelectedFilter: ''
});
	
function loadresByCategory(){
	var category = document.getElementById("resCategory").value;
	var selectItem = $('#dynamicListbox');
	var demo2 = $('.demo2').bootstrapDualListbox();
	
	$("#dynamicListbox option").each(function() {
		$(this).remove();
	});
	$.getJSON("functions.php?reloadNewList="+category,function(data){
			$.each(data.rows, function(i,itemDetails){
			   	console.log(itemDetails.doc._id + "--" + itemDetails.doc.title);
			   	selectItem.append("<option value='" +itemDetails.doc._id+ "'>" +itemDetails.doc.title+ "</option>");
			});
			 demo2.bootstrapDualListbox('refresh', true);
	});
//alert("changed")
	//var subject =  document.getElementById("subject").value;
	///var level = $('input:radio[name=rdLevel]:checked').val();
	///$("#listOfRes").load("displayResList4mCouchdb.php?listCat="+category);
}
	
$("#consoleForm").submit(function() {
	var selectedItems = $('.demo2').val();
	var freq = document.getElementById("frequency").value;
	document.getElementById("startTransmission").disabled =true;;
		var jsonString = JSON.stringify(selectedItems);
		   $.ajax({
				type: "GET",
				url: "functions.php?freq="+freq+"&title=www.oleghana.org",
				data: {startPlay : jsonString}, 
				cache: false,
				success: function(){
					document.getElementById("startTransmission").disabled =false;;
					alert("Playlist Played Successfully");
					
				}
			});

      return false;
});
  

</script>
</body>

</html>
