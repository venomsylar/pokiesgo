<?php

abstract class Debug
{
    private static $noindex_tag;
    private static function set_noindex_tag()
    {
        self::$noindex_tag = '<meta name="robots" content="noindex,nofollow" />';
        echo self::$noindex_tag;
    }

    public static function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }

    public static function get_function_speed($function, $callback) {
        $time = microtime(TRUE);
        $mem = memory_get_usage();?>
        <div class="speed_hidden" style="display: none!important;">
            <?php for($i = 1; $i<$callback; $i++) {
                echo $function;
            } ?>
        </div>
        <?php print_r(array(
            'memory' => (memory_get_usage() - $mem) / (1024 * 1024),
            'seconds' => microtime(TRUE) - $time
        ));
        self::set_noindex_tag();
    }

    public static function var_dump($data) {
        $pretty = function($v='',$c="&nbsp;&nbsp;&nbsp;&nbsp;",$in=-1,$k=null)use(&$pretty){$r='';if(in_array(gettype($v),array('object','array'))){$r.=($in!=-1?str_repeat($c,$in):'').(is_null($k)?'':"$k: ").'<br>';foreach($v as $sk=>$vl){$r.=$pretty($vl,$c,$in+1,$sk).'<br>';}}else{$r.=($in!=-1?str_repeat($c,$in):'').(is_null($k)?'':"$k: ").(is_null($v)?'&lt;NULL&gt;':"<strong>$v</strong>");}return$r;};
        echo '<pre style="padding-left: 50px; font-family: Courier New"><code class="json">' . $pretty($data) . '</code></pre>';
        self::set_noindex_tag();
    }
}