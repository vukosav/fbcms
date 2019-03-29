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
	<!--<link href="<?=base_url()?>theme/default/plugins/select2/select2.min.css" rel="stylesheet"> -->
    
    <style>
        .addActive {

            background-color: rgba(0, 0, 0, 0.10);
            
            animation-name: example;
            animation-duration: 4s;
        }
        @keyframes example {
            from {background-color: rgba(0, 0, 0, 0.10);}
            to {background-color: rgba(0, 0, 0, 0.30);}
        }

        select#pages_list.form-control.select2,
        select#groups_list.form-control.select2
        {
            padding:2px;
        }

        #addPagesDetails, #addGroupsDetails {
            padding:px;
        }

        .addPagesGroups {
            list-style-type: disc;
            padding: 0px;
            margin: 0px; 
        }
        .addPG {
            margin:2px;
        }
        .addPagesGroups li a {
        padding: 12px !important;
        display: block !important;
        }
        .addPagesGroups li {
        margin: 0px !important;
        padding: 0 !important;
        list-style: none;
        float:left;
        }

        .addPGActive {    
        border-color: #8053F5 !important;
        
        }
        
        .addPagesGroups li a {
        border-top-style: solid;
        border-top-width: 3px;
        border-color: transparent;
        }

        .addPagesGroups li a:hover {
            background-color:  rgba(0, 0, 0, 0.10);
        }

        
    </style>

    <!-- vendor css -->
    
    <link href="<?=base_url()?>theme/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/highlightjs/github.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="<?=base_url()?>theme/lib/select2/css/select2.min.css" rel="stylesheet">
    
    <script src="<?=base_url()?>theme/default/js/jquery.js"></script>
    <script src="<?=base_url()?>theme/default/js/libs/dashboard.min.js"></script>
     <!-- 
    <script type="text/javascript" src="<?=base_url()?>theme/default/bootstrap/js/transition.js"></script>
    <script type="text/javascript" src="<?=base_url()?>theme/default/bootstrap/js/collapse.js"></script>
    -->
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
        <div class="kt-logo"><a href="#">Datadata</a></div>
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
    <!-- <div class="kt-pagetitle">
       <h5>Edit Post</h5>
     </div>   -->
