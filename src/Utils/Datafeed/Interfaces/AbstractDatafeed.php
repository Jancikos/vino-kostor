<?php

namespace App\Utils\Datafeed\Interfaces;

abstract class AbstractDatafeed
{
    protected $data;
    protected IDatafeedParams $params;

    public function __construct() { }

    public function getData(IDatafeedParams $params) {
        $this->params = $params;
        $this->_validateParams();

        $this->data = $this->_getDefaultData();
        
        $this->_prepareData();

        return $this->data;
    }
    
    /**
     * @return array struktura ako maju byt data vracane z datafeedu + defaultne hodnoty
     */
    protected function _getDefaultData() {
        $defData = [];
        
        return $defData;
    }

    /**
     * spracuje data z databazy a ulozi ich do $this->data
     * 
     *  @return void
     */
    protected abstract function _prepareData();
    
    /**
     * validuje parametre
     * 
     * @return void
     * @throws \Exception ak su parametre nevalidne
     */
    protected function _validateParams() { }
}