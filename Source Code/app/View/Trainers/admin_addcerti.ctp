<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Admin Add New Trainer
## *****************************************************************
?>
<script>

$(document).ready(function(){
	$('#CertificationTrainersCertificationOrg').on('change', function() {
  //alert( 'Hello' ); // or $(this).val()
  if(this.value==' ')
  {
   $("#otherhide").show();	
  }
  else
  {
  $("#otherhide").hide();

}
  
});
});

$(document).ready(function(){
	$('#CertificationTrainersCertificationName').on('change', function() {
  //alert( 'Hello' ); // or $(this).val()
  if(this.value==' ')
  {
   $("#otherhide2").show();	
  }
  else
  {
  $("#otherhide2").hide();

}
  
});
});

$(document).ready(function(){
	$('#CertificationTrainersCertificationDegree').on('change', function() {
  //alert( 'Hello' ); // or $(this).val()
  if(this.value==' ')
  {
   $("#otherhide3").show();	
  }
  else
  {
  $("#otherhide3").hide();

}
  
});
}); 
</script>

<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create('Trainer' ,array('controller'=>'trainers', 'action'=>'addcerti/'.$trid, 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Certification</h5><a href="<?php echo $this->Html->url(array('controller'=>'trainers', 'action'=>'managecerti/'.$trid)); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
				
             <input type="hidden"  name="data[CertificationTrainers][trainer_id]" id="CertificationTrainers_trainer_id" value="<?php echo $trid;?>"/> 
             <div class="rowElem noborder"><label>Certification Organization:</label><div class="formRight">
               <?php
           $option=array();
			
			$options = array(
            ' ' => 'Other'
            
            );
            $cert_org1 = array_merge($cert_org,$options);
              
              echo $this->Form->select('CertificationTrainers.certification_org',$cert_org1,array('empty'=>'Select','class'=>'sltbx')); ?>    
             
			

			</div><div class="fix"></div></div>
			<div class="row">
            <div class="six columns"  id='otherhide' style="display:none;margin-left: 34.5%;">
             
				
<?php echo $this->Form->text('CertificationTrainers.certification_org1', array('maxlength'=>255,'id'=>'Certification Organisation','class'=>'validate[required]','placeholder'=>'Other Certification Organisation')); ?>

				<?php echo $this->Form->error('CertificationTrainers.certification_org1', null, array('class' => 'error')); ?>
                
               
              </div>
              </div>
			
			<div class="rowElem noborder"><label>Certification:</label><div class="formRight">
              <?php

              $option2=array();
			
			$options2 = array(
            ' ' => 'Other'
            
            );
            $certifications1 = array_merge($certifications,$options2);
              
              echo $this->Form->select('CertificationTrainers.certification_name',$certifications1,array('empty'=>'Select','class'=>'topAction')); ?>

			</div><div class="fix"></div></div>
			
			  <div class="row">
            <div class="six columns"  id='otherhide2' style="display:none;margin-left: 34.5%;">
             
				
<?php echo $this->Form->text('CertificationTrainers.certification_name1', array('maxlength'=>255,'id'=>'Certification','class'=>'validate[required]','placeholder'=>'Other Certification')); ?>

				<?php echo $this->Form->error('CertificationTrainers.certification_name1', null, array('class' => 'error')); ?>
                
               
              </div>
              </div>
			
			<div class="rowElem noborder"><label>Degree:</label><div class="formRight">
                     <?php  
               
               $option3=array();
			
			$options3 = array(
            ' ' => 'Other',
            
            );
            $degrees1 = array_merge($degrees,$options3);
               
               echo $this->Form->select('CertificationTrainers.certification_degree',$degrees1,array('empty'=>'Select','class'=>'topAction','onchange'=>'document.getElementById(\'customSelectDegid\').value= this.options[this.selectedIndex].text')); ?>      
			</div><div class="fix"></div></div>
			
			  <div class="row">
            <div class="six columns"  id='otherhide3' style="display:none;margin-left: 34.5%;">
             
				
<?php echo $this->Form->text('CertificationTrainers.certification_degree1', array('maxlength'=>255,'id'=>'Degree','class'=>'validate[required]','placeholder'=>'Other Degree')); ?>

				<?php echo $this->Form->error('CertificationTrainers.certification_degree1', null, array('class' => 'error')); ?>
                
               
              </div>
              </div>	
			
			
			

			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'trainers', 'action'=>'managecerti/'.$trid)); ?>">CANCEL</a>
			
			<div class="fix"></div>



	</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>


