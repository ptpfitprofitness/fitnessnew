
	<script>
		jQuery(document).ready( function() {
			
			// binds form submission and fields to the validation engine
			jQuery("#Trainervalid").validationEngine();
			var emailok = false;
			var rEmail=jQuery("#TrainerEmail");
			var emailInfo=jQuery("#emailInfo");
			$("#emailInfo").css('display','none');
			var email_url ='<?php echo $config['url']?>trainers/EmailExistCheck';
			rEmail.blur(function(){
				$.ajax({
					type: "POST",
					data: "email="+$(this).attr("value"),
					dataType: "json",
					url: email_url,
					beforeSend: function(){
					emailInfo.html("Checking Email…"); //show checking or loading image
					},
					success: function(data){
						//alert(data.success);
						
					if(data.success==2)
					{
						$("#emailInfo").css('display','block');
					emailok = false;
					emailInfo.html("Inavlid Email");
					}
					else if(data.success==1)
					{
						$("#emailInfo").css('display','block');
					emailok = false;
					emailInfo.html("Email Already Exist");
					}
					else
					{
					emailok = true;
					emailInfo.html("Email Available");
					}
					$("#emailInfo").css('display','block');
					 $("#emailInfo").delay("slow").fadeOut();
					}
					});
				});
			
		});
	</script>
	<style>
	#emailInfo{  background: none repeat scroll 0 0 #75BB2E;
    border-radius: 5px;
    left: 155px;
    margin-bottom: 12px;
    padding: 2px 5px;
    position: absolute;
    top: 54px;
    width: 119px;}
	</style>

<!-- Register page -->
  <section class="register-wrapper clearfix">
    <div class="register-main-shadow">
      <div class="row">
        <div class="seven columns Register-img-box">
          <div class="register-quote" style="top:0;left:0;"><img src="../images/register_text.png" /></div>
          <img src="../images/register_bg.png" /></div>
        <div class="five  columns register-form">
          <h2 class="register-heading">Register Here!</h2>
       <h2 class="register-heading"><!--Personal Training Personalized…Through Simplicity & Innovation--></h2>
          <h3 class="register-subheading">Create a New Account</h3>
        <?php /* ?>  <form class="resform-wrap"><?php */?>
          <?php echo $this->Form->create('Trainer' ,array('controller'=>'trainers', 'action'=>'register', 'enctype'=>'multipart/form-data', 'class'=>'resform-wrap', 'id'=>'Trainervalid')); ?>
            <?php /* ?><input type="text" name="" value="" placeholder="Username" /><?php */?>
             <?php echo $this->Form->input('Trainer.email',array( 'placeholder' => 'Email address','label'=>'','class'=>"validate[required,custom[email]] text-input")); ?>
             <div id="emailInfo" style="background:#75bb2e;"  ></div>
           
            <div class="row">
              <div class="twelve columns">
              
              
                 <?php echo $this->Form->input('Trainer.password',array( 'placeholder' => 'Password','label'=>'','class'=>"validate[required] text-input",'id'=>'password')); ?>
					
				<?php echo $this->Form->input('Trainer.con_password',array( 'placeholder' => 'Confirm password','label'=>'','type'=>'password','class'=>"validate[required,equals[password]]")); ?>
				
                
              </div>
              <div class="twelve columns">
               <?php /*?> <input type="text" name="" value="" placeholder="Confirm password" /> <?php*/ ?>
                 <?php echo $this->Form->input('Trainer.first_name',array( 'placeholder' => 'First name','label'=>'','class'=>"validate[required] text-input")); ?>
               
                <?php echo $this->Form->input('Trainer.last_name',array( 'placeholder' => 'Last name','label'=>'','class'=>"validate[required] text-input")); ?>
              </div>
            </div>
          
            <?php echo $this->Form->input('Trainer.address',array( 'placeholder' => 'Address','label'=>'','class'=>"validate[required] text-input")); ?>
            <div class="row">
              <div class="six columns">
               
                <?php echo $this->Form->input('Trainer.city',array( 'placeholder' => 'City','label'=>'','class'=>"validate[required] text-input")); ?>
              </div>
              <div class="six columns">
                
                 <?php echo $this->Form->input('Trainer.state',array( 'placeholder' => 'State','label'=>'','class'=>"validate[required] text-input")); ?>
              </div>
            </div>
            <div class="row">
              <div class="twelve form-select columns">
              <?php $default3=array('226'); ?>
                <select name="data[Trainer][country]" id="dd" onChange="document.getElementById('customSelect').value= this.options[this.selectedIndex].text">
               
             <?php foreach ($countries as $key=>$country){ ?>
             <option value="<?php echo $key; ?>" <?php if(in_array($key,$default3)) { echo 'selected="selected"';} ?>><?php echo $country; ?></option>
             <?php  }?>
     
                </select>
                
                
                <input type="text" id="customSelect" value="UNITED STATES"/>
              </div>
            </div>
           
             <?php echo $this->Form->input('Trainer.zip',array( 'placeholder' => 'Zip code','label'=>'','class'=>"validate[required] text-input")); ?>
            <div class="row">
            <?php /* ?>
              <div class="six columns">
               
                <?php echo $this->Form->input('Trainer.area_code',array( 'placeholder' => 'Area Code','label'=>'')); ?>
              </div>
              <?php */ ?>
              <div class="twelve columns">
                <?php echo $this->Form->input('Trainer.phone',array( 'placeholder' => 'Phone 555-555-5555','label'=>'','class'=>'validate[required,custom[phone]] text-input','pattern'=>'\d{3}-?\d{3}-?\d{4}')); ?>
              </div>
            </div>
            <div class="input text required">
              <?php echo $this->Form->input('Trainer.mobile',array( 'placeholder' => 'Mobile 555-555-5555','label'=>'','class'=>"validate[required,custom[phone]] text-input",'pattern'=>'\d{3}-?\d{3}-?\d{4}')); ?>
            </div>
            <?php /* ?>
            <input type="text" name="" value="" placeholder="Years of experience" />
            <input type="text" name="" value="" placeholder="Workout session price" />
            <input type="text" name="" value="" placeholder="PayPal address" />
            <?php */ ?>
            <div class="row">
              <!--div class="six columns"><span class="file-wrapper">
                <input type="file" name="data[Trainer][logo]" id="photo" />
                <span class="button">Upload Logo</span> </span></div-->
              <div class="six columns">
               <?php /* ?> <input type="text" name="" value="" placeholder="Certification Organization" /><?php */?>
              </div>
            </div>
         <?php /*?>   <input type="text" name="" value="" placeholder="Certifications" />
            <input type="text" name="" value="" placeholder="Degrees" />
            <?php */ ?>
            <div class="row">
              <div class="twelve check-condition columns">
                <?php /* ?><input type="checkbox" name="" value="" /> <?php */ ?>
                <?php echo $this->Form->input('checkbox', 
    array(
      'label'=>false,'name'=>'tnc','id'=>'tnc','class'=>'validate[required]', 
      'type'=>'checkbox','div' => false
 )); ?>
                <span>Yes I agree to the Personal Training Partners <a href="<?php echo $config['url']?>terms-of-use" target="_blank">Terms of Use</a> and <a href="<?php echo $config['url']?>privacy-policy" target="_blank">Privacy Policy</a>.</span> </div>
            </div>
            <input type="submit" class="submit-nav" name="" value="Next"  />
         <?php echo $this->Form->end(); ?>
        </div>
      </div>
    </div>
  </section>
  <!-- Register page --> 
  <!-- contentContainer ends -->
  <div class="clear"></div>
  <!-- footer part -->
