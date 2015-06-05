<div class="fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
	<div id="example_length" class="dataTables_length">
		<label><?php echo $this->Paginator->counter(array('format' => 'Page %page% of %pages%, showing %current% records out of %count% total')); ?></label></div>
		<div class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_full_numbers" id="example_paginate">
			
			
			<?php
			if($this->Paginator->hasPrev()){
			?>
			<span class="previous fg-button ui-button" id="example_previous">
				<?php echo $this->Paginator->first('First');?>
			</span>
			<?php
			} else {
			?>
			<span class="previous fg-button ui-button ui-state-disabled" id="example_previous">
				First
			</span>
			<?php
			}
			?>
			
		
			
			
			<?php
			if($this->Paginator->hasPrev()){
			?>
			<span class="previous fg-button ui-button" id="example_previous">
				<?php echo $this->Paginator->prev('Previous');?>
			</span>
			<?php
			} else {
			?>
			<span class="previous fg-button ui-button ui-state-disabled" id="example_previous">
				 Previous
			</span>
			<?php
			}
			?>
			
			
			
			
			<span>
				<?php echo $this->Paginator->numbers(array("separator"=>"", "class"=>"fg-button ui-button")); ?>
			</span>
			
			<?php
			if($this->Paginator->hasNext()){
			?>
			<span class="previous fg-button ui-button" id="example_previous">
				<?php echo $this->Paginator->next('Next');?>
			</span>
			<?php
			} else {
			?>
			<span class="previous fg-button ui-button ui-state-disabled" id="example_previous">
				Next
			</span>
			<?php
			}
			?>
			
			<?php
			if($this->Paginator->hasNext()){
			?>
			<span class="previous fg-button ui-button" id="example_previous">
				<?php echo $this->Paginator->last('Last');?>
			</span>
			<?php
			} else {
			?>
			<span class="previous fg-button ui-button ui-state-disabled" id="example_previous">
				Last
			</span>
			<?php
			}
			?>
	</div>
</div>