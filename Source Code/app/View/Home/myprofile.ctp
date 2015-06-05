<?php /*echo $setSpecalistArrURL['Admin']['rssurl']; 
echo "Test";
			 die(); */
?>
<?php
/*echo '<pre>';
print_r($setSpecalistArr);
//print_r($certifications);
echo '</pre>';*/
 //print_r($this->params);
 
 

$logo=$config['url'].'images/avtar.png';
$website_logo=$config['url'].'images/logo.png';
if(isset($setSpecalistArr[$dbusertype]['id']))
{
	
$utype=$dbusertype;


  if($utype=='Club' || $utype=='Trainer')
  {
  	if($setSpecalistArr[$utype]['logo']!='')
  	{
  		$logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['logo'];
  	}
  	if($setSpecalistArr[$utype]['website_logo']!='')
  	{
  		$website_logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['website_logo'];
  	}
  	
  	$uname=$setSpecalistArr[$utype]['full_name'];
  	
  }
  elseif($utype=='Trainee')
  {
  	
  	if($setSpecalistArr[$utype]['photo']!='')
  	{
  		$logo=$config['url'].'uploads/'.$setSpecalistArr[$utype]['photo'];
  	}
  	$uname=$setSpecalistArr[$utype]['full_name'];
  }
  if($utype=='Corporation')
  {
  	$uname=$setSpecalistArr[$utype]['company_name'];
  }	
	
}

?>
<script>
function validuppic()
{
	var pic=$('#TrainerLogo').val();
	if(pic=='')
	{
		alert('Please select the photo');
		return false;
	}
	else
	{
		return true;
	}
	
}


function validcuppic()
{
	var pic=$('#<?php echo $this->Session->read('UTYPE');?>Cpic').val();
	if(pic=='')
	{
		alert('Please select the Cover photo');
		return false;
	}
	else
	{
		return true;
	}
	
}


function editstatus(str)
{
	//alert(str);
	var editsecHtml='<textarea name="userfb_status" id="userfb_statusid"></textarea><input type="button" name="submit" value="Save" onclick="saveedit('+str+');" class="change-pic-nav" style="width:50px;"/><input type="button" name="cancel" class="change-pic-nav" style="width:58px;margin-left:10px;" onclick="canceledit('+str+');" value="Cancel"/>';
	$('#userfb_status').html(editsecHtml);
	
}
function saveedit(str2)
{
	var sthtml=$('#userfb_statusid').val();
	//alert(sthtml);
	 $.post("<?php echo $config['url'];?>home/userfbstatus", {userfb_status: sthtml, id: str2}, function(data)
            {
            	if(data==1)
            	{
            		$('#userfb_status').html('<a href="javascript:void(0);" onclick="editstatus('+str2+');" style="color:#fff;">'+sthtml+'<a>');
            	}
            	else
            	{
            		$('#userfb_status').html('<a href="javascript:void(0);" onclick="editstatus('+str2+');" style="color:#fff;">Set your current status, click here!!!</a>');
            	}
            });
}
function canceledit(str3)
{
	
	 $.post("<?php echo $config['url'];?>home/userfbstatusget", {id: str3}, function(data)
	 {
	 	if(data!='')
	 	{
	 		$('#userfb_status').html('<a href="javascript:void(0);" onclick="editstatus('+str3+');" style="color:#fff;">'+data+'</a>');
	 	}
	 	else
	 	{
	 		$('#userfb_status').html('<a href="javascript:void(0);" onclick="editstatus('+str3+');" style="color:#fff;">Set your current status, click here!!!</a>');
	 	}
	 });
	
}

function newcorporation()
{
	
	//document.location.href="<?php echo $config['url'];?>home/manage_certifications/";
	
	document.location.href="<?php echo $config['url'];?>home/addcertification_trainer/";
}




function editprofile()
{
	
	document.location.href="<?php echo $config['url'];?>home/editprofile/";
}
function newevent()
{
  document.location.href="<?php echo $config['url'];?>home/addevent/";
}
function deleteevent(str)
{
	if(str)
	{
		 var website_url ='<?php echo $config['url'];?>home/deleteevent';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "eventid="+str,							
		   		success: function(msg)
					{						
						alert(msg);
						$('#ev_'+str).css('display','none');
					}
				});	
		
	}
	
}

