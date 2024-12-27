<?php

if (!function_exists('spiral')) {
    function spiral()
    {
        if (class_exists('Spiral')) {
            global $SPIRAL;
            return $SPIRAL;
        }

        throw new Exception('SPIRAL変数が見つかりませんでした', 500);

        //return new Spiral();
    }
}