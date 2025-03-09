<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateUtils
{
    public function nextDateFromPeriod($date, $period)
    {
        if (isset($period)) {
            if ($period['repeat'] == 'day') {
                return $this->getRepeatFromDay($date, $period);
            } else if ($period['repeat'] == 'week') {
                return $this->getRepeatFromWeek($date, $period);
            } else {
                return $this->getRepeatFromMonth($date, $period);
            }
        }
        return null;
    }

    private function getRepeatFromDay($date, $period)
    {
        return isset($period['every']) ? $date->addDays($period['every']) : $date->addDay();
    }

    private function getRepeatFromWeek($date, $period)
    {
        if (!isset($period['every']) && !isset($period['week_days']))
            $date->addWeek();
        else if (isset($period['every']) && !isset($period['week_days'])) {
            $date->addWeeks($period['every']);
        } else {
            $date = $this->getNextDateFromWeek($date, $period);
        }
        return $date;
    }

    private function getNextDateFromWeek($date, $period)
    {
        if (!isset($period['every'])) {
            $period['every'] = 1;
        }
        $next = $date->copy();
        while (true) {
            if ($period['first_send']) {
                $next->addWeek($period['every'])->startOfWeek(0);
                $date->startOfWeek(0);
                $period['first_send'] = false;
            } else {
                $next->addDay();
            }
            if (in_array($next->dayOfWeek, $period['week_days'])) {
                $difference = $date->diffInWeeks($next);
                if ($difference % $period['every'] == 0) {
                    break;
                }
            }
        }
        return $next;
    }

    private function getRepeatFromMonth($date, $period)
    {
        if ($period['month_type'] == 'day') {
            return $this->getRepeatFromMonthAtDay($date, $period);
        }
        return $this->getRepeatFromMonthAtDayOfWeek($date, $period);
    }

    private function getRepeatFromMonthAtDay($date, $period)
    {
        if (!isset($period['days']) && !isset($period['months'])) {
            $date->addMonth();
        } else if (isset($period['days']) && !isset($period['months'])) {
            while (true) {
                $date->addDay();
                $next = $date->copy();
                $next->endOfMonth();
                if (in_array($date->dayOfMonth, $period['days']) || (in_array('last', $period['days']) && $date->day == $next->day)) {
                    break;
                }
            }
        } else if (!isset($period['days']) && isset($period['months'])) {
            while (true) {
                $date->addMonth();
                if (in_array($date->month, $period['months'])) {
                    break;
                }
            }
        } else {
            $next = $date->copy();
            while (true) {
                $next->addDay();
                if (in_array($next->dayOfMonth, $period['days']) || (in_array('last', $period['days']) && $date->day == $next->day)) {
                    $difference = $date->diffInMonths($next);
                    if ($difference % $period['every'] == 0) {
                        $date = $next;
                        break;
                    }
                }
            }
        }
        return $date;
    }

    private function getRepeatFromMonthAtDayOfWeek($date, $period)
    {
        if (!isset($period['days']) && !isset($period['months']) && !isset($period['week_days'])) {
            $date->addMonth();
        } else {
            $next = $date->copy();
            if (!isset($period['months'])) {
                $period['months'] = [1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 11, 12];
            }
            if (!isset($period['days']) && !isset($period['week_days'])) {
                while (true) {
                    $next->addMonth();
                    if (in_array($next->month, $period['months'])) {
                        $date = $next;
                        break;
                    }
                }
            } else {
                while (true) {
                    $next->addDay();
                    if (in_array($next->month, $period['months'])) {
                        if (!isset($period['days']) && isset($period['week_days']) && in_array($next->dayOfWeek(), $period['week_days'])) {
                            $date = $next;
                            break;
                        } else if (isset($period['days']) && isset($period['week_days'])) {
                            $break = false;
                            foreach ($period['week_days'] as $wd) {
                                if (!in_array($wd, [0, 1, 2, 3, 4, 5, 6])) {
                                    continue;
                                }
                                foreach ($period['days'] as $d) {
                                    $d = $d == -1 ? $next->copy()->lastOfMonth($wd) : $next->copy()->nthOfMonth($d, $wd);
                                    if ($d->gt($date)) {
                                        $date = $d;
                                        $break = true;
                                        break;
                                    }
                                }
                                if ($break) {
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $date;
    }
}