function deletecertifytrainer(str)
{
	if(str!='')
	{
		if(confirm("Are you sure, you want to delete this Certification Trainer?"))
		{
	         	$.ajax({
				url:"<?php echo $config['url'];?>home/deletecertifytrainer/",
				type:"POST",
				data:{id:str},
				success:function(e) {
					var response = eval(' ( '+e+' ) ');
					if( response.responseclassName == "nSuccess" ) {
						alert(response.errorMsg);
						document.location.href=document.location.href;
						
					}
					else
					{
							alert(response.errorMsg);
						
					}
				}
		      });
		}
	}
}



</script>

<!-- bxSlider Javascript file -->
<script src="<?php echo $config['url'];?>js/jquery.bxslider.min.js"></script>
<!-- bxSlider CSS file -->
<link href="<?php echo $config['url'];?>css/front/jquery.bxslider.css" rel="stylesheet" />
<script>
$(document).ready(function(){
  $('.bxslider').bxSlider({
  captions: true,
  touchEnabled:true,
  autoControls:true,
  autoControlsCombine:true,
  auto:true,
  autoStart:true
  }
  );
});
</script>
<style>
<?php if($setSpecalistArr[$utype]['cpic']!=''){?>
.inside-banner{ background: url("<?php echo $config['url'];?>uploads/<?php echo $setSpecalistArr[$utype]['cpic'];?>") no-repeat scroll 0 0 / cover rgba(0, 0, 0, 0);}
<?php }?>
.middle_section .six, .row .six {
    width: 55%;
}
.profile-pic{margin:-257px 0 30px 2px;}
.profile-navigation li a span {text-align:left;}

.profile-navigation a{border-bottom:none;}

