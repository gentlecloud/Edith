<?php
namespace Gentle\Edith\Support\Database;

use Illuminate\Support\Facades\DB;
class Helper
{
    /**
     * SQL 执行记录
     * @var array
     */
    protected static array $record = [];

    /**
     * 查询时间
     * @var float
     */
    protected static float $queryTime = 0;

    /**
     * 监听记录 SQL 查询
     * @return void
     */
    public static function listen()
    {
        DB::listen(function ($query) {
            $bindings = $query->bindings;
            $sql      = $query->sql;

            foreach ($bindings as $replace) {
                $value = is_numeric($replace) ? $replace : "'" . $replace . "'";
                $sql   = preg_replace('/\?/', $value, $sql, 1);
            }

            $sql = sprintf('[%s ms] %s', $query->time, $sql);

            self::$queryTime += $query->time;
            self::$record[] = $sql;
        });
    }

    /**
     * 获取 SQL 执行记录
     * @return array
     */
    public static function records(): array
    {
        if (self::$queryTime > 1000) {
            $queryTime = round(self::$queryTime / 1000, 2) . 's';
        } else {
            $queryTime = round(self::$queryTime, 2) . 'ms';
        }
        return [
            '_record' => self::$record,
            '_query_time' => $queryTime
        ];
    }
}