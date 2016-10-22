<?php
	/*
		array:1 [
 		 	0 => array:6 [
    			"cartId" => "62"
    			"productId" => 1
    			"productDiscount" => 0.68
    			"create" => "2016-10-22 19:03:48"
    			"update" => "2016-10-22 19:03:48"
    			"productQty" => 2
  			]
		]
	*/

	foreach ($arr_product as $key => $product) {
        	if (isset($product['id'])) {
          		$where = [
                        	['cartId', '=', $cartId],
                        	['productId', '=', $product['id']],
              		];
                $exit = DB::table('cart_detail')->where($where)->first();
                    //dd($exit);
                $arr_cart_detail[$key] = [
                        'cartId' => $cartId,
                        'productId' => $product['id'],
                        'productDiscount' => $product['discount'],
                        'create' => date('Y-m-d H:i:s'),
                        'update' => date('Y-m-d H:i:s'),
                 ];
                 if ($exit) {
                        $arr_cart_detail[$key]['productQty'] =  $exit->productQty + $product['qty'];
                    } else {
                        $arr_cart_detail[$key]['productQty'] =  $product['qty'];
                    }
                    dd($arr_cart_detail);
                }
            }
	
	// 不添加key，就会，非同一个数组的情况
	/*
		array:2 [
 		 	0 => array:5 [
    				"cartId" => "62"
    				"productId" => 1
    				"productDiscount" => 0.68
    				"create" => "2016-10-22 19:19:26"
    				"update" => "2016-10-22 19:19:26"
  			]
  			1 => array:1 [
    				"productQty" => 2
  			]
		]
	*/
	foreach ($arr_product as $key => $product) {
                if (isset($product['id'])) {
                    $where = [
                        ['cartId', '=', $cartId],
                        ['productId', '=', $product['id']],
                    ];
                    $exit = DB::table('cart_detail')->where($where)->first();
                    //dd($exit);
                    $arr_cart_detail[$key] = [
                        'cartId' => $cartId,
                        'productId' => $product['id'],
                        'productDiscount' => $product['discount'],
                        'create' => date('Y-m-d H:i:s'),
                        'update' => date('Y-m-d H:i:s'),
                    ];
                    if ($exit) {
                        $arr_cart_detail[]['productQty'] =  $exit->productQty + $product['qty'];
                    } else {
                        $arr_cart_detail[]['productQty'] =  $product['qty'];
                    }
                    dd($arr_cart_detail);
                }
            }
