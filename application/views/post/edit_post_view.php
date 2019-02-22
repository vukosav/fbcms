<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="theme-color" content="#4A64B0">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 
    <link rel="icon" type="image/png" href="http://localhost/fbcms/theme/default/images/kp_favicon1.png?v=kp272" >
    <title>Edit FB Post</title>

    <!-- vendor css -->
    
<link href="<?=base_url()?>theme/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/highlightjs/github.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/select2/css/select2.min.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/rickshaw/rickshaw.min.css" rel="stylesheet">

    <!-- Katniss CSS -->
    <link rel="stylesheet" href="<?=base_url()?>theme/css/katniss.css">


    <link href="http://localhost/fbcms/theme/default/bootstrap/css/bootstrap.min.css?v=kp272" rel="stylesheet">
    <link href="http://localhost/fbcms/theme/default/bootstrap/css/bootstrap-4.min.css?v=kp272" rel="stylesheet">
    <link href="http://localhost/fbcms/theme/default/css/roboto_font.css?v=kp272" rel="stylesheet">
    <link href="http://localhost/fbcms/theme/default/css/preloader.min.css?v=kp272" rel="stylesheet" type="text/css" />
    <link href="http://localhost/fbcms/theme/default/fontawesome/css/all.min.css?v=kp272" rel="stylesheet" />
    <link href="http://localhost/fbcms/theme/default/css/dashboard.min.css?v=kp272" rel="stylesheet" />
    <link href="http://localhost/fbcms/theme/default/css/skins/skin-blue.min.css?v=kp272" rel="stylesheet" />
    
    <link href="http://localhost/fbcms/theme/default/css/theme_color.css?v=kp272" rel="stylesheet" type="text/css" />
    <link href="http://localhost/fbcms/theme/default/css/general.css?v=kp272" rel="stylesheet" type="text/css" />
    
    <link href="http://localhost/fbcms/theme/default/css/skins/md.css?v=kp272" rel="stylesheet" />
    
    
    <link href="http://localhost/fbcms/theme/default/plugins/animate/animate.min.css" rel="stylesheet">
    
  
  	<link href="http://localhost/fbcms/theme/default/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" type="text/css" href="http://localhost/fbcms/vendor/elfinder/jquery/css/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="http://localhost/fbcms/vendor/elfinder/css/elfinder.min.css">

	<link rel="stylesheet" type="text/css" href="http://localhost/fbcms/theme/default/css/emojionearea.min.css">

	<link href="http://localhost/fbcms/theme/default/css/datatables.bootstrap.min.css" rel="stylesheet">
	<link href="http://localhost/fbcms/theme/default/plugins/select2/select2.min.css" rel="stylesheet"> 
    <link rel='stylesheet' type='text/css' href="http://localhost/fbcms/theme/default/css/style_fb_status_presets.css" rel="stylesheet">



    <script src="http://localhost/fbcms/theme/default/js/jquery.js?v=kp272"></script>
    <script src="http://localhost/fbcms/theme/default/js/libs/dashboard.min.js?v=kp272"></script>
    <script src="http://localhost/fbcms/theme/default/bootstrap/js/bootstrap.min.js?v=kp272"></script>
    <script src="http://localhost/fbcms/theme/default/js/libs/preloader.min.js?v=kp272"></script>
    <script src="http://localhost/fbcms/theme/default/js/helpers.js?v=kp272"></script>
    
    <script src="http://localhost/fbcms/vendor/elfinder/jquery/js/jquery-ui.min.js"></script>
    <script type="text/javascript">
            $('[data-toggle="kp_tooltip"]').tooltip();
    </script>
    <script src="http://localhost/fbcms/theme/default/js/libs/emojione.min.js"></script>
</head>
<body>
<!-- ##### SIDEBAR MENU ##### -->
<?php $this->load->view('includes/sidebar'); ?> 
    <!-- kt-sideleft -->

    <!-- ##### HEAD PANEL ##### -->
    <?php $this->load->view('includes/headPanel'); ?> 
    <!-- kt-breadcrumb -->

    <!-- ##### MAIN PANEL ##### -->
    <div class="kt-mainpanel">
      <!-- <div class="kt-pagetitle">-->
      <!--   <h5>Dashboard</h5>-->
      <!-- </div> --><!-- kt-pagetitle -->

