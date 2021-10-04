<?php

class Session {
    
    public $idUser = 0;
    public $idSesion = 0;
    public $detail = '';

    public function __construct($user){
    	$this->idUser = $user;
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $ipAddr = $_SERVER['REMOTE_ADDR'];

        $infoBrowser = $this->getUserAgent($browser);

        $SQLS = "INSERT INTO seg_session VALUES (NULL, $this->idUser, '$ipAddr', '$browser', NOW(), NOW()); ";
        $resS = mysqli_query($conn, $SQLS);

        $ids = mysqli_insert_id($conn);
        $this->idSesion = $ids;

	    $this->detail = $infoBrowser['browser'].' en '.$infoBrowser['platform'].' ['.$ipAddr.']';
    }

    public function getSesion(){
        return $this->idSesion;
    }

    public function getDetail(){
        return $this->detail;
    }

    public function updateUser(){
        $SQLU = "UPDATE seg_user SET last_access = NOW() WHERE id_user = '$this->idUser';";
        $resU = mysqli_query($conn, $SQLU);

        return $resU;
    }

    public function getPermission($perfil){
        $SQLP = "SELECT * FROM seg_permiso p, seg_modulo m 
                    WHERE fk_perfil = $perfil AND m.id_modulo = p.fk_modulo AND m.status = 1
                            ORDER BY fk_modulo; ";
        $resP = mysqli_query($conn, $SQLP);

        $arrPer = array();
        while ($perm = mysqli_fetch_assoc($resP)) {
            //$perm['nombre'] = utf8_encode($perm['nombre']);

            if($perm['fk_parent'] == 0){
                $arrPer[$perm['id_modulo']] = $perm;
            }else{
                $arrPer[$perm['fk_parent']]['children'][$perm['id_modulo']] = $perm;
            }
        }

        return $arrPer;
    }


    public function getUserAgent( $u_agent = null ) {
        if( is_null($u_agent) ) {
            if(isset($_SERVER['HTTP_USER_AGENT'])) {
                $u_agent = $_SERVER['HTTP_USER_AGENT'];
            }else{
                throw new \InvalidArgumentException('getUserAgent requires a user agent');
            }
        }

        $platform = null;
        $browser  = null;
        $version  = null;

        $empty = array( 'platform' => $platform, 'browser' => $browser, 'version' => $version );

        if( !$u_agent ) return $empty;

        if( preg_match('/\((.*?)\)/im', $u_agent, $parent_matches) ) {

            preg_match_all('/(?P<platform>BB\d+;|Android|CrOS|iPhone|iPad|Linux|Macintosh|Windows(\ Phone)?|Silk|linux-gnu|BlackBerry|PlayBook|Nintendo\ (WiiU?|3DS)|Xbox(\ One)?)
                    (?:\ [^;]*)?
                    (?:;|$)/imx', $parent_matches[1], $result, PREG_PATTERN_ORDER);

            $priority           = array( 'Android', 'Xbox One', 'Xbox' );
            $result['platform'] = array_unique($result['platform']);
            if( count($result['platform']) > 1 ) {
                if( $keys = array_intersect($priority, $result['platform']) ) {
                    $platform = reset($keys);
                } else {
                    $platform = $result['platform'][0];
                }
            } elseif( isset($result['platform'][0]) ) {
                $platform = $result['platform'][0];
            }
        }

        if( $platform == 'linux-gnu' ) {
            $platform = 'Linux';
        } elseif( $platform == 'CrOS' ) {
            $platform = 'Chrome OS';
        }

        preg_match_all('%(?P<browser>Camino|Kindle(\ Fire\ Build)?|Firefox|Iceweasel|Safari|MSIE|Trident/.*rv|AppleWebKit|Chrome|IEMobile|Opera|OPR|Silk|Lynx|Midori|Version|Wget|curl|NintendoBrowser|PLAYSTATION\ (\d|Vita)+)
                (?:\)?;?)
                (?:(?:[:/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%ix',
            $u_agent, $result, PREG_PATTERN_ORDER);


        // If nothing matched, return null (to avoid undefined index errors)
        if( !isset($result['browser'][0]) || !isset($result['version'][0]) ) {
            return $empty;
        }

        $browser = $result['browser'][0];
        $version = $result['version'][0];

        $find = function ( $search, &$key ) use ( $result ) {
            $xkey = array_search(strtolower($search), array_map('strtolower', $result['browser']));
            if( $xkey !== false ) {
                $key = $xkey;

                return true;
            }

            return false;
        };

        $key = 0;
        if( $browser == 'Iceweasel' ) {
            $browser = 'Firefox';
        } elseif( $find('Playstation Vita', $key) ) {
            $platform = 'PlayStation Vita';
            $browser  = 'Browser';
        } elseif( $find('Kindle Fire Build', $key) || $find('Silk', $key) ) {
            $browser  = $result['browser'][$key] == 'Silk' ? 'Silk' : 'Kindle';
            $platform = 'Kindle Fire';
            if( !($version = $result['version'][$key]) || !is_numeric($version[0]) ) {
                $version = $result['version'][array_search('Version', $result['browser'])];
            }
        } elseif( $find('NintendoBrowser', $key) || $platform == 'Nintendo 3DS' ) {
            $browser = 'NintendoBrowser';
            $version = $result['version'][$key];
        } elseif( $find('Kindle', $key) ) {
            $browser  = $result['browser'][$key];
            $platform = 'Kindle';
            $version  = $result['version'][$key];
        } elseif( $find('OPR', $key) ) {
            $browser = 'Opera Next';
            $version = $result['version'][$key];
        } elseif( $find('Opera', $key) ) {
            $browser = 'Opera';
            $find('Version', $key);
            $version = $result['version'][$key];
        } elseif( $find('Midori', $key) ) {
            $browser = 'Midori';
            $version = $result['version'][$key];
        } elseif( $find('Chrome', $key) ) {
            $browser = 'Chrome';
            $version = $result['version'][$key];
        } elseif( $browser == 'AppleWebKit' ) {
            if( ($platform == 'Android' && !($key = 0)) ) {
                $browser = 'Android Browser';
            } elseif( strpos($platform, 'BB') === 0 ) {
                $browser  = 'BlackBerry Browser';
                $platform = 'BlackBerry';
            } elseif( $platform == 'BlackBerry' || $platform == 'PlayBook' ) {
                $browser = 'BlackBerry Browser';
            } elseif( $find('Safari', $key) ) {
                $browser = 'Safari';
            }

            $find('Version', $key);

            $version = $result['version'][$key];
        } elseif( $browser == 'MSIE' || strpos($browser, 'Trident') !== false ) {
            if( $find('IEMobile', $key) ) {
                $browser = 'IEMobile';
            } else {
                $browser = 'MSIE';
                $key     = 0;
            }
            $version = $result['version'][$key];
        } elseif( $key = preg_grep('/playstation \d/i', array_map('strtolower', $result['browser'])) ) {
            $key = reset($key);

            $platform = 'PlayStation ' . preg_replace('/[^\d]/i', '', $key);
            $browser  = 'NetFront';
        }

        return array( 'platform' => $platform, 'browser' => $browser, 'version' => $version );
    }
}

?>

