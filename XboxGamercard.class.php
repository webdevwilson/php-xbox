<?php

define('URL_PREFIX', 'http://gamercard.xbox.com/en-US/');
define('URL_AFFIX', '.card');
define('SUBSCRIPTION_GOLD', 'Gold');
define('SUBSCRIPTION_SILVER', 'Silver');

class XboxGamercard {

    public $gamertag;

    public $html;

    public $subscription;

    public $gamerscore;

    public $games;

    public function __construct($gamertag) {
        $this->gamertag = $gamertag;
        $this->refresh();
    }

    public function refresh() {

        $url = URL_PREFIX . rawurlencode($this->gamertag) . URL_AFFIX;

        $h = file_get_contents($url);

        if($h === false) {
            throw new Exception("Invalid gamertag or service not available");
        }

        $this->html = $h;
        $this->subscription = stristr($h, "<span class=\"Gold\">") === false ?
                                SUBSCRIPTION_SILVER : SUBSCRIPTION_GOLD;

        $this->gamerscore = preg_match('/<div class="Stat">([0-9]+)<\/div>/', $h, $m);
        $this->gamerscore = intval($m[1]);

        $this->games = array();
        $re = '/<img class="Game" width="32" height="32" src="(.+)" alt="(.+)" title="(.+)" \/>/';
        preg_match_all($re, $h, $m);
        for($i = 0; $i < count($m[1]); $i++ ) {
            $this->games[] = array(
                'title' => $m[3][$i],
                'tile' => $m[1][$i]
            );
        }
    }
}