
<script>
		jQuery(document).ready( function() {
			// binds form submission and fields to the validation engine
			jQuery("#Traineevalid").validationEngine();
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
          <h2 class="register-heading">Are You a Client? register here!</h2>
          <h3 class="register-subheading">Create a New Account</h3>
        <?php /* ?>  <form class="resform-wrap"><?php */?>
          <?php echo $this->Form->create('Trainee' ,array('controller'=>'Trainees', 'action'=>'register', 'enctype'=>'multipart/form-data', 'class'=>'resform-wrap', 'id'=>'Traineevalid')); ?>
            <?php /* ?><input type="text" name="" value="" placeholder="Username" /><?php */?>
            <?php echo $this->Form->input('Trainee.username',array( 'placeholder' => 'Username','label'=>'','class'=>'validate[required] text-input')); ?>
           
            <?php echo $this->Form->input('Trainee.email',array( 'placeholder' => 'Email address','label'=>'','class'=>"validate[required,custom[email]] text-input")); ?>
            <div class="row">
              <div class="six columns">
              
              
                 <?php echo $this->Form->input('Trainee.password',array( 'placeholder' => 'Password','label'=>'','class'=>"validate[required] text-input",'id'=>'password')); ?>
               
                <?php echo $this->Form->input('Trainee.first_name',array( 'placeholder' => 'First name','label'=>'','class'=>"validate[required] text-input")); ?>
              </div>
              <div class="six columns">
               <?php /*?> <input type="text" name="" value="" placeholder="Confirm password" /> <?php*/ ?>
                 <?php echo $this->Form->input('Trainee.con_password',array( 'placeholder' => 'Confirm password','label'=>'','type'=>'password','class'=>"validate[required,equals[password]]")); ?>
               
                <?php echo $this->Form->input('Trainee.last_name',array( 'placeholder' => 'Last name','label'=>'','class'=>"validate[required] text-input")); ?>
              </div>
            </div>
          
            <?php echo $this->Form->input('Trainee.address',array( 'placeholder' => 'Address','label'=>'')); ?>
            <div class="row">
              <div class="six columns">
               
                <?php echo $this->Form->input('Trainee.city',array( 'placeholder' => 'City','label'=>'')); ?>
              </div>
              <div class="six columns">
                
                 <?php echo $this->Form->input('Trainee.state',array( 'placeholder' => 'State','label'=>'')); ?>
              </div>
            </div>
            <div class="row">
              <div class="twelve form-select columns">
              
                <select name="data[Trainee][country]" id="dd" onChange="document.getElementById('customSelect').value= this.options[this.selectedIndex].text">
               
             <?php foreach ($countries as $key=>$country){ ?>
             <option value="<?php echo $key; ?>"><?php echo $country; ?></option>
             <?php  }?>
     
                </select>
                
                
                <input type="text" id="customSelect" value="--Select Country--"/>
              </div>
            </div>
           
             <?php echo $this->Form->input('Trainee.zip',array( 'placeholder' => 'Zip code','label'=>'')); ?>
            <div class="row">
              <div class="six columns">
               
                <?php echo $this->Form->input('Trainee.phone',array( 'placeholder' => 'Phone','label'=>'','class'=>'validate[custom[phone]] text-input')); ?>
              </div>
              <div class="six columns">
               
                 <?php echo $this->Form->input('Trainee.mobile',array( 'placeholder' => 'Mobile','label'=>'')); ?>
              </div>
            </div>
            <?php /* ?>
            <input type="text" name="" value="" placeholder="Years of experience" />
            <input type="text" name="" value="" placeholder="Workout session price" />
            <input type="text" name="" value="" placeholder="PayPal address" />
            <?php */ ?>
            <div class="row">
              <div class="six columns"><span class="file-wrapper">
                <input type="file" name="data[Trainee][logo]" id="photo" />
                <span class="button">Upload Logo</span> </span></div>
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
                <span>Yes, I agree to Personal Training Partners.com <a href="#">Terms and Conditions</a>.</span> </div>
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
