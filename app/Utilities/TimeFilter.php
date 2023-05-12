<?php

namespace App\Utilities;

use Carbon\Carbon;
use App\Exceptions\TimeFilterException;

class TimeFilter
{
    public static function get($endDate = null, $startDate = null, $noOfSteps = 6, $stepType): object
    {
        //Define end Date
        try {
            $endDate = $endDate ? Carbon::create((string) $endDate) : now();
        } catch (\Throwable $th) {
            $endDate = now();
        }

        //Define start Date
        if ($startDate) {
            try {
                $startDate = Carbon::create($startDate)->startOfDay();
            } catch (\Throwable $th) {
                $startDate = null;
            }

            // Define the noOfSteps
            switch ($stepType) {
                case TimeStepType::DAILY:
                    $noOfSteps = ceil($startDate->floatDiffInDays($endDate));
                    break;
                case TimeStepType::WEEKLY:
                    $noOfSteps = ceil($startDate->floatDiffInWeeks($endDate));
                    break;
                case TimeStepType::MONTHLY:
                    $noOfSteps = ceil($startDate->floatDiffInMonths($endDate));
                    break;
                case TimeStepType::YEARLY:
                    $noOfSteps = ceil($startDate->floatDiffInYears($endDate));
                    break;
                default:
                    throw new TimeFilterException("invalid 'stepType' query parameter");
            }
        } else {
            $startDate = null;
        }

        if ($startDate == null) {
            $placeholderEndDate = Carbon::create((string) $endDate);

            switch ($stepType) {
                case TimeStepType::DAILY:
                    $startDate = $placeholderEndDate->startOfDay()->subDays($noOfSteps);
                    break;
                case TimeStepType::WEEKLY:
                    $startDate = $placeholderEndDate->startOfWeek()->subWeeks($noOfSteps);
                    break;
                case TimeStepType::MONTHLY:
                    $startDate = $placeholderEndDate->startOfMonth()->subMonths($noOfSteps);
                    break;
                case TimeStepType::YEARLY:
                    $startDate = $placeholderEndDate->startOfYear()->subYears($noOfSteps);
                    break;
                default:
                    throw new TimeFilterException("invalid 'stepType' query parameter");
            }
        }

        return (object) compact(
            'endDate',
            'startDate',
            'stepType',
            'noOfSteps'
        );
    } //end method get
}//end class TimeFilter