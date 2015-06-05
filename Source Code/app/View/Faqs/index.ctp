<section class="contentContainer clearfix">
<div class="clear" style="margin-top:120px;"></div>
    <div class="row">
      <div class="tweleve columns mid-panel">
        <h1 class="heading">FAQs</h1>
        <p class="paragraph"><?php 
       /* echo '<pre>';
        print_r($faqInfo);
        echo '</pre>';*/
        foreach ($faqInfo as $key=>$val)
        {
        	echo '<b>Question: '.$val['Faq']['question'].'</b><br/>';
        	echo '<b>Answer: </b>'.$val['Faq']['answer'].'</b><br/>';
        }
        ?></p>
        <!--<a href="#" class="read-more">Read More</a> --></div>
    </div>
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
   