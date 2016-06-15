<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MaxConcurrent;

use Piwik\View;
use Piwik\WidgetsList;
use Piwik\ViewDataTable\Factory as ViewDataTableFactory;
use Piwik\Plugins\CoreVisualizations\Visualizations\Graph;

class Widgets extends \Piwik\Plugin\Widgets
{
    /**
     * @var string
     */
    protected $category = 'General_Visitors';

    protected function init()
    {
         $this->addWidget('Maximum Concurrent Users', $method = 'maxConcurrentUsage');
         $this->addWidget('Concurrent Usage By Time Span Graph', $method = 'lineGraph');
         $this->addWidget('Concurrent Usage By Time Span Table', $method = 'tableView');

    }

    /**
     *
     * @return string
     */
    public function maxConcurrentUsage()
    {
         $view = new View('@MaxConcurrent/concur_display.twig');
         $result = \Piwik\API\Request::processRequest('MaxConcurrent.getMaxConcurrentUsers');
         $view->concurrent = $result;
         return $view->render();

    }

        public function lineGraph()
    {

         $view = ViewDataTableFactory::build('graphEvolution', 'MaxConcurrent.getAllConcurrentUsers', $controllerAction = 'MaxConcurrent.lineGraph');
         $view->config->selectable_columns = array();
         $view->config->translations['value'] = "Visits";
         $view->config->max_graph_elements = 289;
         $view->config->show_exclude_low_population = false;
         $view->config->show_table_all_columns = false;
         $view->config->disable_row_evolution  = true;
         $view->config->show_bar_chart = false;
         $view->config->show_pie_chart = false;
         $view->config->show_tag_cloud = false;
         $view->config->show_search = false;
         $view->config->max_graph_elements = 288;
         $view->config->hide_annotations_view      = true;
         $view->config->show_all_view_icons      = false;
         $view->config->show_footer     = false;
         $view->requestConfig->filter_sort_order = 'asc';
         $view->requestConfig->filter_sort_column = 'label';
    
         return $view->render();
    }

        public function tableView()
    {

         $view = ViewDataTableFactory::build('table', 'MaxConcurrent.getAllConcurrentUsers', $controllerAction = 'MaxConcurrent.tableView');
        $view->config->translations['value'] = 'Visits';
        $view->config->translations['label'] = 'Hour';
        $view->requestConfig->filter_sort_column = 'label';
        $view->requestConfig->filter_sort_order = 'asc';
        $view->requestConfig->filter_limit = 100;
        $view->config->columns_to_display  = array('label', 'value');
        $view->config->show_exclude_low_population = false;
        $view->config->show_table_all_columns = false;
        $view->config->disable_row_evolution  = true;
        $view->config->max_graph_elements = 288;
        $view->config->show_search = false;
         return $view->render();
    }


}
