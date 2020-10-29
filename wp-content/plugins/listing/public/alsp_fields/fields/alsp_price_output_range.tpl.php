<?php
	if(count($content_field->range_options)){
		echo $content_field->formatPrice() . $content_field->formatPriceEnd();
	}