<div class="row">
    <div class="col-sm-5">
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
            <?php echo form_open('post/insert_post'); ?>
                <input type="hidden" name="postType" id="postType" value="<?php echo $input_post_type; ?>" />
                <input type="hidden" name="postId" id="postId" value="<?php echo $input_post_id; ?>" />
                <input type="hidden" name="URLFrom" id="URLFrom" value="" />
            
                <div class="formField descriptionField">
                    <label for="message">Message<a href="#"  onclick="return false;" data-toggle="kp_tooltip" data-placement="top" style="float:right" title="Spinning example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {foo|bar|foobar}!!"> <i class="fa fa-question-circle" aria-hidden="true"></i></a></label>
                    <textarea name="message" id="message" rows="5" cols="50" class="form-control" placeholder="Your status here..."><?php echo strip_tags($input_post_message,FALSE) ; ?></textarea>
                </div>

                <!-- fb presets included !-->
                <input type="hidden" name="fb_preset_id" id="fb_preset_id" value="<?php if($input_post_fb_preset_id ==="") {echo "0"; } else { echo $input_post_fb_preset_id; }?>" />
                <div class="fb_presets">
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
                </div>

          
                <div id="postLinkDetails" <?php if($post_row_type !== "link") { echo 'style="display:none"' ;} ?> >
                    <div class="formField">
                        <label for="link">LINK
                            <a href="#"  onclick="return false;" data-toggle="kp_tooltip" data-placement="top" style="float:right" title="Link sub fields Are no longer supported from Facebook API">
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>
                        </label>
                        <input type='text' name='link' class="form-control" id="link" value="<?php echo $input_post_link ?>" placeholder="Post link here." />
                        <span class="linkError"></span>
                    </div>
                    <?php 
                   $link_style = "none" ;
                   //    if ($input_post_name !=="" or $input_post_picture !=="" or $input_post_caption!=="" or $input_post_description!=="")
                    //       { $link_style = "block";}
                    ?>
               <div class="linkSubFields" style="display:<?php echo $link_style; ?>">
                        <div class="formField">
                            <label for="picture">PICTURE</label>
                            <div class="input-group">
                                <input type='text' name='picture' id="picture" class="form-control"  value="<?php echo $input_post_picture; ?>" placeholder="Post picture here." />
                                <div class="input-group-btn">
                                    <button type="button" id="mediaLibraryImageLink" class="btn btn-default">
                                        Upload</button>
                                </div>
                            </div>
                        </div>
                        <div class="formField">
                            <label for="name">Title</label>
                            <input type='text' id="name" name='name' class="form-control" value="<?php echo $input_post_name ;?>" placeholder="Post title here." />
                        </div>
                        <div class="formField">
                            <label for="caption">CAPTION</label>
                            <input type='text' name='caption' id="caption" class="form-control" value="<?php echo $input_post_caption; ?>" placeholder="Post Caption here." />
                        </div>
                        <div class="formField">
                            <label for="description">DESCRIPTION</label>
                            <textarea name='description' id="description" rows='3' cols='50' class="form-control" placeholder="Post description here."><?php echo $input_post_description; ?></textarea>
                        </div>
                    </div>
                    
                </div>
               
       
                <div id="postImageDetails" <?php if ($post_row_type !== "image" ) {echo 'style="display:none"';}?> >
                    <div class="formField">
                        <label for="imageURL">IMAGE 
                            <a href="#"  onclick="return false;" data-toggle="kp_tooltip" data-placement="top" style="float:right" title="Image URL"> 
                            <i class="fa fa-question-circle" aria-hidden="true"></i></a>
                        </label>
                        <!--
                        <label class="switch">
                            <input type="checkbox" id="enable360Image" name="enable360Image" aria-label="Unique post" <?php //if ($p_allow_spherical_photo === true) echo 'checked'; ?> />
                            <span class="slider round"></span>
                        </label>
                        
                        <label for="enable360Image" class="input-text">360° image</label>
                        !-->
                        <div class="multiImages">
                            <input type='hidden' name='image_number' id="image_number" value="0" />
                            <?php 
                            if ($post_row_type === "image" ) //or $p_image[0] !=="")
                            {
                                /*
                                // petlja kroz niz slika - for image in p.image 
                            ?>
                                <div class="input-group">
                                    <input type='text' name='imageURL' class="form-control" id="imageURL_{{ loop.index0 }}" value="{{ p.image[loop.index0] }}" placeholder='{{ l("Image URL.") }}' />
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default mediaLibraryImage" value="{{ loop.index0 }}">Upload</button>
                                    </div>
                                    <i class="fa fa-times removeImage" {% if loop.index0 == 0 %}style="display:none;"{% endif %} aria-hidden="true"></i>
                                </div>
                                {% endfor %}
                            {% else %}
                                <div class="input-group">
                                    <input type='text' name='imageURL' class="form-control" id="imageURL_0" value="{{ input_post("imageURL") }}" placeholder='{{ l("Image URL.") }}' />
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default mediaLibraryImage" value="0">{{ l("Upload") }}</button>
                                    </div>
                                    <i class="fa fa-times removeImage" style="display:none;" aria-hidden="true"></i>
                                </div>
                            {% endif %} */
                            
                            }?>
                        </div>
                    </div>
                    <button type="button" class="btn btn-default addNewImageField"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </div>

                <div id="postVideoDetails" <?php if ($post_row_type !== "video") {echo 'style="display:none"';}?> >
                    <div class="formField">
                            <label for="video">VIDEO
                            <a href="#"  onclick="return false;" data-toggle="kp_tooltip" data-placement="top" style="float:right" title="Supported formats for uploaded videos: 3g2, 3gp, 3gpp, asf, avi, dat, divx, dv, f4v, flv, m2ts, m4v, mkv, mod, mov, mp4, mpe, mpeg, mpeg4, mpg, mts, nsv, ogm, ogv, qt, tod, ts, vob, wmv."> 
                                <i class="fa fa-question-circle" aria-hidden="true"></i></a>
                            </label>
                            <div class="input-group">
                                <input type='text' name='video' class="form-control" id="video" value="<?php echo $input_post_video ; ?>" placeholder="Video link (3gp, avi, mov, mp4, mpeg, mpeg4, vob, wmv...etc)." />
                                <div class="input-group-btn">
                                    <button type="button" id="mediaLibraryVideo" class="btn btn-default">Upload</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
       <div class="panel panel-default ">
            <div class="panel-body">
         <!--    {% if app_settings['enable_instant_post'] == 1 %} 
            <div class="formField">
                <label for="defTime">POST INTERVAL

            		{% if app_settings['ipri'] != 0 %} 
                        <a href="#"  onclick="return false;" data-toggle="kp_tooltip" data-placement="top" style="float:right" title="Post interval is random, the real interval is between (selected interval and XXX seconds)" > <i class="fa fa-question-circle" aria-hidden="true"></i></a>
           		{% endif  %} 

                </label>
                <select name='defTime' id="defTime" class="form-control">
                	{% set selected = input_post('defTime') %}					
                    
                    {% if user_options['postInterval'] is not empty and input_post('defTime') is not empty %}
                        {% set selected = user_options['postInterval'] %}
                    {% endif %}

                    {% set minInterval = Options.get('min_interval') %}
                    {% set minInterval = settings.min_interval < 5 ? 5 : settings.min_interval %}
                    {% for i in range(minInterval, minInterval+60, 10) %}
                        {% set currentUserInterval = user_options['postInterval'] is not empty ? user_options['postInterval'] : minInterval %}
                        {% if currentUserInterval == i %}
                            <option value='{{ i }}' selected=="selected">{{ i }} {{ l("Sec") }}</option>
                        {% else %}
                            <option value='{{ i }}'>{{ i }} {{ l("Sec") }}</option>
                        {% endif %}
                    {% endfor %}
                    {% for i in range(minInterval+70, minInterval+300, 30) %}
                        {% set currentUserInterval = user_options['postInterval'] is not empty ? user_options['postInterval'] : minInterval %}
                        {% if currentUserInterval == i %}
                            <option value='{{ i }}' selected=="selected">{{ i }} {{ l("Sec") }}</option>
                        {% else %}
                            <option value='{{ i }}'>{{ i }} {{ l("Sec") }}</option>
                        {% endif %}
                    {% endfor %}
                    {% for i in range(minInterval+330, minInterval+1500, 60) %}
                        {% set currentUserInterval = user_options['postInterval'] is not empty ? user_options['postInterval'] : minInterval %}
                        {% if currentUserInterval == i %}
                            <option value='{{ i }}' selected=="selected">{{ i }} {{ l("Sec") }}</option>
                        {% else %}
                            <option value='{{ i }}'>{{ i }} {{ l("Sec") }}</option>
                        {% endif %}
                    {% endfor %}
                
                <option value='1' selected=="selected">1 min</option>
                <option value='5' selected=="selected">5 min</option>
                <option value='10' selected=="selected">10 min</option>
                </select>
            </div>
             {% endif %} !-->
            
            <div class="formField">
            <button type='submit' class='btn btn-primary' id="savepost" name='savepost'>
                    <i class="fas fa-save" aria-hidden="true"></i> Save as draft 
                </button>
                <button onclick="return false;" class='btn btn-primary' id="savepost" name='savepost'>
                    <i class="fas fa-save" aria-hidden="true"></i> Save draft 
                </button>
                <button onclick="return false;" class='btn btn-primary' id="scheduledpost">
                    <i class="fa fa-calendar" aria-hidden="true"></i> Schedule post  
                </button>
                <button onclick="return false;" class='btn btn-primary' id="post" name='post'>
                        <i class="fa fa-paper-plane" aria-hidden="true"></i>Share now
                </button>

           <?php if($queued_post) { ?>
                <div class="controls">
                    <button id="pauseButton" class="btn btn-primary" onclick="postPause()" disabled>
                        <i class="fa fa-pause" aria-hidden="true"></i> PAUSE 
                    </button>
                    
                    <button id="resumeButton" class="btn btn-primary"  onclick="postResume()" disabled>
                        <i class="fa fa-play" aria-hidden="true"></i> RESUME
                    </button>
                </div>
           <?php
           }
           ?> 
             <!--<div class="postingDetails">!-->
            <!--	{% if app_settings['enable_instant_post'] == 1 %}  !-->
            <!--         ELAPSED : <strong><span class="totalPostTime">-</span></strong> | 
                    TIME_LEFT : <strong><span class="leftTime">-</span></strong>
            	{% endif %}   !-->
             <!--</div>!-->
            <!-- 	{% endif %}  
            </div> !-->
            <!-- 	{% include "schedule_posts/schedule_block.twig" %} !-->
            <!-- <div class="row scheduledpost">
                <div class="col-lg-12">
                    <button onclick="return false;" class='btn btn-primary' id="saveScheduledPost" name='scheduledpost'>
                        <i class="fa fa-calendar" aria-hidden="true"></i> SAVE_SCHEDULED_POSTS
                    </button>
                </div> !-->
            </div>
            <div class="preloader"></div>
            <div class="messageBox"></div>
        </div>
    </div>
                </div></div>
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
            <!-- {% include "blocks/ads.twig" %} !-->
            </div>
        </div>
    </div>
    <div class="col-sm-2" style="background-color:grey">GROUPS</div>
    <div class="col-sm-1" style="background-color:light-grey">PAGES</div>
                            </form>

