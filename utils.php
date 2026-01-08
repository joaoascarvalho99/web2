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

    function tends() {
        $trends = getTrendTemas();
        foreach($trends as $trend){
            echo <<<TRENDS
                <div class="trend-item">
                    <div>t/{$trend["temaname"]}</div>
                    <div class="pill">🔥 {$trend['temaid']}</div>
                </div>
            TRENDS;
        }
    }

    function coms(){
        if(isset($_SESSION['username'])){
            echo <<<COMS
                <h4>Comunidades</h4>
                <ul class="sub-list">
                    <li>
                        <div class="sub-mark">PT</div>
                        <div>t/Portugal</div>
                    </li>
                    <li>
                        <div class="sub-mark">JS</div>
                        <div>t/javascript</div>
                    </li>
                    <li>
                        <div class="sub-mark">UX</div>
                        <div>t/userexperience</div>
                    </li>
                    <li>
                        <div class="sub-mark">AI</div>
                        <div>t/artificial</div>
                    </li>
                </ul>
            COMS;
        }
    }
    
?>