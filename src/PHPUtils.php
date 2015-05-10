<?php


class PHPUtils {

    public static function PHP_isset($ArrayToBeChecked, $TargetArray){
        //Check If all the Elements in the Array is set
        //RETURNS TRUE IF EVERY ELEMENT IS TRUE
        //RETURNS AN ARRAY WITH ALL THE ELEMENTS WHICH ARE NOT SET
        /*
         * Profiling Details with xdebug
         * ----------------------------------------------------
         * Execution time => 0.8-1.3 ms when tried with 5 Elements in Target Array and
         * 3 Elements on ArrayToBeChecked, and when Elements are all set
         * Execution time => 1.7-2.0 ms when tried with 5 Elements in TargetArray and
         * 4 Elements on the ArrayToBeChecked, and when 1 Element is not Set.
         *
         * */

        $Boolean_Element_Set_Flag = true;
        $NotSetElementsArray = array();

        foreach($TargetArray as $ToBeCheckedElement){
            //Check if all the Elements Are Set
            if(!isset($ArrayToBeChecked[$ToBeCheckedElement])){
                $Boolean_Element_Set_Flag = false;
                array_push($NotSetElementsArray,$ToBeCheckedElement);
            }
        }

        return (($Boolean_Element_Set_Flag==true)?true:$NotSetElementsArray);

    }

    public static function PHP_not_empty($ArrayToBeChecked,$ArrayofElementsWhichisToBeCheckedEmpty,$handleSpace){
        /*
         * Checks to See if Every Array in the Element is not Empty
         * Returns TRUE if every Elements are not Empty
         * Returns the Array With Empty Elements if Some of them are Empty
         *
         * of Comparision Array is -1 then all the value are checked for Empty
         * */
        $Boolean_Element_Empty_Flag = true;
        $EmptyElementsArray = array();
       if(is_array($ArrayofElementsWhichisToBeCheckedEmpty)){
           foreach($ArrayofElementsWhichisToBeCheckedEmpty as $key=>$Element){

               if(empty($ArrayToBeChecked[$Element])){
                   $Boolean_Element_Empty_Flag=false;
                  array_push($EmptyElementsArray, $key);
               }
               else if($handleSpace){
                   if(strlen(trim($Element))==0){
                       $Boolean_Element_Empty_Flag=false;
                       array_push($EmptyElementsArray, $key);
                   }
               }
           }
       }
        else if($ArrayofElementsWhichisToBeCheckedEmpty == -1){
            /*
             * -1 denotes Check all the Elements
             * */
            foreach($ArrayToBeChecked as $key=>$Element){

                if(empty($Element)){
                    $Boolean_Element_Empty_Flag = false;
                    array_push($EmptyElementsArray, $key);
                }
                else if($handleSpace){
                    if(strlen(trim($Element))==0){
                        $Boolean_Element_Empty_Flag=false;
                        array_push($EmptyElementsArray, $key);
                    }
                }
            }
        }
        else{
            return false;
            //If the Both of the Condition are false then the function returns a false
            //To indicate that its wrong.
        }

        return (($Boolean_Element_Empty_Flag==true)?true:$EmptyElementsArray);
        //Returns the Element
    }



    public static function onSetAndEmptyCheckHandler($TargetArray, $labelArray,$emptyCheckArray,
                                                     $onSuccessHandler, $onEmptyHandler, $onNotSetHandler,
                                                     $handleSpace=0
                                                     ){

        /*
         * This Function Accepts 5 Different Arguements
         *          $TargetArray -> Array That is to be Analysed (USUAL POST, GET Array)
         *          $labelArray  -> Array Which is passed to Compare for the Array to be Analysed.
         *                          ( It should contain all the required Arguements)
         *          $emptyCheckArray -> Empty check array contains all the elements which are to checked empty against
         *                           the TargetArray, if -1 then all the elements are checked.
         *          EVENT HANDLERS
         *          ---------------------------------------------------------------------------------------------------
         *          $onsuccessHandler -> This function is called when Everything Goes All rights
         *          $onEmptyHandler   -> This function is called when Some Element is empty-> Element names are also passed
         *          $onNotSetHandler  -> This function is called when Some Element is not set -> Element name is passed to
         *                               the Handler function.
         *          $handleSpace   -> If Just space should be checked.
         *
         * */

        $isset = PHPUtils::PHP_isset($TargetArray,$labelArray);
        //Array with Variable Names which are Not Set
        if(is_array($isset)){
            //Some Variables were Not Set
            $onNotSetHandler($isset);
            //User Specified Function is called When Some Element is Not set
        }
        else{
            //Variables were set
            $is_empty = PHPUtils::PHP_not_empty($TargetArray,$emptyCheckArray,$handleSpace);
            if(is_array($is_empty)){
                //If some Element of this Array is Empty
                $onEmptyHandler($is_empty);
                //When Some Element of this Array is Empty
            }
            else{
                //If None of the Elements in array has an Empty Value
                $onSuccessHandler();
                //When The Elements of the array are not empty and when

            }
        }}


	
    public  static function PHP_person_tag_check($TagString){
        //Check if the String Inputted is of THe person Tag

        if(preg_match_all("/[@][a-zA-Z0-9_\.\-]+/",$TagString,$match_array)){
            //If some Variable Matches.

            if(sizeof($match_array[0])>1){
                return false;
            }
            else if(strlen($match_array[0][0]) == strlen(trim($TagString))){
                return true;
            }
        }
        return false;
    }

