<?php
if(!function_exists("FB_DATA")){
    function FB_Analytics_Data($token, $id, $action =''){  
        $response = FB_FETCH_DATA($token, $id, $action);
        $yt_dash_statsdata="";
        if(!empty($response)){
            if(!empty($response[0]["values"])){
                $data = $response[0]["values"];
                foreach ($data as $row) {
                    $date  = date("Y-m-d H:i:s", strtotime($row["end_time"]));
                    $year  = date("Y", strtotime($date));
                    $month = date("m", strtotime($date)) - 1;
                    $day   = date("d", strtotime($date));
                    if(isset($row["value"])){
                        $yt_dash_statsdata.="[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".$row["value"]."],";
                    }else{
                        $yt_dash_statsdata.="[Date.UTC(".$year.",".$month.",".$day.",0,0,0),0],";
                    }
                }
            }else{
                $yt_dash_statsdata.="['0',0],";
            }
        }
        return substr($yt_dash_statsdata, 0, -1);
    }
}

if(!function_exists("FB_DATA_NEGATIVE")){
    function FB_DATA_NEGATIVE($token, $id, $action =''){  
        $response = FB_FETCH_DATA($token, $id, $action);
        $result = array(
            "unlike_page_clicks" => "",
            "report_spam_clicks" => "",
            "xbutton_clicks"     => "",
            "hide_all_clicks"    => "",
            "hide_clicks"        => ""
        );

        if(!empty($response)){
            if(!empty($response[0]["values"])){
                $data = $response[0]["values"];
                foreach ($data as $row) {
                    $date  = date("Y-m-d H:i:s", strtotime($row["end_time"]));
                    $year  = date("Y", strtotime($date));
                    $month = date("m", strtotime($date)) - 1;
                    $day   = date("d", strtotime($date));

                    $result['unlike_page_clicks'] .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".$row["value"]["unlike_page_clicks"]."],";
                    $result['report_spam_clicks'] .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".$row["value"]["report_spam_clicks"]."],";
                    $result['xbutton_clicks']     .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".$row["value"]["xbutton_clicks"]."],";
                    $result['hide_all_clicks']    .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".$row["value"]["hide_all_clicks"]."],";
                    $result['hide_clicks']        .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".$row["value"]["hide_clicks"]."],";
                }

                $result['unlike_page_clicks'] = substr($result['unlike_page_clicks'], 0, -1);
                $result['report_spam_clicks'] = substr($result['report_spam_clicks'], 0, -1);
                $result['xbutton_clicks']     = substr($result['xbutton_clicks'], 0, -1);
                $result['hide_all_clicks']    = substr($result['hide_all_clicks'], 0, -1);
                $result['hide_clicks']        = substr($result['hide_clicks'], 0, -1);
            }
        }
        return $result;
    }
}

if(!function_exists("FB_DATA_POSITIVE_FEEDBACK")){
    function FB_DATA_POSITIVE_FEEDBACK($token, $id, $action =''){  
        $response = FB_FETCH_DATA($token, $id, $action);
        $result = array(
            "like"   => "",
            "comment"=> "",
            "link"   => "",
            "answer" => "",
            "claim"  => "",
            "rsvp"   => ""
        );

        if(!empty($response)){
            if(!empty($response[0]["values"])){
                $data = $response[0]["values"];
                foreach ($data as $row) {
                    $date  = date("Y-m-d H:i:s", strtotime($row["end_time"]));
                    $year  = date("Y", strtotime($date));
                    $month = date("m", strtotime($date)) - 1;
                    $day   = date("d", strtotime($date));

                    $result['like']   .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["like"]))?$row["value"]["like"]:0)."],";
                    $result['comment'].= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["comment"]))?$row["value"]["comment"]:0)."],";
                    $result['link']   .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["link"]))?$row["value"]["link"]:0)."],";
                    $result['answer'] .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["answer"]))?$row["value"]["answer"]:0)."],";
                    $result['claim']  .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["claim"]))?$row["value"]["claim"]:0)."],";
                    $result['rsvp']   .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["rsvp"]))?$row["value"]["rsvp"]:0)."],";
                }

                $result['like']    = substr($result['like'], 0, -1);
                $result['comment'] = substr($result['comment'], 0, -1);
                $result['link']    = substr($result['link'], 0, -1);
                $result['answer']  = substr($result['answer'], 0, -1);
                $result['claim']   = substr($result['claim'], 0, -1);
                $result['rsvp']    = substr($result['rsvp'], 0, -1);
            }
        }
        return $result;
    }
}

