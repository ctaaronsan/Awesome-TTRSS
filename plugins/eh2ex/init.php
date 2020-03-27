<?php
class eh2ex extends Plugin {

    private $host;

    function about() {
        return array(
            1.0,
            "Add a link to EX page of the gallery for E-Hentai feeds",
            "Aaron San",
            false
            );
    }

    function init($host) {
        $this->host = $host;

        $host->add_hook($host::HOOK_ARTICLE_FILTER, $this);
    }

    /*
    function show_array($array) {
        $str = "";
        foreach ($array as $key => $value) {
            $str = $str . "$key: $value;\n";
        }
        return $str;      
    }
    */

    function hook_article_filter($article) {
        // $article["content"] = "tags: chinese;\nTESTING:\ntags: " . $this->show_array($article["tags"]) . "labels: " . $this->show_array($article["labels"]) . "feed: " .$this->show_array($article["feed"]);
        if (preg_match('/^https?:\/\/e-hentai.org/', $article["feed"]["site_url"]) == 1) {
            $eh_link = $article["link"];
            $ex_link = str_replace("e-hentai.org", "exhentai.org", $article["link"]);

            $p_regex = '/(<p(?:\s[^<>]+|)>)([^<>]+)<\/p>/i'; // the first <p> tag is the gallery title
            $article["link"] = $ex_link;
            $article["content"] = preg_replace($p_regex, '${1}' . "<a href=\"$eh_link\">" . '${2}' . "</a></p>", $article["content"], 1);
        }

        return $article;
    }

    function api_version() {
        return 2;
    }
}
?>
