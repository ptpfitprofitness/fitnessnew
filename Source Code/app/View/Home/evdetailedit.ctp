<?php

foreach($scheduleCalendars as $key=>$val)
		{?> 
<input type="text" name="title1" id="title1" class="validate[required,maxSize[250]]"  value="<?php echo $val['title'];?>" placeholder="Title"/>
                          <textarea name="description1" id="description1" placeholder="Description"  class="validate[required,maxSize[500]]"><?php echo $val['description'];?></textarea>
                          <div class="row">
                         <!-- <div class="six columns">
					          <input type="text" name="startD" id="startD" value="" placeholder="Start DATE"/>
                          <input type="text" name="endD" id="endD" value="" placeholder="End DATE"/>
					          </div>
       </div>-->
                          <input type="text" name="startD1" id="startD1" class="validate[required,maxSize[200]]" value="<?php echo $val['start'];?>" placeholder="Start DATE"/>
                          <span>[Ex: 19/03/2014 11:00AM]</span>
                          <input type="text" name="endD1" id="endD1" class="validate[required,maxSize[200]]" value="<?php echo $val['end'];?>" placeholder="End DATE"/>
                          <span>[Ex: 19/03/2014 12:00PM]</span>
                          <input type="hidden" name="trainer_id1" id="trainer_id1" value="<?php echo $val['trainer_id'];?>" />
                          <input type="hidden" name="evids" id="evids" value="<?php echo $val['id'];?>" />
                         
                               
                            <div class="row">
                        
                        <div class="twelve already-member columns">
                          <input type="submit" value="Submit" name="" class="submit-nav">
                       </div>   
                      </div>   
                      
<?php }?>                      