if(!function_exists("FB_DATA_CLICK_BY_TYPE")){
    function FB_DATA_CLICK_BY_TYPE($token, $id, $action =''){  
        $response = FB_FETCH_DATA($token, $id, $action);
        $result = array(
            "link_clicks"  => "",
            "photo_view"   => "",
            "video_play"   => "",
            "other_clicks" => ""
        );

        if(!empty($response)){
            if(!empty($response[0]["values"])){
                $data = $response[0]["values"];
                foreach ($data as $row) {
                    $date  = date("Y-m-d H:i:s", strtotime($row["end_time"]));
                    $year  = date("Y", strtotime($date));
                    $month = date("m", strtotime($date)) - 1;
                    $day   = date("d", strtotime($date));

                    $result['link_clicks']  .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["link clicks"]))?$row["value"]["link clicks"]:0)."],";
                    $result['photo_view']   .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["photo view"]))?$row["value"]["photo view"]:0)."],";
                    $result['video_play']   .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["video play"]))?$row["value"]["video play"]:0)."],";
                    $result['other_clicks'] .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["other clicks"]))?$row["value"]["other clicks"]:0)."],";
                }

                $result['link_clicks']  = substr($result['link_clicks'], 0, -1);
                $result['photo_view']   = substr($result['photo_view'], 0, -1);
                $result['video_play']   = substr($result['video_play'], 0, -1);
                $result['other_clicks'] = substr($result['other_clicks'], 0, -1);
            }
        }
        return $result;
    }
}

if(!function_exists("FB_DATA_FREQUENCY")){
    function FB_DATA_FREQUENCY($token, $id, $action =''){  
        $response = FB_FETCH_DATA($token, $id, $action);
        $frequencys = array(
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6-10'  => 0,
            '11-20' => 0,
            '21+'   => 0
        );

        $str_frequencys = "";
        if(!empty($response)){
            if(!empty($response[0]["values"])){
                $data = $response[0]["values"];
                foreach ($data as $row) {
                    if(isset($row["value"])){
                        $nodes = $row["value"];
                        foreach ($nodes as $key => $node) {
                            if(isset($frequencys[$key])){
                                $frequencys[$key] += $node;  
                            }                  
                        }
                    }
                }

                foreach ($frequencys as $key => $value) {
                    $str_frequencys .= "['".$key."',".$value."],";
                }

                $str_frequencys = substr($str_frequencys, 0, -1);
            }
        }
        return $str_frequencys;
    }
}

