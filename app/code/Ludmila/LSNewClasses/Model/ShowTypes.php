<?php
namespace Ludmila\LSNewClasses\Model;

class ShowTypes
{

    public $typeString;
    public $typeObject;
    public $typeBoolean;
    public $typeNumber;
    public $typeInit;
    public $typeConst;
    public $typeNull;
    public $typeArray;

    public function __construct($typeString, $typeObject, $typeBoolean, $typeNumber, $typeInit, $typeConst, $typeNull, $typeArray)
    {
        $this->typeString = $typeString;
        $this->typeObject = $typeObject;
        $this->typeBoolean = $typeBoolean;
        $this->typeNumber = $typeNumber;
        $this->typeInit = $typeInit;
        $this->typeConst = $typeConst;
        $this->typeNull = $typeNull;
        $this->typeArray = $typeArray;
    }

    public function getArgs()
    {
        $param = [];
        $param['typeString'] = $this->typeString;
        $param['typeObject'] = $this->typeObject;
        $param['typeBoolean'] = $this->typeBoolean;
        $param['typeNumber'] = $this->typeNumber;
        $param['typeInit'] = $this->typeInit;
        $param['typeConst'] = $this->typeConst;
        $param['typeNull'] = $this->typeNull;
        $param['typeArray'] = $this->typeArray;
        return $param;
    }

}