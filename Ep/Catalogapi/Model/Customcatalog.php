<?php

/**
 * Copyright © 2020 ePurnima. All rights reserved.
 */
namespace Ep\Catalogapi\Model;

use Ep\Catalogapi\Api\CustomcatalogInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Pricing\PriceCurrencyInterface;

/**
 * Class Customcatalog
 * @package Ep\Catalogapi\Model
 */
class Customcatalog implements CustomcatalogInterface
{
    /**
     * @var CollectionFactory
     */
    protected $productCollectionFactory;

    /** @var PriceCurrencyInterface $priceCurrency */
    protected $priceCurrency;
    /**
     * PostRepository constructor.
     * @param CollectionFactory $productCollectionFactory
     */
    public function __construct(
        PriceCurrencyInterface $priceCurrency,
        CollectionFactory $productCollectionFactory
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * @param $sku
     * @return \Magento\Framework\DataObject[]
     */
    public function getById($sku)
    {
        $return = [];
        $products = $this->getProducts($sku);
        foreach ($products->getItems() as $item){ 
            $return[] = [
                "name" => $item->getName(),
                "sku" => $item->getSku(),
                "price" => $this->getFormatedPrice($item->getFinalPrice()),
            ];
        }
        return $return;
    }


    /**
     * Function getFormatedPrice
     *
     * @param float $price
     *
     * @return string
     */
    public function getFormatedPrice($amount)
    {
        return $this->priceCurrency->convertAndFormat($amount, false);
    }
    /**
     * @param $categoryId
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    private function getProducts($sku)
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('sku', ['like' => "%$sku%"]);

        $collection->getSelect()->group('e.entity_id');

        return $collection;
    }
}
