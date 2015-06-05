<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		view, page settings and its details
## *****************************************************************
?>
<?php echo $this->Html->css('dataTable'); ?> 

<?php echo $this->Html->script('dataTables/jquery.dataTables'); ?> 
<?php echo $this->Html->script('dataTables/colResizable.min'); ?> 

<?php echo $this->Html->script('jBreadCrumb.1.1'); ?> 
<?php echo $this->Html->script('cal.min'); ?> 
<?php echo $this->Html->script('jquery.collapsible.min'); ?> 
<?php echo $this->Html->script('jquery.ToTop'); ?> 
<?php echo $this->Html->script('jquery.listnav'); ?> 
<?php echo $this->Html->script('jquery.sourcerer'); ?> 

<?php echo $this->Html->script('wysiwyg/jquery.wysiwyg'); ?> 
<?php echo $this->Html->script('wysiwyg/wysiwyg.image'); ?> 
<?php echo $this->Html->script('wysiwyg/wysiwyg.link'); ?> 
<?php echo $this->Html->script('wysiwyg/wysiwyg.table'); ?> 

<?php echo $this->Html->script('flot/jquery.flot'); ?> 
<?php echo $this->Html->script('flot/jquery.flot.pie'); ?> 
<?php echo $this->Html->script('flot/excanvas.min'); ?> 

<?php echo $this->Html->script('selectunselect'); ?> 

<?php
	if(isset($status) && trim($status)!=""){
		$url = array($status);
		$this->Paginator->options(array('url' => $url));
	}
?>

<script type="text/javascript">
function del(field) {
	 if(!anyChecked(field)) {
	 	// alert('Please select atleast one record to perform any action.');
		jAlert('Please select atleast one record to perform any action.', 'Alert::<?php echo $config['base_title']; ?>');
	 	return false;
	 } else {
		 if(jQuery('#Status').val() == 'delete'){
			if(!confirm("Are you sure want to perform this action?")){
				return false;
			}else{
				return true;
			}
		 }else if(jQuery('#Status').val() == ''){
		 	jAlert('Please select action.', 'Alert::<?php echo $config['base_title']; ?>');
	 		return false;
		 } else {
			 return true;
		 }
	 }
}
//-->
</script>




<div class="content">
<div class="title"><h5>Manage Members</h5></div>

<div class="users index">
 
<?php 
if (($this->Session->check('Message.flash'))) {
	echo $this->Session->flash('flash', array('element' => 'flash'));
}
?>
 
<div class="table">
            <div class="head"><h5 class="iFrames">Members</h5> </div>
            <div class="dataTables_wrapper" id="example_wrapper">
			<div class="" style="visibility:hidden;">
				<div class="dataTables_filter" id="example_filter">
					<label>Search: <input type="text" placeholder="type here...">
					<div class="srch"></div>
					</label>
				</div>
			</div>
			<?php echo $this->Form->create('' ,array('controller'=>'users', 'action'=>'list', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>	
			<table cellspacing="0" cellpadding="0" border="0" id="" class="display">
                <thead>
                    <tr>
                    	<th class="ui-state-default" rowspan="1" colspan="1" width="3%">
							<div style="padding-right:8px;"><?php echo $this->Form->text('Member.all', array('type'=>'checkbox', 'id'=>'data[Member][all]', 'onclick'=>"selectDeselect('data[Member][id][]', this.name);"));?></div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width="10%">
							<div style="padding-right:8px;">#</div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width="30%">
							<div class="DataTables_sort_wrapper">
								<?php echo $this->Paginator->sort('first_name','Name');?>									
							</div>
						</th>
						
						<th class="ui-state-default" rowspan="1" colspan="1" width="35%">
							<div class="DataTables_sort_wrapper">
								<?php echo $this->Paginator->sort('email','Email');?>
							</div>
						</th>
						
						
						<th class="ui-state-default" rowspan="1" colspan="1"  width="15%">
							<div class="DataTables_sort_wrapper">
								<?php echo $this->Paginator->sort('created','Created');?>
							</div>
						</th>
						
					
						<th class="ui-state-default">
							Action
						</th>
										
					</tr>
                </thead>
				
				<?php
				if(isset($members) && count($members) > 0){
					$count = 0; 
					foreach($members as $prow){
						
						$index = ((($page-1)*$limit) + ($count+1));
				?>
				
				<tbody>				
				<tr class="gradeA <?php if($count%2==0) echo 'odd'; else echo 'even';?>">
					<td align="center"><?php echo $this->Form->text('Member.id][', array('type'=>'checkbox', 'value'=>$prow['Member']['id'],  'onclick'=>"checkSelection('data[Member][id][]', 'data[Member][all]')"));?></td>
					<td align="center"><?php echo $index;?></td>
					<td><?php echo $prow['Member']['first_name'].' '.$prow['Member']['last_name'] ?></td>
					<td><?php echo $prow['Member']['email'];?>
					</td>
					
					<td><?php echo date($config['date_format'], strtotime($prow['Member']['created'])); ?></td>
					<td align="center"><?php echo $this->Html->link($this->Html->image('view.png'),array('controller'=>'users','action'=>'view/'.$prow['Member']['id'] ), array('title'=>'View member Details','escape'=>false));?>
					</td>
					
				</tr>
				<?php $count++; } } ?>
			
				<?php if(isset($members) && count($members) > 0){?>
					<tr><td colspan="6">
					<div class="rowElem noborder">
						<?php  echo $this->Form->select('Member.status',unserialize($config['member_status_array']),array('empty'=>'Select', 'id'=>'Status','style'=>'width:80px;float:left;')); ?>&nbsp;
						<?php  echo $this->Form->submit('OK', array('style'=>'float:left','class'=>'greyishBtn submitForm','name'=>'data[Member][submit]', 'div'=>false, 'onclick'=>"return del('data[Member][id][]')"));?>
					</div>
					</td></tr>
				<?php }?>
				
				</tbody>
			</form>	
				</table>
				
				
				<?php
				if(isset($members) && count($members) > 0){
				?>
				
				<?php echo $this->element('admin/paginate')?>
				<?php }else {?>
				<div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
					<div class="dataTables_length" id="example_length" style="width:100%;text-align:center;">
						No records available yet.
					</div>
	
				</div>
				<?php } ?>
				

				

			</div>
        </div>	
</div>

</div>
