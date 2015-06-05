<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		view, page settings and its details
## *****************************************************************
?>
<section id="midpart">
<article class="content-part">
<div class="about-us">
<?php 
    //if($termspage['Page']['page_slug']=='terms-privacy')
    $this->set('title_for_layout',$title_for_layout);
    echo "<h1>".$title_for_layout."</h1>";	
	echo $content;	
 ?>	
<br/><br/>
</div>      
</article>
<div class="clr"></div>
</section>