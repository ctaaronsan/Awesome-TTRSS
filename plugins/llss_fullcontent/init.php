<?php
require "/vendor/autoload.php";

use Masterminds\HTML5;

class llss_fullcontent extends Plugin {
    
    private $host;

    function about() {
        return array(
            3.0,
            "抓取琉璃神社文章的完整内容, 并添加磁链和度盘的超链接",
            "Aaron San",
            false
            );
    }

    function init($host) {
        $this->host = $host;

        $host->add_hook($host::HOOK_ARTICLE_FILTER, $this);
    }

    function hook_article_filter($article) {
        if (strpos($article["link"], "www.liuli.") != FALSE) {
            $h5 = new HTML5();
            $dom = $h5->loadHTMLFile($article["link"]);

            $xpath = new DOMXPath($dom);
            # see https://stackoverflow.com/questions/28148178/xpath-query-wont-return-results
            $xpath->registerNamespace('x', 'http://www.w3.org/1999/xhtml');
            $contents = $xpath->evaluate("//x:div[@class='entry-content']");
            
            if ($contents->length > 0) {
                // let article content be the original content
                $content = $dom->saveHTML($contents->item(0));

                // 图片后面加换行
                $content = preg_replace('/(<img [^<>]+>)/', '${1}<br>', $content);

                // add magnet links
                // BitTorrent Info Hash
                $pat = '/(?<![[:xdigit:]])((?:magnet:\?xt=urn:btih:)?([[:xdigit:]]{40}))(?![[:xdigit:].])/'; // the dot in look-ahead excludes image filenames
                $replace = '<a href="magnet:?xt=urn:btih:${2}">${1}</a>';
                $content = preg_replace($pat, $replace, $content);

                // 度盘链接
                $pat = '/(?<!\w)((?:pan\.baidu\.com\/)?(s\/[[:alnum:]]{8}))(?![[:alnum:]])/';
                $replace = '<a href="https://pan.baidu.com/${2}">${1}</a>';
                $content = preg_replace($pat, $replace, $content);

                $article["content"] = $content;
            }
        }

        return $article;
    }

    function api_version() {
        return 2;
    }
}
?>
