<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Admin Add New Employee
## *****************************************************************
?>
<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create('Employee' ,array('controller'=>'trainees', 'action'=>'edit', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->
<?php echo $this->Form->hidden('Employee.id'); ?>

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Edit Employees</h5><a href="<?php echo $this->Html->url(array('controller'=>'employees', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			

			
			<div class="rowElem noborder"><label>Corporation<span style="color:red;">*</span>:</label><div class="formRight">
               <?php
               //$trainertypeArr=array('C'=>'Associated with Club','I'=>'Individual');
               ?>       
				<?php  echo $this->Form->select('Employee.corporation_id',$corporations,array('class'=>'topAction','id'=>'BranchCorporationId','empty'=>'-- Select Corporation --','default'=>226,'class'=>'validate[required]','onchange'=>'getCorporationBranchListEmp()')); ?>

			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder"><label>Branch<span style="color:red;">*</span>:</label><div class="formRight" id="EmpBranchID">  
			<div id="branchesID">                      
				<?php  echo $this->Form->select('Employee.branch_id',$branches,array('class'=>'topAction','empty'=>'-- Select Branch --','default'=>226,'class'=>'validate[required]')); ?>
				</div>

			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder"><label>Designation:<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Employee.designation', array('maxlength'=>255,'id'=>'designation', 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Employee.designation', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			<!--<div class="rowElem noborder"><label>Username:<span style="color:red;">*</span>:</label><div class="formRight">

				<?php //echo $this->Form->text('Employee.username', array('maxlength'=>255,'id'=>'Username', 'class'=>'validate[required] ')); ?>

				<?php //echo $this->Form->error('Employee.username', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			-->
			
			
			<div class="rowElem noborder"><label>Email<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Employee.email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email],ajax[agantEmailValidate]] ')); ?>

				<?php echo $this->Form->error('Employee.email', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
            <div class="rowElem noborder"><label>Password<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->password('Employee.password', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Employee.password', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>First Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Employee.first_name', array('maxlength'=>255,'id'=>'FirstName','class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Employee.first_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			<div class="rowElem noborder"><label>Last Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Employee.last_name', array('maxlength'=>255,'id'=>'LastName','class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Employee.last_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>


			<div class="rowElem noborder"><label>Address:</label><div class="formRight">	
				
				<?php echo $this->Form->text('Employee.address', array('maxlength'=>255,'id'=>'Address')); ?>

				<?php echo $this->Form->error('Employee.address', null, array('class' => 'error')); ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>City:</label><div class="formRight">

				<?php echo $this->Form->text('Employee.city', array('maxlength'=>255, 'id'=>'city')); ?>
				
				<?php echo $this->Form->error('Employee.city', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>State:</label><div class="formRight">

				<?php echo $this->Form->text('Employee.state', array('maxlength'=>255, 'id'=>'state')); ?>
				
				<?php echo $this->Form->error('Employee.state', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			

			<div class="rowElem noborder"><label>Country:</label><div class="formRight">

				<?php echo $this->Form->select('Employee.country', $countries, array('style'=>'','empty'=>'-- Select Country --','default'=>226));?>
				
				<?php echo $this->Form->error('Employee.country', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>			

			<div class="rowElem noborder"><label>Zip:</label><div class="formRight">

				<?php echo $this->Form->text('Employee.zip', array('maxlength'=>255, 'id'=>'zip')); ?>
				
				<?php echo $this->Form->error('Employee.zip', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Phone:</label><div class="formRight">

				<?php echo $this->Form->text('Employee.phone', array('maxlength'=>255,'id'=>'Phone')); ?>

				<?php echo $this->Form->error('Employee.phone', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Mobile:</label><div class="formRight">

				<?php echo $this->Form->text('Employee.mobile', array('maxlength'=>255,'id'=>'Phone')); ?>

				<?php echo $this->Form->error('Employee.mobile', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>Date Enrolled:</label><div class="formRight">

				<?php echo $this->Form->text('Employee.date_enrolled', array('maxlength'=>255,'id'=>'datepicker')); ?>

				<?php echo $this->Form->error('Employee.date_enrolled', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Notification Status:</label><div class="formRight">
<?php $notify=array('0'=>'No','1'=>'Yes');
 ?>
				<?php echo $this->Form->select('Employee.notification_status', $notify, array('style'=>'','empty'=>'-- Select Status --','default'=>0));?>
				
				<?php echo $this->Form->error('Employee.notification_status', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
			
			
						<div class="rowElem noborder"><label>Profile Picture:</label><div class="formRight">

				<?php echo $this->Form->file('Employee.photo');?>
								<?php echo $this->Form->error('Employee.photo', null, array('class' => 'error'));?>
							</div>
							<div class="fix"></div>
							<?php echo $this->Form->hidden('Employee.id'); ?>
							
							 <?php echo $this->Form->hidden('Employee.old_image',array('value'=>$this->request->data["Employee"]["photo"]));?>
							
						</div>
							<div id="imgCont" class="rowElem noborder"><label></label>
						<div class="formRight">
						
							<div style="float:left;<?php if( array_key_exists("photo",$this->request->data["Employee"]) && !empty($this->request->data["Employee"]["photo"]) ) { ?>border:1px solid #d8d8d8;<?php } ?>padding:8px;" id="video_container">
							<?php if( array_key_exists("photo",$this->request->data["Employee"]) && !empty($this->request->data["Employee"]["photo"]) ) { ?>
								<img border="1"  width="100px" src="<?php echo $config["imgurl"];?>uploads/<?php echo $this->data["Employee"]["photo"];?>"/>
								<span style="margin-left:11px;margin-top:-22px;position:absolute;">
									<a id="<?php echo $this->data["Employee"]["id"];?>" onclick="removePict(this);"  style="cursor:pointer" title="click to delete">
										<img border="1" src="<?php echo $config["imgurl"];?>img/cross.png"/>
									</a>
								</span>
							<?php 	} ?>	
							</div>
						</div>
						<div class="fix"></div>
					</div>

			
			
			<div class="rowElem noborder"><label>Make Trainee:</label><div class="formRight">
<?php $flag=array('0'=>'No','1'=>'Yes');
 ?>
				<?php echo $this->Form->select('Employee.trainee_flag', $flag, array('style'=>'','empty'=>'-- Select --','default'=>0));?>
				
				<?php echo $this->Form->error('Employee.trainee_flag', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
			
			

			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'employees', 'action'=>'index')); ?>">CANCEL</a>
			
			<div class="fix"></div>



	</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>