<?php //echo form_open('fb_post/insert_post2','id="edit_post_form_j"'); ?>
<form id="edit_post_form_j" action="">
    <input type="hidden" id = "file_list" name = "file_list" value="<?php echo $input_post_image_list; ?>">
    <input type="hidden" name="postType" id="postType" value="<?php echo $input_post_type; ?>" />
    <input type="hidden" name="post_status" id="post_status" value="<?php echo $post_status; ?>" />
    <input type="hidden" name="postId"   id="postId" value="<?php echo $input_post_id; ?>" />
    <input type="hidden" name="ins_or_upd"   id="ins_or_upd" value="<?php echo $input_ins_or_upd; ?>" />
    <input type="hidden" name="scheduleDateFromDb"   id="scheduleDateFromDb" value="<?php echo $scheduleDateTime; ?>" />
    <input type="hidden" name="URLFrom"  id="URLFrom" value="" />
    <input type="hidden" name="selected_page_id"  id="selected_page_id" value="0" />
    <input type="hidden" name="selected_group_id"  id="selected_group_id" value="0" />
    <input type="hidden" name="videoFileName" id="videoFileName"  value="<?php echo $hidden_post_video_name; ?>"/>
    <input type="hidden" name="can_edit_groups_pages" id="can_edit_groups_pages" value="<?php echo $can_edit_groups_pages; ?>"  />
    
    <div class="container-edit-post" style="padding:10px;width:100%">
    <div class="row container">
         
            <div class="col-sm-9"><h2 class='pull-left'><?php echo $edit_post_title; ?></h2></div>
            <div class="col-sm-3"><h2><?php echo $posting_nums; ?></h2></div>
       
    </div>
    <div class="row container"><h4><?php echo $edit_post_subtitle; ?></h4></div>
    <hr>

    <div class="row">
    
        <div class="col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading" <?php  if( $can_edit_groups_pages=="0") { echo ' style="display:none;" ' ;}; ?>>
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
                            <input type='text' name='link' class="form-control" id="link" value="<?php echo $input_post_link ?>" placeholder="Post link here."
                            <?php  if( $can_edit_groups_pages=="0") { echo ' readonly ' ;}; ?> />
                            <span class="linkError"></span>
                        </div>
                    </div>
        
                    <div id="postImageDetails" <?php if ($input_post_type !== "image" ) {echo 'style="display:none"';}?> >
                        <div class="formField">
                            <label for="imageURL">IMAGE 
                                <a href="#"  onclick="return false;" data-toggle="kp_tooltip" data-placement="top" style="float:right" title="Supportde formats for uplaoded images> jpg, png, bmp."> 
                                <i class="fa fa-question-circle" aria-hidden="true"></i></a>
                            </label>
                            <div  class="dropzone" id="myAwesomeDropzone" data-value="<?php echo $input_post_image_list;?>" 
                            <?php  if( $can_edit_groups_pages=="0") { echo ' style="display:none;" ' ;}; ?> >
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
                                <input type="file" name="videoFile" id="videoFile" class="inputfile" 
                                <?php  if( $can_edit_groups_pages=="0") { echo ' disabled ' ;}; ?>/>
                                <!--<label for="file">Choose a video</label>-->
                                    <input type='text' 
                                           name='video' 
                                           class="form-control" 
                                           id="video" 
                                           value="<?php echo $input_post_video ; ?>" 
                                           placeholder="Video link (3gp, avi, mov, mp4, mpeg, mpeg4, vob, wmv...etc)." 
                                           <?php  if( $can_edit_groups_pages=="0") { echo ' readonly ' ;}; ?>
                                           />
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
                    <button type="button" onclick="SaveAsDraft(event);" class='btn btn-secondary' id="savepost" name='savepost' 
                        <?php  if( $can_save_as_draft=="0") { echo ' style="display: none;" ' ;}; ?>>
                        <span id="spanSaveAsDraft" class="fas fa-save" aria-hidden="true"></span> Save as draft 
                    </button>
                    <!--<button onclick="return false;" class='btn btn-primary' id="savepost" name='savepost'>
                        <i class="fas fa-save" aria-hidden="true"></i> Save draft 
                    </button>-->
                    <button type="button" onclick="SaveAsQueued(event);" class='btn btn-primary' id="qpost"name='qpost' >
                        <span id="spanSaveAsQueued"class="fa fa-calendar" aria-hidden="true"></span> Save post  
                    </button>
                    <button type="button" onclick="SendPostToFB(event);" class='btn btn-primary' id="post" name='post' style = "display : none;">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>Share now
                    </button>
                    <button type="button" onclick="CancelEdit('<?php echo $this->uri->segment(3); ?>');" class='btn btn-secondary' id="cancel_edit_post" name='cancel_edit_post'>
                        <span id="spanCancelEdit" class="fas fa-save" aria-hidden="true"></span> Cancel
                    </button>              
                </div>
                <div class="preloader"></div>
                <div class="messageBox"></div>
            </div>

              
        
        
           
   
        
        
        
        
        
        </div>

        <div class="col-sm-4">
        <div class="row">    
                <div class='col-sm-4'>Schedule post</div>
                 
                       <div class='col-sm-8'>
                          
                          <div class="form-group">
                              <div class='input-group date' id='datetimepicker1'>
                                  <input type='text' class="form-control" id="schedule_date_time" name="schedule_date_time" 
                                  <?php  if( $can_edit_groups_pages=="0") { echo ' readonly ' ;}; ?> />
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                              </div>
                          </div>
                       </div>
                       <div class='col-sm-12'>User timezone: <?php echo $timezone; ?></div>
                </div>
                
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
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="addPagesGroups">
                        <li>
                        <a href="#" onclick="return false;" class="addPages addPGActive">
                        <i class="fa fa-file" aria-hidden="true"></i>
                            <span class="hidden-xs hidden-sm hidden-md">AddPages</span>
                        </a>
                        </li>

                        <li>
                        <a href="#" onclick="return false;"  class="addGroups">
                        <i class="fa fa-th" aria-hidden="true"></i>
                            <span class="hidden-xs hidden-sm hidden-md">AddGroups</span>
                        </a>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div id="addPagesDetails">
                    <select class="form-control select2" id="pages_list" name="pages_list" data-placeholder="Choose Page"
                    <?php  if( $can_edit_groups_pages=="0") { echo ' disabled ' ;}; ?>>
                        <option value="0">Add Page</option>
                         <?php  
                            $numofpages = count( $user_pages);
                            $last= $numofpages-1;
                            for ($i = 0; $i <=  $last; $i++) {
                                    echo '<option id="' . $user_pages[$i]['id'] . '" value="' . $user_pages[$i]['fbPageName'] .'">' . $user_pages[$i]['fbPageName'] . '</option>';
                                }
                        ?>
                        
                    </select>
                    <div id="selPages"></div>
                        <br>
                        <?php  
                          /* $numofpages = count( $user_pages);
                            $last= $numofpages-1;
                            for ($i = 0; $i <=  $last; $i++) {
                               
                                echo '<div class="addPG" id="page-'. $user_pages[$i]['id'] . '" style="border: 1px solid grey; border-radius:5px; position: relative; display:none;" >';
                                echo  '<div style="display:inline-block;" width="50px;"> ' . $user_pages[$i]['id'] . '  ' . $user_pages[$i]['fbPageName'];
                                echo '</div><a href="#" onclick="RemovePage(' . $user_pages[$i]["id"] . ')">' 

                                     . '<i class="fa fa-times-circle-o" style="position: absolute; top:0; right:0;" aria-hidden="true"></i>
                                           
                                    </a>';
                                echo '</div>' ;
    
                            }
                            */
                            //temp preview of selected paegs from db
                            if($input_post_id>0){
                            $num_selected = count( $selected_page_id);
                            //$last= $num_selected-1;
                           // echo '<div><br>SELECTED PAGES FROM DB </div>';
                               // for ($i = 0; $i <  $num_selected; $i++) {
                                //   $id = $selected_page_id[$i]['pageId'];
                                 //  $name =  $selected_page_id[$i]['fbPageName'];
                                   /* echo '<div class="addPG" id="page-'. $selected_page_id[$i]['pageId'] . '" style="border: 1px solid grey; border-radius:5px; position: relative; " >';
                                    echo  '<div style="display:inline-block;" width="50px;"> ' . $selected_page_id[$i]['pageId'] . '  ' . $selected_page_id[$i]['fbPageName'];
                                    echo '</div><a href="#" onclick="RemovePage(' . $selected_page_id[$i]["pageId"] . ')">' 

                                        . '<i class="fa fa-times-circle-o" style="position: absolute; top:0; right:0;" aria-hidden="true"></i>
                                            
                                        </a>';
                                    echo '</div>' ;
                                     */
                               // }
                                   $js_array =json_encode($selected_page_id);
                                   $script = '<script>var pageArrayFromDB = ' . $js_array . ';</script>';
                                   echo $script;

                                   $js_group_array  =json_encode( $selected_post_groups);
                                 $script_g = '<script>var groupArrayFromDB = ' . $js_group_array . ';</script>';
                                 echo $script_g;
                                   if($input_post_type == "video"){
                                    $script_v = '<script>  $(document).ready(function() {videoPostPreview();});</script>';
                                    echo $script_v;
                                   }

                            }
                        ?>
                </div>
                                   
                <div id="addGroupsDetails" style="display:none">
                    <select class="form-control select2" id="groups_list" name="groups_list" data-placeholder="Choose Group"
                    <?php  if( $can_edit_groups_pages=="0") { echo ' disabled ' ;}; ?>>
                        <option value="0">Add Group</option>
                         <?php  
                            $numofgroups = count( $user_groups);
                            $last= $numofgroups-1;
                            for ($i = 0; $i <=  $last; $i++) {
                                    echo '<option id="' . $user_groups[$i]['id'] . '" value="' . $user_groups[$i]['name'] .'">' . $user_groups[$i]['name'] . '</option>';
                                }
                        ?>
                     </select>
                        <br>
                        <?php  
                                 $js_array  =json_encode( $user_groups);
                                 $script = '<script>var groupArrayNom = ' . $js_array . ';</script>';
                                 echo $script;
                            // var_dump($user_groups); 
                            // $groups2 = array();
                            // for ($i = 0; $i < count( $user_groups); $i++) {
                            // $group = $user_groups[$i];
                            //     $page_array =json_encode( $group['pages']);
                            //     $group_id = $group['id'];
                            //     $group_name =  $group['name'];
                            //     $script = '<script>var pageArrayFromDB = ' . $js_array . ';</script>';
                            //     echo $script;
                                // echo '<div class="addPG addActive" id="group-'. $user_groups[$i]['id'] . 
                                // '" style="border: 1px solid rgba(0, 0, 0, 0.20);; border-radius:5px; position: relative; display:none;" >';
                                // echo  '<div style="display:inline-block;" width="50px;"> ' . $user_groups[$i]['id'] . '  ' . $user_groups[$i]['name'];
                                // echo '</div><a href="#" onclick="RemoveGroup(' . $user_groups[$i]["id"] . ')">' 
                                //      . '<i class="fa fa-times-circle-o" style="position: absolute; top:0; right:0;" aria-hidden="true"></i>
                                //      </a>';
                                // echo '</div>' ;
    
                            //}
                        ?>
                        <div id = "selGroups"></div>
                  </div>
               

            </div><!-- panel-default --> 
            <p id = "validation_selected_page_message" style = "color:red; display: none;">You have not selected page to post on-panel</p>
        </div> <!-- col-sm-3-->  
    </div> <!-- row -->  
                        



    </div><!-- container -->
