<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="theme-color" content="#4A64B0">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 
    <link rel="icon" type="image/png" href="<?=base_url()?>theme/default/images/logo_favicon.png" >
    <title>Edit FB Post</title>

    <!-- Katniss CSS -->
    <link rel="stylesheet" href="<?=base_url()?>theme/css/katniss.css">

    <link href="<?=base_url()?>theme/default/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/default/bootstrap/css/bootstrap-4.min.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/default/css/roboto_font.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/default/css/preloader.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>theme/default/fontawesome/css/all.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>theme/default/css/dashboard.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>theme/default/css/skins/skin-blue.min.css" rel="stylesheet" />
    
    <link href="<?=base_url()?>theme/default/css/theme_color.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>theme/default/css/general.css" rel="stylesheet" type="text/css" />
    
    <link href="<?=base_url()?>theme/default/css/skins/md.css" rel="stylesheet" />
    <link href="<?=base_url()?>theme/default/plugins/animate/animate.min.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/default/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>theme/default/css/emojionearea.min.css">

	<link href="<?=base_url()?>theme/default/css/datatables.bootstrap.min.css" rel="stylesheet">
	<link href="<?=base_url()?>theme/default/plugins/select2/select2.min.css" rel="stylesheet"> 
    

    <!-- vendor css -->
    
    <link href="<?=base_url()?>theme/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/highlightjs/github.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/select2/css/select2.min.css" rel="stylesheet">
    
    <script src="<?=base_url()?>theme/default/js/jquery.js"></script>
    <script src="<?=base_url()?>theme/default/js/libs/dashboard.min.js"></script>
    <script src="<?=base_url()?>theme/default/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>theme/default/js/libs/preloader.min.js"></script>
    <script src="<?=base_url()?>theme/default/js/helpers.js"></script>
    
    
    <script type="text/javascript">
            $('[data-toggle="kp_tooltip"]').tooltip();
    </script>
    <script src="<?=base_url()?>theme/default/js/libs/emojione.min.js"></script>

    <!-- dropzone !-->
    <link href="<?=base_url()?>resources/dist/dropzone.css" type="text/css" rel="stylesheet" />
    <script src="<?=base_url()?>resources/dropzone.min.js"></script>

    <script>
        var global_file_list = [];
        var global_file_original_name_list = [];
        var global_deleted_list = [];
    </script>

<!-- fb presets include !-->
<?php $this->load->view('style_fb_status_presets'); ?>

</head>
<body>
<!-- ##### SIDEBAR LOGO ##### -->
    <div class="kt-sideleft-header">
        <div class="kt-logo"><a href="<?=base_url()?>">Create post</a></div>
        <div id="ktDate" class="kt-date-today"></div>
        <!--<div class="input-group kt-input-search">
            <input type="text" class="form-control" placeholder="Search...">
            <span class="input-group-btn mg-0">
            <button class="btn"><i class="fa fa-search"></i></button>
            </span>
        </div>--><!-- input-group -->
    </div><!-- kt-sideleft-header -->
<!-- ##### SIDEBAR MENU ##### -->
<?php $this->load->view('includes/sidebar'); ?> 
    <!-- kt-sideleft -->

<!-- ##### HEAD PANEL ##### -->
    <?php $this->load->view('includes/headPanel'); ?> 
    <!-- kt-breadcrumb -->

<!-- ##### MAIN PANEL ##### -->
<div class="kt-mainpanel">
    <!--  <div class="kt-pagetitle">
       <h5>Edit Post</h5>
     </div> --><!-- kt-pagetitle -->
