<?php

/**
 * Copyright © 2020 ePurnima. All rights reserved.
 */

namespace Ep\Catalogapi\Api;

interface CustomcatalogInterface
{
    /**
     * Retrieve catalog details
     * @param string $sku
     * @return mixed[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($sku);
}
