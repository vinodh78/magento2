<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Framework\MessageQueue\Config;

use Magento\Framework\MessageQueue\Code\Generator\Config\RemoteServiceReader\MessageQueue as RemoteServiceReader;

/**
 * Class for access to MessageQueue configuration data.
 */
class Data extends \Magento\Framework\Config\Data
{
    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\MessageQueue\Config\Reader\XmlReader $reader
     * @param \Magento\Framework\Config\CacheInterface $cache
     * @param \Magento\Framework\MessageQueue\Config\Reader\EnvReader $envReader
     * @param \Magento\Framework\MessageQueue\Config\Reader\EnvReader\Validator $envValidator
     * @param RemoteServiceReader $remoteServiceReader
     * @param string $cacheId
     */
    public function __construct(
        \Magento\Framework\MessageQueue\Config\Reader\XmlReader $reader,
        \Magento\Framework\Config\CacheInterface $cache,
        \Magento\Framework\MessageQueue\Config\Reader\EnvReader $envReader,
        \Magento\Framework\MessageQueue\Config\Reader\EnvReader\Validator $envValidator,
        RemoteServiceReader $remoteServiceReader,
        $cacheId = 'message_queue_config_cache'
    ) {
        $this->merge($remoteServiceReader->read());
        parent::__construct($reader, $cache, $cacheId);

        $envConfigData = $envReader->read();
        $envValidator->validate($envConfigData, $this->get());
        $this->merge($envConfigData);
    }
}
