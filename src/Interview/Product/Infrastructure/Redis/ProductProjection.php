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
    }

    public function removeProduct(string $id) : void
    {
        $this->adapter->deleteItem($this->adapter->getItem($id));
    }

    public function getProduct(string $productId) : ProductView
    {
        $item = $this->adapter->getItem($productId);
        if (!$item->isHit()) {
            throw ProductNotFoundException::forIdAsString($productId);
        }

        $productData = $item->get();
        $productData['id'] = $productId;

        return $this->createProductViewFromArray($productData);
    }

    public function getAlProducts() : array
    {
        $items = $this->adapter->getItems($this->getAllProductsId());
        $products = [];

        foreach ($items as $item) {
            $products[] = $this->createProductViewFromArray($item->get());
        }

        return $products;
    }

    public function reset() : void
    {
        $this->adapter->clear();
    }

    protected function getAllProductsId() : array
    {

    }

    protected function rememberProductId(string $id) : void
    {

    }
}
