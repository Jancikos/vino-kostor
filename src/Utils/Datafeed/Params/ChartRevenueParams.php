<?php

namespace App\Utils\Datafeed\Params;

use App\Utils\Datafeed\Interfaces\IDatafeedParams;
use DateTime;

class ChartRevenueParams implements IDatafeedParams
{
    private DateTime $periodFrom;
    private DateTime $periodTo;

    public function __construct() {
        $this->periodFrom = new DateTime();
        $this->periodTo = new DateTime();

        $this->setYtdPeriod();
     }


    /**
     * Set period from 12 months ago to now
     * periodFrom will be first day of month 12 months ago
     * periodTo will be last day of month now
     * @return void 
     */
    public function setYtdPeriod(): void
    {
        $this->periodFrom = new DateTime('first day of last month - 11 months');
        $this->periodTo = new DateTime('last day of this month');
    }
    
    public function setPeriodFrom(DateTime $periodFrom): void
    {
        $this->periodFrom = $periodFrom;
    }

    public function setPeriodTo(DateTime $periodTo): void
    {
        $this->periodTo = $periodTo;
    }
    
    public function getPeriodFrom(): DateTime
    {
        return clone($this->periodFrom);
    }

    public function getPeriodTo(): DateTime
    {
        return clone($this->periodTo);
    }
}