<?php //echo form_open('fb_post/insert_post2','id="edit_post_form_j"'); ?>
<form id="edit_post_form_j" action="">
    <input type="hidden" id = "file_list" name = "file_list">
    <input type="hidden" name="postType" id="postType" value="<?php echo $input_post_type; ?>" />
    <input type="hidden" name="postId"   id="postId" value="<?php echo $input_post_id; ?>" />
    <input type="hidden" name="URLFrom"  id="URLFrom" value="" />
    <input type="hidden" name="selected_page_id"  id="selected_page_id" value="0" />
    <input type="hidden" name="videoFileName" id="videoFileName"  />
    
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="postType">
                        <li>
                        <a href="#" onclick="return false;" class="postTypeMessage <?php if ($input_post_type==="message"){echo ' postTypeActive';}?>">
                        <i class="fa fa-align-left" aria-hidden="true"></i>
                            <span class="hidden-xs hidden-sm hidden-md">Status</span>
                        </a>
                        </li>

                        <li>
                        <a href="#" onclick="return false;"  class="postTypeLink  <?php if ($input_post_type==="link"){echo ' postTypeActive';}?>">
                        <i class="fa fa-link" aria-hidden="true"></i>
                            <span class="hidden-xs hidden-sm hidden-md">LINK</span>
                        </a>
                        </li>

                        <li>
                        <a href="#" onclick="return false;"  class="postTypeImage <?php if ($input_post_type==="image"){echo ' postTypeActive';}?>">
                            <i class="far fa-images" aria-hidden="true"></i>
                            <span class="hidden-xs hidden-sm hidden-md">IMAGE</span>
                        </a>
                        </li>

                        <li>
                        <a href="#" onclick="return false;"  class="postTypeVideo <?php if ($input_post_type==="video"){echo ' postTypeActive';}?>">
                            <i class="fas fa-video" aria-hidden="true"></i>
                        <span class="hidden-xs hidden-sm hidden-md">VIDEO</span>
                        </a>
                        </li>

                    </ul>
                    <div class="clear"></div>
                </div>
            
                <div class="panel-body">
                
                
                    <div class="formField titleField">
                        <label for="title">Post Title<a href="#"  onclick="return false;" data-toggle="kp_tooltip" data-placement="top" style="float:right" title="Working title for post "></i></a></label>
                        <input type="text" id="postTitle" name="postTitle" class="form-control" placeholder="Working post title..." value="<?php echo $input_post_title;?>"></input>
                        <p id = "validation_title_message" style = "color:red; display: none;">You have not provided post title</p>
                    </div>
                    <div class="formField descriptionField">
                        <label for="message">Message<a href="#"  onclick="return false;" data-toggle="kp_tooltip" data-placement="top" style="float:right" title=""></i></a></label>
                        <textarea name="message" id="message" rows="5" cols="50" class="form-control" placeholder="Your status here..."><?php echo strip_tags($input_post_message,FALSE) ; ?></textarea>
                        <p id = "validation_content_message" style = "color:red; display: none;">You have not provided message content</p>
                    </div>

                    <!-- fb presets included !-->
                    <input type="hidden" name="fb_preset_id" id="fb_preset_id" value="<?php if($input_post_fb_preset_id ==="") {echo "0"; } else { echo $input_post_fb_preset_id; }?>" />
                    <!-- <div class="fb_presets">
                        <ul>
                            <li class="fbp fbp-0" data-psid="0"></li>
                            <li class="fbp fbp-1903718606535395" data-psid="1903718606535395"></li>
                            <li class="fbp fbp-1887542564794370" data-psid="1887542564794370"></li>
                            <li class="fbp fbp-1881421442117417" data-psid="1881421442117417"></li>
                            <li class="fbp fbp-324777221272701" data-psid="324777221272701"></li>
                            <li class="fbp fbp-1365883126823705" data-psid="1365883126823705"></li>
                            <li class="fbp fbp-814910605325191" data-psid="814910605325191"></li>
                            <li class="fbp fbp-362672934129151" data-psid="362672934129151"></li>
                            <li class="fbp fbp-249307305544279" data-psid="249307305544279"></li>
                            <li class="fbp fbp-1288458721262047" data-psid="1288458721262047"></li>
                            
                            <li class="fbp fbp-357109954713249" data-psid="357109954713249"></li>
                            <li class="fbp fbp-127281214508877" data-psid="127281214508877"></li>
                            <li class="fbp fbp-1943057695973225" data-psid="1943057695973225"></li>
                            <li class="fbp fbp-112865389425474" data-psid="112865389425474"></li>
                            <li class="fbp fbp-126877221295325" data-psid="126877221295325"></li>
                            <li class="fbp fbp-623911921148129" data-psid="623911921148129"></li>
                            <li class="fbp fbp-1705020913127345" data-psid="1705020913127345"></li>
                            <li class="fbp fbp-1200070923437550" data-psid="1200070923437550"></li>
                            <li class="fbp fbp-816008591908985" data-psid="816008591908985"></li>
                            <li class="fbp fbp-425789167806189" data-psid="425789167806189"></li>
                            <li class="fbp fbp-528808880819990" data-psid="528808880819990"></li>
                            <li class="fbp fbp-308229619684986" data-psid="308229619684986"></li>
                            <li class="fbp fbp-382422138883041" data-psid="382422138883041"></li>
                            <li class="fbp fbp-396343990807392" data-psid="396343990807392"></li>
                            <li class="fbp fbp-1974886472751579" data-psid="1974886472751579"></li>
                            
                        </ul>
                    </div>!-->
                    <div><span class="tx-danger"><?php echo validation_errors(); ?></div>
            
                    <div id="postLinkDetails" <?php if($input_post_type !== "link") { echo 'style="display:none"' ;} ?> >
                        <div class="formField">
                            <label for="link">LINK
                                <a href="#"  
                                    onclick="return false;" 
                                    data-toggle="kp_tooltip" 
                                    data-placement="top" 
                                    style="float:right" 
                                    title="Link sub fields Are no longer supported from Facebook API">
                                <i class="fa fa-question-circle" aria-hidden="true"></i></a>
                            </label>
                            <input type='text' name='link' class="form-control" id="link" value="<?php echo $input_post_link ?>" placeholder="Post link here." />
                            <span class="linkError"></span>
                        </div>
                    </div>
        
                    <div id="postImageDetails" <?php if ($input_post_type !== "image" ) {echo 'style="display:none"';}?> >
                        <div class="formField">
                            <label for="imageURL">IMAGE 
                                <a href="#"  onclick="return false;" data-toggle="kp_tooltip" data-placement="top" style="float:right" title="Supportde formats for uplaoded images> jpg, png, bmp."> 
                                <i class="fa fa-question-circle" aria-hidden="true"></i></a>
                            </label>
                            <div  class="dropzone" id="myAwesomeDropzone" data-value="<?php echo $input_post_image_list;?>">
                            </div>
                        </div>
                    </div>

                    <div id="postVideoDetails" <?php if ($input_post_type !== "video") {echo 'style="display:none"';}?> >
                        <div class="formField">
                                <label for="video">VIDEO
                                <a href="#"  onclick="return false;" data-toggle="kp_tooltip" data-placement="top" style="float:right" title="Supported formats for uploaded videos: 3g2, 3gp, 3gpp, asf, avi, dat, divx, dv, f4v, flv, m2ts, m4v, mkv, mod, mov, mp4, mpe, mpeg, mpeg4, mpg, mts, nsv, ogm, ogv, qt, tod, ts, vob, wmv."> 
                                    <i class="fa fa-question-circle" aria-hidden="true"></i></a>
                                </label>
                                <div class="input-group">
                                <input type="file" name="videoFile" id="videoFile" class="inputfile"/>
                                <!--<label for="file">Choose a video</label>-->
                                    <input type='text' 
                                           name='video' 
                                           class="form-control" 
                                           id="video" 
                                           value="<?php echo $input_post_video ; ?>" 
                                           placeholder="Video link (3gp, avi, mov, mp4, mpeg, mpeg4, vob, wmv...etc)." />
                                   <!-- <div class="input-group-btn">
                                        <button type="button" 
                                        id="mediaLibraryVideo" 
                                        class="btn btn-default"
                                        onclick="UploadVideoJ()">Upload</button>
                                    </div>-->
                                </div>
                        </div>
                    </div>
                </div>
               
               <div class="formField">
                    <button type="button" onclick="SaveAsDraft();" class='btn btn-secondary' id="savepost" name='savepost'>
                        <i class="fas fa-save" aria-hidden="true"></i> Save as draft 
                    </button>
                    <!--<button onclick="return false;" class='btn btn-primary' id="savepost" name='savepost'>
                        <i class="fas fa-save" aria-hidden="true"></i> Save draft 
                    </button>-->
                    <button onclick="return false;" class='btn btn-primary' id="scheduledpost" style = "display : none;">
                        <i class="fa fa-calendar" aria-hidden="true"></i> Schedule post  
                    </button>
                    <button type="button" onclick="SendPostToFB();" class='btn btn-primary' id="post" name='post' style = "display : none;">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>Share now
                    </button>
                </div>
                <div class="preloader"></div>
                <div class="messageBox"></div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">POST PREVIEW</h3>
                </div>
                <div class="panel-body">
                    <div class="postPreview">
                        <div class="post">
                            <div class="PreviewPoster">
                                <?php if($fbaccountDetails_fb_id !== "") { ?> 
                                <img src='https://graph.facebook.com/<?php echo $fbaccountDetails_fb_id ?>/picture?redirect=1&height=40&width=40&type=normal' style='vertical-align:top;'  onerror="this.src = './theme/default/images/facebookUser.jpg'" />
                                <?php } else { ?>
                                <img src='./theme/default/images/facebookUser.jpg' width='32' height='32' style='vertical-align:middle;' />
                                <?php } ?>
                                <span class="userFullName">
                                    <?php if ($fbaccountDetails !==null) {
                                        echo $fbaccountDetails_firstname . " " . $fbaccountDetails_lastname;
                                    } else {
                                        echo "Facebook Page";
                                    }
                                    ?>
                                </span>
                                <span class="postPreviewDetails">
                                    Now · Public/Private						
                                </span>
                                <div class="clear"></div>
                            </div>
                            <p class="message">
                                <span class="defaultMessage" style="width: 60%"></span>	
                                <span class="defaultMessage" style="width: 80%"></span>
                                <span class="defaultMessage" style="width: 50%"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">ADD PAGE</h3>
                </div>
                <div style="height:70vh;">
                    <select id="pages_list" name="pages_list" style="width:100%;">
                        <option value="0">Add Page</option>
                        <?php  
                            $numofpages = count( $user_pages);
                            $last= $numofpages-1;
                            for ($i = 0; $i <=  $last; $i++) {
                                    echo '<option id="' . $user_pages[$i]['id'] . '" value="' . $user_pages[$i]['fbPageName'] .'">' . $user_pages[$i]['fbPageName'] . '</option>';
                                }
                        ?>
                        
                    </select>
                    <br><br><br>
                    <label for="selected_page">Selected page: </label>                    
                    <input type="text" id="selected_page" value="..." width="100%" disabled />
                    <p id = "validation_selected_page_message" style = "color:red; display: none;">You have not selected page to post on</p>
                </div>   
            </div>        
        </div>  
    </div>   