</form>

<div class="kt-footer">
<!-- <span>Copyright &copy;. All Rights Reserved. </span>
<span>Created by: ThemePixels, Inc.</span> -->
</div><!-- kt-footer -->
</div><!-- kt-mainpanel -->

<script type="text/javascript">

    var arrayGroups =new Array(); 
    var arrayPages =new Array();  
    function GeneratePageList(){
        guideList = document.getElementById("selPages");
        var canEdit=document.getElementById("can_edit_groups_pages").value;
        if (arrayPages.length) {
            let html = '';
            arrayPages.forEach(page => {  
                const li1 = `
                    <div class="addPG" id="page-'${page.id}'" style="border: 1px solid grey; border-radius:5px; position: relative;" > 
                    <div style="display:inline-block;" width="50px;">${page.name}</div>`;
                var li2 = '';   
                if(canEdit === '1') {
                         li2 = `<a href="#" onclick="RemovePage(${page.id})">
                            <i class="fa fa-times-circle-o" style="position: absolute; top:0; right:0;" aria-hidden="true"></i>
                                </a>`;
                } 
                const li3 = `</div>`;
                var li = li1 + li2 +li3;
       
        html += li;
      });
      console.log("html", html);
      guideList.innerHTML = html
    } else {
      guideList.innerHTML = '<h5 class="center-align">No selected pages</h5>';
    }
    }
    function GenerateGroupList(){
        guideList = document.getElementById("selGroups");
        var canEdit=document.getElementById("can_edit_groups_pages").value;
        if (arrayGroups.length) {
            let html = '';
            arrayGroups.forEach(group => { 
                 var innerLi = ``;
                 if(group.pages!=null && group.pages.length > 0){
                    group.pages.forEach(page => { 
                        innerLi = innerLi + ` <p>${page.fbPageName} </p> `;
                    });
                }
                 const li1 = `
                 <div class="panel-group">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                            <a data-toggle="collapse" href="#collapse${group.id}">${group.name}`
                  var li2 = '';
                  if(canEdit === '1') {
                         li2 = `<i onclick="RemoveGroup(${group.id})" class="fa fa-times-circle-o" style="position: absolute; top:0; right:0;" ></i>`;
                       }       
                  const li3  = `</a>
                            </h4>
                        </div>
                        <div id="collapse${group.id}" class="panel-collapse collapse">
                            <div class="panel-body"> 
                                       ${innerLi}
                            </div>
                        </div>
                    </div>
                    </div>
                 `;
            html += li1 + li2 + li3;
      });
     // console.log("html", html);
      guideList.innerHTML = html
    } else {
      guideList.innerHTML = '<h5 class="center-align">No selected groups</h5>';
    }
    }
    function listPages(){
       // event.preventDefault();
        var ep = document.getElementById("pages_list");
            if(ep.selectedIndex > 0){
                var page_id=ep.options[ep.selectedIndex].id;
                var page_name=ep.options[ep.selectedIndex].value;
                console.log('page_id',page_id);
                console.log('page_name',page_name);
                //document.getElementById("page-" + page_id).style.display = "block";
                
               // var index = arrayPages.indexOf(page_id.toString());
               console.log('arrayPages before',arrayPages);
                if (arrayPages.filter(function(e) { return e.id === page_id; }).length == 0) {
                    arrayPages.push({ id: page_id, name: page_name});
                   
                }
                console.log('arrayPages after',arrayPages);
                // if (index == -1) {
                //     arrayPages.push(page_id);
                // }
                    ep.selectedIndex=0;
                    GeneratePageList();
                }
            }
    document.getElementById("pages_list").addEventListener("click",listPages);

    function listGroups(){            
                event.preventDefault();
                var eg = document.getElementById("groups_list");
                if(eg.selectedIndex > 0){
                              
                    var group_id=eg.options[eg.selectedIndex].id;
                    var  group_name=eg.options[eg.selectedIndex].value;
                  //  console.log('group_id', group_id);
                  //  console.log('group_name', group_name);
                    console.log('groupArrayNom', groupArrayNom.filter(function(e) { return e.id === group_id; })[0]);
                   // document.getElementById("group-" + group_id).style.display = "block";
                   if (groupArrayNom.filter(function(e) { return e.id === group_id; }).length > 0) {
                        
                        arrayGroups.push(groupArrayNom.filter(function(e) { return e.id === group_id; })[0] ); 
                     }

                   //  console.log('arrayGroups', arrayGroups);
                   // var index = arrayGroups.indexOf(group_id.toString());
                        
                   // if (index == -1) {
                   // arrayGroups.push(group_id);
                   // }
                   
                   // console.log('add group id ' + arrayGroups);
                    
                    //document.getElementById("group-" + group_id).addClass("activePG");
                    // $("#group-" + group_id + " .addPG").addClass("activePG");
                        
                    // document.getElementById("group-" + e.options[e.selectedIndex].id).style.display = "block";
                        //add page in list  ("li #id").value($id)

                    //  document.getElementById("selected_group").value=e.options[e.selectedIndex].value;
                    // document.getElementById("selected_group_id").value=e.options[e.selectedIndex].id;
                    eg.selectedIndex=0;
                    GenerateGroupList();
                }
            }  
            document.getElementById("groups_list").addEventListener("click",listGroups);
        
    function RemovePage(page_id){
            //document.getElementById("page-" + page_id).style.display = "none";
           // var index = arrayPages.indexOf(page_id.toString())
           // console.log('page_id ',page_id);  
          //  console.log('index ',arrayPages.findIndex(v => v.id === page_id.toString()));  
          //  console.log('index2 ',index);  
            arrayPages.splice(arrayPages.findIndex(v => v.id === page_id.toString()), 1);
          
           // var index = arrayPages.indexOf(page_id.toString());
           GeneratePageList();
            //if (index > -1) {
           //     arrayPages.splice(index, 1);
           // } 
    }
    
    function RemoveGroup(group_id){
            //document.getElementById("group-" + group_id).style.display = "none";
           // console.log('array groups before remove group id ' + arrayGroups);
           // var index = arrayGroups.indexOf(group_id.toString());
            //console.log('groupid: ' + group_id);
           // console.log('index ' + index);
            
           // if (index > -1) {
             //   arrayGroups.splice(index, 1);
                
              //console.log('array groups after remove groupid ' + arrayGroups);
            //  console.log('arrayGroups before',arrayGroups);
              arrayGroups.splice(arrayGroups.findIndex(v => v.id === group_id.toString()), 1);
             // console.log('arrayGroups after',arrayGroups);
              GenerateGroupList();
            } 
       

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
function SaveAsQueued(event){

       const form = document.querySelector('#edit_post_form_j');

       event.preventDefault();

       if($('#spanSaveAsQueued').hasClass('fa-calendar')){
            $('#spanSaveAsQueued').removeClass('fa-calendar');
            $('#spanSaveAsQueued').addClass('fa-refresh');
            $('#spanSaveAsQueued').addClass('fa-spin');
        } else {
            return;
        }


       document.querySelector('#post_status').value=2; //queued
       
       document.querySelector('#selected_group_id').value=arrayGroups;
       document.querySelector('#selected_page_id').value=arrayPages;

       const schedule_date_time = document.querySelector('#schedule_date_time');

      // console.log('schedule_date_time ',schedule_date_time.value);

        
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
        var page_count = arrayPages.length;
        var page_in_group_count = 0; 
        arrayGroups.forEach(group => { 
            if(group.pages != null){
                page_in_group_count = page_in_group_count+ group.pages.length;
                }
            });
        var total_page_count = page_count + page_in_group_count;  
        if(total_page_count == 0){
           document.querySelector('#validation_selected_page_message').style.display = "block";
           valid = false;
         }
         else{
            document.querySelector('#validation_selected_page_message').style.display = "none";
           valid = true;
         }
         formData.append('ins_or_upd', document.querySelector('#ins_or_upd').value);
          
            var postType;
            var videoFileName;
            var video;
            var file_list;
            formData.forEach(function(value, key){
            if(key === "postType"){
                postType = value;
            }
            else if(key === "videoFileName"){
                    videoFileName = value;
                }
           else if(key === "video"){  
                    video = value;
             }
             else if(key === "file_list"){  
                file_list = value;
             }
           });
          // console.log('videoFileName',videoFileName);
          // console.log('video',video);
           if(postType === "video"){
               if(videoFileName === null || videoFileName === ""){
                   valid = false;
                    Swal.fire({
                            title: "Error", 
                            text:"Please, wait video file upload!",  
                            confirmButtonText: "OK", 
                        });
                         
               }
               else if(video === null || video === ""){
                    valid = false;
                    Swal.fire({
                                title: "Error", 
                                text:"Please, wait video file upload!",  
                                confirmButtonText: "OK", 
                            });
                   
               }
           }
           if(postType === "image"){
               if(file_list === null || file_list === ""){
                   valid = false;
                    Swal.fire({
                            title: "Error", 
                            text:"Please, add at least one image!",  
                            confirmButtonText: "OK", 
                        });
                         
               }
           }

           if(document.querySelector('#schedule_date_time').value){
               const scheduleD = moment(document.querySelector('#schedule_date_time').value);
               if(scheduleD.diff(Date.now(),'month',true)>=6){
                   valid = false;
                   Swal.fire({
                            title: "Validation", 
                            text:"Please, select other schedule time! It must be less than 6 months from now.",  
                            confirmButtonText: "OK", 
                        });
               }
               else if(scheduleD.diff(Date.now(),'minutes',true)<=20){
                   valid = false;
                   Swal.fire({
                            title: "Validation", 
                            text:"Please, select other schedule time! It must be greater than 10 minutes from now.",  
                            confirmButtonText: "OK", 
                        });
               }
           }
           if(!valid){
                    $('#spanSaveAsQueued').removeClass('fa-refresh');
                    $('#spanSaveAsQueued').removeClass('fa-spin'); 
                    $('#spanSaveAsQueued').addClass('fa-calendar');
            }
    if(valid){
        formData.append("arrayPages", JSON.stringify(arrayPages));
        formData.append("arrayGroups", JSON.stringify(arrayGroups));
        var object = {};
        formData.forEach(function(value, key){
            object[key] = value;
        });
      //  console.log('arrayGroups',JSON.stringify(arrayGroups));
      //  console.log('arrayPages',JSON.stringify(arrayPages));
       console.log('formData',JSON.stringify(object));

     $.ajax({
        url:'<?=base_url()?>FB_post/insert_post',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data){
            console.log('data',data);
            var dataJ = jQuery.parseJSON (data);
            console.log('dataJ',dataJ);
            if(!dataJ.error){
               // document.querySelector("#post").style.display = "block";
               // document.querySelector("#savepost").style.display = "none";
               // console.log('dataJ',dataJ);
               // document.querySelector("#postId").value = dataJ.id;
               window.location.replace('<?=base_url()?>posting/1');
            }
            else{
               // alert('alert dataJ ' +dataJ.message);
                console.log('dataJ.error je true', JSON.stringify(dataJ));
                Swal.fire({
                    title: "Error", 
                    html: dataJ.message,  
                    confirmButtonText: "Confirm", 
                    });
                $('#spanSaveAsQueued').removeClass('fa-refresh');
                $('#spanSaveAsQueued').removeClass('fa-spin'); 
                $('#spanSaveAsQueued').addClass('fa-calendar');
            }
        },
        error:function(e){
           
          // console.log('error kod insert_post', JSON.stringify(e).responseText);
           Swal.fire({
                    title: "Error", 
                    html: e.responseText,  
                    confirmButtonText: "Confirm", 
                    });
                    $('#spanSaveAsQueued').removeClass('fa-refresh');
                    $('#spanSaveAsQueued').removeClass('fa-spin'); 
                    $('#spanSaveAsQueued').addClass('fa-calendar');
        }

      });
      }

    }


