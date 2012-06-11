<?php

/**
 * Description of OrderModel
 *
 * @author oggy
 */
class OrderModel extends BaseModel {
    
    static function fetchByToken($token) {
        return self::$notORM->sale()->where("token",$token)->fetch();
    }
    
    static function newOrder($values,$products) {
        self::$notORM->begin;
       
        foreach ($values as &$value) {
            if($value === '') $value = NULL;
        }

        $order = self::$notORM->sale()->insert($values);
        
        foreach ($products as $id => $product) {
            $row = self::fetchRow('product', $id);
            $row->update(array('sales' => new NotORM_Literal("sales + $product[amount]")));
            $product['product_id'] = $id; 
            $product['sale_id'] = $order['id'];
            $product['priceDPH'] = Helpers::dph($product['price'], BasePresenter::DPH);
            self::$notORM->saleProduct()->insert($product);
        }
        self::$notORM->commit;
        
        return $order;
    }
    
    static function update($id, $values) {
        return self::$notORM->sale()
                                    ->where('id',$id)
                                    ->update($values);
    }
    
    static function addItem($values) {
        
        $saleProduct = self::$notORM->saleProduct()->insert($values);
        
        $sale = self::fetchRow('sale', $values['sale_id']);
        $total = $sale['total'] + $saleProduct['total'];
        $sale->update(array('total'=>$total));
        
        return $saleProduct;
    }
    
    static function addDiscount($values) {
        self::$notORM->begin;
        try {
            $sale = self::fetchRow('sale',$values['sale_id']);


            if(!$values['saleProduct_id']) {
                $values['total'] = $sale->saleProduct()->aggregation("SUM(total)") * $values['value'];
                
                $saleDiscount = self::fetchRow('saleDiscount',array('sale_id'=>$values['sale_id'],'saleProduct_id'=>$values['saleProduct_id']));
                
                if($saleDiscount) 
                    return false;
            }

            
            $sale->saleDiscount()->insert($values );
            
            $sale['total'] = $sale->saleProduct()->aggregation("SUM(total)") + $sale['shippingPrice'] + $sale['paymethodPrice'] - $values['total'];
            $sale->update();

            self::$notORM->commit;
            
            return true;
        }
        catch(PDOException $exc) {
            self::$notORM->rollback;
            return false;
        }
    }
}

?>