</form>

<div class="kt-footer">
<!-- <span>Copyright &copy;. All Rights Reserved. </span>
<span>Created by: ThemePixels, Inc.</span> -->
</div><!-- kt-footer -->
</div><!-- kt-mainpanel -->

<script type="text/javascript">
function SendPostToFB(){
    event.preventDefault();
    const id = document.querySelector("#postId").value;
    console.log("id", id);
    Swal.fire({
                            title: "Please be patient...",
                            text: "Your posting is in progress",
                            type: 'info',
                            showConfirmButton: false,
     });
    $.ajax({
        url:'<?=base_url()?>send_post/index/'+id,
        type: 'POST',
       // postId: id,
        processData: false,
        contentType: false,
        success: function(data){
            console.log('data',data);
            var dataJ = jQuery.parseJSON (data);
            if(!dataJ.error)
            {
                Swal.fire(
                            "Well done!",
                            dataJ.message,
                            'success'
                        ).then(() => {location.reload();});
            } else{
                Swal.fire(
                            "Ouch!",
                            dataJ.message,
                            'error'
                        );
            }

        },
        error: function(xhr, status, error) {
            Swal.fire(
                            "Ouch!",
                            xhr.responseText,
                            'error'
                        );
                    }

        

      });
    }

function SaveAsDraft(){
   // console.log("event", event);
    event.preventDefault();
   // console.log("klik");
    const form = document.querySelector('#edit_post_form_j');

    const postTitle = document.querySelector('#postTitle');
    const message = document.querySelector('#message');
    const pages_list = document.querySelector('#pages_list');

    console.log('postTitle',postTitle.value);
    console.log('message',message.value);
    console.log('pages_list',pages_list.value);
    var formData = new FormData(form);
    var valid = true;
    if(postTitle.value === '' || postTitle.value === null){
        document.querySelector('#validation_title_message').style.display = "block";
        valid = false;
    }else{
        document.querySelector('#validation_title_message').style.display = "none";
    }

    if(message.value === ''){
        document.querySelector('#validation_content_message').style.display = "block";
        valid = false;
        }else{
         document.querySelector('#validation_content_message').style.display = "none";
    }


    if(pages_list.value === '0'){
        document.querySelector('#validation_selected_page_message').style.display = "block";
        valid = false;
        }else{
        document.querySelector('#validation_selected_page_message').style.display = "none";   
    }
  //  console.log("form", form);
  if(valid){


    $.ajax({
        url:'<?=base_url()?>fb_post/insert_post',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data){
           // console.log('data',data);
            var dataJ = jQuery.parseJSON (data);
          //  console.log('dataJ',dataJ);
            if(!dataJ.error){
                document.querySelector("#post").style.display = "block";
                document.querySelector("#savepost").style.display = "none";
                console.log('id generisanog posta',dataJ.id);
                document.querySelector("#postId").value = dataJ.id;
            }
            else{
                alert(dataJ.message);
            }
        },
        error:function(e){
            alert(e);
        }

      });
      }
    }
    function listPages(){
        event.preventDefault();
        var e = document.getElementById("pages_list");
        if(e.selectedIndex > 0){
             // alert(e.options[e.selectedIndex].value) ;
            document.getElementById("selected_page").value=e.options[e.selectedIndex].value;
            document.getElementById("selected_page_id").value=e.options[e.selectedIndex].id;
              //add page in list  ("li #id").value($id)
             //e.selectedIndex=0;
        }
    }
   document.getElementById("pages_list").addEventListener("click",listPages);


