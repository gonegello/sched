<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Helpers {    
    
    public function checkSession() {
        if(!isset($_SESSION['SESS_AUTH'])) {
            return false;
        }
        return true;
    }
    
    public function redirectLogin() {
        header('Location: /login.php');
    }

    public function encryptDecrypt($string, $action = 'encrypt') {
        $encryptMethod = "AES-256-CBC";
        $secretKey     = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
        $secretIv      = '5fgf5HJ5g27'; // user define secret key
        $key    = hash('sha256', $secretKey);
        $iv     = substr(hash('sha256', $secretIv), 0, 16); // sha256 is hash_hmac_algo
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encryptMethod, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encryptMethod, $key, 0, $iv);
        }

        return $output;
    }

    /**
     * Check active menu
     * @param uri
     * @param activekeyword
     * 
     * @return boolean
     */

    public function checkactivemenu($uri, $activekeyword) : bool {
        if(stripos($uri, $activekeyword) !== false) {
            return true;
        }

        return false;
    }

    public function logdata($params) : bool {
        require (DOCUMENT_ROOT . '/models/Logs.php');

        $log = new Logs();

        $reslog = $log->insertData($params);
        if($reslog) {
            return true;
        }

        return false;
    }

    public function getsignage($brgysecretary, $type = 'secretary', $brgycaptain = '') : string {
        if($type == 'secretary') {
            $result = <<<PREPAREDBY
            <div>
                Prepared by: <br> <br>
                <span style="border-bottom: 1px solid #000; padding-right: 10px; font-weight: 600;"> $brgysecretary </span>
                <br>
                Barangay Secretary
                <br><br>
            </div>
            PREPAREDBY;
        }

        if($type == 'all') {
            $result = <<<PREPAREDBY
            <table style="width: 100%;">
                <tr>
                    <td valign="top" style="width: 50%;">
                        <div>
                            Prepared by: <br> <br>
                            <span style="border-bottom: 1px solid #000; padding-right: 10px; font-weight: 600;"> $brgysecretary </span>
                            <br>
                            Barangay Secretary
                            <br><br>
                        </div>
                    </td>
                    <td valign="top" style="width: 50%;">
                        <div>
                            Approved by: <br> <br>
                            <span style="border-bottom: 1px solid #000; padding-right: 10px; font-weight: 600;"> $brgycaptain </span>
                            <br>
                            Barangay Captain
                            <br><br>
                        </div>
                    </td>
                </tr>
            </table>
            PREPAREDBY;
        }

        return $result;
    }

    public function getheader($brgysecretary, $type = 'secretary') : string {
        if($type == 'secretary') {
            $result = <<<PREPAREDBY
            <div>
                Prepared by: <br> <br>
                <span style="border-bottom: 1px solid #000; padding-right: 10px; font-weight: 600;"> $brgysecretary </span>
                <br>
                Barangay Secretary
                <br><br>
            </div>
            PREPAREDBY;
        }

        return $result;
    }
}