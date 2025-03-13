<?php

namespace App\Traits;

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
        if ($period['first_send']) {
            $next = $next->addWeeks($period['every']);
        }
        while (true) {
            $next->addDay();
            if (in_array($next->dayOfWeek, $period['week_days'])) {
                $startWeek = $date->copy()->startOfWeek(0);
                $endWeek = $next->copy()->startOfWeek(0);
                $difference = $startWeek->diffInWeeks($endWeek);
                if ($difference % $period['every'] == 0) {
                    break;
                }
            }
        }
        return $next;
    }

    private function getRepeatFromMonth($date, $period)
    {
        if (
            !isset($period['month_type']) ||
            (!isset($period['days']) && !isset($period['week_days'])) ||
            ($period['month_type'] == 'day' && !isset($period['days'])) ||
            ($period['month_type'] == 'el' && !isset($period['week_days']))
        ) {
            return $this->getRepeatFromMonthOnly($date, $period);
        } else if ($period['month_type'] == 'day') {
            return $this->getRepeatFromMonthAtDay($date, $period);
        }
        return $this->getRepeatFromMonthAtDayOfWeek($date, $period);
    }

    private function getRepeatFromMonthOnly($date, $period)
    {
        $next = $date->copy();
        if (!isset($period['months'])) {
            $next->addMonthNoOverflow();
        } else {
            while (true) {
                $next->addMonthNoOverflow();
                if (in_array($next->month, $period['months'])) {
                    break;
                }
            }
        }
        return $next;
    }

    private function getRepeatFromMonthAtDay($date, $period)
    {
        $next = $date->copy();
        if (!isset($period['months'])) {
            while (true) {
                $next->addDay();
                $lastDate = $next->copy()->endOfMonth();
                if (
                    in_array($next->day, $period['days']) ||
                    (in_array('last', $period['days']) && $lastDate->day == $next->day)
                ) {
                    break;
                }
            }
        } else {
            while (true) {
                $next->addDay();
                $lastDate = $next->copy()->endOfMonth();
                if ((in_array($next->day, $period['days']) ||
                        (in_array('last', $period['days']) && $lastDate->day == $next->day)) &&
                    in_array($next->month, $period['months'])
                ) {
                    break;
                }
            }
        }
        return $next;
    }

    private function getRepeatFromMonthAtDayOfWeek($date, $period)
    {
        $next = $date->copy();
        if (!isset($period['months'])) {
            $period['months'] = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        }
        if (isset($period['week_days']) && !isset($period['days'])) {
            while (true) {
                $next->addDay();
                if (
                    in_array($next->dayOfWeek, $period['week_days']) &&
                    in_array(
                        $next->month,
                        $period['months']
                    )
                ) {
                    break;
                }
            }
        } else {
            while (true) {
                $next->addDay();
                if (in_array($next->month, $period['months'])) {
                    $lastDayOfMonth = $next->copy()->endOfMonth();
                    $dayOfWeek = $next->dayOfWeek;
                    $lastDayOfWeek = $lastDayOfMonth->copy()->previous($dayOfWeek);
                    $week = ceil($next->day / 7);
                    if (
                        in_array($dayOfWeek, $period['week_days']) &&
                        (in_array($week, $period['days']) || (in_array('last', $period['days']) && $lastDayOfWeek->format('Y-m-d') == $next->format('Y-m-d')))
                    ) {
                        break;
                    }
                } else {
                    $next->endOfMonth();
                }
            }
        }
        return $next;
    }
}