</script>


<script type="text/javascript">
    function imagePostPreview2(){
        resetPostPreview();
        //console.log('usli smo u imagePostPreview2');
        var ic = global_file_list.length;
      //  console.log('global_file_list',global_file_list);
        imageCount = ic > 4 ? 4 : ic;
      //console.log('imageCOunt',imageCount);
        var imgblock = "<div class='previewImageType pit"+imageCount+"'>";

        for (var i = 1; i <= imageCount; i++) {
            imgblock += "<div class='image_"+i+"'>";
            if(ic > 4 && i == 4){
                    imgblock += "<div class='moreImages'>+"+(ic-4)+"</div>";
            }
            imgblock += "<img src='<?=base_url()?>uploads/"+global_file_list[i-1]+"'"; 
            imgblock += " />";
                
            imgblock += "</div>";
        }
        //console.log('postPreview prije',$('.postPreview')[0].innerHTML);
       // console.log('global_file_list',imgblock);
        $('.postPreview').append(imgblock);
       // console.log('postPreview poslije',$('.postPreview')[0].innerHTML);
    }

    function hiddenValueGenerate(){ 
        var hiddenElement = document.getElementById('file_list');
        hiddenElement.value = '';
        var imageCount = global_file_list.length; 

        for (var i = 0; i < imageCount; i++) {
            hiddenElement.value = hiddenElement.value + global_file_list[i] +',';
        } 

        hiddenElement.value = hiddenElement.value.substring(0, hiddenElement.value.length - 1); 
        //console.log('hiddenElement.value', hiddenElement.value);
    }
  
    function videoPostPreview(){
        resetPostPreview();
        var videoBlock = "<div class='previewVideoType'>";

            if($.trim($("#video").val()) != ""){
                var videoLink = spin($("#video").val());
                if(IsYoutubeVideo(videoLink)){
                    var videoID = $("#video").val().match(/^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/)[1];
                    
                    var regexp = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
                    
                    $("#postVideoDetails .input-group").removeClass("inputError");

                    if(!regexp.test($("#video").val())){
                        $("#postVideoDetails .input-group").addClass("inputError");
                        alertBox("{{l('Invalid Youtube video link')}}","danger",false,true,true);
                    }

                    videoBlock += "<iframe src='https://www.youtube.com/embed/"+videoID+"' width='100%' height='300px' frameborder='0' allowfullscreen='allowfullscreen'></iframe>";
                }else if(IsFacebookVideo(videoLink)){
                    var myRegexp = /\d+/;
                    var match = myRegexp.exec(videoLink);
                    videoBlock += "<iframe src='https://www.facebook.com/video/embed?video_id="+match[0]+"' height='300px' width='100%' frameborder='0'></iframe>";
                }else{
                    videoBlock += "<video controls><source src='"+videoLink+"'></source></video>";
                }
            }
            videoBlock += "</div>";
        $('.postPreview').append(videoBlock);
    }