h5 {
    font-size: 16px;
    text-align: center;
}
</style>
<section class="contentContainer clearfix">
    <div class="inside-banner changecover-pic">
    <!--<div class="change-coverpic" onclick="popupOpen('pop5');"><img src="<?php //echo $config['url'];?>images/pencial_icon.png" /> Change Cover </div>-->
      <div class="row">
        <div class="eight inside-head offset-by-four columns">
        <!--button add area section---------------->
		    <div class="top_btn_area">
			     <a href="javascript:void(0);"class="btn_01" onclick="popupOpen('pop555');">Testimonials</a>
                 <a href="javascript:void(0);" class="btn_01" onclick="popupOpen('pop556');">Classes & Events</a>
                			 
			</div>
		<!--button add area section---------------->
          <h2 class="client-name"><?php echo $uname;?></h2>
          <h3 class="client-details">from <?php echo $setSpecalistArr[$utype]['city'].', '. $setSpecalistArr[$utype]['state'];?></h3>
          <p class="client-discription" id="userfb_status"><?php if($setSpecalistArr[$utype]['userfb_status']!=''){ echo $setSpecalistArr[$utype]['userfb_status'];}?></p>
        </div>
      </div>
    </div>
    <div class="row">
     <!--middle section start here--------------------->
	   <div class="middle_section">
     <?php echo $this->element('publictrainer');?>
       <div class="six inside-head columns">
         <div class="banner_area">
		      
			  <h2 class="heading_text"></h2>
			 
		      <div class="articla_area">
		      <?php if(!empty($galleries))
		      { 
		      	echo '<ul class="bxslider">';
		      	foreach ($galleries as $galleries){?>
		      
				  <li><img src="<?php echo $config['url'];?>galleryuploads/timthumb.php?src=<?php echo $galleries['Gallery']['gallery_image'];?>&h=600&w=800&zc=1" title="<?php echo $galleries['Gallery']['gallery_titile'];?>"/></li>			
			<?php }
			echo ' </ul>';
		      	} else {?>		      
			  <img src="<?php echo $config['url'];?>images/default_picture.jpg">
			  <?php }?>
			  
		      </div>
		       <p><?php echo $setSpecalistArr[$utype]['Bio'];?></p>
		 </div>
		
      
	  </div>
       <div  class="fore inside-head columns">
	      <div class="btn_con">
           <p class="contact">Contact</p>
		   <p class="number"><?php echo $setSpecalistArr[$utype]['phone'];
		   if($setSpecalistArr[$utype]['mobile']!=''){ echo '<br/>'.$setSpecalistArr[$utype]['mobile'];}
		   ?></p>
		   <p class="mail_text" style="font-family:'HelveticaLTCondensedRegular';"><a href="mailto:<?php echo $setSpecalistArr[$utype]['email'];?>"><?php echo $setSpecalistArr[$utype]['email'];?></a><p>
		  
		  </div>
		  <div class="rss_team_area">
		     <p> <b>Health and Fitness Tidbits</b></p>
			 
			 <?php
					$rss = new DOMDocument();
					$rssfeeds = $setSpecalistArrURL['Admin']['rssurl'];
				//$rss->load('http://www.fitness.com/generated/rss_fit_tips.xml');
					$rss->load($rssfeeds);
					$feed = array();
					foreach ($rss->getElementsByTagName('item') as $node) {
						$item = array ( 
							'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
							'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
							'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
							'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
							);
						array_push($feed, $item);
					}
					$limit = 5;
					for($x=0;$x<$limit;$x++) {
						$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
						$link = $feed[$x]['link'];
						$description = $feed[$x]['desc'];
						$date = date('l F d, Y', strtotime($feed[$x]['date']));
						echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
						echo '<small><em>Posted on '.$date.'</em></small></p>';
						echo '<p>'.$description.'</p>';
					}
				?>
			 
			 
		  </div>
	      
         
		</div>	   
   </div>
	<!--------middle section end here----------------------->
    </div>
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
   <!-- Change Pic popup -->
                
                <!-- Change Pic popup End -->
   <!-- Change Cover popup -->
                <div id="pop556" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('pop556');" id="pop456" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                      <h2> Classes and Events</h2>
                          <?php if(!empty($events)){?>
        <style>
#Subscriptions .about-details-list li{padding:0;}
        </style>
        <div class="main-responsive-box"><ul class="listing-box all-headtabs">
          <li class="listing-heading">
            <!--<div class="list-colum first-tabs" style="min-width:50px;">S.No.</div>-->
            <div class="list-colum second-tabs">Classes and Events</div>
            <div class="list-colum third-tabs">Date</div>
           
          </li>
        </ul>
        <ul class="listing-box">
          <div id="testDivNested" class="list-scroll-wrap">
          <?php 
          $cnt=1;
         //print_r($events);
          foreach ($events as $events)
          {
          	
          ?>
            <li id="ev_<?php echo $events['Event']['id'];?>">
              <!--<div class="list-colum first-tabs" style="min-width:50px;"><?php //echo $cnt; ?></div>-->
              <div class="list-colum second-tabs"><?php if(!empty($events['Event']['events'])){echo $events['Event']['events']; };  ?></div>
              <div class="list-colum third-tabs"><?php if(!empty($events['Event']['added_date'])){echo date('Y-m-d',strtotime($events['Event']['added_date'])); };  ?></div>
            
            </li>
         <?php   $cnt++; ?>
            <?php  }?>
            
          </div>
        </ul>
        
         <?php }?>
                      </div>
                     
                    </div>
                  </div>
                </div>
                </div>
                <!-- Change Cover End -->        
                 <!-- Change Cover popup -->
                <div id="pop555" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('pop555');" id="pop5554" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                      <h2> Testimonials</h2>
                        <?php echo $setSpecalistArr[$utype]['testimonials'];?>
                      </div>
                     
                    </div>
                  </div>
                </div>
                <!-- Change Cover End -->         
<script type="text/javascript">
$(document).ready(function(){
		var hash = window.location.hash;
       if(hash=='#Certification'){
       
       	$("#Profile").css('display','none');
       	$("#Certification").css('display','block');
       	$("html, body").animate({ scrollTop: 0 }, "slow");
       	$('a[href=' + hash + ']').addClass('active');
       	var shref='#Profile';
       	$('a[href=' + shref + ']').removeClass('active');
       }
       if(hash=='#Bio'){
       	$("#Profile").css('display','none');
       	$("#Bio").css('display','block');
       	$("html, body").animate({ scrollTop: 0 }, "slow");
       	$('a[href=' + hash + ']').addClass('active');
       	var sshref='#Profile';
       	$('a[href=' + sshref + ']').removeClass('active');
       }
});
	 

</script>