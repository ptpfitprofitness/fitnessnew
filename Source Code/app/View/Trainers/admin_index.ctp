<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Admin Trainer Index
## *****************************************************************
echo $this->Html->css('dataTable'); ?> 

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
	 /*if(!anyChecked(field)) {
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
	 }*/
}
//-->
$( document ).ready(function() {
	var udata=$('#keyword').val();
 $("#keyword").autocomplete('<?php echo $config['url'];?>admin/trainers/userautocomplete/?usrdata='+udata,{selectFirst:true,highlightItem:true,autoFill:false,max:100,
	
	
	}).result(function(event, item) { 				
			//alert(item[0]);
			

		});
});		
</script> 
<?php //pr($this->request->data);
//die('here');
 ?>
<?php echo $this->Form->create('Trainer' ,array('controller'=>'trainers', 'action'=>'index', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<?php
echo $this->Html->link('Export Data',array('controller'=>'trainers','action'=>'download'), array('target'=>'_blank','style'=>'background: #21ADED; padding:4px;color: #ffffff'));
?>
<?php
echo $this->Html->link('Manage Un-Assign Trainers',array('controller'=>'trainers','action'=>'unassigntrainer'), array('target'=>'_blank','style'=>'background: #21ADED; padding:4px; margin:0 0 0 15px; color: #ffffff'));
?>
<div class="content"> 

<div class="users index">
 
<?php 
if (($this->Session->check('Message.flash'))) {
	echo $this->Session->flash('flash', array('element' => 'flash'));
}
?>
 
<div class="table">
    <div class="head">
		<h5 class="iFrames">Manage Trainers</h5>
		<div class="rowElem noborder" style="clear:none;margin-top: -4px;">
			<?php if(isset($trainers) && count($trainers) > 0){ ?>
				<?php  echo $this->Form->select('Trainer.statusTop',unserialize($config['status_array_trainer']),array('empty'=>'Select','class'=>'topAction','style'=>'width:20%')); ?>&nbsp;
				<?php  echo $this->Form->submit('OK', array('style'=>'float:none;margin-left: -1px;','class'=>'blueBtn submitForm','name'=>'data[Trainer][submit]', 'div'=>false, 'onclick'=>"return del('data[Trainer][id][]')",'id'=>'StatusTop'));?>				
				
			<?php 	} ?> 		
				<a href="<?php echo $this->Html->url(array('controller'=>'trainers', 'action'=>'add')); ?>" style="float: right; margin-top:0px; padding: 2px 13px;margin-right:0px;" class='blueBtn'>Add New</a>
		</div>		
	</div>
        <div class="dataTables_wrapper" id="example_wrapper">
			<?php echo $this->Form->create('Trainer',array('controller'=>'trainers','action'=>'index/'.$this->params["pass"][0],'class'=>'mainForm')); ?>	
				<div class="">
					<div class="dataTables_filter" id="example_filter" style="right:15%;top:-38px;">
						<label>Search: <input type="text" name="keyword" id="keyword" value="<?php echo $keyword;?>" placeholder="Search by email or Trainer Name..."/>
						<div class="srch" style="right: 11px;top:4px;"><input style="padding: 2px 3px;" type="submit" name="submit" value="Search"/></div>
						</label>
					</div>
				</div>
			<?php 
				echo $this->Form->end();
				
				if(isset($trainers) && count($trainers) > 0){
					$this->Paginator->options(array('url' => array("controller"=>"trainers","action"=>"index/$tab/keyword:$keyword")));
					echo $this->element('admin/paginate');
				} 
			?>
			<br/>
			<table cellspacing="0" cellpadding="0" border="0" id="" class="display">
                <thead>
                    <tr>
						<th class="ui-state-default" rowspan="1" colspan="1" width="3%">
							<div style="padding-right:8px;"><?php echo $this->Form->text('Trainer.all', array('type'=>'checkbox', 'id'=>'data[Trainer][all]', 'onclick'=>"selectDeselect('data[Trainer][id][]', this.name);"));?></div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width="3%">
							<div style="padding-right:8px;">#</div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width="20%">
							<div class="DataTables_sort_wrapper">
								Name
							</div>
						</th>
						
						
						<th class="ui-state-default" rowspan="1" colspan="1">
							<div class="DataTables_sort_wrapper">
								Email
							</div>
						</th>	
						<th class="ui-state-default" rowspan="1" colspan="1">
							<div class="DataTables_sort_wrapper">
								Certifications
							</div>
						</th>						
						
						<th class="ui-state-default" rowspan="1" colspan="1"  width="13%">
							<div class="DataTables_sort_wrapper">
								Created
							</div>
						</th>
						
						<th class="ui-state-default" rowspan="1" colspan="1" width="10%">
							<div class="DataTables_sort_wrapper">
								Status
							</div>
						</th>
						
						<th class="ui-state-default" width="10%">
							Action
						</th>
										
					</tr>
                </thead>
				
				<?php
				if(isset($trainers) && count($trainers) > 0){
					$count = 0; 
					foreach($trainers as $prow){
						$index = ((($page-1)*$limit) + ($count+1));
						
					if(trim($prow['Trainer']['full_name']))
						$full = trim($prow['Trainer']['full_name']);
					else
						$full = "";	
				?>
				
				<tbody>				
				<tr class="gradeA <?php if($count%2==0) echo 'odd'; else echo 'even';?>">
					<td align="center"><?php echo $this->Form->text('Trainer.id][', array('type'=>'checkbox', 'value'=>$prow['Trainer']['id'],  'onclick'=>"checkSelection('data[Trainer][id][]', 'data[Trainer][all]')"));?></td>
					<td align="center"><?php echo $index;?></td>
					<td><a href="<?php echo $config['url']; ?>admin/trainers/view/<?php echo $prow['Trainer']['id']; ?>" target="_blank" ><?php echo $full; ?></a></td>
					<td><?php echo $prow['Trainer']['email'] ?></td>		
					<td>
					<a class="blueBtn" style=" margin-top:0px; padding: 2px 13px;margin-right:0px;" href="<?php echo $config['url'];?>admin/trainers/managecerti/<?php echo $prow['Trainer']['id'];?>">Add/Edit Certifications</a>
					</td>		
										
					<td align="center"><?php echo date($config['date_format'], strtotime($prow['Trainer']['added_date'])); ?></td>
					<td align="center"><?php 
						if($prow['Trainer']['status']==1){
							echo $this->Html->image('tick.png');	
						}else{
							echo $this->Html->image('cross.png');
						}	
							?>
							
							</td>
					<td align="center"><?php echo $this->Html->link($this->Html->image('edit-icon.png'),array('controller'=>'trainers','action'=>'edit/'.$prow['Trainer']['id'] ), array('title'=>'Edit Trainer','escape'=>false));?>
					</td>
					
				</tr>
				<?php $count++; } } ?>
				
				<?php if(isset($trainers) && count($trainers) > 0){?>
					<tr><td colspan="6">
					<div class="rowElem noborder">
						<?php  //echo $this->Form->select('Trainer.status',unserialize($config['status_array']),array('empty'=>'Select', 'id'=>'Status','style'=>'width:20%;float:left;')); ?>&nbsp;
						<?php  //echo $this->Form->submit('OK', array('style'=>'float:left;','class'=>'blueBtn submitForm','name'=>'data[Trainer][submit]', 'div'=>false, 'onclick'=>"return del('data[Trainer][id][]')"));?>
					</div>
					</td></tr>
				<?php }?>
				</tbody>
			
				</table>
				
				
				<?php
				if(isset($trainers) && count($trainers) > 0){
				?>
				
				<?php echo $this->element('admin/paginate')?>

				<?php
				}else {
				?>
				<div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
					<div class="dataTables_length" id="example_length" style="width:100%;text-align:center;">
						No records available yet.
					</div> 
				</div>
				<?php
				}
				?> 
			</div>
        </div>	
	</div>
</div>
<style>.topAction{border: 1px solid #D5D5D5;font-size: 12px;padding: 4px;width: 20%;}</style>
<script>
	$("#StatusTop").click(function(){ $("#valid").submit(); });
</script>		
<?php echo $this->Form->end(); ?>	