</script>
<script type="text/javascript">
	$(".fb_presets .fbp").on("click",function() {
		/*var textEditor = $(".emojionearea");
		textEditor.removeClass();
		textEditor.addClass("emojionearea");
		textEditor.addClass("form-control");*/

		var statusPreview = $(".postPreview .message");
		statusPreview.removeClass();
		statusPreview.addClass("message");

		$("#fb_preset_id").val(0); 
		if($(this).data("psid")!=0 && $.trim($(".emojionearea-editor").text()).length <= 130){
			$("#fb_preset_id").val($(this).data("psid")); 
			/*textEditor.addClass("fbpb");
			textEditor.addClass("fbpb-"+$(this).data("psid"));	*/
			statusPreview.addClass("fbpb");
			statusPreview.addClass("fbpb-"+$(this).data("psid"));
		}

		if($.trim($(".emojionearea-editor").text()).length > 130){
			alertBox('The status content is too long, Status background must be used with text shorter than 130 characters.',"danger",false,true);
		}
	});
</script>
<?php if ($input_post_fb_preset_id !== "" and $input_post_fb_preset_id !== 0) 
{ ?>
<script type="text/javascript">
        $(window).bind("load", function() {
	   	/*var textEditor = $(".emojionearea");
		textEditor.addClass("fbpb");
		textEditor.addClass("fbpb-{{ input_post('fb_preset_id') }}");*/

		var statusPreview = $(".postPreview .message");
		statusPreview.addClass("fbpb");
		statusPreview.addClass("fbpb-{{ input_post('fb_preset_id') }}");
	});
</script>    
<?php } ?>
<script type="text/javascript">
	// Preview instant update (message)
	$('#message,.emojionearea-editor').bind('input propertychange change', function() {

		if($("#postForm #postType").val()!="message"){return false;}

		if($("#fb_preset_id").val() != "" && $("#fb_preset_id").val() != 0){
			/*var textEditor = $(".emojionearea");*/
			var statusPreview = $(".postPreview .message");

			if($.trim($(".emojionearea-editor").text()).length > 130 ){
				if(statusPreview.hasClass("fbpb")){
					alertBox("The status is content is too long, Status background cannot be used with longer than 130 characters.)","danger",false,true,true);
				}
				/*textEditor.removeClass("fbpb");
				textEditor.removeClass("fbpb-"+$("#fb_preset_id").val());*/

				statusPreview.removeClass("fbpb");
				statusPreview.removeClass("fbpb-"+$("#fb_preset_id").val());

			}else{
				/*textEditor.addClass("fbpb");
				textEditor.addClass("fbpb-"+$("#fb_preset_id").val());*/

				statusPreview.addClass("fbpb");
				statusPreview.addClass("fbpb-"+$("#fb_preset_id").val());
			}
		}
	});
	$( ".postTypeMessage" ).click(function() {
		if($("#fb_preset_id").val() != "" && $("#fb_preset_id").val() !=0 && $.trim($(".emojionearea-editor").text()).length <= 130){
			/*var textEditor = $(".emojionearea");
			textEditor.addClass("fbpb");
			textEditor.addClass("fbpb-"+$("#fb_preset_id").val());	*/

			var statusPreview = $(".postPreview .message");
			statusPreview.addClass("fbpb");
			statusPreview.addClass("fbpb-"+$("#fb_preset_id").val());	
		}
		$(".fb_presets").show();
	});
	
	// postTypeLink click event when click (define post type and make current post type active) 
	$( ".postTypeLink,.postTypeImage,.postTypeVideo" ).click(function() {
		$(".fb_presets").hide();
		/*var textEditor = $(".emojionearea");
		textEditor.removeClass("fbpb");
		textEditor.removeClass("fbpb-"+$("#fb_preset_id").val());*/

		var statusPreview = $(".postPreview .message");
		statusPreview.removeClass("fbpb");
		statusPreview.removeClass("fbpb-"+$("#fb_preset_id").val());
	});