function SaveAsDraft(event){
   
    event.preventDefault();
    if($('#spanSaveAsDraft').hasClass('fa-save')){
        $('#spanSaveAsDraft').removeClass('fa-save');
        $('#spanSaveAsDraft').addClass('fa-refresh');
        $('#spanSaveAsDraft').addClass('fa-spin');
    } else {
        return;
    }
    document.querySelector('#post_status').value=1;//draft
   
    const form = document.querySelector('#edit_post_form_j');

    const postTitle = document.querySelector('#postTitle');
    const message = document.querySelector('#message');
    //const pages_list = document.querySelector('#pages_list');
   //const schedule_date_time = document.querySelector('#schedule_date_time');

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
   
     
         formData.append('ins_or_upd', document.querySelector('#ins_or_upd').value);
     
        formData.append("arrayPages", JSON.stringify(arrayPages));
        formData.append("arrayGroups", JSON.stringify(arrayGroups)); 


     //   var object = {};
//formData.forEach(function(value, key){
   // object[key] = value;
//});
//var json = JSON.stringify(object);

//console.log('formData', json);

            var postType;
            var videoFileName;
            var video;
            var file_list;
            formData.forEach(function(value, key){
            if(key === "postType"){
                postType = value;
            }
            else if(key === "videoFileName"){
                    videoFileName = value;
                }
           else if(key === "video"){  
                    video = value;
             }
             else if(key === "file_list"){  
                file_list = value;
             }
           });
          // console.log('videoFileName',videoFileName);
         ///  console.log('video',video);
           if(postType === "video"){
               if(videoFileName === null || videoFileName === ""){
                   valid = false;
                    Swal.fire({
                            title: "Error", 
                            text:"Please, wait video file upload!",  
                            confirmButtonText: "OK", 
                        });
                         
               }
               else if(video === null || video === ""){
                    valid = false;
                    Swal.fire({
                                title: "Error", 
                                text:"Please, wait video file upload!",  
                                confirmButtonText: "OK", 
                            });
                   
               }
           }
           if(postType === "image"){
               if(file_list === null || file_list === ""){
                   valid = false;
                    Swal.fire({
                            title: "Error", 
                            text:"Please, add at least one image!",  
                            confirmButtonText: "OK", 
                        });
                         
               }
           }

           if(document.querySelector('#schedule_date_time').value){
               const scheduleD = moment(document.querySelector('#schedule_date_time').value);
               if(scheduleD.diff(Date.now(),'month',true)>=6){
                   valid = false;
                   Swal.fire({
                            title: "Validation", 
                            text:"Please, select other schedule time! It must be less than 6 months from now.",  
                            confirmButtonText: "OK", 
                        });
               }
               else if(scheduleD.diff(Date.now(),'minutes',true)<=20){
                   valid = false;
                   Swal.fire({
                            title: "Validation", 
                            text:"Please, select other schedule time! It must be greater than 10 minutes from now.",  
                            confirmButtonText: "OK", 
                        });
               }
           }
     if(!valid){
       
        $('#spanSaveAsDraft').removeClass('fa-refresh');
        $('#spanSaveAsDraft').removeClass('fa-spin'); 
        $('#spanSaveAsDraft').addClass('fa-save');
     }
    if(valid){

    $.ajax({
        url:'<?=base_url()?>FB_post/insert_post',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data){
           // console.log('data',data);
            var dataJ = jQuery.parseJSON (data);
          //  console.log('dataJ',dataJ);
            if(!dataJ.error){
                //document.querySelector("#post").style.display = "block";
               //document.querySelector("#savepost").style.display = "none";
                //console.log('id generisanog posta',dataJ.id);
                //document.querySelector("#postId").value = dataJ.id;
                window.location.replace('<?=base_url()?>posting/2');
            }
            else{
               // alert('alert dataJ 2 ' + dataJ.message);
               // console.log('dataJ.error je true', JSON.stringify(dataJ));
               Swal.fire({
                    title: "Error", 
                    html: dataJ.message,  
                    confirmButtonText: "Confirm", 
                    });
                $('#spanSaveAsDraft').removeClass('fa-refresh');
                $('#spanSaveAsDraft').removeClass('fa-spin'); 
                $('#spanSaveAsDraft').addClass('fa-save');
            }
        },
        error:function(e){
            //alert('alert dataJ 2 eeeee' + e);
            //console.log('error', JSON.stringify(e));
            Swal.fire({
                    title: "Error", 
                    html: e.responseText,  
                    confirmButtonText: "Confirm", 
                    });
                    $('#spanSaveAsDraft').removeClass('fa-refresh');
                    $('#spanSaveAsDraft').removeClass('fa-spin'); 
                    $('#spanSaveAsDraft').addClass('fa-save');
        }

      });
      }
}

 
function CancelEdit(postingType){
     
    const id = document.querySelector("#postId").value;
    //console.log("id", id);
    console.log("postingType", postingType);

    if($('#spanCancelEdit').hasClass('fa-save')){
        $('#spanCancelEdit').removeClass('fa-save');
        $('#spanCancelEdit').addClass('fa-refresh');
        $('#spanCancelEdit').addClass('fa-spin');
    } else {
        return;
    }
    if(postingType == null || postingType === ''){
        postingType = 1;
    }
    $.ajax({
        url:'<?=base_url()?>cancel_edit/'+id,
        type: 'POST',
       // postId: id,
        processData: false,
        contentType: false, 
        success: function(data){
            window.location.replace('<?=base_url()?>posting/' +postingType);
        },
        error:function(e){ 
            Swal.fire({
                    title: "Error", 
                    html: e.responseText,  
                    confirmButtonText: "Confirm", 
                    }); 
        }
      });
    }

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
                        alertBox("Invalid Youtube video link","danger",false,true,true);
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
                alert('alert 1 ' + dataJ.message);
            }
            videoPostPreview();
        }

    });
}

  


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
        if( typeof pageArrayFromDB  !=='undefined' && pageArrayFromDB!==null){ 
            pageArrayFromDB.forEach(pageFromDB => { 
                arrayPages.push({id: pageFromDB.pageId, name: pageFromDB.fbPageName});
            }); 
            GeneratePageList(); 
        }
        if( typeof groupArrayFromDB  !=='undefined' && groupArrayFromDB !== null){ 
             groupArrayFromDB.forEach(groupFromDB => { 
                    arrayGroups.push(groupFromDB);
             }); 
            GenerateGroupList();
        }
        console.log('scheduleDateFromDb',document.querySelector("#scheduleDateFromDb").value);
        var scheduleDTFromDb =document.querySelector("#scheduleDateFromDb").value;

        if(scheduleDTFromDb != null && scheduleDTFromDb != ''){
           var dateDT = moment(scheduleDTFromDb).toDate();
            $('#datetimepicker1').datetimepicker({
                defaultDate: dateDT
            });
            } else{
                $('#datetimepicker1').datetimepicker();
            }
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

<script src="<?=base_url()?>theme/js/moment.min.js"></script>
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
