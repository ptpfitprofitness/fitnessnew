<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		view, page settings and its details
## *****************************************************************
?>
<div class="content">
	<div class="content" id="container">
		<?php echo $this->Form->create('Member' ,array('controller'=>'members', 'action'=>'edit', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
		<?php echo $this->Form->hidden('Member.id'); ?>
		<!-- Input text fields -->
		<fieldset>
		<div class="widget first">
		<div class="head"><h5 class="iList">Edit Customer</h5><a href="<?php echo $this->Html->url(array('controller'=>'members', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div> 
			
			<div class="rowElem noborder"><label>Username<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Member.username', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Member.username', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			<div class="rowElem noborder"><label>Password<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->password('Member.password', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Member.password', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
		
			
			<div class="rowElem noborder"><label>Email<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Member.email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email],ajax[agantEmailValidate]] ')); ?>

				<?php echo $this->Form->error('Member.email', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			<div class="rowElem noborder"><label>First Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Member.first_name', array('maxlength'=>255,'id'=>'FirstName')); ?>

				<?php echo $this->Form->error('Member.first_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			<div class="rowElem noborder"><label>Last Name:</label><div class="formRight">

				<?php echo $this->Form->text('Member.last_name', array('maxlength'=>255,'id'=>'LastName')); ?>

				<?php echo $this->Form->error('Member.last_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>


			<div class="rowElem noborder"><label>Gender:</label><div class="formRight">	
				
				<?php echo $this->Form->radio("Member.gender",array("Male"=>"Male","Female"=>"Female","NULL"=>"N/A"),array("type"=>"radio","label"=>"","legend"=>"", 'style' => 'margin-left:20px;'));?>
				<?php echo $this->Form->error('Member.gender', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>					


			<div class="rowElem noborder"><label>City:</label><div class="formRight">

				<?php echo $this->Form->text('Member.city', array('maxlength'=>128, 'id'=>'city')); ?>
				
				<?php echo $this->Form->error('Member.city', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			

			<div class="rowElem noborder"><label>Country:</label><div class="formRight">

				<?php echo $this->Form->select('Member.country_id', $countries, array('style'=>'','empty'=>'-- Select Country --','default'=>226));?>
				
				<?php echo $this->Form->error('Member.country_id', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>			

			<div class="rowElem noborder"><label>Age:</label><div class="formRight">

				    <?php
					 $start_date = explode('-',$this->data["Member"]["age"]);
					 $Dob = $start_date[1].'-'.$start_date[2].'-'.$start_date[0];
					?>	
					<?php // echo $this->Form->text('Member.age', array('maxlength'=>3)); ?>
					<?php echo $this->Form->text('Member.age', array('maxlength'=>11,'id'=>'datepicker', 'readonly'=>'true ', 'value'=>$Dob)); ?>
				
				<?php echo $this->Form->error('Member.age', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>						
			
			<div class="rowElem noborder"><label>Profile Picture:<br>(Your profile picture will only be viewable to specialists that you personally contact)</label>
							<div class="formRight">
								<?php echo $this->Form->file('Member.picture');?>
								<?php echo $this->Form->error('Member.picture', null, array('class' => 'error'));?>
							</div>
							<div class="fix"></div>
							<?php echo $this->Form->hidden('Member.id'); ?>
							
							 <?php echo $this->Form->hidden('Member.old_image',array('value'=>$this->request->data["Member"]["picture"]));?>
							
						</div>
							<div id="imgCont" class="rowElem noborder"><label></label>
						<div class="formRight">
							<div style="float:left;<?php if( array_key_exists("picture",$this->request->data["Member"]) && !empty($this->request->data["Member"]["picture"]) ) { ?>border:1px solid #d8d8d8;<?php } ?>padding:8px;" id="video_container">
							<?php if( array_key_exists("picture",$this->request->data["Member"]) && !empty($this->request->data["Member"]["picture"]) ) { ?>
								<img border="1"  width="100px" src="<?php echo $config["imgurl"];?>uploads/<?php echo $this->data["Member"]["picture"];?>"/>
								<span style="margin-left:11px;margin-top:-22px;position:absolute;">
									<a id="<?php echo $this->data["Member"]["id"];?>" onclick="removePic(this);"  style="cursor:pointer" title="click to delete">
										<img border="1" src="<?php echo $config["imgurl"];?>img/cross.png"/>
									</a>
								</span>
							<?php 	} ?>	
							</div>
						</div>
						<div class="fix"></div>
					</div>
					
					
			<div class="rowElem noborder"><label>Default Avatars:<br>(If no profile picture is uploaded, Please select the Default Avatars to be used)</label><div class="formRight">	
				
				<?php 
				
				echo $this->Form->radio("Member.avatar",array("1"=>"<img border='1'  width='50px' src='".$config['imgurl']."img/1.jpg'/>","2"=>"<img border='1'  width='50px' src='".$config['imgurl']."img/2.jpg'/>","3"=>"<img border='1'  width='50px' src='".$config['imgurl']."img/3.jpg'/>","4"=>"<img border='1'  width='50px' src='".$config['imgurl']."img/4.jpg'/>"),array("type"=>"radio","label"=>"","legend"=>"","default" => '1', 'style' => 'margin-left:10px;'));?>
				<?php echo $this->Form->error('Member.avatar', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			<input type="submit" value="Save" class="blueBtn submitForm" />

			<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'members', 'action'=>'index')); ?>">CANCEL</a>
			<div class="fix"></div>
		</div>
	</fieldset>
<?php echo $this->Form->end(); ?>
</div>
<div class="fix"></div>
</div>
</div>
<style>
.divFormCon .divRow .divColm2 {
    float: left;
    width: 490px;
}
.checkBoxList {
    width: 330px;
}
.whiteBoxWrap {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #DBDBDB;
    padding: 22px 30px;
}
.checkBoxList .checkListCon {
    float: left;
    width: 350px;
}

.checkBoxList .checkListCon li {
    float: left;
    width: 30%;
}
.checkListCon ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}
.checkListCon li {
    color: #818181;
    display: block;
    font-size: 12px;
    list-style-type: none;
    margin: 0 0 5px;
    padding: 0;
	float:left;
	width:40%;
}
.checkListCon li input {
    margin-right: 5px;
    vertical-align: middle;
}
</style>

<script>
	$(document).ready(function(){			
		$('#datepicker').datepicker({
			inline: true,
			changeMonth: true,
            changeYear: true,
            maxDate: '-1',
            dateFormat: 'mm-dd-yy',
            yearRange:'-100:+0'
		});	
		
		
	});
	
</script>
