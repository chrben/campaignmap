<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    public function dateToDays($year, $seg, $day) 
    {
        $totalDays = 0;
        if ($seg > count($this->segments) - 1) return false;
        foreach($this->segments as $index => $segment) 
        {
            if ($segment->every_nth == null)
            {
                $totalDays += $year * $segment->length;
                if ($index < $seg) {
                    $totalDays += $segment->length;
                }
            }
            else
            {
                $totalDays += intval(floor($year/$segment->every_nth)) * $segment->length;
                if ($index < $seg && $year%$segment->every_nth == 0) {
                    $totalDays += $segment->length;
                }
            }
        }
        $totalDays += $day;
        return $totalDays;
    }

    public function daysToDate($days) 
    {
        $daysInAYear = 0;
        $leapDenominators = [];
        $daysUntilSegment = [];
        foreach($this->segments as $index => $segment) 
        {
            if ($segment->every_nth == null)
            {
                $daysUntilSegment[] = $daysInAYear;
                $daysInAYear += $segment->length;
            }
            else
            {
                $leapDenominators[] = [$segment->every_nth, $segment->length];
            }
        }
        $leapPeriod = 0;
        $leapDays = 0;
        foreach ($leapDenominators as $leap) {
            $leapPeriod = $leapPeriod == 0 ? $leap[0] : $leapPeriod * $leap[0];
        }
        foreach ($leapDenominators as $leap) {
            $leapDays += ($leap[0] / $leapPeriod) * $leap[1];
        }
        $daysPerLeapPeriod = $daysInAYear * $leapPeriod + $leapDays;
        $year = intval(floor(($days / $daysPerLeapPeriod) * $leapPeriod));
        $restDays = $days - $this->dateToDays($year, 0, 0);
        echo $restDays;
        $segment = 0;
        $day = 0;
        foreach ($daysUntilSegment as $index => $currentDayTotal) {
            if ($currentDayTotal < $restDays) {
                $segment = $index;
                $day = $restDays - $daysUntilSegment[$index];
            }
        }

        return [$year, $segment, $day];
    }

    public function segments() 
    {
        return $this->hasMany(CalendarSegment::class, 'calendar_id')->orderBy('index');
    }
}
