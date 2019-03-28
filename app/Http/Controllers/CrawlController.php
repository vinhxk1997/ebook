<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;

class CrawlController extends Controller
{
    public function index(){
        $dom = HtmlDomParser::file_get_html('https://truyen.tangthuvien.vn/doc-truyen/trieu-hoan-mong-yem', false, null, 0);
        // foreach ($dom->find('#max-volume .cf li a') as $link) {
        //     echo $link->href . '<br>';
        // }

        $link = $dom->find('#max-volume .cf li a')[0];
        $doc = HtmlDomParser::file_get_html($link->href, false, null, 0);
        echo $doc->find('.box-chap', 0)->innertext;
    }
}