if(!function_exists("FB_DATA_TAB")){
    function FB_DATA_TAB($token, $id, $action =''){  
        $response = FB_FETCH_DATA($token, $id, $action);
        $result = array(
            "timeline"       => "",
            "photos"         => "",
            "photos_albums"  => "",
            "profile"        => "",
            "profile_photos" => "",
            "likes"          => "",
            "videos"         => "",
            "photos_stream"  => ""
        );

        if(!empty($response)){
            if(!empty($response[0]["values"])){
                $data = $response[0]["values"];
                foreach ($data as $row) {
                    $date  = date("Y-m-d H:i:s", strtotime($row["end_time"]));
                    $year  = date("Y", strtotime($date));
                    $month = date("m", strtotime($date)) - 1;
                    $day   = date("d", strtotime($date));

                    $result['timeline']       .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["timeline"]))?$row["value"]["timeline"]:0)."],";
                    $result['photos']         .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["photos"]))?$row["value"]["photos"]:0)."],";
                    $result['photos_albums']  .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["photos_albums"]))?$row["value"]["photos_albums"]:0)."],";
                    $result['profile']        .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["profile"]))?$row["value"]["profile"]:0)."],";
                    $result['profile_photos'] .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["profile_photos"]))?$row["value"]["profile_photos"]:0)."],";
                    $result['likes']          .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["likes"]))?$row["value"]["likes"]:0)."],";
                    $result['videos']         .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["videos"]))?$row["value"]["videos"]:0)."],";
                    $result['photos_stream']  .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["photos_stream"]))?$row["value"]["photos_stream"]:0)."],";
                }

                $result['timeline']      = substr($result['timeline'], 0, -1);
                $result['photos']        = substr($result['photos'], 0, -1);
                $result['photos_albums'] = substr($result['photos_albums'], 0, -1);
                $result['profile']       = substr($result['profile'], 0, -1);
                $result['profile_photos']= substr($result['profile_photos'], 0, -1);
                $result['likes']         = substr($result['likes'], 0, -1);
                $result['videos']        = substr($result['videos'], 0, -1);
                $result['photos_stream'] = substr($result['photos_stream'], 0, -1);
            }
        }
        return $result;
    }
}

if(!function_exists("FB_DATA_STRORYTELLERS")){
    function FB_DATA_STRORYTELLERS($token, $id, $action =''){  
        $response = FB_FETCH_DATA($token, $id, $action);
        $result = array(
            "fan"        => "",
            "page_post"  => "",
            "user_post"  => "",
            "coupon"     => "",
            "mention"    => "",
            "checkin"    => "",
            "question"   => "",
            "event"      => "",
            "other"      => ""
        );

        if(!empty($response)){
            if(!empty($response[0]["values"])){
                $data = $response[0]["values"];
                foreach ($data as $row) {
                    $date  = date("Y-m-d H:i:s", strtotime($row["end_time"]));
                    $year  = date("Y", strtotime($date));
                    $month = date("m", strtotime($date)) - 1;
                    $day   = date("d", strtotime($date));

                    $result['fan']      .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["fan"]))?$row["value"]["fan"]:0)."],";
                    $result['page_post'].= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["page post"]))?$row["value"]["page post"]:0)."],";
                    $result['user_post'].= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["user post"]))?$row["value"]["user post"]:0)."],";
                    $result['coupon']   .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["coupon"]))?$row["value"]["coupon"]:0)."],";
                    $result['mention']  .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["mention"]))?$row["value"]["mention"]:0)."],";
                    $result['checkin']  .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["checkin"]))?$row["value"]["checkin"]:0)."],";
                    $result['question'] .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["question"]))?$row["value"]["question"]:0)."],";
                    $result['event']    .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["event"]))?$row["value"]["event"]:0)."],";
                    $result['other']    .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".((isset($row["value"]["other"]))?$row["value"]["other"]:0)."],";
                }

                $result['fan']      = substr($result['fan'], 0, -1);
                $result['page_post']= substr($result['page_post'], 0, -1);
                $result['user_post']= substr($result['user_post'], 0, -1);
                $result['coupon']   = substr($result['coupon'], 0, -1);
                $result['mention']  = substr($result['mention'], 0, -1);
                $result['checkin']  = substr($result['checkin'], 0, -1);
                $result['question'] = substr($result['question'], 0, -1);
                $result['event']    = substr($result['event'], 0, -1);
                $result['other']    = substr($result['other'], 0, -1);
            }
        }
        return $result;
    }
}

