<?php

declare(strict_types=1);

namespace Shop;

final class Shop
{
    /**
     * @var Item[]
     */
    private $items;

    const MAX_QUALITY = 50;
    
    static $not_for_sale = array('Mjolnir' => 'true');
    static $magic_items = array('Magic cake' => 'true');
    static $quality_incr = 1;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            if(!isset(self::$not_for_sale[$item->name])) {
                $item->sell_in = $item->sell_in - 1;

                if($item->name == 'Blue cheese') {
                    if($item->sell_in < 0) {
                        $quality_incr = $quality_incr + 1;
                    }         
                }

                if($item->name == 'Concert tickets') {
                    if ($item->sell_in < 10) {
                        $quality_incr = $quality_incr + 1;
                    }
                    if ($item->sell_in < 5) {
                        $quality_incr = $quality_incr + 1;
                    }     
                    if ($item->sell_in < 0) {
                        $quality_incr = -$item->quality;
                    }  
                }
                
                if ($item->name != 'Blue cheese' and $item->name != 'Concert tickets') {
                    if ($item->sell_in >= 0) {
                        $quality_incr = -1;
                    }
                
                    else {
                        $quality_incr = -2;
                    }

                    if(isset(self::$magic_items[$item->name])) {
                        $quality_incr = $quality_incr * 2;
                    }
                } 

                if($quality_incr > 0) {
                    if($item->quality + $quality_incr > self::MAX_QUALITY) {
                        $item->quality = self::MAX_QUALITY;
                    }
                    else {
                        $item->quality = $item->quality + $quality_incr;
                    }
                }
                else {
                    if($item->quality + $quality_incr < 0) {
                        $item->quality = 0;
                    }
                    else {
                        $item->quality = $item->quality + $quality_incr;
                    }
                }
                
       
            }

            $quality_incr = 1;
        }
    }
    
}
