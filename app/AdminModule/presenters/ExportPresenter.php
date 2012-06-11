<?php

/**
 * My Application
 *
 * @copyright  Copyright (c) 2010 John Doe
 * @package    MyApplication
 */

require_once LIBS_DIR . '/PHPExcel/PHPExcel/IOFactory.php';

/**
 * Sign in/out presenters.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class Admin_ExportPresenter extends Admin_BasePresenter
{

        
    public function actionInvoice($id) {
        $sale = $this->fetchRow("sale", $id);
        if($sale['invoice_id']) {
            $objPHPExcel = PHPExcel_IOFactory::load(WWW_DIR.'/'.$sale->invoice['excel_path']);
            $name = basename($sale->invoice['excel_path']);
        }
        else {
            if(!file_exists(WWW_DIR.'/static/files/invoice-pattern.xls')) {
                throw new InvalidStateException("Soubor".WWW_DIR.'/static/files/invoice-pattern.xls nenalezen');
            }
            
            $id = BaseModel::fetchAll('invoice')->max('id') + 1;
            $number  = '50'.Helpers::padLeft($id, 2,'0').  TemplateHelpers::date($sale['created'], 'Y');
            
            $objPHPExcel = PHPExcel_IOFactory::load(WWW_DIR.'/static/files/invoice-pattern.xls');
            $today = new DateTime53();
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('I1',$number)
                    ->setCellValue('I3','i'.$sale['id'])
                    ->setCellValue('I5',strtok($sale['paymethod'], " "))
                    ->setCellValue('I6',$sale['shipping'])
                    ->setCellValue('D11',strtok($sale['paymethod'], " "))
                    ->setCellValue('C15',$sale['name'])
                    ->setCellValue('C16',$sale['street'])
                    ->setCellValue('C17',$sale['postcode'].' '.$sale['city'])
                    ->setCellValue('D10',$today->format('j.n.Y'))
                    ->setCellValue('D12',$today->format('j.n.Y'));
            
            if($sale['iscompany']) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('C18',$sale['ic']);
                if($sale['dic'])
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('C19',$sale['dic']);
            }
            
            $totalwithoutdph = ($sale['total']*100)/(100+(100*$sale['dph']));
            
            $objPHPExcel->getActiveSheet()->setCellValue('I26',  Helpers::currency($totalwithoutdph));
            $objPHPExcel->getActiveSheet()->setCellValue('I27',  Helpers::currency($sale['total']-$totalwithoutdph));
            $objPHPExcel->getActiveSheet()->setCellValue('I29',  Helpers::currency($sale['total']));
            
            $baseRow = 25;
            if($sale['shippingPrice'] > 0) {
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($baseRow,1);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$baseRow, 'poštovné');
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$baseRow, 1);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$baseRow, 'ks');
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$baseRow, Helpers::currency(($sale['shippingPrice'] * 100)/(100+($sale['dph']*100))));
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$baseRow, $sale['dph'] * 100);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$baseRow, Helpers::currency(($sale['shippingPrice'] * 100)/(100+($sale['dph']*100))));
            }
            foreach($sale->saleDiscount()->order('id DESC') as $saleDiscount) {
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($baseRow,1);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$baseRow, 'sleva');
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$baseRow, $saleDiscount['value'] * 100);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$baseRow, '%');
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$baseRow, '-');
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$baseRow, $sale['dph'] * 100);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$baseRow, '- ' .Helpers::currency(($saleDiscount['total'] * 100)/(100+($sale['dph']*100))));
            }
            foreach($sale->saleProduct()->order('id DESC') as $saleProduct) {
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($baseRow,1);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$baseRow, $saleProduct['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$baseRow, $saleProduct['amount']);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$baseRow, $saleProduct['unit']);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$baseRow, Helpers::currency($saleProduct['price']));
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$baseRow, $sale['dph'] * 100);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$baseRow, Helpers::currency(($saleProduct['total'] * 100)/(100+($sale['dph']*100))));
            }
            
            
            
            $objWriterXls = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriterXls->save(WWW_DIR.'/static/files/invoices/'.$number.'.xls');
            
            /*$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
            $objWriter->save(WWW_DIR.'/static/files/invoices/50032012.pdf');*/
            try {
                $invoice = InvoiceModel::newInvoice($sale,array('id'=>$id,'excel_path'=>'/static/files/invoices/'.$number.'.xls','number'=>$number));
            }
            catch (PDOException $exc) {
                Debug::log($exc, Debug::ERROR);
            }
            $name = $number.'.xls';
        }
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'"');
        header('Cache-Control: max-age=0');

        $objWriterDownload = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriterDownload->save('php://output');
        
        $this->terminate();
    }
    
    public function actionReceipt($id) {
        $sale = $this->fetchRow("sale", $id);
        if($sale['receipt_id']) {
            $objPHPExcel = PHPExcel_IOFactory::load(WWW_DIR.'/'.$sale->receipt['excel_path']);
            $name = basename($sale->receipt['excel_path']);
        }
        else {
            if(!file_exists(WWW_DIR.'/static/files/receipt-pattern.xls')) {
                throw new InvalidStateException("Soubor".WWW_DIR.'/static/files/receipt-pattern.xls nenalezen');
            }
            
            $objPHPExcel = PHPExcel_IOFactory::load(WWW_DIR.'/static/files/receipt-pattern.xls');
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C14','i'.$sale['id'])
                    ->setCellValue('C15',$sale['shipping'])
                    ->setCellValue('C5',$sale['name'])
                    ->setCellValue('C6',$sale['street'])
                    ->setCellValue('C7',$sale['postcode'].' '.$sale['city'])
                    ->setCellValue('C10',$sale['phone'])
                    ->setCellValue('C11',$sale['email']);
            
            if($sale['iscompany']) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('C8',$sale['ic']);
                if($sale['dic'])
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('C9',$sale['dic']);
            }
            
            $baseRow = 23;

            foreach($sale->saleProduct()->order('id DESC') as $saleProduct) {
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($baseRow,1);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$baseRow, $saleProduct['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$baseRow, $saleProduct['amount']);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$baseRow, $saleProduct['unit']);
            }
            
            $id = BaseModel::fetchAll('receipt')->max('id') + 1;
            
            $objWriterXls = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriterXls->save(WWW_DIR.'/static/files/receipts/D'.$id.'.xls');
            
            /*$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
            $objWriter->save(WWW_DIR.'/static/files/invoices/50032012.pdf');*/
            try {
                $invoice = InvoiceModel::newReceipt($sale,array('excel_path'=>'/static/files/receipts/D'.$id.'.xls'));
            }
            catch (PDOException $exc) {
                Debug::log($exc, Debug::ERROR);
            }
            $name = $id.'.xls';
        }
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'"');
        header('Cache-Control: max-age=0');

        $objWriterDownload = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriterDownload->save('php://output');
        
        $this->terminate();
    }
    
}
