<?php 

    function show_var($var) {
        echo "<section>";
        echo "<pre>";
        print_r( $var );
        echo "</pre>";
        echo "</section>";
    }

    function data($data) {
        $ts = is_numeric($data) ? (int)$data : strtotime($data);
        if ($ts === false) 
            return '';
        $diff = time() - $ts;
        if ($diff < 60)
            return 'agora';
        if ($diff < 3600)
            return floor($diff / 60) . ' min';
        if ($diff < 86400)
            return floor($diff / 3600) . ' h';
        if ($diff < 2592000)
            return floor($diff / 86400) . ' d';
        if ($diff < 31536000)
            return floor($diff / 2592000) . ' m';
        return floor($diff / 31536000) . ' a';
    }

?>