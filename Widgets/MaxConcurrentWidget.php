<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MaxConcurrent\Widgets;

use Piwik\API\Request;
use Piwik\Piwik;
use Piwik\Widget\WidgetConfig;

class MaxConcurrentWidget extends \Piwik\Widget\Widget
{
    /**
     * @var string
     */
    const CATEGORY = 'General_Visitors';

    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId(self::CATEGORY);
        $config->setName(Piwik::translate('MaxConcurrent_MaxUsers'));
        $config->setOrder(99);
    }

    public function render()
    {
        $result = Request::processRequest('MaxConcurrent.getMaxConcurrentUsers');

        return $this->renderTemplate('concur_display', array(
            'concurrent' => $result
        ));
    }
}
