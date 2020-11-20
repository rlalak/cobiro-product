<?php


namespace Interview\Product\Infrastructure\Redis;


use Interview\Product\Infrastructure\CreateProductViewTrait;
use Interview\Product\Application\Query\GetProductQueryInterface;
use Interview\Product\Application\Query\ProductView;
use Interview\Product\Domain\ProductProjectionInterface;
use Interview\Product\Exception\Infrastructure\ProductNotFoundException;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class ProductProjection implements ProductProjectionInterface, GetProductQueryInterface
{
    use CreateProductViewTrait;

    private AdapterInterface $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function updateProduct(string $id, string $name, string $priceAmount, string $priceCurrency) : void
    {
        $item = $this->adapter->getItem($id);

        $item->set(['name' => $name, 'price_amount' => $priceAmount, 'price_currency' => $priceCurrency]);
        $this->adapter->save($item);

        $this->rememberProductId($id);
    }

    public function removeProduct(string $id) : void
    {
        $this->adapter->deleteItem($this->adapter->getItem($id));
        $this->forgotProductId($id);
    }

    public function getProduct(string $id) : ProductView
    {
        $item = $this->adapter->getItem($id);
        if (!$item->isHit()) {
            throw ProductNotFoundException::forIdAsString($id);
        }

        $productData = $item->get();
        $productData['id'] = $id;

        return $this->createProductViewFromArray($productData);
    }

    public function getAlProducts() : array
    {
        $items = $this->adapter->getItems($this->getAllProductsId());
        $products = [];

        foreach ($items as $key => $item) {
            $productData = $item->get();
            $productData['id'] = $key;

            $products[] = $this->createProductViewFromArray($productData);
        }

        return $products;
    }

    public function reset() : void
    {
        $this->adapter->clear();
    }

    protected function getAllProductsId() : array
    {
        // this is not the best solution (especially for large number of products) but the easiest one when using AdapterInterface
        $item = $this->adapter->getItem('all-ids');

        if ($item->isHit()) {
            return array_keys($item->get());
        }

        return [];
    }

    protected function rememberProductId(string $id) : void
    {
        $item = $this->adapter->getItem('all-ids');

        if ($item->isHit()) {
            $allIds = $item->get();
            $allIds[$id] = 1;

            $item->set($allIds);
        } else {
            $item->set([$id => 1]);
        }

        $this->adapter->save($item);
    }

    protected function forgotProductId(string $id) : void
    {
        $item = $this->adapter->getItem('all-ids');

        if ($item->isHit()) {
            $allIds = $item->get();
            unset($allIds[$id]);

            $item->set($allIds);
        }

        $this->adapter->save($item);
    }
}
