<?php
namespace Ludmila\LSNewClasses\Model;

class ShowTypes
{
    private $typeString;
    private $typeObject;
    private $typeBoolean;
    private $typeNumber;
    private $typeInit;
    private $typeConst;
    private $typeNull;
    private $typeArray;

    /**
     * ShowTypes constructor.
     * @param $typeString
     * @param $typeObject
     * @param $typeBoolean
     * @param $typeNumber
     * @param $typeInit
     * @param $typeConst
     * @param $typeNull
     * @param $typeArray
     */
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

    /**
     * @return array
     */
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