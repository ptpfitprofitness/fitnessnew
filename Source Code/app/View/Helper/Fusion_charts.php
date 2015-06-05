<?php 
class FusionChartsHelper extends AppHelper
{
var $helpers = array('Html', 'Javascript', 'Session');
var $charts = array();

function beforeRender()
{
$this->Javascript->link('FusionCharts', false);
return true;
}

function afterRender()
{
$this->Session->del('FusionChartsPlugin.Charts');
}

function _getCharts()
{
static $read = false;

if ($read === true)
{
return $this->charts;
}

$this->charts = $this->Session->read('FusionChartsPlugin.Charts');
$read = true;

return $this->charts;
}

function render($name)
{
$charts = $this->_getCharts();

if (!isset($charts[$name]))
{
trigger_error(sprintf(__('Chart %s could not be found', true), $name), E_USER_ERROR);
return;
}

ob_start();
$charts[$name]->renderChart();
$output = @ob_get_contents();
@ob_end_clean();

return $this->output($output);
}
}