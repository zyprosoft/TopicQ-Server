<?php
namespace Com\Pdd\Pop\Sdk;

/**
 * Pop request类
 */
abstract class PopBaseHttpRequest extends PopBaseJsonEntity
{
    private $timestamp;

    public function __construct()
    {
    }

    public function getTimestamp()
    {
        if ($this->timestamp == null) {
            $this->timestamp = time();
        }

        return $this->timestamp;
    }

    public abstract function getVersion();

    public abstract function getDataType();

    public abstract function getType();


    public final function getParamsMap()
    {
        $paramsMap = array();
        $paramsMap["version"] = $this->getVersion();
        $paramsMap["data_type"] = $this->getDataType();
        $paramsMap["type"] = $this->getType();
        $paramsMap["timestamp"] = $this->getTimestamp();
        $this->setUserParams($paramsMap);
        return $paramsMap;
    }


    protected abstract function setUserParams(&$var);

    protected final function setUserParam(&$paramMap, $name, $param)
    {
        if (!is_null($param)&&$param !== "") {
            if ($this->isPrimaryType($param)) {
                $paramMap[$name] = $param;
            } else {
                $paramMap[$name] = json_encode($param);
            }
        }

    }

    private function isPrimaryType($param)
    {
        if (is_bool($param)) {
            return true;
        } else if (is_integer($param)) {
            return true;
        } else if (is_long($param)) {
            return true;
        } else if (is_float($param)) {
            return true;
        } else if (is_double($param)) {
            return true;
        } else if (is_numeric($param)) {
            return true;
        } else {
            return is_string($param);
        }
    }
}