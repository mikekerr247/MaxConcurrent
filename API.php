<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MaxConcurrent;

use Piwik\DataTable;
use Piwik\Date;
use Piwik\Piwik;

/**
 * API for plugin MaxConcurrent
 *
 * @method static \Piwik\Plugins\MaxConcurrent\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    /**
     * @param  int $idSite
     * @param  int $period
     * @param  int $date
     * @param  int $lastMinutes
     * @param  int $lastDays
     *
     * @return int
     */
    public function getMaxConcurrentUsers($idSite, $period, $date)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $settings = new Settings('MaxConcurrent');
        $lastDays = $settings->lastDays->getValue();
        $lastMinutes = $settings->timeInterval->getValue();

        /* Time is UTC in database. */
        $refNow = Date::factory('now');
        
        $timeLimit = $refNow->subDay($lastDays)->toString('Y-m-d H:i:s');

        $sql =  "SELECT MAX(g.concurrent) as maxbin, g.time as visittime
                 FROM (
                        SELECT COUNT(idvisitor) as concurrent, round(UNIX_TIMESTAMP(visit_last_action_time) / ?) as time 
                        FROM ". \Piwik\Common::prefixTable("log_visit") . "
                        WHERE visit_last_action_time >= ?
                        AND idsite = ?
                        GROUP BY time
                       ) g";

        $maxvisits = \Piwik\Db::fetchOne($sql, array(
            $lastMinutes * 60, $timeLimit, $idSite 
        ));
        
        $maxvisits = (int)$maxvisits;
        
        return $maxvisits;
    }

    public function getAllConcurrentUsers($idSite, $period, $date)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $settings = new Settings('MaxConcurrent');
        $lastDays = $settings->lastDays->getValue();
        $lastMinutes = $settings->timeInterval->getValue();

        $refNow = Date::factory('now');
        
        $timeLimit = $refNow->subDay($lastDays)->toString('Y-m-d H:i:s');

        $sql =  "SELECT MAX(g.concurrent) as maxbin, round((((g.time * ? * 60) % 86400) / 3600), 2) as xAxisLabel
                 FROM (
                        SELECT COUNT(idvisitor) as concurrent, round(UNIX_TIMESTAMP(visit_last_action_time) / ?) as time 
                        FROM ". \Piwik\Common::prefixTable("log_visit") . "
                        WHERE visit_last_action_time >= ?
                        AND idsite = ?
                        GROUP BY time
                       ) g
                 GROUP BY xAxisLabel";

        $rows = \Piwik\Db::fetchAll($sql, array(
            $lastMinutes, $lastMinutes * 60, $timeLimit, $idSite 
        ));

        $convisits = array();
            foreach ($rows as $row){
                $convisits[(string)$row['xAxisLabel'] . Piwik::translate('MaxConcurrent_HourShort')] = $row['maxbin'];
            }

        $table = DataTable::makeFromIndexedArray($convisits);

        return $table;
    }

}
