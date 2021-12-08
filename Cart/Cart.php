<?php


namespace Cart;


use Cart\Abstracts\CartAbstracts;
use Cart\Builder\CartBuilder;
use Cart\Interfaces\CartInterface;
use Faker\Factory;
use Generator;

class Cart extends CartAbstracts implements CartInterface
{

	public function add(array $item): bool
	{
        $items = [];
        $items[] = $item;
        try {
            $this->builder->set([
                'cart' => $items
            ]);
            $this->sync_cart_session();
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
        return true;
	}

    /**
     * @throws Exceptions\InvalidRentalException
     * @throws Exceptions\InvalidItemException
     */
    public function update(string $id, array $updated_item): bool
	{
        $cart = $this->cart_session['cart'];
		$ids = array_column($cart , 'id');

        if (in_array($id , $ids)){
            $index = array_search($id , $ids);
            $cart[$index] = array_replace($cart[$index] , $updated_item);
            try {
                $this->builder->setItems($cart);
                return true;
            }catch (\Exception $exception){
                echo $exception->getMessage();
            }
        }
        return false;
	}

	public function remove(string $id): bool
	{
		// TODO: Implement remove() method.
	}

	public function get(?string $id = null): array
	{
		return $this->cart_session;
	}

	public function content(): Generator
	{
		// TODO: Implement content() method.
	}
}