<script type="text/javascript">
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
<div id="mediaLibModalImage" class="modal fade" role="dialog" tabindex="-1" data-backdrop="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Media library</h4>
			</div>
			<div class="modal-body">
				<div id="elfinderImage"></div>
			</div>
		</div>
	</div>
</div>

<div id="mediaLibModalVideo" class="modal fade" role="dialog" tabindex="-1" data-backdrop="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Media library</h4>
			</div>
			<div class="modal-body">
				<div id="elfinderVideo"></div>
			</div>
		</div>
	</div>
</div>

<!-- Save post dialog -->
<div id="postTitleModal" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">POST_TITLE</h4>
			</div>
			<div class="modal-body">
				<div class="messageBoxModal"></div>
				<div class="formField">
					<label class="sr-only" for="postTitle">POST_TITLE</label>
					<input type="text" name='postTitle' id="postTitle" class="form-control" placeholder="POST_TITLE" value="<?php echo $input_post_name ; ?>" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
				<button onclick="return false;" id="savePostModal" class="btn btn-primary">SAVE_POST</button>
			</div>
		</div>
	</div>
</div>

</div>


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
			alertBox('{{l("The status is content is too long, Status background cannot be used with longer than 130 characters.")}}',"danger",false,true);
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
					alertBox('{{l("The status is content is too long, Status background cannot be used with longer than 130 characters.")}}',"danger",false,true,true);
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

 <script src="http://localhost/fbcms/theme/default/js/jsui.js?v=kp272"></script>
  
  <script src="http://localhost/fbcms/theme/default/plugins/select2/select2.min.js"></script>
  <script src="http://localhost/fbcms/theme/default/js/post_form.js"></script>
  <script src="http://localhost/fbcms/theme/default/js/libs/jquery.reel.js"></script>
  <script src="http://localhost/fbcms/theme/default/js/postpreview.js"></script>
  <script src="http://localhost/fbcms/theme/default/js/libs/moment.min.js"></script>
  
  <script src="http://localhost/fbcms/theme/default/js/libs/bootstrap-datetimepicker.min.js"></script>
  <script src="http://localhost/fbcms/theme/default/js/libs/emojionearea.min.js"></script>
  
  <script src="http://localhost/fbcms/vendor/elfinder/js/elfinder.min.js"></script>
  
  <script src="http://localhost/fbcms/theme/default/js/jquery.dataTables.min.js"></script>
  <script src="http://localhost/fbcms/theme/default/js/dataTables.bootstrap.min.js"></script>
  
  <script>

  $(document).ready(function() {$('#nodescategory').select2();});

  
  var groups = []; // List of selected groups
  var TOTALPOSTINGTIME = 0; // in milliseconds
  var leftTime = 0;
  var postingInterval = 0;
  var countGroup = 0;
  var nextGroup = 0;
  var timeDeff = 30000; // default 30 seconds
  var randomInterval = 0;

      $(document).ready(function(){

          kp_preloader("off");

                          var translations = {
                      "lengthMenu": "Display _MENU_ Records per page",
                      "zeroRecords": "No records available",
                      "info": "Showing _START_ to _END_ of _TOTAL_",
                      "infoFiltered": "Filtered from _MAX_ total recods",
                      "search":  "Search",
                      "paginate": {
                          "first": "First",
                          "last": "Last",
                          "next":  "Next",
                          "previous":   "Previous",
                      }
              };

              var groupsDataTable = $('#groupsDataTable').DataTable({
                  "aaSorting": [],
                  "bSort": true,
                  "responsive": true,
                  "aoColumnDefs": [{
                      'bSortable': false,
                      'aTargets': [0]
                  }],
                  "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                  "iDisplayLength": 100,
                  "language": translations,
              });
            
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

      });

      $( "#repeatEvery" ).change(function() {
    if($(this).val() == 0){
      $("#start_on").prop('disabled', true);
      $("#end_on").prop('disabled', true);
    }else{
       $("#start_on").prop('disabled', false);
       $("#end_on").prop('disabled', false);
    }
  });

  $( "#schedulePauseAfter" ).change(function() {
    if($(this).val() == 0){
      $("#scheduleResumeAfter").prop('disabled', true);
    }else{
       $("#scheduleResumeAfter").prop('disabled', false);
    }
  });
 

      // Global variables 
  $(document).ready(function() {
      
      $("#postForm .linkSubFieldsToggle button").click(function(){
          $("#postForm .linkSubFields").stop().toggle('fast');
      });

      $("#postForm .itemPriceFieldsToggle button").click(function(){
          $("#postForm .ItemDetails").stop().toggle('fast');
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

  function getMediaLib(){
      $('#elfinderImage').elfinder({
          url : 'upload/upload_image',
          onlyMimes: ['image'],
          docked: false,
          lang: 'en',
          dialog: { width: 600, modal: true },
          closeOnEditorCallback: true,
          uiOptions: { toolbar : [
              ['home','up'],['mkdir','upload'],['quicklook'],['rm'],['duplicate','rename'],['search'],['view']
          ]},
          getFileCallback: function(data) {
              if($("#URLFrom").val() == "image"){
                  $("#imageURL_"+$("#image_number").val()).val(data.url);
                  $("#imageURL_"+$("#image_number").val()).trigger('propertychange');
              }else{
                  $("#picture").val(data.url);
                  $( "#picture" ).trigger('propertychange');
              }
              $('#mediaLibModalImage').modal('hide');
          }
      }).elfinder('instance');
  }

  function send(){
      var unexpectedPostingError = true;
      var currentGroup = groups[nextGroup];
      POST_IN_PROGRESS = true;
      // update the left time
      var duree = random(parseInt($("#postForm #defTime").val()),parseInt($("#postForm #defTime").val())+randomInterval) * (countGroup-nextGroup);
      TOTALPOSTINGTIME = duree*1000;
      // Clear errors
      $('.postingStatusErrors').html("");
      if(!$('#selectgroup_' + currentGroup).is(":checked")) return false;
      // Get post data
      var params = {};
      params["groupID"] = currentGroup;
      params["postType"] = $("#postForm #postType").val();
      params["csrf_kingposter"] = getCookie('csrf_kingposter_cookie');
      if($.trim($("#postForm #message").val()) != ""){
          params["message"] = $("#postForm #message").val();
      }
      params['fb_preset_id'] =  $("#postForm #fb_preset_id").val();

                  params["image_0"] = $("#postForm #imageURL_0").val();
                  params["image_1"] = $("#postForm #imageURL_1").val();
                  params["image_2"] = $("#postForm #imageURL_2").val();
                  params["image_3"] = $("#postForm #imageURL_3").val();
                  params["image_4"] = $("#postForm #imageURL_4").val();
                  params["image_5"] = $("#postForm #imageURL_5").val();
                  params["image_6"] = $("#postForm #imageURL_6").val();
      params['allow_spherical_photo'] = $('#enable360Image', "#postForm").is(":checked") ? 1 : 0;

      if($("#postForm #postType").val() == "video"){
          if($.trim($("#postForm #video").val()) != ""){
              params["video"] = $("#postForm #video").val();
          }
          if($.trim($("#postForm #video-description").val()) != ""){
              params["description_video"] = $("#postForm #video-description").val();
          }
      }

      params['itemprice'] = $("#postForm #itemprice").val();
      params['itemname'] = $("#postForm #itemname").val();
      
      if($("#postForm #postType").val() == "link"){
          if($.trim($("#postForm #link").val()) != "") 
              params["link"] = $("#postForm #link").val();
          
          if($(".linkSubFields").is(':visible')){
              if($.trim($("#postForm #picture").val()) != "") 
                  params["picture"] = $("#postForm #picture").val(); 
          
              if($.trim($("#postForm #name").val()) != "") 
                  params["name"] = $("#postForm #name").val();
          
              if($.trim($("#postForm #caption").val()) != "") 
                  params["caption"] = $("#postForm #caption").val();
          
              if($.trim($("#postForm #description").val()) != "") 
                  params["description"] = $("#postForm #description").val();
          }
      }
          kp_preloader("on");
          $(".postStatus_"+currentGroup).html("<span class='badge'>Sending post...<span>");
          $.ajax({
              url: 'http://localhost/fbcms/posts/send_post',
              dataType: 'json',
              type: 'post',
              contentType: 'application/x-www-form-urlencoded',
              data: params,
              success: function( data, textStatus, jQxhr ){
                    if(data.status == "success"){
                        $('#'+currentGroup).removeClass('postingError');
                      $('#'+currentGroup).addClass('postingSuccess');
                      $(".postStatus_"+currentGroup).html("<a href='https://www.facebook.com/"+data.id+"' target='_blank'><i class='fa fa-check' aria-hidden='true'></i> View post</a>");
                  }else{
                      $('#'+currentGroup).removeClass('postingSuccess');
                      $('#'+currentGroup).addClass('postingError');
                      htmlData = "";
                      if(data.message !== null && typeof data.message === 'object'){
                          Object.keys(data.message).forEach(function(key) {
                              htmlData += data.message[key]+" ";
                          });
                      }else{
                          htmlData = data.message;
                      }
                      $(".postStatus_"+currentGroup).html("<i class='fa fa-info-circle' aria-hidden='true'></i> "+htmlData);
                  }
              },
              error: function( jqXhr, textStatus, errorThrown ){
                  $('#'+currentGroup).removeClass('postingSuccess');
                  $('#'+currentGroup).addClass('postingError');
                  $(".postStatus_"+currentGroup).html("<i class='fa fa-info-circle' aria-hidden='true'></i> "+textStatus+" : "+errorThrown);
              },
              complete: function(){
                  kp_preloader("off");
              }
          });
  }

  function post(){
      
      timeDeff = random(parseInt($("#postForm #defTime").val()),parseInt($("#postForm #defTime").val())+randomInterval);
      timeDeff = timeDeff*1000;

      // Clear groups, groupCount vars
      groups = [];
      countGroup = 0;
      
      // Get all checked groups
      $('.groupName:visible .fbnode:checked').each(function(){
          groups.push($(this).val());
          countGroup++;
      });

      if(countGroup != 0){
          alertBox('Posting... Please wait',"info","#postForm .messageBox",true);		
          // Set the left time
          var duree = random(parseInt($("#postForm #defTime").val()),parseInt($("#postForm #defTime").val())+randomInterval) * (countGroup-1);
          TOTALPOSTINGTIME = duree*1000;
  
          $(".totalPostTime").html("&sim; "+Math.round(((parseInt($("#postForm #defTime").val())+randomInterval)* (countGroup-1))/60).toFixed(2)+" "+'Minutes');	
          
          startTimer();
          send();
          $(".postingDetails").show();
          postingInterval = setTimeout(posting,timeDeff);
          
      }else{
          alertBox('Please choose a group(s) to post in!',"danger","#postForm .messageBox",true);	
      }
      
  }

  $(document).ready(function() {
      
      var imageCount = $(".multiImages > .input-group").length;

      $(".multiImages").on( 'click', '.mediaLibraryImage', function () {
          $('#mediaLibModalImage').modal('show');
          getMediaLib();
          $("#URLFrom").val("image");
          $("#image_number").val($(this).val());
      });

      $(".multiImages").on( 'click', '.removeImage', function () {
          $(this).parent().remove();
          imageCount--;
          $(".multiImages input").trigger('propertychange');
      });

      $(".addNewImageField").click(function(){
          if(imageCount >= 6 ){
              return false;
          }
          var field = "<div class='input-group'>";
              field += "<input type='text' name='imageURL' class='form-control' id='imageURL_"+imageCount+"' value='' placeholder='Image URL.' />";
              field += "<div class='input-group-btn'>";
              field += "<button type='button' class='btn btn-default mediaLibraryImage' value='"+imageCount+"'>Upload</button>";
              field += "</div><i class='fa fa-times removeImage' aria-hidden='true'></i>";
              field += "</div>";
          $('.multiImages').append(field);
          imageCount++;
          $(".multiImages input").trigger('propertychange');
      });

      $('#mediaLibraryImageLink').click(function(){
          $('#mediaLibModalImage').modal('show');
          getMediaLib();
          $("#URLFrom").val("link");
      });

      $('#mediaLibraryVideo').click(function(){
          $('#mediaLibModalVideo').modal('show');
          var fv = $('#elfinderVideo').elfinder({
              url : 'upload/upload_video',
              onlyMimes: ['video/mp4','video/x-msvideo','video/mp4','video/mpeg','video/3gpp','video/quicktime','video/ogg','video/webm'],
              docked: false,
              lang: 'en',
              dialog: { width: 600, modal: true },
              closeOnEditorCallback: true,
              uiOptions: { toolbar : [
                  // toolbar configuration
                  ['home', 'up'],
                  ['mkdir', 'upload'],
                  ['quicklook'],
                  ['rm'],
                  ['duplicate', 'rename'],
                  ['search'],
                  ['view']
              ]},
              getFileCallback: function(data) {
                  $('#video').val(data.url);
                  $( "#video" ).trigger('propertychange');
                  $('#mediaLibModalVideo').modal('hide');
              }
          }).elfinder('instance');
      });

  });

      $("#postForm #savepost").click(function(){
      if($.trim($("#postForm #message").val()) == "" && $.trim($("#postForm #link").val()) == "" && $.trim($("#postForm #imageURL_0").val()) == "" && $.trim($("#postForm #video").val()) == ""){
          alertBox('The post is empty!',"danger","#postForm .messageBox",true,true);
      }else{
          $('#postTitleModal').modal('show');
      }
  });	

  $("#savePostModal").click(function(){
      if($.trim($("#postTitleModal #postTitle").val()) != ""){
          savePost();
      }else{
          alertBox('Please choose a title for the post.',"danger","#postTitleModal .messageBoxModal",true);
      }
  });

      $("#postForm #updatepost").click(function(){

      if($.trim($("#postForm #message").val()) == "" && $.trim($("#postForm #link").val()) == "" && $.trim($("#postForm #imageURL_0").val()) == "" && $.trim($("#postForm #video").val()) == ""){
          alertBox('The post is empty!',"danger","#postForm .messageBox",true,true);
      }else{
          kp_preloader("on");

          var params = {};

          params['post_id'] = $("#postForm #postId").val();
          params['post_type'] = $("#postForm #postType").val();

          params['post_title'] = $("#postTitleModal #postTitle").val();
          params['post_type'] = $("#postForm #postType").val();
          params['message'] =  $("#postForm #message").val();

          params['fb_preset_id'] =  $("#postForm #fb_preset_id").val();

          params['link'] = $("#postForm #link").val();

                              params["image_0"] = $("#postForm #imageURL_0").val();
                              params["image_1"] = $("#postForm #imageURL_1").val();
                              params["image_2"] = $("#postForm #imageURL_2").val();
                              params["image_3"] = $("#postForm #imageURL_3").val();
                              params["image_4"] = $("#postForm #imageURL_4").val();
                              params["image_5"] = $("#postForm #imageURL_5").val();
                              params["image_6"] = $("#postForm #imageURL_6").val();
          
          params['allow_spherical_photo'] = $('#enable360Image', "#postForm").is(":checked") ? 1 : 0;

          params['itemprice'] = $("#postForm #itemprice").val();
          params['itemname'] = $("#postForm #itemname").val();

          params['video'] = $("#postForm #video").val();
          params['description_video'] = $("#postForm #video-description").val();

          params['csrf_kingposter'] = getCookie('csrf_kingposter_cookie');

          if($(".linkSubFields").is(':visible')){
              params['picture'] = $("#postForm #picture").val();
              params['name'] = $("#postForm #name").val();
              params['caption'] = $("#postForm #caption").val();
              params['description'] = $("#postForm #description").val();
          }

          $.ajax({
              url: 'http://localhost/fbcms/posts/update',
              dataType: 'json',
              type: 'post',
              contentType: 'application/x-www-form-urlencoded',
              data: params,
              success: function( data, textStatus, jQxhr ){
                  if(data.status == "success"){
                      alertBox(data.message,"success",false,true,true);
                  }else{
                      if(data.message !== null && typeof data.message === 'object'){
                          htmlData = "<ul>";
                          Object.keys(data.message).forEach(function(key) {
                              htmlData += "<li>" + data.message[key] + "</li>";
                          });
                          htmlData += "</ul>";
                        }else{
                          htmlData = data.message;
                        }
                        alertBox(htmlData,"danger",false,false,true);
                  }
              },
              error: function( jqXhr, textStatus, errorThrown ){ 
                console.log(errorThrown);
                alertBox("Unable to complete your request","danger",false,true,true);
              },
              complete: function(){
                  kp_preloader("off");
              }
          });
          
      }
  });	

      $("#postForm #saveScheduledPost").click(function(){
      
      // Clear groups, groupCount vars
      groups = [];
      countGroup = 0;
      
      // Get all checked groups
      $('.groupName:visible .fbnode:checked').each(function(){
          groups.push($(this).val());
          countGroup++;
      });

      if($("#postForm #postId").val() == ""){
                      savePost(true);
      }else if(countGroup == 0){
          alertBox("Please choose a group(s) to post in!","danger","#postForm .messageBox",true);	
      }else{
          saveSchedule();
      }
  });


      $('.groupsOptions').on('click','#deleteSelectedNodes', function() {
      nodes = [];
      // Get all checked nodes
      $('.groupName:visible .fbnode:checked').each(function(){
          nodes.push($(this).val());
      });

      $.ajax({
          url: 'http://localhost/fbcms/nodes_categories/remove_nodes',
          dataType: 'json',
          type: 'post',
          contentType: 'application/x-www-form-urlencoded',
          data: { 
              category_id: $("#nodescategory").val(),
              nodes: JSON.stringify(nodes),
              csrf_kingposter: getCookie('csrf_kingposter_cookie') 
          },
          success: function( data, textStatus, jQxhr ){
              if(data.status == "success"){
              for (var i = 0; i < nodes.length; i++ ) {
                  $( "#" + nodes[i] ).css('background','#ffcccc');
                  $( "#" + nodes[i] ).fadeOut(500, function() { $(this).remove(); });
                  }
              }else{
                  alertBox(data.message,"danger",true,true);
              }
          },
          error: function( jqXhr, textStatus, errorThrown ){ 
            console.log(errorThrown);
            alertBox('Unable to complete your request',"danger",true,true);
          }
      });
  });

  var $nodes = [];
  $('.groupsOptions').on('click','#addSelectedNodes', function() {
      // Get all checked nodes
      nodes = [];
      $('.groupName:visible .fbnode:checked').each(function(){
          nodes.push($(this).val());
      });
      // Clear message box
      $(".addCateMsgBoxModal").html("");
      // and finally show the modal
      $( '#addToCategoryModal' ).modal({ show: true });
      return false;
  });

  $('#modalAddCateBtn').click(function() {

      // Clear message box
      $(".addCateMsgBoxModal").html("");

      // Choos category 
      if($('#addToCategoryModal .nodescategory').val() == ""){
          alertBox('Choose a category',"danger",".addCateMsgBoxModal",false);
      }else{

          $("#modalAddCateBtn").prop('disabled', true);

          $.ajax({
              url: 'http://localhost/fbcms/nodes_categories/add_nodes',
              dataType: 'json',
              type: 'post',
              contentType: 'application/x-www-form-urlencoded',
              data: { 
                  category_id: $('#addToCategoryModal .nodescategory').val(),
                  nodes: JSON.stringify(nodes),
                  csrf_kingposter: getCookie('csrf_kingposter_cookie') 
              },
              success: function( data, textStatus, jQxhr ){
                  if(data.status == "success"){
                      alertBox(data.message,"success",".addCateMsgBoxModal",false);
                  }else{
                      if(data.message !== null && typeof data.message === 'object'){
                          htmlData = "<ul>";
                          Object.keys(data.message).forEach(function(key) {
                              htmlData += "<li>" + data.message[key] + "</li>";
                          });
                          htmlData += "</ul>";
                      }else{
                          htmlData = data.message;
                      }
                      alertBox(htmlData,"danger",".addCateMsgBoxModal",false);
                  }
              },
              error: function( jqXhr, textStatus, errorThrown ){ 
                console.log(errorThrown);
                $("#modalAddCateBtn").prop('disabled', true);
                alertBox("Unable to complete your request","danger",".addCateMsgBoxModal",false);
              },
              complete: function(){
                  $("#modalAddCateBtn").prop('disabled', false);
              }
          });

          $("#modalAddCateBtn").prop('disabled', true);
      }
  });


  function startTimer(){
      var h = Math.floor(TOTALPOSTINGTIME / 36e5),
           m = Math.floor((TOTALPOSTINGTIME % 36e5) / 6e4),
           s = Math.floor((TOTALPOSTINGTIME % 6e4) / 1000);
      
      h= (h<10)?"0"+h: h;
      m= (m<10)?"0"+m: m;
      s= (s<10)? "0"+s : s;
      
      $(".leftTime").html("&sim; "+h+":"+m+":"+s);
      TOTALPOSTINGTIME = TOTALPOSTINGTIME - 1000;
          
     if( h==0 && m==0 && s==0 ){
          clearTimeout(leftTime);
          $(".leftTime").html("Done");
          alertBox("Posting completed","success","#postForm .messageBox",true);	
          $("#postForm #post").prop('disabled', false);
      }else{
          $("#postForm #post").prop('disabled', true);
          leftTime = setTimeout(startTimer,1000);
          $("#pauseButton").prop('disabled', false);
          $("#pauseButton").removeClass("btnDisabled");
      }
  }
 
  var xhrGetSiteDetails = null;
  function GetSiteDetails(url,callback){
      if(xhrGetSiteDetails!==null) xhrGetSiteDetails.abort();
      xhrGetSiteDetails = $.ajax({
          url: "http://localhost/fbcms/helpers/get_url_info",
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

          
  function posting() {
      nextGroup++;
      timeDeff = random(parseInt($("#postForm #defTime").val()),parseInt($("#postForm #defTime").val())+randomInterval);
      timeDeff = timeDeff*1000;

      if (nextGroup < countGroup) {
          send();
          postingInterval = setTimeout(posting,timeDeff);
      }else{
          clearTimeout(postingInterval);
          // Reinitial all variables 
          TOTALPOSTINGTIME = 0;
          groups.length = 0;
          leftTime = 0;
          countGroup = 0;
          nextGroup = 0;
          $("#postForm #post").prop('disabled', false);
          $(".postingDetails").hide();
      }
  }

  function random(min,max){
      min = parseInt(min);
      max = parseInt(max);
      return Math.floor(Math.random() * (max - min + 1)) + min;  
  }

  function postPause(){
    clearTimeout(leftTime);
    clearTimeout(postingInterval);
      $("#pauseButton").prop('disabled', true);
      $("#resumeButton").prop('disabled', false);
      $("#pauseButton").addClass("btnDisabled");
      $("#resumeButton").removeClass("btnDisabled");
  }

  function postResume(){
      clearTimeout(leftTime);
        clearTimeout(postingInterval);
        leftTime = setTimeout(startTimer,1000);
       postingInterval = setTimeout(posting,timeDeff);
      
      $("#pauseButton").prop('disabled', false);
      $("#resumeButton").prop('disabled', true);
      $("#pauseButton").removeClass("btnDisabled");
      $("#resumeButton").addClass("btnDisabled");
  }

      function savePost(saveScheduleThen){
      if($.trim($("#postForm #message").val()) == "" && $.trim($("#postForm #link").val()) == "" && $.trim($("#postForm #imageURL_0").val()) == "" && $.trim($("#postForm #video").val()) == ""){
          alertBox('The post is empty!',"danger","#postForm .messageBox",true,true);
          return;
      }

      kp_preloader("on","#postTitleModal .modal-body");
      $("#savePostModal").prop('disabled', true);

      var params = {};

      params['post_title'] = $("#postTitleModal #postTitle").val();
      params['post_type'] = $("#postForm #postType").val();
      params['message'] =  $("#postForm #message").val();

      params['fb_preset_id'] =  $("#postForm #fb_preset_id").val();

      params['link'] = $("#postForm #link").val();

                      params["image_0"] = $("#postForm #imageURL_0").val();
                      params["image_1"] = $("#postForm #imageURL_1").val();
                      params["image_2"] = $("#postForm #imageURL_2").val();
                      params["image_3"] = $("#postForm #imageURL_3").val();
                      params["image_4"] = $("#postForm #imageURL_4").val();
                      params["image_5"] = $("#postForm #imageURL_5").val();
                      params["image_6"] = $("#postForm #imageURL_6").val();
      
      params['allow_spherical_photo'] = $('#enable360Image', "#postForm").is(":checked") ? 1 : 0;

      params['itemprice'] = $("#postForm #itemprice").val();
      params['itemname'] = $("#postForm #itemname").val();

      params['video'] = $("#postForm #video").val();
      params['description_video'] = $("#postForm #video-description").val();

      params['csrf_kingposter'] = getCookie('csrf_kingposter_cookie');

      if($(".linkSubFields").is(':visible')){
          params['picture'] = $("#postForm #picture").val();
          params['name'] = $("#postForm #name").val();
          params['caption'] = $("#postForm #caption").val();
          params['description'] = $("#postForm #description").val();
      }

      $.ajax({
          url: 'http://localhost/fbcms/posts/add',
          dataType: 'json',
          type: 'post',
          contentType: 'application/x-www-form-urlencoded',
          data: params,
          success: function( data, textStatus, jQxhr ){
              if(data.status == "success"){
                  alertBox(data.message,"success","#postTitleModal .messageBoxModal",false,false);
                  $('#postId').val(data.post_id);
                  if(saveScheduleThen === true){
                      saveSchedule();
                  }
              }else{
                  if(data.message !== null && typeof data.message === 'object'){
                      htmlData = "<ul>";
                      Object.keys(data.message).forEach(function(key) {
                          htmlData += "<li>" + data.message[key] + "</li>";
                      });
                      htmlData += "</ul>";
                    }else{
                      htmlData = data.message;
                    }
                    alertBox(htmlData,"danger","#postTitleModal .messageBoxModal",false,false);
              }
          },
          error: function( jqXhr, textStatus, errorThrown ){ 
            console.log(errorThrown);
            alertBox("Unable to complete your request","danger","#postTitleModal .messageBoxModal",false,false);
          },
          complete: function(){
              $("#savePostModal").prop('disabled', false);
              kp_preloader("off","#postTitleModal .modal-body");
          }
      });
  }

      function saveSchedule(){
      // Clear groups, groupCount vars
      groups = [];
      countGroup = 0;
      
      // Get all checked groups
      $('.groupName:visible .fbnode:checked').each(function(){
          groups.push($(this).val());
          countGroup++;
      });

      kp_preloader("on","#postForm .preloader");

      var pi = $("#scheduledPostInterval","#postForm").val();
      var apf = $("#scheduleResumeAfter","#postForm").val();

      var post_interval = $(".schedulePI input[type='radio']:checked","#postForm").val() == "minute" ? pi : pi*60 ;
      var resume_after = $(".autoPause input[type='radio']:checked","#postForm").val() == "minute" ? apf : apf*60 ;
      
      $("#postForm .messageBox").html("");
      
      // Disable save schedule post
      $("#postForm #saveScheduledPost").prop('disabled', true);
          
      $.ajax({
          url: 'http://localhost/fbcms/schedules/action/add',
          dataType: 'json',
          type: 'post',
          contentType: 'application/x-www-form-urlencoded',
          data: {
              run_at: $("#scheduledPostTime","#postForm").val(),
              post_interval: post_interval,
              nodes: JSON.stringify(groups),
              post_id: $("#postForm #postId").val(),
              post_app: $("#scheduledPostApp","#postForm").val(),
              fb_account: $("#scheduledFbAccount","#postForm").val(),
              pause_after: $("#schedulePauseAfter","#postForm").val(),
              resume_after: resume_after,
              
              repeat_every: $("#repeatEvery","#postForm").val(),
                end_on: $("#end_on","#postForm").val(),

              csrf_kingposter: getCookie('csrf_kingposter_cookie') 
          },
          success: function( data, textStatus, jQxhr ){
              if(data.status == "success"){
                  alertBox(data.message,"success","#postForm .messageBox",false);
              }else{
                  if(data.message !== null && typeof data.message === 'object'){
                      htmlData = "<ul>";
                      Object.keys(data.message).forEach(function(key) {
                          htmlData += "<li>" + data.message[key] + "</li>";
                      });
                      htmlData += "</ul>";
                  }else{
                      htmlData = data.message;
                  }
                  alertBox(htmlData,"danger","#postForm .messageBox",false);
              }
          },
          error: function( jqXhr, textStatus, errorThrown ){ 
            console.log(errorThrown);
            alertBox("Unable to complete your request","danger","#postForm .messageBox",false);
          },
          complete: function() {
              // Re-enable save schedule post
              $("#postForm #saveScheduledPost").prop('disabled', false);
              kp_preloader("off","#postForm .preloader");
          }
      });	
  }

  </script>
  

