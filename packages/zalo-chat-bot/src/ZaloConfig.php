<?php
/**
 * Zalo © 2017
 *
 */

namespace Zalo;

/**
 * Class ZaloConfig
 *
 * @package Zalo
 */
class ZaloConfig {

    /** @var self */
    protected static $instance;
    
    /** config your app id here */
    const ZALO_APP_ID_CFG = "1909228162873375583";
    
    /** config your app secret key here */
    const ZALO_APP_SECRET_KEY_CFG = "6VHEJ2Lzk3f5gl29xtR6";
    
    /** config your offical account id here */
    const ZALO_OA_ID_CFG = "2526770453643396075";
    
    /** config your offical account secret key here */
    const ZALO_OA_SECRET_KEY_CFG = "S6nRrQTsgHLOZCs5J9l6";

    /**
     * Get a singleton instance of the class
     *
     * @return self
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get zalo sdk config
     * @return []
     */
    public function getConfig() {
        return [
            'app_id' => static::ZALO_APP_ID_CFG,
            'app_secret' => static::ZALO_APP_SECRET_KEY_CFG,
            'oa_id' => static::ZALO_OA_ID_CFG,
            'oa_secret' => static::ZALO_OA_SECRET_KEY_CFG
        ];
    }

}
