<?php
/**
 * @author Puneet Sethi <puneetsethi25@gmail.com>
 */

namespace punjabistudios\aws;


use Aws\Sdk;
use yii\base\Component;
use yii\base\InvalidConfigException;

class AwsSdk extends Component
{
    public $key;
    public $secret;
    public $region;
    public $version = 'latest';

    //additional options
    public $options = [];

    public $configFile = false;

    private $_config;

    /**
     * @var Sdk $_sdk
     */
    private $_sdk = null;

    public function init()
    {
        if ($this->configFile == false) {
            $this->_config = [
                'region' => $this->region,
                'version' => $this->version,
            ];

            //if credentials is set on app config.
            if (!$this->key == null && !$this->secret == null) {
                $this->_config = array_merge($this->_config, ['credentials' => [
                    'key' => $this->key,
                    'secret' => $this->secret,
                ]]);
            }

            $this->_config = array_merge($this->_config, $this->options);

        } else {
            if (!file_exists($this->configFile)) {
                throw new InvalidConfigException("{$this->configFile} does not exist");
            }
            $this->_config = $this->configFile;
        }

    }

    public function getSdk()
    {
        if ($this->_sdk === null) {
            $this->_sdk = new Sdk($this->_config);
        }
        return $this->_sdk;
    }

    public function __call($method, $params)
    {
        $sdk = $this->getSdk();
        if (is_callable([$sdk, $method]))
            return call_user_func_array(array($sdk, $method), $params);
        return parent::__call($method, $params);
    }

}