<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		view, page settings and its details
## *****************************************************************
?>
<div class="content">

    <div class="title"><h5><?php echo $this->Html->link('Home',array('controller'=>'users','action'=>'index'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Members',array('controller'=>'users','action'=>'list'), array('title'=>'Manage Members','escape'=>false));?></h5></div>

<div class="content" id="container">


<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">View Member Details</h5></div>

			<div class="rowElem noborder">
				<label>Type:</label>
				<div class="formRight" style="margin:0px;"><?php if($this->data['Member']['plan_id']==1){echo "Monthly";} else if($this->data['Member']['plan_id']==2){echo "Lifetime";} else{echo "NIL";} ?></div>
				<div class="fix"></div>
			</div>
			<?php if($this->data['Member']['profile_pic']!=''){?>
			<div class="rowElem noborder">
				<label>Profile Picture:</label>
				<div class="formRight" style="margin:0px;"><img src="<?php echo $config['url']?>app/webroot/uploads/avatar/<?php echo $this->data['Member']['profile_pic']?>" width="50px" height="50px"></div>
				<div class="fix"></div>
			</div>
			<?php }?>
			<div class="rowElem noborder">
				<label>First Name:</label>
				<div class="formRight" style="margin:0px;"><?php echo $this->data['Member']['first_name'] ?></div>
				<div class="fix"></div>
			</div>

			<div class="rowElem noborder">
				<label>Last Name:</label>
				<div class="formRight" style="margin:0px;"><?php echo $this->data['Member']['last_name'] ?></div>
				<div class="fix"></div>
			</div>

			<div class="rowElem noborder">
				<label>Username:</label>
				<div class="formRight" style="margin:0px;"><?php echo $this->data['Member']['username'] ?></div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Email:</label>
				<div class="formRight" style="margin:0px;"><?php echo $this->data['Member']['email'] ?></div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Gender:</label>
				<div class="formRight" style="margin:0px;"><?php echo $this->data['Member']['gender'] ?></div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Birthday:</label>
				<div class="formRight" style="margin:0px;"><?php echo date('M, j Y',strtotime($this->data['Member']['birthday'])) ?></div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Hometown:</label>
				<div class="formRight" style="margin:0px;"><?php echo $this->data['Member']['hometown'] ?></div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Location:</label>
				<div class="formRight" style="margin:0px;"><?php echo $this->data['Member']['location'] ?></div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Website:</label>
				<div class="formRight" style="margin:0px;"><?php echo $this->data['Member']['website'] ?></div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Religion:</label>
				<div class="formRight" style="margin:0px;"><?php echo $this->data['Member']['religion'] ?></div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Political View:</label>
				<div class="formRight" style="margin:0px;"><?php echo $this->data['Member']['political'] ?></div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Status:</label>
				<div class="formRight" style="margin:0px;">
				<?php 
				if($this->data['Member']['created_by']==0 && $this->data['Member']['stripe_cust_id']=='' && $this->data['Member']['status']==1){
					echo "Visitor";
				}
				else if($this->data['Member']['created_by']==0 && $this->data['Member']['stripe_cust_id']!='' && $this->data['Member']['status']==1){
					echo "Customer";
				}
				else{
					echo "Suspended";
				}
				?>
				</div>
				<div class="fix"></div>
			</div>

			<div class="rowElem noborder">
				<label>Account Type:</label>
				<div class="formRight" style="margin:0px;">
				<?php 
				if($this->data['Member']['accounttype']=='Free'){
					echo "Free";
				}
				else{
					if($this->data['Member']['plan_id']==1){
							echo "Monthly";
						} 
						else if($this->data['Member']['plan_id']==2){
							echo "Lifetime";
						} 
						else{
							echo "Visitor";
						} 
					
				}
				?>
				</div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Last Visit:</label>
				<div class="formRight" style="margin:0px;"><?php if($this->data['Member']['last_login']!='0000-00-00 00:00:00'){echo date('F j, Y h:i:s',strtotime($this->data['Member']['last_login'])); }?></div>
				<div class="fix"></div>
			</div>
			<?php if(isset($this->data['Member']['stripe_cust_id']) && $this->data['Member']['stripe_cust_id']!=''){?>
			<div class="rowElem noborder">
				<label># of Evertalk Pages:</label>
				<div class="formRight" style="margin:0px;"><?php echo $_no_memorial_pages; ?></div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Total Payments:</label>
				<div class="formRight" style="margin:0px;"><?php if($_total_revenue!=''){?>$<?php echo number_format($_total_revenue,2); ?><?php }?></div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Last Payment Date:</label>
				<div class="formRight" style="margin:0px;"><?php echo $_last_payment_date; ?></div>
				<div class="fix"></div>
			</div>
			<?php }?>
			
	</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>

