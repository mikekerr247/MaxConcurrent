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

class MaxConcurrentTableViewWidget extends \Piwik\Widget\Widget
{
    /**
     * @var string
     */
    const CATEGORY = 'General_Visitors';

    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId(self::CATEGORY);
        $config->setName(Piwik::translate('MaxConcurrent_ConcurrentUsageTable'));
        $config->setOrder(101);
    }

    public function render()
    {
        $view = ViewDataTableFactory::build('table', 'MaxConcurrent.getAllConcurrentUsers', $controllerAction = 'MaxConcurrent.tableView');
        $view->config->translations['value'] = Piwik::translate('MaxConcurrent_Visitors');
        $view->config->translations['label'] = Piwik::translate('MaxConcurrent_Hour');
        $view->requestConfig->filter_sort_column = 'label';
        $view->requestConfig->filter_sort_order = 'asc';
        $view->requestConfig->filter_limit = 100;
        $view->config->columns_to_display  = array('label', 'value');
        $view->config->show_exclude_low_population = false;
        $view->config->show_table_all_columns = false;
        $view->config->disable_row_evolution  = true;
        $view->config->max_graph_elements = 1440;
        $view->config->show_search = false;
        return $view->render();
    }
}