    /*
     * Check if the email id passed or the array of email ids Have the right format
     * @param String|Array --> Either the Email id or an array which has all the email ids
     * @return Boolean|Int Boolean true if every element(s) matches the test or an integer with the Position of the Wrong email id
     * */
    public static function isEmailId($email){
        return (filter_var($email,FILTER_VALIDATE_EMAIL)?true:false);
    }


    public static function createPasswordHash($password){

        return crypt($password,'$2a$07$nGYCCmhrzjrgdTagdToUniqueSaltFtelluwhathatsweirdorUcxjH$');
    }


    public static function getUniqueId(){
        $time= microtime();
        $rand = 0;
        for($i=0; $i<10; ++$i){
            $rand += rand(484,34949494999);
        }
        return md5(md5($time."RandomePasswordHash").sha1($rand."tagdtohashforpeople"));
    }

    public static  function isRegexComp($RegEx, $string){
        preg_match($RegEx,$string,$matches);
        if(isset($matches[0])){
            if(strlen($matches[0]) == strlen($string)){
                return true;
            }}
        return false;
    }

    public static function removeEmpty($items){
        for($i =0 ; $i<count($items); $i++){
            if($items[$i] == "")
                unset($items[$i]);
        }
        return $items;
    }

    public static function getRealIP(){
        $real_ip_adress = "";
        if (isset($_SERVER['HTTP_CLIENT_IP']))
        {   if(!empty($_SERVER['HTTP_CLIENT_IP']))
            $real_ip_adress = $_SERVER['HTTP_CLIENT_IP'];
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
                $real_ip_adress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {   if(!empty($_SERVER['REMOTE_ADDR']))
            $real_ip_adress = $_SERVER['REMOTE_ADDR'];
        }

        return ($real_ip_adress == "")?false:$real_ip_adress;
    }


    public static function GeoCodeIP($ip){
        $result = @json_decode(file_get_contents("http://freegeoip.net/json/{$ip}"), true);
        $result_array = array();

        if(is_array($result)){
            $required_labels= array(
                "city"          => "city",
                "region_name"   => "region_name",
                "area_code"     => "area_code",
                "country_code"  => "country_code",
                "country_name"  => "country_name",
                "latitude"      => "latitude",
                "longitude"     => "longitude",
                "region_code"   => "region_code"
            );
            foreach($required_labels as $label=>$item){
                if(isset($result[$item])){
                    if(!empty($result[$item])){
                        $result_array[$label] = $result[$item];
                    }
                }
            }
            return ((count($result_array)>1)?$result_array:false);
        }
        return false;
    }

    public static function getInfoByIp($ip =false){
        if($ip === false){
            $ip = self::getRealIP();
        }
        $result = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"),true);
        $result_array = array();
        if($result){
            if($result["geoplugin_status"] > 399){
                return self::backupFreeGeoIP($ip);
            }
            $required_labels = array(
                "city"           => "geoplugin_city",
                "region"         => "geoplugin_region",
                "area_code"      => "geoplugin_areaCode",
                "dma_code"       => "geoplugin_dmaCode",
                "country_code"   => "geoplugin_countryCode",
                "country_name"   => "geoplugin_countryName",
                "continent_code" => "geoplugin_continentCode",
                "latitude"       => "geoplugin_latitude",
                "longitude"      => "geoplugin_longitude",
                "region_code"    => "geoplugin_regionCode",
                "region_name"    => "geoplugin_regionName",
                "currency_code"  => "geoplugin_currencyCode"
            );
            foreach($required_labels as $label=>$item){
                if(isset($result[$item])){
                    if(!empty($result[$item])){
                        $result_array[$label] = $result[$item];
                    }
                }
            }

            return ((count($result_array)>1)?$result_array:false);
        }
        return false;

    }

    public  static function checkSameOriginEmail($email, $website){
        $email_root = explode("@", $email);
        if($email_root[count($email_root)-1] == $website){
            return true;
        }
        return false;
    }

    public static  function downloadFile ($url, $path) {
        try{
            $chunksize = 10 * (1024 * 1024); // 10 Megs

            /**
             * parse_url breaks a part a URL into it's parts, i.e. host, path,
             * query string, etc.
             */
            $parts = parse_url($url);
            $i_handle = fsockopen($parts['host'], 80, $errstr, $errcode, 5);
            $o_handle = fopen($path, 'wb');

            if ($i_handle == false || $o_handle == false) {
                return false;
            }

            if (!empty($parts['query'])) {
                $parts['path'] .= '?' . $parts['query'];
            }

            /**
             * Send the request to the server for the file
             */
            $request = "GET {$parts['path']} HTTP/1.1\r\n";
            $request .= "Host: {$parts['host']}\r\n";
            $request .= "User-Agent: Mozilla/5.0\r\n";
            $request .= "Keep-Alive: 115\r\n";
            $request .= "Connection: keep-alive\r\n\r\n";
            fwrite($i_handle, $request);

            /**
             * Now read the headers from the remote server. We'll need
             * to get the content length.
             */
            $headers = array();
            while(!feof($i_handle)) {
                $line = fgets($i_handle);
                if ($line == "\r\n") break;
                $headers[] = $line;
            }

            /**
             * Look for the Content-Length header, and get the size
             * of the remote file.
             */
            $length = 0;
            foreach($headers as $header) {
                if (stripos($header, 'Content-Length:') === 0) {
                    $length = (int)str_replace('Content-Length: ', '', $header);
                    break;
                }
            }

            /**
             * Start reading in the remote file, and writing it to the
             * local file one chunk at a time.
             */
            $cnt = 0;
            while(!feof($i_handle)) {
                $buf = '';
                $buf = fread($i_handle, $chunksize);
                $bytes = fwrite($o_handle, $buf);
                if ($bytes == false) {
                    return false;
                }
                $cnt += $bytes;

                /**
                 * We're done reading when we've reached the conent length
                 */
                if ($cnt >= $length) break;
            }

            fclose($i_handle);
            fclose($o_handle);
            return $cnt;
        }
        catch(Exception $e){
            return false;
        }
    }

    public static function get_file_size( $url ) {
        // Assume failure.
        $result = -1;

        $curl = curl_init( $url );

        // Issue a HEAD request and follow any redirects.
        curl_setopt( $curl, CURLOPT_NOBODY, true );
        curl_setopt( $curl, CURLOPT_HEADER, true );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $curl, CURLOPT_USERAGENT, "'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'" );

        $data = curl_exec( $curl );
        curl_close( $curl );

        if( $data ) {
            $content_length = "unknown";
            $status = "unknown";

            if( preg_match( "/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches ) ) {
                $status = (int)$matches[1];
            }

            if( preg_match( "/Content-Length: (\d+)/", $data, $matches ) ) {
                $content_length = (int)$matches[1];
            }

            // http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
            if( $status == 200 || ($status > 300 && $status <= 308) ) {
                $result = $content_length;
            }
        }

        return $result;
    }

    public static  function equateSize($sizeString, $inBytes){
        //Format must be like 20mb, 10kb, 3gb ..
        //returns TRUE if $sizeString > $inBytes
        $size  = substr($sizeString, 0,-2);
        $label = substr($sizeString, -2);

        switch($label){
            case "kb":
                $size = $size * 1024;
                break;
            case "mb":
                $size = ($size * 1024 * 1024);
                break;
            case "gb":
                $size = ($size * 1024 * 1024 * 1024);
                break;
            case "tb":
                $size = ($size * 1024 * 1024 * 1024 * 1024);
                break;
        }

        if($size>$inBytes){
            return true;
        }
        return false;

    }




    public static  function normalizeURL($url){
        $http_url     = "/https?\:\/\/[a-zA-Z0-9\-\#]+(\.[0-9a-zA-Z\-\#]+)*/";
        $www          = "/www2?\.[a-zA-Z0-9\-]+(\.[a-zA-Z0-9\_0-9\-]{2,5})+/";
        $url_normal   = "/[a-zA-Z0-9\-]+(\.[a-zA-Z0-9\_0-9\-]{2,5})+/";

        $slash_pos = @strpos($url,"/",8);
        if($slash_pos)
            $url       = substr($url,0,$slash_pos);


        if(self::isRegexComp($http_url,$url)){
            $items = preg_split("/[\/+\.]/",$url);
            $items = self::removeEmpty($items);
            // $url   = "{$items[2]}.{$items[3]}";
            $url = "";
            $i   = 0;
            foreach($items as $elem){

                $elem = strtolower($elem);
                if(!empty($elem)    AND
                    $elem != "www"  AND
                    $elem != "http" AND
                    $elem != ""     AND
                    $elem != "/"    AND
                    $elem != "http:"AND
                    $elem != "www2" AND
                    $elem != "//"   AND
                    $elem != ":"){

                    if($i == 0){
                        $url .= ($elem);
                    }
                    else{
                        $url .= (".".$elem);
                    }
                    ++$i;
                }
            }
            return $url;
        }


        else if(self::isRegexComp($www, $url)){
            $items = preg_split("/[\/+\.]/",$url);
            $items = self::removeEmpty($items);

            $url = "";
            $i   = 0;
            foreach($items as $elem){

                $elem = strtolower($elem);
                if(!empty($elem)    AND
                    $elem != "www"  AND
                    $elem != "http" AND
                    $elem != ""     AND
                    $elem != "/"    AND
                    $elem != "http:"AND
                    $elem != "www2" AND
                    $elem != "//"   AND
                    $elem != ":"){

                    if($i == 0){
                        $url .= ($elem);
                    }
                    else{
                        $url .= (".".$elem);
                    }
                    ++$i;
                }
            }

            return $url;
        }
        else if(self::isRegexComp($url_normal, $url)){
            return $url;
        }

        return false;

    }
}

?>