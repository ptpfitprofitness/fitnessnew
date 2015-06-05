<?php

class FusionController extends AppController
{

var $helpers = array('FusionCharts'); // used FusionCharts helper
var $components = array('FusionCharts'); // used fusionCharts components

function createCharts($charttype)
{

$this->set('charttype',$charttype);

if($charttype=='line') //create line chart
{
$this->FusionCharts->create
(
'Line2D Chart',
array
(
'type' => 'Line',
'width' => 600,
'height' => 350,
'id' => ''
)
);

$this->FusionCharts->setChartParams
(
'Line2D Chart',
array
(
'caption' => 'Competition chart',
'xAxisName' => '',
'yAxisName' => '',
'decimalPrecision' => '0',
'formatNumberScale' => '0',
'chartRightMargin' => '30'
)
);

$arr=array();
foreach($dataCompUser as $value)
{
$arr[]=array('value' => $value['compuser']['value_int'], 'params' => array('name' => $value['puser']['nickname']));
}
$this->FusionCharts->addChartData('Line2D Chart',$arr);
}
else
{
$this->FusionCharts->create
(
'Bar2D Chart',
array
(
'type' => 'Bar2D',
'width' => 600,
'height' => 350,
'id' => ''
)
);

$this->FusionCharts->setChartParams
(
'Bar2D Chart',
array
(
'caption' => 'Competition chart',
'xAxisName' => '',
'yAxisName' => '',
'decimalPrecision' => '0',
'formatNumberScale' => '0',
'chartRightMargin' => '30'
)
);

$arr=array();
foreach($dataCompUser as $value)
{
$arr[]=array('value' => $value['compuser']['value_int'], 'params' => array('name' => $value['puser']['nickname']));
}
$this->FusionCharts->addChartData('Bar2D Chart',$arr);
}
}

}