if(!function_exists("FB_DATA_FANS_ONLINE")){
    function FB_DATA_FANS_ONLINE($token, $id, $action =''){  
        $response = FB_FETCH_DATA($token, $id, $action);
        $result = array(
            "0" => 0,
            "1" => 0,
            "2" => 0,
            "3" => 0,
            "4" => 0,
            "5" => 0,
            "6" => 0,
            "7" => 0,
            "8" => 0,
            "9" => 0,
            "10" => 0,
            "11" => 0,
            "12" => 0,
            "13" => 0,
            "14" => 0,
            "15" => 0,
            "16" => 0,
            "17" => 0,
            "18" => 0,
            "19" => 0,
            "20" => 0,
            "21" => 0,
            "22" => 0,
            "23" => 0,
        );

        $hours = "";
        if(!empty($response)){
            if(!empty($response[0]["values"])){
                $data = $response[0]["values"];
                foreach ($data as $row) {
                    $result['0']   += (isset($row["value"][0]))?$row["value"][0]:0;
                    $result['1']   += (isset($row["value"][1]))?$row["value"][1]:0;
                    $result['2']   += (isset($row["value"][2]))?$row["value"][2]:0;
                    $result['3']   += (isset($row["value"][3]))?$row["value"][3]:0;
                    $result['4']   += (isset($row["value"][4]))?$row["value"][4]:0;
                    $result['5']   += (isset($row["value"][5]))?$row["value"][5]:0;
                    $result['6']   += (isset($row["value"][6]))?$row["value"][6]:0;
                    $result['7']   += (isset($row["value"][7]))?$row["value"][7]:0;
                    $result['8']   += (isset($row["value"][8]))?$row["value"][8]:0;
                    $result['9']   += (isset($row["value"][9]))?$row["value"][9]:0;
                    $result['10']  += (isset($row["value"][10]))?$row["value"][10]:0;
                    $result['11']  += (isset($row["value"][11]))?$row["value"][11]:0;
                    $result['12']  += (isset($row["value"][12]))?$row["value"][12]:0;
                    $result['13']  += (isset($row["value"][13]))?$row["value"][13]:0;
                    $result['14']  += (isset($row["value"][14]))?$row["value"][14]:0;
                    $result['15']  += (isset($row["value"][15]))?$row["value"][15]:0;
                    $result['16']  += (isset($row["value"][16]))?$row["value"][16]:0;
                    $result['17']  += (isset($row["value"][17]))?$row["value"][17]:0;
                    $result['18']  += (isset($row["value"][18]))?$row["value"][18]:0;
                    $result['19']  += (isset($row["value"][19]))?$row["value"][19]:0;
                    $result['20']  += (isset($row["value"][20]))?$row["value"][20]:0;
                    $result['21']  += (isset($row["value"][21]))?$row["value"][21]:0;
                    $result['22']  += (isset($row["value"][22]))?$row["value"][22]:0;
                    $result['23']  += (isset($row["value"][23]))?$row["value"][23]:0;
                }

                foreach ($result as $key => $value) {
                    $hours .= "[".$key.",".$value."],";
                }

                $hours = substr($hours, 0, -1);
            }
        }
        return $hours;
    }
}

