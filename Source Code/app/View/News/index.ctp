<section class="contentContainer clearfix">
<div class="clear" style="margin-top:120px;"></div>
    <div class="row">
      <div class="tweleve columns mid-panel">
        <h1 class="heading">Health and Fitness Tidbits</h1>
        <p class="paragraph"><?php 
       /* echo '<pre>';
        print_r($faqInfo);
        echo '</pre>';*/
        /*foreach ($faqInfo as $key=>$val)
        {
        	echo '<b>'.$val['Neww']['heading'].'</b><br/>';
        	echo $val['Neww']['description'].'<br/><span style="text-align:right;font-size: 13px;">Posted Date : '.date('l jS F Y',strtotime($val['Neww']['modified_date'])).'</span><br/>';
        }*/
        ?></p>
		<!--<p> <b>Health and Fitness Tidbits</b></p>-->
			 
			 <?php
					$rss = new DOMDocument();
					$rssfeeds = $setSpecalistArrURL['Admin']['rssurl'];
					//$rss->load('http://www.fitness.com/generated/rss_fit_tips.xml');
					$rss->load($rssfeeds);
					$feed = array();
					foreach ($rss->getElementsByTagName('item') as $node) {
						$item = array ( 
							'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
							'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
							'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
							'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
							);
						array_push($feed, $item);
					}
					$limit = 5;
					for($x=0;$x<$limit;$x++) {
						$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
						$link = $feed[$x]['link'];
						$description = $feed[$x]['desc'];
						$date = date('l F d, Y', strtotime($feed[$x]['date']));
						echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
						echo '<small><em>Posted on '.$date.'</em></small></p>';
						echo '<p>'.$description.'</p>';
					}
				?>
        <!--<a href="#" class="read-more">Read More</a> --></div>
    </div>
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
   