<?php


namespace App\Entity;


class SearchDates {

    protected $startDate;
    protected $endDate;

    public function getStartDate(){
        return $this->startDate;
    }

    public function setStartDate(\DateTime $date = null){
        $this->startDate = $date;
    }

    public function getEndDate(){
        return $this->endDate;
    }

    public function setEndDate(\DateTime $date = null){
        $this->endDate = $date;
    }
}