if(!function_exists("FB_DATA_GENDER")){
    function FB_DATA_GENDER($token, $id, $action =''){  
        $response = FB_FETCH_DATA($token, $id, $action);

        $yt_dash_statsdata="";
        $value_male = array(
            '13-17' => 0,
            '18-24' => 0,
            '25-34' => 0,
            '35-44' => 0,
            '45-54' => 0,
            '55-64' => 0,
            '65+'   => 0
        );

        $value_female = array(
            '13-17' => 0,
            '18-24' => 0,
            '25-34' => 0,
            '35-44' => 0,
            '45-54' => 0,
            '55-64' => 0,
            '65+'   => 0
        );

        $yt_dash_male = "";
        $yt_dash_female = "";
        $result = array();
        if(!empty($response)){
            if(!empty($response[0]["values"])){
                $data = $response[0]["values"];
                foreach ($data as $row) {
                    if(isset($row["value"])){
                        $nodes = $row["value"];
                        foreach ($nodes as $key => $node) {
                            $array_node = explode(".", $key);
                            if($array_node[0] == 'M'){
                                $value_male[$array_node[1]] += $node;
                            }else{
                                $value_female[$array_node[1]] += $node;
                            }
                        }
                    }
                }

                $yt_dash_male.="['13-17',".$value_male["13-17"]."],";
                $yt_dash_male.="['18-24',".$value_male["18-24"]."],";
                $yt_dash_male.="['25-34',".$value_male["25-34"]."],";
                $yt_dash_male.="['35-44',".$value_male["35-44"]."],";
                $yt_dash_male.="['45-54',".$value_male["45-54"]."],";
                $yt_dash_male.="['55-64',".$value_male["55-64"]."],";
                $yt_dash_male.="['65+',".$value_male["65+"]."]";
                $yt_dash_female.="['13-17',".$value_female["13-17"]."],";
                $yt_dash_female.="['18-24',".$value_female["18-24"]."],";
                $yt_dash_female.="['25-34',".$value_female["25-34"]."],";
                $yt_dash_female.="['35-44',".$value_female["35-44"]."],";
                $yt_dash_female.="['45-54',".$value_female["45-54"]."],";
                $yt_dash_female.="['55-64',".$value_female["55-64"]."],";
                $yt_dash_female.="['65+',".$value_female["65+"]."]";

                $result = array(
                    "male" => $yt_dash_male,
                    "female" => $yt_dash_female
                );
            }
        }
        return $result;
    }
}

if(!function_exists("FB_DATA_COUNTRY")){
    function FB_DATA_COUNTRY($token, $id, $action =''){  
        $response = FB_FETCH_DATA($token, $id, $action);
        $result = array();

        if(!empty($response)){
            if(!empty($response[0]["values"])){
                $data = $response[0]["values"];
                foreach ($data as $row) {
                    if(isset($row["value"]) && !empty($row["value"])){
                        $values = $row["value"];
                        foreach ($values as $key => $value) {
                            if(!isset($result[nameCountry($key)])){
                                $result[nameCountry($key)] = 0;
                            }
                            $result[nameCountry($key)] += $value;
                        }
                    }
                }
            }
        }

        $listop = "";
        if(!empty($result)){
            $count = 0;
            foreach ($result as $key => $row) {
                if($count < 10){
                    $listop .= "[\"".$key."\",".$row."],";;
                }
                $count++;
            }
        }
        return array("result" => $result, "top" => $listop);
    }
}

if(!function_exists("FB_DATA_REFERRERS")){
    function FB_DATA_REFERRERS($token, $id, $action =''){  
        $response = FB_FETCH_DATA($token, $id, $action);
        $yt_dash_statsdata="";
        $list_referrers = array();
        if(!empty($response)){
            if(!empty($response[0]["values"])){
                $data = $response[0]["values"];
                foreach ($data as $row) {
                    if(isset($row['value']) && !empty($row['value'])){
                        $values = $row['value'];
                        foreach ($values as $key => $value) {
                            if($key != 'unknown'){
                                if(stripos($key, "http") !== false){
                                    $parse = parse_url($key);
                                    $parse = str_replace("www.", "", $parse);
                                    if(stripos($key, "google") !== false){
                                        $list_referrers['google.com'] = '';
                                    }else{
                                        $list_referrers[$parse['host']] = '';
                                    }

                                }else{
                                    $list_referrers['facebook.com'] = '';
                                }
                            }
                        }
                    }
                }

                foreach ($data as $row) {
                    if(isset($row['value']) && !empty($row['value'])){
                        $date  = date("Y-m-d H:i:s", strtotime($row["end_time"]));
                        $year  = date("Y", strtotime($date));
                        $month = date("m", strtotime($date)) - 1;
                        $day   = date("d", strtotime($date));

                        $values = $row['value'];
                        $list_referrers_tmp = array();
                        $name_referrers = "";
                        $countValue = 0;

                        foreach ($values as $key => $value) {
                            if($key != 'unknown'){
                                if(stripos($key, "http") !== false){
                                    $parse = parse_url($key);
                                    $parse = str_replace("www.", "", $parse);
                                    if(stripos($key, "google") !== false){
                                        $name_referrers = 'google.com';
                                    }else{
                                        $name_referrers = $parse['host'];
                                    }
                                }else{
                                    $name_referrers = 'facebook.com';
                                }
                            }

                            if(!empty($list_referrers) && $name_referrers != ""){
                                if(isset($list_referrers[$name_referrers])){
                                    $countValue += $value;
                                    $list_referrers_tmp[] = $name_referrers;
                                }
                            }
                        }

                        if(!empty($list_referrers)){
                            if(isset($list_referrers[$name_referrers])){
                                $list_referrers[$name_referrers] .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),".$countValue."],";
                            }

                            foreach ($list_referrers as $referrers => $item) {
                                if(!in_array($referrers, $list_referrers_tmp)){
                                    $list_referrers[$referrers] .= "[Date.UTC(".$year.",".$month.",".$day.",0,0,0),0],";
                                }
                            }
                        }
                    }
                }
            }
        }
        return $list_referrers;
    }
}

