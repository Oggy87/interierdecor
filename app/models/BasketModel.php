<?php


class BasketModel extends BaseModel {

    static function fetchBasket($customer_id) {
        return self::$notORM->basket('customer_id',$customer_id);
    }

    static function update($customer_id, $product_id, $amount) {
        return self::$notORM->basket()
                                    ->where('customer_id',$customer_id)
                                    ->where('product_id', $product_id)
                                    ->update(array("amount" => $amount));
    }
    
    static function clear($customer_id) {
        return self::$notORM->basket()->where('customer_id',$customer_id)->delete();
    }

    static function intoBasket($basket,$customer_id) {
        
        try {
            foreach ($basket as $product_id => $amount) {
                $product_id = intval($product_id);
                $amount = intval($amount);

                self::$notORM->basket()
                                ->insert_update(
                                        array('customer_id' => $customer_id,
                                               'product_id' => $product_id),
                                        array('customer_id' => $customer_id,
                                               'product_id' => $product_id,
                                               'amount' => $amount),
                                        array('amount' => $amount));
                unset($basket[$product_id]);
            }

        } catch (PDOException $exc) {
            Debug::log($exc->getMessage());
        }
    }

    static function addToBasket($basket,$customer_id) {

        try {
            foreach ($basket as $product_id => $amount) {
                $product_id = intval($product_id);
                $amount = intval($amount);

                self::$notORM->basket()
                                ->insert_update(
                                        array('customer_id' => $customer_id,
                                               'product_id' => $product_id),
                                        array('customer_id' => $customer_id,
                                               'product_id' => $product_id,
                                               'amount' => $amount),
                                        array('amount' => $amount));
                unset($basket[$product_id]);
            }
            return true;
        } catch (PDOException $exc) {
            Debug::log($exc->getMessage());
            return false;
        }
    }

    static function removeFromBasket($product_id, $customer_id) {
        try {
            self::$notORM->basket()->where(array('customer_id' => $customer_id,
                                               'product_id' => $product_id))
                            ->delete();

            return true;
        } catch (PDOException $exc) {
            Debug::log($exc->getMessage());
            return false;
        }
    }
}
