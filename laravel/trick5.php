<?php

	select *, count(*) from products group by category_id having count(*) > 1;

	DB::table('prodcuts')
	 ->select('*', DB::row(count(*) as products_count))
	 ->groupBy('category_id')
	 ->having('products_count', '>', 1)
	 ->get();

	Product::groupBy('category_id')->havingRaw('count(*) > 1')->get();
