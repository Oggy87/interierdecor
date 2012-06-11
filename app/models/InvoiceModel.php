<?php

/**
 * Description of OrderModel
 *
 * @author oggy
 */
class InvoiceModel extends BaseModel {
    
    static function newInvoice($sale,$values) {
        $invoice = self::$notORM->invoice()->insert($values);
        $sale['invoice_id'] = $invoice['id'];
        $sale->update();
        
        return $invoice;
    }
    
    static function newReceipt($sale,$values) {
        $receipt = self::$notORM->receipt()->insert($values);
        $sale['receipt_id'] = $receipt['id'];
        $sale->update();
        
        return $receipt;
    }
}

?>
