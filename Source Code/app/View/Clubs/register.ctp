
<script>
		jQuery(document).ready( function() {
			// binds form submission and fields to the validation engine
			jQuery("#Clubvalid").validationEngine();
		});
	</script>

<!-- Register page -->
  <section class="register-wrapper clearfix">
    <div class="register-main-shadow">
      <div class="row">
        <div class="seven columns Register-img-box">
          <div class="register-quote"><img src="../images/register_text.png" /></div>
          <img src="../images/register_bg.png" /></div>
        <div class="five  columns register-form">
          <h2 class="register-heading">Are YOu a Club? register here!</h2>
          <h3 class="register-subheading">Create a New Account</h3>
        <?php /* ?>  <form class="resform-wrap"><?php */?>
          <?php echo $this->Form->create('Club' ,array('controller'=>'Clubs', 'action'=>'register', 'enctype'=>'multipart/form-data', 'class'=>'resform-wrap', 'id'=>'Clubvalid')); ?>
            <?php /* ?><input type="text" name="" value="" placeholder="Username" /><?php */?>
            <?php //echo $this->Form->input('Club.username',array( 'placeholder' => 'Username','label'=>'','class'=>'validate[required] text-input')); ?>
           
            <?php echo $this->Form->input('Club.email',array( 'placeholder' => 'Email address','label'=>'','class'=>"validate[required,custom[email]] text-input")); ?>
            <div class="row">
              <div class="twelve columns">
              
              
                
               
                <?php echo $this->Form->input('Club.first_name',array( 'placeholder' => 'First name','label'=>'','class'=>"validate[required] text-input")); ?>
				
				<?php echo $this->Form->input('Club.last_name',array( 'placeholder' => 'Last name','label'=>'','class'=>"validate[required] text-input")); ?>
              </div>
              <div class="twelve columns">
               <?php /*?> <input type="text" name="" value="" placeholder="Confirm password" /> <?php*/ ?>
			    <?php echo $this->Form->input('Club.password',array( 'placeholder' => 'Password','label'=>'','class'=>"validate[required] text-input",'id'=>'password')); ?>
			   
                 <?php echo $this->Form->input('Club.con_password',array( 'placeholder' => 'Confirm password','label'=>'','type'=>'password','class'=>"validate[required,equals[password]]")); ?>
               
                
              </div>
            </div>
          
            <?php echo $this->Form->input('Club.club_name',array( 'placeholder' => 'Club Name','label'=>'','class'=>"validate[required] text-input")); ?>
            <?php echo $this->Form->input('Club.address',array( 'placeholder' => 'Address','label'=>'')); ?>
            <div class="row">
              <div class="six columns">
               
                <?php echo $this->Form->input('Club.city',array( 'placeholder' => 'City','label'=>'')); ?>
              </div>
              <div class="six columns">
                
                 <?php echo $this->Form->input('Club.state',array( 'placeholder' => 'State','label'=>'')); ?>
              </div>
            </div>
            <div class="row">
              <div class="twelve form-select columns">
              
                <select name="data[Club][country]" id="dd" onChange="document.getElementById('customSelect').value= this.options[this.selectedIndex].text">
               
             <?php foreach ($countries as $key=>$country){ ?>
             <option value="<?php echo $key; ?>"<?php if($key=='226')echo"selected";?>><?php echo $country; ?></option>
             <?php  }?>
     
                </select>
                
                
                <input type="text" id="customSelect" value="UNITED STATES"/>
              </div>
            </div>
           
             <?php echo $this->Form->input('Club.zip',array( 'placeholder' => 'Zip code','label'=>'')); ?>
            <div class="row">
              <div class="six columns">
               
                <?php echo $this->Form->input('Club.phone',array( 'placeholder' => 'Phone 555-555-5555','label'=>'','class'=>'validate[custom[phone]] text-input','pattern'=>'\d{3}-?\d{3}-?\d{4}')); ?>
              </div>
              <div class="six columns">
               
                 <?php echo $this->Form->input('Club.mobile',array( 'placeholder' => 'Mobile 555-555-5555','label'=>'','class'=>'validate[custom[phone]] text-input','pattern'=>'\d{3}-?\d{3}-?\d{4}')); ?>
              </div>
            </div>
            <?php /* ?>
            <input type="text" name="" value="" placeholder="Years of experience" />
            <input type="text" name="" value="" placeholder="Workout session price" />
            <input type="text" name="" value="" placeholder="PayPal address" />
            <?php */ ?>
           <!-- <div class="row">
              <div class="six columns"><span class="file-wrapper">
                <input type="file" name="data[Club][logo]" id="photo" />
                <span class="button">Upload Logo</span> </span></div>
              <div class="six columns">
               <?php /* ?> <input type="text" name="" value="" placeholder="Certification Organization" /><?php */?>
              </div>
            </div>-->
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
                <!--<span>Yes, I agree to Personal Training Partners.com <a href="#">Terms and Conditions</a>.</span>-->

<span>Yes I agree to the Personal Training Partners <a href="<?php echo $config['url']?>terms-of-use" target="_blank">Terms of Use</a> and <a href="<?php echo $config['url']?>privacy-policy" target="_blank">Privacy Policy</a>.</span>				</div>
            </div>
            <input type="submit" class="submit-nav" name="" value="Sign Up"  />
         <?php echo $this->Form->end(); ?>
        </div>
      </div>
    </div>
  </section>
  <!-- Register page --> 
  <!-- contentContainer ends -->
  <div class="clear"></div>
  <!-- footer part -->
