<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		04/03/2014
##  Description :		Admin Trainer Packages Index
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

</script> 
<?php //pr($this->request->data);
//die('here');
 ?>
<?php echo $this->Form->create('Package' ,array('controller'=>'packages', 'action'=>'index', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>

<div class="content"> 

<div class="users index">
 
<?php 
if (($this->Session->check('Message.flash'))) {
	echo $this->Session->flash('flash', array('element' => 'flash'));
}
?>
 
<div class="table">
    <div class="head">
		<h5 class="iFrames">Trainers Session Packages</h5>
		<div class="rowElem noborder" style="clear:none;margin-top: -4px;">
			<?php if(isset($packages) && count($packages) > 0){ ?>
				<?php  echo $this->Form->select('Package.statusTop',unserialize($config['status_array']),array('empty'=>'Select','class'=>'topAction','style'=>'width:20%')); ?>&nbsp;
				<?php  echo $this->Form->submit('OK', array('style'=>'float:none;margin-left: -1px;','class'=>'blueBtn submitForm','name'=>'data[Package][submit]', 'div'=>false, 'onclick'=>"return del('data[Package][id][]')",'id'=>'StatusTop'));?>				
				
			<?php 	} ?> 		
				<a href="<?php echo $this->Html->url(array('controller'=>'packages', 'action'=>'add')); ?>" style="float: right; margin-top:0px; padding: 2px 13px;margin-right:0px;" class='blueBtn'>Add New</a>
		</div>		
	</div>
        <div class="dataTables_wrapper" id="example_wrapper">
			<?php echo $this->Form->create('Package',array('controller'=>'packages','action'=>'index/'.$this->params["pass"][0],'class'=>'mainForm')); ?>	
				<div class="">
					<div class="dataTables_filter" id="example_filter" style="right:15%;top:-38px;">
						<label>Search: <input type="text" name="keyword" value="<?php echo $keyword;?>" placeholder="Search by Package Name..."/>
						<div class="srch" style="right: 11px;top:4px;"><input style="padding: 2px 3px;" type="submit" name="submit" value="Search"/></div>
						</label>
					</div>
				</div>
			<?php 
				echo $this->Form->end();
				
				if(isset($packages) && count($packages) > 0){
					$this->Paginator->options(array('url' => array("controller"=>"packages","action"=>"index/$tab/keyword:$keyword")));
					echo $this->element('admin/paginate');
				} 
			?>
			<br/>
			<table cellspacing="0" cellpadding="0" border="0" id="" class="display">
                <thead>
                    <tr>
						<th class="ui-state-default" rowspan="1" colspan="1" width="3%">
							<div style="padding-right:8px;"><?php echo $this->Form->text('Package.all', array('type'=>'checkbox', 'id'=>'data[Package][all]', 'onclick'=>"selectDeselect('data[Package][id][]', this.name);"));?></div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width="3%">
							<div style="padding-right:8px;">#</div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width="20%">
							<div class="DataTables_sort_wrapper">
								Trainer Name
							</div>
						</th>
						<th class="ui-state-default" rowspan="1" colspan="1" width="20%">
							<div class="DataTables_sort_wrapper">
								Package Name
							</div>
						</th>
						
						
						<th class="ui-state-default" rowspan="1" colspan="1">
							<div class="DataTables_sort_wrapper">
								Number of Sessions
							</div>
						</th>						
						
						
						
						<th class="ui-state-default" rowspan="1" colspan="1"  width="13%">
							<div class="DataTables_sort_wrapper">
							  Price
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
				if(isset($packages) && count($packages) > 0){
					$count = 0; 
					foreach($packages as $prow){
						$index = ((($page-1)*$limit) + ($count+1));
						
					if(trim($prow['Package']['package_name']))
						$full = trim($prow['Package']['package_name']);
					else
						$full = "";	
					if(trim($prow['Trainer']['full_name']))
						$tfull = trim($prow['Trainer']['full_name']);
					else
						$tfull = trim($prow['Trainer']['username']);
				?>
				
				<tbody>				
				<tr class="gradeA <?php if($count%2==0) echo 'odd'; else echo 'even';?>">
					<td align="center"><?php echo $this->Form->text('Package.id][', array('type'=>'checkbox', 'value'=>$prow['Package']['id'],  'onclick'=>"checkSelection('data[Package][id][]', 'data[Package][all]')"));?></td>
					<td align="center"><?php echo $index;?></td>
					<td><?php echo $tfull;?></td>
					<td><a href="<?php echo $config['url']; ?>admin/packages/view/<?php echo $prow['Package']['id']; ?>" ><?php echo $full;?></a></td>
					<td><?php echo $prow['Package']['no_session'] ?></td>		
										
					<td align="center">$<?php echo $prow['Package']['price']; ?></td>
					<td align="center"><?php 
						if($prow['Package']['status']==1){
							echo $this->Html->image('tick.png');	
						}else{
							echo $this->Html->image('cross.png');
						}	
							?>
							
							</td>
					<td align="center"><?php echo $this->Html->link($this->Html->image('edit-icon.png'),array('controller'=>'packages','action'=>'edit/'.$prow['Package']['id'] ), array('title'=>'Edit Trainer Package','escape'=>false));?>
					</td>
					
				</tr>
				<?php $count++; } } ?>
				
				<?php if(isset($packages) && count($packages) > 0){?>
					<tr><td colspan="7">
					<div class="rowElem noborder">
						<?php  //echo $this->Form->select('Trainer.status',unserialize($config['status_array']),array('empty'=>'Select', 'id'=>'Status','style'=>'width:20%;float:left;')); ?>&nbsp;
						<?php  //echo $this->Form->submit('OK', array('style'=>'float:left;','class'=>'blueBtn submitForm','name'=>'data[Trainer][submit]', 'div'=>false, 'onclick'=>"return del('data[Trainer][id][]')"));?>
					</div>
					</td></tr>
				<?php }?>
				</tbody>
			
				</table>
				
				
				<?php
				if(isset($packages) && count($packages) > 0){
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