<?php
/**
 * Created by JetBrains PhpStorm.
 * User: daviddjian
 * Date: 03/07/13
 * Time: 10:03
 * To change this template use File | Settings | File Templates.
 */

namespace Core\Lib;

class Tracking
{
    /**
     * @var
     */
    protected $serverDns;
    /**
     * @var
     */
    protected $realIp;
    /**
     * @var
     */
    protected $hostName;
    /**
     * @var
     */
    protected $proxy;
    /**
     * @var
     */
    protected $referer;


    /**
     *
     */
    public function setHostName()
    {
        $this->hostName = $this->getHostByAddrTimeout($this->realIp, $this->serverDns);
    }

    /**
     * @param     $ip
     * @param     $dns
     * @param int $timeout
     *
     * @return string
     */
    public function getHostByAddrTimeout($ip, $dns, $timeout = 900)
    {
        // random transaction number (for routers etc to get the reply back)
        $data = rand(0, 99);
        // trim it to 2 bytes
        $data = substr($data, 0, 2);
        // request header
        $data .= "\1\0\0\1\0\0\0\0\0\0";
        // split IP up
        $bits = explode(".", $ip);
        // error checking
        if (count($bits) != 4) {
            return "ERROR";
        }
        // there is probably a better way to do this bit...
        // loop through each segment
        for ($x = 3; $x >= 0; $x--) {
            // needs a byte to indicate the length of each segment of the request
            switch (strlen($bits[$x])) {
                case 1: // 1 byte long segment
                    $data .= "\1";
                    break;
                case 2: // 2 byte long segment
                    $data .= "\2";
                    break;
                case 3: // 3 byte long segment
                    $data .= "\3";
                    break;
                default: // segment is too big, invalid IP
                    return "INVALID";
            }
            // and the segment itself
            $data .= $bits[$x];
        }
        // and the final bit of the request
        $data .= "\7in-addr\4arpa\0\0\x0C\0\1";
        // create UDP socket

        $handle = @fsockopen("udp://$dns", 53);

        $seconds      = floor($timeout / 1000);
        $microseconds = 1000 * ($timeout - $seconds * 1000);

        @socket_set_timeout($handle, $seconds, $microseconds);

        // send our request (and store request size so we can cheat later)
        $requestsize = @fwrite($handle, $data);

        // hope we get a reply
        $response = @fread($handle, 1000);

        $info = stream_get_meta_data($handle);

        @fclose($handle);

        if ($info['timed_out']) {
            return $ip;
        } else {

            if ($response == "") {
                return $ip;
            }
            // find the response type
            $type = @unpack("s", substr($response, $requestsize + 2));
            if ($type[1] == 0x0C00) // answer
            {
                // set up our variables
                $host = "";
                $len  = 0;
                // set our pointer at the beginning of the hostname
                // uses the request size from earlier rather than work it out
                $position = $requestsize + 12;
                // reconstruct hostname
                do {
                    // get segment size
                    $len = unpack("c", substr($response, $position));
                    // null terminated string, so length 0 = finished
                    if ($len[1] == 0) // return the hostname, without the trailing .
                    {
                        return substr($host, 0, strlen($host) - 1);
                    }
                    // add segment to our host
                    $host .= substr($response, $position + 1, $len[1]) . ".";
                    // move pointer on to the next segment
                    $position += $len[1] + 1;
                } while ($len != 0);

                // error - return the hostname we constructed (without the . on the end)
                return $ip;
            }

            return $ip;
        }
    }


    /**
     * @param $referer
     */
    public function setReferer($referer)
    {
        $referer = preg_replace("#http://#", "", $referer);
        $referer = preg_replace("#www.#", "", $referer);
        $referer = explode("/", $referer);

        $this->referer = $referer[0];
    }

    /**
     * @param $_SERVER
     */
    public function setRealIp()
    {
        if (isset($_SERVER)) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $this->realIp = $_SERVER["HTTP_X_FORWARDED_FOR"];
                $this->proxy  = $_SERVER["REMOTE_ADDR"];
            } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $this->realIp = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $this->realIp = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $this->realIp = getenv('HTTP_X_FORWARDED_FOR');
                $this->proxy  = getenv('REMOTE_ADDR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $this->realIp = getenv('HTTP_CLIENT_IP');
            } else {
                $this->realIp = getenv('REMOTE_ADDR');
            }
        }

        if (strstr($this->realIp, ',')) {
            $ips          = explode(',', $this->realIp);
            $this->realIp = $ips[0];
        }
    }

    /**
     * @param mixed $proxy
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * @return mixed
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @param mixed $serverDns
     */
    public function setServerDns($serverDns)
    {
        $this->serverDns = $serverDns;
    }

    /**
     * @return mixed
     */
    public function getServerDns()
    {
        return $this->serverDns;
    }

    /**
     * @return mixed
     */
    public function getHostName()
    {
        return $this->hostName;
    }

    /**
     * @return mixed
     */
    public function getRealIp()
    {
        return $this->realIp;
    }

    /**
     * @return mixed
     */
    public function getReferer()
    {
        return $this->referer;
    }

}