if(!function_exists("FB_DATA_SOURCE")){
    function FB_DATA_SOURCE($token, $id, $action =''){  
        $response = FB_FETCH_DATA($token, $id, $action);
        $result = array();
        if(!empty($response)){
            if(!empty($response[0]["values"])){
                $data = $response[0]["values"];
                foreach ($data as $row) {
                    if(isset($row["value"]) && !empty($row["value"])){
                        $values = $row["value"];
                        foreach ($values as $key => $value) {
                            $name = str_replace("_", " ", $key);
                            $name = ucwords($name);
                            if(!isset($result[$name])){
                                $result[$name] = 0;
                            }
                            $result[$name] += $value;
                        }
                    }
                }
            }
        }

        $listop = "";
        if(!empty($result)){
            foreach ($result as $key => $row) {
                $listop .= "['".$key."',".$row."],";;
            }
        }
        return $listop;
    }
}


if(!function_exists("FB_PAGE")){
    function FB_PAGE($access_token, $pageid){  
        $params = array("access_token" =>  $access_token);
        $response = FbOAuth()->api('/v2.7/'.$pageid.'?fields=name,access_token,picture.type(large),cover,id,category,talking_about_count,fan_count', "GET", $params);
        if(isset($response['name'])){
            //pr($response,1);
            return $response;
        }else{
            return false;
        }
    }
}

if(!function_exists("FB_FETCH_DATA")){
    function FB_FETCH_DATA($access_token, $pageid, $action =''){  
        $from = date('Y-m-d', strtotime(NOW.' -28 day'));
        $to   = date('Y-m-d', strtotime(NOW.'-1 day'));
        if(post('daterange'))
        {
            $range = explode('-', post('daterange'));
            if(count($range) > 1){
                $from= date('Y-m-d', strtotime($range[0]));
                $to  = date('Y-m-d', strtotime($range[1]));
            }
        }

        if(get('daterange')){
            $range = explode('-', get('daterange'));
            $from  = date('Y-m-d', strtotime($range[0]));
            $to    = date('Y-m-d', strtotime($range[1]));
        }

        $params = array(
            "since" => $from,
            "until" => $to,
            "access_token" =>  $access_token
        );

        $response = FbOAuth()->api('/v2.6/'.$pageid.'/'.$action, "GET", $params);

        if(isset($response['data'])){
            return $response['data'];
        }else{
            return false;
        }
    }
}

if(!function_exists("FbOAuth")){
    function FbOAuth(){
        require_once( APPPATH."libraries/FbOAuth/facebook.php" );
        $fb  = new FacebookCustom( array("appId" => 1767593543471526, "secret" => "4abe49fc8d28ed719268d9108dbc8fe3") );
        return $fb;
    }
}

