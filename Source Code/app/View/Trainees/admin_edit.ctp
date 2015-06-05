<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Admin edit Trainer
## *****************************************************************
?>
<?php //pr($this->request->data);




?>
<div class="content">
	<div class="content" id="container">
		<?php echo $this->Form->create('Trainee' ,array('controller'=>'trainees', 'action'=>'edit', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
		<?php echo $this->Form->hidden('Trainee.id'); ?>
		<!-- Input text fields -->
		<fieldset>
		<div class="widget first">
		<div class="head"><h5 class="iList">Edit Client</h5><a href="<?php echo $this->Html->url(array('controller'=>'trainees', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div> 
				
			<?php /*
			<div class="rowElem noborder"><label>Club:</label><div class="formRight">
               <?php
            //  pr($selectedClub);
            $selector=0;
              foreach ($selectedClub as $ky=>$myikeys){
              	$sel[]=$ky;
              }
            
              //pr($clubs);
               //$trainertypeArr=array('C'=>'Associated with Club','I'=>'Individual');
               ?>       
				<?php  //echo $this->Form->select('',$clubs,array('class'=>'topAction','multiple'=>true,'style'=>'width:62%;height:80px;','size'=>'5','class'=>'validate[required]','name'=>'TraineeClub_Id','onchange'=>'getTrainerList()','selected'=>$selectedClub)); ?>
				
			<?php  ?>	<select name="TraineeClub_Id[]" class="" multiple="multiple" style="width:62%;height:80px;" size="5" onchange="getTrainerList()" id="TraineeClubId">
				<?php foreach ($clubs as $key=>$clb) {?>
			<?php 
			
			
			if(in_array($key,$sel)){
				$selector=1;
			}
			
				?>	
	<option <?php if($selector==1){echo "selected='selected'";} ?> value="<?php echo $key; ?>"><?php echo $clb; ?></option>
	
<?php $selector=0; }?>
</select>
			<?php ?>	

			</div><div class="fix"></div></div>	
			
			*/ ?>
			
			<?php
            //  pr($selectedClub);
			//print_r($trainers);
			
            $selector2=0;
              foreach ($selectedTrainer as $ky=>$myikeys){
              	$sel2[]=$ky;
              }
              ?>
<!--<div class="rowElem noborder"><label>Trainers:</label><div class="formRight" id="trainersID"> 
<select name="TraineeTrainer[]" class="" multiple="multiple" style="width:62%;height:80px;" size="5" id="TraineeTrainers">
<select name="data[Trainee][trainer_id]" class="" multiple="multiple" style="width:62%;height:80px;" size="5" id="TraineeTrainers">


				<?php foreach ($trainers as $key=>$val) {?>
			<?php 
			
			
			if(in_array($key,$sel2)){
				$selector2=1;
			}
			
				?>	
	<option <?php if($selector2==1){echo "selected='selected'";} ?> value="<?php echo $key; ?>"><?php echo $val; ?></option>
	
<?php $selector2=0; }?>
</select>
			
			
			
			<?php  //echo $this->Form->select('Trainee.trainers',$trainers,array('class'=>'topAction','multiple'=>'multiple','style'=>'width:62%;height:80px;','size'=>'5','class'=>'','name'=>'TraineeTrainer')); ?>
			
				<?php  //echo $this->Form->select('Trainee.trainers',$trainers,array('class'=>'topAction','multiple'=>'multiple','style'=>'width:62%;height:80px;','size'=>'5','class'=>'','name'=>'TraineeTrainer')); ?>
				
				

			</div><div class="fix"></div></div>	-->
			<!--
			<div class="rowElem noborder"><label>Username:<span style="color:red;">*</span>:</label><div class="formRight">

				<?php //echo $this->Form->text('Trainee.username', array('maxlength'=>255,'id'=>'Username', 'class'=>'validate[required] ')); ?>

				<?php //echo $this->Form->error('Trainee.username', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>-->
			
			
			
			<!-- FOR CLUB SELECTIONS-->
				<div class="rowElem noborder"><label>Club:</label><div class="formRight">

				<?php echo $this->Form->select('Trainee.club_id', $clubs, array('style'=>'','empty'=>'-- Select Club --'));?>
				
				<?php echo $this->Form->error('Trainee.club_id', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
			<!-- FOR CLUB SELECTIONS-->
			
			
			<!-- FOR TRAINER SELECTIONS-->
				<div class="rowElem noborder"><label>Trainer:</label><div class="formRight">

				<?php echo $this->Form->select('Trainee.trainer_id', $trainers, array('style'=>'','empty'=>'-- Select Trainer --'));?>
				
				<?php echo $this->Form->error('Trainee.trainer_id', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
			<!-- FOR TRAINER SELECTIONS-->
			
			
			
			
			<div class="rowElem noborder"><label>Email<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[custom[email],ajax[agantEmailValidate]] ')); ?>

				<?php echo $this->Form->error('Trainee.email', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
            <div class="rowElem noborder"><label>Password<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->password('Trainee.password', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Trainee.password', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>First Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.first_name', array('maxlength'=>255,'id'=>'FirstName','class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Trainee.first_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
				<div class="rowElem noborder"><label>Last Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.last_name', array('maxlength'=>255,'id'=>'LastName','class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Trainee.last_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>


			<div class="rowElem noborder"><label>Address:</label><div class="formRight">	
				
				<?php echo $this->Form->text('Trainee.address', array('maxlength'=>255,'id'=>'Address')); ?>

				<?php echo $this->Form->error('Trainee.address', null, array('class' => 'error')); ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>City:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.city', array('maxlength'=>255, 'id'=>'city')); ?>
				
				<?php echo $this->Form->error('Trainee.city', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>State:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.state', array('maxlength'=>255, 'id'=>'state')); ?>
				
				<?php echo $this->Form->error('Trainee.state', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			

			<div class="rowElem noborder"><label>Country:</label><div class="formRight">

				<?php echo $this->Form->select('Trainee.country', $countries, array('style'=>'','empty'=>'-- Select Country --','default'=>226));?>
				
				<?php echo $this->Form->error('Trainee.country', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>			

			<div class="rowElem noborder"><label>Zip:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.zip', array('maxlength'=>255, 'id'=>'zip')); ?>
				
				<?php echo $this->Form->error('Trainee.zip', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>Phone:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.phone', array('maxlength'=>255,'id'=>'Phone')); ?>

				<?php echo $this->Form->error('Trainee.phone', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Mobile:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.mobile', array('maxlength'=>255,'id'=>'Phone')); ?>

				<?php echo $this->Form->error('Trainee.mobile', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Date Enrolled:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.date_enrolled', array('maxlength'=>255,'id'=>'datepicker')); ?>

				<?php echo $this->Form->error('Trainee.date_enrolled', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Notification Status:</label><div class="formRight">
<?php $notify=array('0'=>'No','1'=>'Yes');
 ?>
				<?php echo $this->Form->select('Trainee.notification_status', $notify, array('style'=>'','empty'=>'-- Select Status --','default'=>1));?>
				
				<?php echo $this->Form->error('Trainee.notification_status', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
			
			<div class="rowElem noborder"><label>Profile Picture:</label><div class="formRight">

				<?php echo $this->Form->file('Trainee.photo');?>
								<?php echo $this->Form->error('Trainee.photo', null, array('class' => 'error'));?>
							</div>
							<div class="fix"></div>
							<?php echo $this->Form->hidden('Trainee.id'); ?>
							
							 <?php echo $this->Form->hidden('Trainee.old_image',array('value'=>$this->request->data["Trainee"]["photo"]));?>
							
						</div>
							<div id="imgCont" class="rowElem noborder"><label></label>
						<div class="formRight">
						
							<div style="float:left;<?php if( array_key_exists("photo",$this->request->data["Trainee"]) && !empty($this->request->data["Trainee"]["photo"]) ) { ?>border:1px solid #d8d8d8;<?php } ?>padding:8px;" id="video_container">
							<?php if( array_key_exists("photo",$this->request->data["Trainee"]) && !empty($this->request->data["Trainee"]["photo"]) ) { ?>
								<img border="1"  width="100px" src="<?php echo $config["imgurl"];?>uploads/<?php echo $this->data["Trainee"]["photo"];?>"/>
								<span style="margin-left:11px;margin-top:-22px;position:absolute;">
									<a id="<?php echo $this->data["Trainee"]["id"];?>" onclick="removePict(this);"  style="cursor:pointer" title="click to delete">
										<img border="1" src="<?php echo $config["imgurl"];?>img/cross.png"/>
									</a>
								</span>
							<?php 	} ?>	
							</div>
						</div>
						<div class="fix"></div>
					</div>
					
					
			<input type="submit" value="Save" class="blueBtn submitForm" />

			<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'trainees', 'action'=>'index')); ?>">CANCEL</a>
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
