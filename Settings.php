<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MaxConcurrent;

use Piwik\Settings\SystemSetting;
use Piwik\Settings\UserSetting;

/**
 * Defines Settings for MaxConcurrent.
 *
 * Usage like this:
 * $settings = new Settings('MaxConcurrent');
 * $settings->autoRefresh->getValue();
 * $settings->metric->getValue();
 */
class Settings extends \Piwik\Plugin\Settings
{
    /** @var UserSetting */
    public $lastDays;

    /** @var UserSetting */
    public $timeInterval;

    protected function init()
    {
        $this->setIntroduction('Here you can specify the length of the time intervals .');

        $this->createTimeIntervalSetting();

        $this->createLastDaysSetting();


    }


    private function createTimeIntervalSetting()
    {
        $this->timeInterval        = new UserSetting('timeInterval', 'Time Interval');
        $this->timeInterval->type  = static::TYPE_INT;
        $this->timeInterval->uiControlType = static::CONTROL_TEXT;
        $this->timeInterval->uiControlAttributes = array('size' => 3);
        $this->timeInterval->description     = 'Defines the length of the time intervals in minutes ';
        $this->timeInterval->inlineHelp      = 'Enter a number which is <= 86400';
        $this->timeInterval->defaultValue    = '30';
        $this->timeInterval->validate = function ($value, $setting) {
            if ($value > 86400 || $value <= 0) {
                $value = 30;
            }
        };

        $this->addSetting($this->timeInterval);
    }

    private function createLastDaysSetting()
    {
        $this->lastDays            = new UserSetting('lastDays', 'Last Days');
        $this->lastDays->type  = static::TYPE_INT;
        $this->lastDays->uiControlType = static::CONTROL_TEXT;
        $this->lastDays->uiControlAttributes = array('size' => 3);
        $this->lastDays->description     = 'Defines how long ago from today should be examined in days ';
        $this->lastDays->inlineHelp      = 'Enter a number which is > 0';
        $this->lastDays->defaultValue    = '200';
        $this->lastDays->validate = function ($value, $setting) {
            if ($value <= 0) {
                $value = 200;
            }
        };

        $this->addSetting($this->lastDays);
    }

}