function nameCountry($key){
    $data = array(
        "AF" => "Afghanistan",
        "AX" => "Aland Islands",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AS" => "American Samoa",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AI" => "Anguilla",
        "AQ" => "Antarctica",
        "AG" => "Antigua and Barbuda",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AU" => "Australia",
        "AT" => "Austria",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas the",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia",
        "BA" => "Bosnia and Herzegovina",
        "BW" => "Botswana",
        "BV" => "Bouvet Island (Bouvetoya)",
        "BR" => "Brazil",
        "IO" => "British Indian Ocean Territory",
        "VG" => "British Virgin Islands",
        "BN" => "Brunei Darussalam",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CX" => "Christmas Island",
        "CC" => "Cocos (Keeling) Islands",
        "CO" => "Colombia",
        "KM" => "Comoros the",
        "CD" => "Congo",
        "CG" => "Congo the",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "CI" => "Cote d`Ivoire",
        "HR" => "Croatia",
        "CU" => "Cuba",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FO" => "Faroe Islands",
        "FK" => "Falkland Islands (Malvinas)",
        "FJ" => "Fiji the Fiji Islands",
        "FI" => "Finland",
        "FR" => "France",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French Southern Territories",
        "GA" => "Gabon",
        "GM" => "Gambia the",
        "GE" => "Georgia",
        "DE" => "Germany",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GL" => "Greenland",
        "GD" => "Grenada",
        "GP" => "Guadeloupe",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GG" => "Guernsey",
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard Island and McDonald Islands",
        "VA" => "Holy See",
        "HN" => "Honduras",
        "HK" => "Hong Kong",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IM" => "Isle of Man",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JE" => "Jersey",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KP" => "Korea",
        "KR" => "Korea",
        "KW" => "Kuwait",
        "KG" => "Kyrgyz Republic",
        "LA" => "Lao",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libyan Arab Jamahiriya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macao",
        "MK" => "Macedonia",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "YT" => "Mayotte",
        "MX" => "Mexico",
        "FM" => "Micronesia",
        "MD" => "Moldova",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "ME" => "Montenegro",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "AN" => "Netherlands Antilles",
        "NL" => "Netherlands the",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "MP" => "Northern Mariana Islands",
        "NO" => "Norway",
        "OM" => "Oman",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PS" => "Palestinian Territory",
        "PA" => "Panama",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn Islands",
        "PL" => "Poland",
        "PT" => "Portugal => Portuguese Republic",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RE" => "Reunion",
        "RO" => "Romania",
        "RU" => "Russian Federation",
        "RW" => "Rwanda",
        "BL" => "Saint Barthelemy",
        "SH" => "Saint Helena",
        "KN" => "Saint Kitts and Nevis",
        "LC" => "Saint Lucia",
        "MF" => "Saint Martin",
        "PM" => "Saint Pierre and Miquelon",
        "VC" => "Saint Vincent and the Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "ST" => "Sao Tome and Principe",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "RS" => "Serbia",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SK" => "Slovakia",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "GS" => "South Georgia and the South Sandwich Islands",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard & Jan Mayen Islands",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland => Swiss Confederation",
        "SY" => "Syrian Arab Republic",
        "TW" => "Taiwan",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania",
        "TH" => "Thailand",
        "TL" => "Timor-Leste",
        "TG" => "Togo",
        "TK" => "Tokelau",
        "TO" => "Tonga",
        "TT" => "Trinidad and Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TC" => "Turks and Caicos Islands",
        "TV" => "Tuvalu",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "AE" => "United Arab Emirates",
        "GB" => "United Kingdom",
        "US" => "United States",
        "UM" => "United States Minor Outlying Islands",
        "VI" => "United States Virgin Islands",
        "UY" => "Uruguay, Eastern Republic of",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VE" => "Venezuela",
        "VN" => "Vietnam",
        "WF" => "Wallis and Futuna",
        "EH" => "Western Sahara",
        "YE" => "Yemen",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe"
    );

    if(!empty($data[$key])){
        return $data[$key];
    }else{
        return $key;
    }
}

?>