<?php

namespace App\Helpers;
use App\Models\{TdSale,TdPurchase};
use DB;

class Helper
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }

    public function getFinancialStartDate()
    {
        if ( date('m') > 3 ) {
            $startDate = date('Y').'-04-01';
        } else {
            $year = date('Y') - 1;
            $startDate = $year.'-04-01';
        }
        return $startDate;
    }

    public function getFinancialEndDate()
    {
        if ( date('m') > 3 ) {
            $year = date('Y') + 1;
            $date = $year.'-04-01';
            $endDate = date ("Y-m-d", strtotime ($date ."-1 days"));
        } else {
            $date = date('Y').'-04-01';
            $endDate = date ("Y-m-d", strtotime ($date ."-1 days"));
        }
        return $endDate;
    }

    public function stockProduct($product_master_id,$start_date)
    {
        // return $start_date;
        $society_id=auth()->user()->society_id;
        $Td_Purchase=TdPurchase::where('product_master_id',$product_master_id)
            ->where('society_id',$society_id)
            ->whereDate('purchase_date','>=',$start_date)
            ->whereDate('purchase_date','<=',date('Y-m-d'))
            ->get();
        
        $total_purchase_qty=0;
        foreach ($Td_Purchase as $key => $value) {
            $total_purchase_qty=$total_purchase_qty+$value->quantity;
        }
        // return $Td_Purchase;
        $TdSale=TdSale::where('product_master_id',$product_master_id)
            ->where('society_id',$society_id)
            ->whereDate('sale_date','>=',$start_date)
            ->whereDate('sale_date','<=',date('Y-m-d'))
            ->get();
        
        $total_sale_qty=0;
        foreach ($TdSale as $key => $value1) {
            $total_sale_qty=$total_sale_qty+$value1->quantity;
        }
        // return $total_sale_qty;
        return $total_stock=$total_purchase_qty - $total_sale_qty;
    }
}