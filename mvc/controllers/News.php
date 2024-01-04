<?php
class News extends Controller {
    public static function SayHi() {
        echo "News - SayHi";
    }

    public static function Abc($ho, $ten) {
        echo $ho . " - " . $ten;
    }

    public static function XuLy($trang) {
        echo $trang;
    }
}