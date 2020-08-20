<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MaxConcurrent;

use Piwik\Piwik;
use Piwik\Settings\FieldConfig;

/**
 * Defines Settings for MaxConcurrent.
 *
 * Usage like this:
 * $settings = new Settings('MaxConcurrent');
 * $settings->autoRefresh->getValue();
 * $settings->metric->getValue();
 */
class UserSettings extends \Piwik\Settings\Plugin\UserSettings
{
    /** @var UserSetting */
    public $lastDays;

    /** @var UserSetting */
    public $timeInterval;

    protected function init()
    {
        $this->timeInterval = $this->createTimeIntervalSetting();

        $this->lastDays = $this->createLastDaysSetting();
    }

    private function createTimeIntervalSetting()
    {
        return $this->makeSetting('timeInterval', $default = '30', FieldConfig::TYPE_INT, function (FieldConfig $field) {
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->uiControlAttributes = array('size' => 3);
            $field->description = Piwik::translate('MaxConcurrent_TimeIntervalDescription');//'Defines the length of the time intervals in minutes ';
            $field->inlineHelp = Piwik::translate('MaxConcurrent_TimeIntervalHint');//'Enter a number which is <= 86400';
            $field->validate = function ($value, $setting) {
                if ($value > 86400 || $value <= 0) {
                    $value = 30;
                }
            };
        });
    }

    private function createLastDaysSetting()
    {
        return $this->makeSetting('lastDays', $default = '200', FieldConfig::TYPE_INT, function (FieldConfig $field) {
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->uiControlAttributes = array('size' => 3);
            $field->description = Piwik::translate('MaxConcurrent_LastDaysDescription');//'Defines how long ago from today should be examined in days ';
            $field->inlineHelp = Piwik::translate('MaxConcurrent_LastDaysHint');//'Enter a number which is > 0';
            $field->validate = function ($value, $setting) {
                if ($value <= 0) {
                    $value = 200;
                }
            };
        });
    }

}