</script>

  <script src="<?=base_url()?>theme/default/js/jsui.js"></script>
<script src="<?=base_url()?>theme/default/plugins/select2/select2.min.js"></script>
 <script src="<?=base_url()?>theme/default/js/post_form.js"></script>
 <script src="<?=base_url()?>theme/default/js/libs/jquery.reel.js"></script>
<script src="<?=base_url()?>theme/default/js/postpreview.js"></script>  
    <script src="<?=base_url()?>theme/default/js/libs/moment.min.js"></script>
    <script src="<?=base_url()?>theme/default/js/libs/bootstrap-datetimepicker.min.js"></script>
    <script src="<?=base_url()?>theme/default/js/libs/emojionearea.min.js"></script>
    <script src="<?=base_url()?>theme/default/js/jquery.dataTables.min.js"></script>
    <script src="<?=base_url()?>theme/default/js/dataTables.bootstrap.min.js"></script> 

<script>
function UploadVideoJ(){
    var files = document.querySelector("#videoFile").files;
    console.log("file", files);

    var formData = new FormData();
    formData.append('file',files[0]);
    console.log("formData", formData);
    $.ajax({
        url: '<?=base_url()?>dropzone/uploadVideo',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data){
            console.log('data',data);
            var dataJ = jQuery.parseJSON (data);
            console.log('dataJ',dataJ);
            if(!dataJ.error){
                document.querySelector("#video").value = '<?=base_url()?>uploads/'+dataJ.fileName;
                document.querySelector("#videoFileName").value = dataJ.fileName;
            }
            else{
                alert(dataJ.message);
            }
            videoPostPreview();
        }

    });
}

    // Global variables --old scripts
    $(document).ready(function() {
        //form submit
        //-------------------
      /*  document.getElementById('edit_post_form_j').addEventListener("submit",function(e) {
             // e.preventDefault(); // before the code
           
             const form = document.querySelector('#edit_post_form_j');
             const selected_page_id = form['selected_page_id'].value;
            console.log('e',e);
            console.log('selected_page_id',selected_page_id);
            console.log('form',form);
            var formData = new FormData(form);

                for (var [key, value] of formData.entries()) { 
                console.log(key, value);
                }
       });*/



        //------------------------
        
        $("#postForm #message").emojioneArea({
                autoHideFilters: false,
                pickerPosition: "bottom",
                autocomplete: false,
                events: {
                    keydown: function (editor, event) {
                        $( "#postForm #message" ).trigger('propertychange');
                    },
                    emojibtn_click: function (button, event) {
                        $( ".emojionearea-editor" ).trigger('keydown');
                    }
                }
            });

        $("#postForm #scheduledpost").click(function(){
            $("#postForm .scheduledpost").stop().toggle('fast');
        });

        $('#scheduledPostTime').datetimepicker({
            format: 'DD/MM/YYYY HH:mm',
            defaultDate: new Date(),
        });

        $('#start_on').datetimepicker({format: 'DD/MM/YYYY HH:mm'});
        $('#end_on').datetimepicker({format: 'DD/MM/YYYY HH:mm'});

        // Trigger click event
        $('.postTypeActive').click();

        // #postForm #post click event => Post validation 
        $("#postForm #post").click(function(){
            $("#postForm .messageBox").removeClass("error");
            $("#postForm .messageBox").html("");
            
            if($("#postForm #postType").val() == "message" && $.trim($("#postForm #message").val()) == ""){
                alertBox('The post is empty!',"danger","#postForm .messageBox",true);	
            }else if($("#postForm #postType").val() == "link" && $.trim($("#postForm #link").val()) == ""){
                alertBox('The post is empty!',"danger","#postForm .messageBox",true);	
            }else if($("#postForm #postType").val() == "image" && $.trim($("#postForm #imageURL_0").val()) == ""){
                alertBox('The post is empty!',"danger","#postForm .messageBox",true);	
            }else{
                post();
            }
        });
       
    });

    var xhrGetSiteDetails = null;
    function GetSiteDetails(url,callback){
            if(xhrGetSiteDetails!==null) xhrGetSiteDetails.abort();
            xhrGetSiteDetails = $.ajax({
                url: "<?=base_url()?>helpers/get_url_info",
                dataType: "json",
                type: "post",

                data: { 
                    url: url,
                    csrf_kingposter: getCookie('csrf_kingposter_cookie') 
                },
                success: callback,
                error: function(request, status, error) {}
            });
            
        }
     
    $(document).ready(function() {
                            Dropzone.autoDiscover = false;
                            var dropZoneParams = {
                                    url: '<?=base_url()?>dropzone/upload',
                                    paramName: "file", // The name that will be used to transfer the file
                                    maxFilesize: 2, // MB
                                    //autoProcessQueue: false,
                                    addRemoveLinks: true,
                                    init: function() {
                                        this.on("addedfile", function(file) { 
                                            console.log('added:', file.name);
                                            global_file_original_name_list.push(file.name);
                                      
                                        });
                                        this.on("removedfile", function(file) { 
                                            console.log('before removed:', file.name);
                                            var indexx =  global_file_original_name_list.indexOf(file.name)
                                            global_file_list.splice(indexx,1);
                                            global_file_original_name_list.splice(indexx,1);
                                            //console.log("global_file_list after removed:",global_file_list);
                                            //console.log("global_file_original_name_list after removed:",global_file_original_name_list);
                                            //imagePostPreview('after delete');
                                            hiddenValueGenerate();
                                            imagePostPreview2();
                                        });

                                    // this.on("success", function(file) {
                                    //        console.log("naziv fajla:",file["name"]);
                                    //     });
                                    },
                                    success: function( file, response ){
                                        global_file_list.push(response);
                                    // console.log("global_file_list",global_file_list);
                                    //  console.log("global_file_original_name_list",global_file_original_name_list);
                                        hiddenValueGenerate();
                                        imagePostPreview2();
                                    },
                                
                                };

             var myDropzone = new Dropzone("div#myAwesomeDropzone",dropZoneParams);
             var dropzoneElement =document.getElementById('myAwesomeDropzone');
             if(dropzoneElement.getAttribute('data-value').length>0 && dropzoneElement.getAttribute('data-value') !== " "){
                 var tmp = dropzoneElement.getAttribute('data-value').split(',');
                 if(tmp.length>0){ 
                    console.log('tmp length .', tmp.length + '.');
                    tmp.forEach(function(element) {
                              global_file_list.push(element);
                              var el =  '<?=base_url()?>uploads/'+ element;
                              console.log('element', el);
                               if (element != 'undefined') {
                                                var mock = {
                                                    name: element, 
                                                    //size : 5000, 
                                                    isMock : true, 
                                                    accepted:true,
                                                    kind:'image',
                                                    serverImgUrl:   el,
                                                    dataURL: el
                                 };
                                Dropzone.forElement("#myAwesomeDropzone").files.push(mock);            
                                Dropzone.forElement("#myAwesomeDropzone").emit("addedfile", mock);
                               

                                Dropzone.forElement("#myAwesomeDropzone").createThumbnailFromUrl(mock,
                                Dropzone.forElement("#myAwesomeDropzone").options.thumbnailWidth, 
                                Dropzone.forElement("#myAwesomeDropzone").options.thumbnailHeight,
                                Dropzone.forElement("#myAwesomeDropzone").options.thumbnailMethod, true, function (thumbnail) 
                                        {
                                            Dropzone.forElement("#myAwesomeDropzone").emit('thumbnail', mock, thumbnail);
                                        });
                                Dropzone.forElement("#myAwesomeDropzone").emit('complete', mock);
                                //Dropzone.forElement("#myAwesomeDropzone").createThumbnailFromUrl(mock,mock.serverImgUrl);
                                //Dropzone.forElement("#myAwesomeDropzone").emit("thumbnail", mock, mock.serverImgUrl);
                                //Dropzone.forElement("#myAwesomeDropzone").emit("complete", mock);
                        }			         		
                   });
              

               imagePostPreview2(); 
                
           }
          }
          
          
          $("#videoFile").change(function(){
              if(document.querySelector("#postType").value === "video")
            {
               UploadVideoJ();
            }
        });
        
        });
</script>


<script src="<?=base_url()?>theme/lib/popper.js/popper.js"></script>
<script src="<?=base_url()?>theme/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
<script src="<?=base_url()?>theme/lib/highlightjs/highlight.pack.js"></script>
<script src="<?=base_url()?>theme/lib/select2/js/select2.min.js"></script>
<!--<script src="<?=base_url()?>theme/lib/rickshaw/rickshaw.min.js"></script>-->

<script src="<?=base_url()?>theme/js/sweetalert2.all.min.js"></script>

<script src="<?=base_url()?>theme/js/katniss.js"></script>

<script src="<?=base_url()?>theme/js/ResizeSensor.js"></script>
<!--<script src="<?=base_url()?>theme/js/dashboard.js"></script>-->

</body>
</html>  
