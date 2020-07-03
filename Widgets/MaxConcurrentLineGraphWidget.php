<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MaxConcurrent\Widgets;

use Piwik\Piwik;
use Piwik\ViewDataTable\Factory as ViewDataTableFactory;
use Piwik\Widget\WidgetConfig;

class MaxConcurrentLineGraphWidget extends \Piwik\Widget\Widget
{
    /**
     * @var string
     */
    const CATEGORY = 'General_Visitors';

    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId(self::CATEGORY);
        $config->setName(Piwik::translate('MaxConcurrent_ConcurrentUsageGraph'));
        $config->setOrder(100);
    }

    public function render()
    {
        $view = ViewDataTableFactory::build('graphEvolution', 'MaxConcurrent.getAllConcurrentUsers', $controllerAction = 'MaxConcurrent.lineGraph');
        $view->config->selectable_columns = array();
        $view->config->translations['value'] = Piwik::translate('MaxConcurrent_Visitors');
        $view->config->max_graph_elements = 1440;
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
}
