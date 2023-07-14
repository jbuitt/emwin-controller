<?php

namespace App\Libraries;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Wfo;

class AwipsProduct
{
    private $fileName;
    private $fileContents;
    private $productInfo;

    ///////////////////////////////////////////////////////////////////////////////
    // Constructor
    ///////////////////////////////////////////////////////////////////////////////
    public function __construct($filename)
    {
        $this->fileName = $filename;
        $this->fileContents = $this->parseFileContents(file($filename));
        $this->productInfo = $this->splitProductInfo();
    }

    /////////////////////////////////////////////////////////////////////////////////
    // Public functions
    /////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////
    // getFileName - Returns the filename of the product
    //
    //   Parameters:
    //    none
    //
    //   Returns:
    //    string - The product's filename
    /////////////////////////////////////////////////////////////////////////////////
    public function getFileName()
    {
        return $this->fileName;
    }

    /////////////////////////////////////////////////////////////////////////////////
    // getProductSource - Returns the source of the product (nwws or emwin)
    //
    //   Parameters:
    //    none
    //
    //   Returns:
    //    string - The product's source
    /////////////////////////////////////////////////////////////////////////////////
    public function getProductSource()
    {
        if (preg_match('/\/nwws\//', $this->fileName)) {
            return 'nwws';
        } elseif (preg_match('/\/emwin\//', $this->fileName)) {
            return 'emwin';
        } else {
            return 'n/a';
        }
    }

    /////////////////////////////////////////////////////////////////////////////////
    // getWmoHeader - Obtains the product's WMO Header
    //
    //   Parameters:
    //    none
    //
    //   Returns:
    //    string - The product's WMO Header
    /////////////////////////////////////////////////////////////////////////////////
    public function getWmoHeader()
    {
        return $this->productInfo['wmoHeader'];
    }

    /////////////////////////////////////////////////////////////////////////////////
    // getAwipsId - Obtains the product's AWIPS ID
    //
    //   Parameters:
    //    none
    //
    //   Returns:
    //    string - The product's AWIPS ID
    /////////////////////////////////////////////////////////////////////////////////
    public function getAwipsId()
    {
        return $this->productInfo['awipsId'];
    }

    /////////////////////////////////////////////////////////////////////////////////
    // getZoneClass - obtains the product's zone class
    //
    //   Parameters:
    //    none
    //
    //   Returns:
    //    string - The product's zone class (A, B, or C)
    /////////////////////////////////////////////////////////////////////////////////
    public function getZoneClass()
    {
        return $this->productInfo['zoneClass'];
    }

    /////////////////////////////////////////////////////////////////////////////////
    // getProductType - obtains the product's type
    //
    //   Parameters:
    //    none
    //
    //   Returns:
    //    string - 3-digit abbreviation of the product's type
    /////////////////////////////////////////////////////////////////////////////////
    public function getProductType()
    {
        if (!is_null($this->productInfo)) {
            if (!is_null($this->productInfo['productType'])) {
                return $this->productInfo['productType'];
            } else {
                return 'n/a';
            }
        } else {
            return 'n/a';
        }
    }

    /////////////////////////////////////////////////////////////////////////////////
    // toObject - creates array with all properties
    //
    //   Parameters:
    //    none
    //
    //   Returns:
    //    array         - Product data
    /////////////////////////////////////////////////////////////////////////////////
    public function toArray()
    {
        return array(
            'fileName' => $this->getFileName(),
            'productTime' => $this->getProductTime(),
            'wmoHeader' => $this->getWmoHeader(),
            'awipsId' => $this->getAwipsId(),
            'zoneClass' => $this->getZoneClass(),
            'productType' => $this->getProductType(),
            'fullContent' => implode("\n", $this->fileContents),
            'productSource' => $this->getProductSource(),
            'wfoInfo' => $this->getWfoInfo(),
            'generatedFileNames' => [
                'emwin' => $this->getEmwinFileName(),
                'nwwsOi' => $this->getNwwsOiFileName(),
            ],
        );
    }

    /////////////////////////////////////////////////////////////////////////////////
    // getProductTime - Obtains the product's time
    //
    //   Parameters:
    //    none
    //
    //   Returns:
    //    string - The product's time
    /////////////////////////////////////////////////////////////////////////////////
    public function getProductTime()
    {
        return filectime($this->fileName);
    }

    /////////////////////////////////////////////////////////////////////////////////
    // getWfoInfo - Obtains data about WFO that issued product
    //
    //   Parameters:
    //    none
    //
    //   Returns:
    //    string - The product's time
    /////////////////////////////////////////////////////////////////////////////////
    public function getWfoInfo()
    {
        if (preg_match('/\/tmp\/npemwin\.[a-f0-9]+\/([A-Z0-9]{3})[A-Z]{2,3}\.TXT/', $this->fileName, $matches)) {
            $abbr = $matches[1];
        } elseif (preg_match('/\/var\/npemwin\/files\/txt\/[a-z]{1}([a-z0-9]{3})\/[a-z0-9.]+/', $this->fileName, $matches)) {
            $abbr = $matches[1];
        } else {
            return [
                'abbr' => 'XXX',
                'fullname' => 'n/a',
                'state' => 'US',
                'tz' => '-',
                'url' => 'n/a',
                'rid' => 'n/a',
            ];
        }
        try {
            $wfo = Wfo::where('abbr', '=', $abbr)->firstOrFail();
            return $wfo->toArray();
        } catch (ModelNotFoundException $e) {
            return [
                'abbr' => $abbr,
                'fullname' => 'n/a',
                'state' => 'US',
                'tz' => '-',
                'url' => 'n/a',
                'rid' => 'n/a',
            ];
        }
    }

    /////////////////////////////////////////////////////////////////////////////////
    // getEmwinFileName - Generate EMWIN file name
    //
    //   Parameters:
    //    none
    //
    //   Returns:
    //    string - The product's EMWIN file name
    /////////////////////////////////////////////////////////////////////////////////
    public function getEmwinFileName()
    {
        // A_WWUS73KLOT051551_C_KWIN_20220705155211_857348-1-NPWLOTIL.TXT
        if (preg_match('/^A_/', basename($this->fileName))) {
            return basename($this->fileName);
        }
        $wfoInfo = $this->getWfoInfo();
        if (is_null($wfoInfo)) {
            return '';
        }
        // Only want the first three fields of the WMO Header (most only have 3)
        $wmoHeaderParts = explode(' ', $this->getWmoHeader());
        if (isset($wmoHeaderParts[0]) && isset($wmoHeaderParts[1]) && isset($wmoHeaderParts[2])) {
            $wmoHeader = $wmoHeaderParts[0] . $wmoHeaderParts[1] . $wmoHeaderParts[2];
        } else {
            return '';      // Invalid WMO Header format
        }
        // If SFW, priority = 1, otherwise priority = 2
        $priority = preg_match('/^(TOR|SVR|SVS|FFW|FFS|EWW)$/', $this->getProductType()) ? 1 : 2;
        // Return name
        return 'A_' .
            $wmoHeader .                                    // WMO Header w/o spaces
            '_C_KWIN_' .                                    // Product source
            date('YmdHis', filectime($this->fileName)) .    // Product UTC Date (YYYYMMDDhhmmss)
            '_' .                                           // Delimiter
            substr(time(), -6) .                            // 6-digit seq. number
            '-' .                                           // Delimiter
            $priority .                                     // Priority
            '-' .                                           // Delimiter
            $this->getAwipsId() .                           // AWIPS ID
            $wfoInfo['state'] .                             // WFO State
            '.TXT';                                         // File extension
    }

    /////////////////////////////////////////////////////////////////////////////////
    // getNwwsOiFileName - Generate NWWS-OI file name
    //
    //   Parameters:
    //    none
    //
    //   Returns:
    //    string - The product's NWWS-OI file name
    /////////////////////////////////////////////////////////////////////////////////
    public function getNwwsOiFileName()
    {
        // klot_wwus83-spslot.060231_13046.24078.txt
        $wmoHeader = explode(' ', $this->getWmoHeader());
        if (preg_match("/^$wmoHeader[1]/", basename($this->fileName))) {
            return basename($this->fileName);
        }
        return strtolower(
            $wmoHeader[1] .                                 // WFO
            '_' .                                           // Static string
            $wmoHeader[0] .                                 // First part of WMO Header
            '-' .                                           // Static string
            $this->getAwipsId() .                           // AWIPS ID
            '.' .                                           // Static string
            date('dHi', filectime($this->fileName)) .       // Product UTC Date (DDhhmm)
            '_' .                                           // Static string
            substr(time(), 0, 5) .                          // 5-digit seq. number #1
            '.' .                                           // Static string
            substr(time(), -5) .                            // 5-digit seq. number #2
            '.txt');                                        // File extension
    }


    /////////////////////////////////////////////////////////////////////////////////
    // Private functions
    /////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////
    // parseFileContents - Gets the product's contents
    //
    //   Parameters:
    //    string    - The full path to the product file
    //
    //   Returns:
    //    array     - The product after having binary character's stripped out
    /////////////////////////////////////////////////////////////////////////////////
    private function parseFileContents($fileContents)
    {
        for($i=0; $i<count($fileContents); $i++) {
            // Strip out binary characters
            $fileContents[$i] = preg_replace('/\r/', '', $fileContents[$i]);
            $fileContents[$i] = preg_replace('/\x00/', '', $fileContents[$i]);
            $fileContents[$i] = preg_replace('/\x03/', '', $fileContents[$i]);
            $fileContents[$i] = preg_replace('/\&lt;/', '<', $fileContents[$i]);
            $fileContents[$i] = preg_replace('/\&gt;/', '>', $fileContents[$i]);
            $fileContents[$i] = preg_replace('/\&amp;/', '&', $fileContents[$i]);
            $fileContents[$i] = preg_replace('/[^\x20-\x7E]/', '', $fileContents[$i]);
        }
        return $fileContents;
    }

    /////////////////////////////////////////////////////////////////////////////////
    // buildFullGmtTime - converts a GMT time in abbr format to UNIX time
    //
    //   Parameters:
    //    string    - The GMT time in DDHHMM format
    //
    //   Returns:
    //    int       - The corresponding UNIX time
    /////////////////////////////////////////////////////////////////////////////////
    private function buildFullGmtTime($gmtAbbrTime)
    {
        $fullGmtTime = 0;
        $hourDiff    = 4;	// default
        //print "**DEBUG** \$gmt_abbr_time = $gmt_abbr_time\n";
        // Convert the day/time if it matches the correct format
        $fileGmtime = $this->getProductTime();
        if (preg_match('/^(\d{2})(\d{2})(\d{2})$/', $gmtAbbrTime, $matches)) {
            $purgeGmtDay  = $matches[1];
            $purgeGmtHour = $matches[2];
            $purgeGmtMin  = $matches[3];
            $purgeGmtMon  = 0;
            $purgeGmtYear = 0;
            //print "**DEBUG** \$purgeGmtMin  = $purgeGmtMin\n";
            //print "**DEBUG** \$purgeGmtHour = $purgeGmtHour\n";
            //print "**DEBUG** \$purgeGmtDay  = $purgeGmtDay\n";
            //print "**DEBUG** gmdate('Y-m-d H:i:s', $file_gmtime) = " . gmdate('Y-m-d H:i:s \G\M\T', $file_gmtime) . "\n";
            $fileGmtSec  = gmdate('s', $fileGmtime);
            $fileGmtMin  = gmdate('i', $fileGmtime);
            $fileGmtHour = gmdate('H', $fileGmtime);
            $fileGmtDay  = gmdate('d', $fileGmtime);
            //print "**DEBUG** \$fileGmtMin  = $fileGmtMin\n";
            //print "**DEBUG** \$fileGmtHour = $fileGmtHour\n";
            //print "**DEBUG** \$fileGmtDay  = $fileGmtDay\n";
            if ($purgeGmtDay > $fileGmtDay) {
                //print "**DEBUG** \$purge_gmt_day > $file_gmt_day\n";
                $hourDiff = (24 * abs($purgeGmtDay - $fileGmtDay)) - ($fileGmtHour - $purgeGmtHour);
                if ($hourDiff > 24) {
                    $hourDiff = 24;
                }
            } elseif ($purgeGmtDay === $fileGmtDay) {
                if ($purgeGmtHour < $fileGmtHour) {
                    // Example:
                    //   file date/time:    01/01/2008 01:00
                    //   purge date/time:   01/01/2008 00:00
                    // Purge date before file date?!?!, i.e. this should never happen!
                } elseif ($purgeGmtHour === $fileGmtHour) {
                    // Example:
                    //   file date/time:    01/01/2008 01:00
                    //   purge date/time:   01/01/2008 01:00
                    $hourDiff = 0;
                } else {	// ($purge_gmt_hour > $file_gmt_hour)
                    // Example:
                    //   file date/time:    01/01/2008 00:00
                    //   purge date/time:   01/01/2008 12:00
                    $hourDiff = $purgeGmtHour - $fileGmtHour;
                }
            } else {	// ($purge_gmt_day < $file_gmt_day)
                $hourDiff = 24 - ($fileGmtHour - $purgeGmtHour);
                if ($hourDiff > 24) {
                    $hourDiff = 24;
                }
            }
            //print "**DEBUG** \$hourDiff = $hourDiff\n";
            //print "**DEBUG** (stat(\$filename))[10] = " . (stat($filename))[10] . "\n";
            $fullGmtTime = $fileGmtime + (60 * 60 * $hourDiff) + (60 * ($purgeGmtMin - $fileGmtMin)) - $fileGmtSec;
        } else {
            $fullGmtTime = $fileGmtime + (60 * 60 * $hourDiff);
        }
        //print "**DEBUG** \$fullGmtTime = $fullGmtTime\n";
        return $fullGmtTime;
    }

    /////////////////////////////////////////////////////////////////////////////////
    // splitProductInfo - splits product info into parts to make it easier to handle
    //
    //   Parameters:
    //
    //    1: (int)           filename of product
    //
    //   Returns:
    //
    //    (ref. to hash)     Hash containing the following info:
    //
    //   key:                value:
    //
    //    'wmoHeader'        WMO header (usually first line)
    //    'awipsId'          Product abbr and product designator (usually second line)
    //    'zoneClass'        zone class (A, B, or C)
    //    'globalInfo'       Information that has no zone associated with it
    //    'productType'      The 3-letter abbreviation of the product type
    //    '<zoneHeader>'     The zone-specific product data
    //
    /////////////////////////////////////////////////////////////////////////////////
    private function splitProductInfo()
    {
        $prodInfo  = array();
        $key       = 'globalInfo';
        $zone      = '';
        $hdr1      = -1;
        $hdr2      = -1;
        $eofFound  = 0;
        $scanZone  = 0;
        $scanLine  = 1;
        $infoLines = array();
        //print "**DEBUG** Number of lines in \$prod_lines = " . scalar(@$prod_lines) . "\n";
        //print "**DEBUG** \$prod_lines->[0] = " . $prod_lines->[0] . "\n";
        $prodInfo['zoneClass']  = 'A';
        $prodInfo['globalInfo'] = '';
        $prodInfo['zoneInfo'] = array();
        // Loop through the lines of the product and parse out the information
        for ($i=0; $i<count($this->fileContents); $i++) {
            if ($hdr1 === -1) {
                // FLUS44 KEWX 212144 CCA
                if (preg_match('/^\w{4}\d{2}\s+\w{4}\s+\d{6}(\s+\w+)?\s*$/', $this->fileContents[$i], $matches)) {
                    // WMO HEADER
                    $prodInfo['wmoHeader'] = $this->fileContents[$i];
                    //print "**DEBUG** WMO header found at array index $i ('" . $prodInfo['wmoHeader'] . "')\n";
                    $hdr1 = $i;
                }
            }
            if ($hdr2 === -1) {
                if (preg_match('/^[A-Z0-9]{4,6}\s*$/', $this->fileContents[$i]) && !preg_match('/METAR/', $this->fileContents[$i])) {
                    // AWIPS ID
                    $prodInfo['awipsId'] = $this->fileContents[$i];
                    $prodInfo['awipsId'] = preg_replace('/(\s*)/', '', $prodInfo['awipsId']);
                    //print "**DEBUG** AWIPS ID found at array index $i ('" . $prodInfo['awipsId'] . "')\n";
                    $hdr2 = $i;
                    $i++;
                }
            }
            //print "**DEBUG** \$hdr1 = $hdr1\n";
            //print "**DEBUG** \$hdr2 = $hdr2\n";
            // If we found the WMO header and the AWIPS ID, start scanning the product info
            if ($hdr1 >= 0 && $hdr2 >= 0) {
                // Check for zone header
                if (preg_match('/^(\w)(\w)(C|Z)(\d+)[->]/', $this->fileContents[$i]) && substr($prodInfo['awipsId'], 0, 3) != 'AFD') {
                    //print "**DEBUG** Beginning of zone header found at line $i\n";
                    $eofFound = 0;
                    if ($i === $hdr2 + 1) {
                        $prodInfo['zoneClass'] = 'B';
                    } else {
                        $prodInfo['zoneClass'] = 'C';
                    }
                    // Loop and read lines until you find the end of the zone header
                    $rc = 0;
                    while(1) {
                        //print "**DEBUG** \$prod_lines[$i] = $prod_lines[$i]\n";
                        $zone .= $this->fileContents[$i];
                        if (preg_match('/[-]*\d{6}[-]*\s*$/', $this->fileContents[$i])) {
                            //print "**DEBUG** End of zone header found at line $i\n";
                            $zone = preg_replace('/ /', '', $zone);
                            $key = $zone;
                            $i++;
                            break;
                        }
                        if (preg_match('/^\s*$/', $this->fileContents[$i])) {
                            //print "**DEBUG** Found blank line at index $i, breaking out of while loop.\n";
                            //print "**DEBUG** Found blank line at index $i, skipping.\n";
                            //key = $prod_lines->[$i-1];
                            //i++;
                            //last;
                        }
                        $rc++;
                        if ($rc === 10) {
                            //print "**DEBUG** Warning!  Endless loop caught in finding end of zone header\n";
                            break;
                        }
                        $i++;
                    }
                    // If there is already information in $infoLines, place it in $prodInfo['globalInfo'] and clean $infoLines array
                    if (count($infoLines) > 0 && $prodInfo['globalInfo'] === '') {
                        //print "**DEBUG** There is data in \$infoLines\n";
                        $prodInfo['globalInfo'] = implode("\n", $infoLines) . "\n";
                        //unset($infoLines);
                        $infoLines = array();
                    }
                }
                // Check for end of info delimiter
                if (preg_match('/^\$\$\s*$/', $this->fileContents[$i]) && !$eofFound) {
                    $eofFound = 1;
                    //print "**DEBUG** End of info delim found\n";
                    $scanZone = 0;
                    $zone     = '';
                    //print "**DEBUG** Inserting info into \$prodInfo[$key]\n";
                    $prodInfo['zoneInfo'][$key] = implode("\n", $infoLines);
                    //unset($infoLines);
                    $infoLines = array();
                }
                //print "**DEBUG** Adding line to $prod_lines array\n";
                // Add the line to the @prod_lines array
                if (!preg_match('/^\$\$\s*$/', $this->fileContents[$i])) {
                    array_push($infoLines, $this->fileContents[$i]);
                }
            }
        }
        //print "**DEBUG** Number of lines in $infoLines = " . count($infoLines) . "\n";
        //
        // Sometimes text products don't contain the EOD delimeter and it also
        // does not contain any zone information.  All the info in the $infoLines
        // array needs to be put in $prodInfo['global data']
        //
        //print "**DEBUG** \$prodInfo['globalInfo'] = " . $prodInfo['globalInfo'] . "\n";
        //print "**DEBUG** \$eofFound               = " . $eofFound . "\n";
        //print "**DEBUG** \$prodInfo['zoneClass']  = " . $prodInfo['zoneClass'] . "\n";
        if ($prodInfo['globalInfo'] === '' && !$eofFound && $prodInfo['zoneClass'] != 'B') {
            //print "**DEBUG** Setting globalInfo\n";
            $prodInfo['globalInfo'] = $this->fileContents;
        }
        // If we didn't find the EOD delimeter and there is data in the $infoLines
        // array, it needs to be added to the $prodInfo[$key] hash.
        if ($key !== 'globalInfo' && !$eofFound) {
            $prodInfo['zoneInfo'][$key] = implode("\n", $infoLines);
        }
        // If the WMO header wasn't found, give it a default value
        if (!isset($prodInfo['wmoHeader'])) {
            // Log::info('AWIPSProduct: Could not determine WMO Header. (' . $this->fileName . ')');
            $prodInfo['wmoHeader'] = 'n/a';
        }
        // If the AWIPS ID wasn't found, give it a default value
        if (!isset($prodInfo['awipsId'])) {
            // Log if AWIPS ID was not found in EMWIN product
            // if (!preg_match('/^A_[A-Z0-9]{16}_C_/', basename($this->fileName))) {
            //     Log::info('AWIPSProduct: Could not determine AWIPS ID. (' . $this->fileName . ')');
            // }
            if (preg_match('/[A-Z0-9]{5,6}\.TXT/', basename($this->fileName))) {
                $prodInfo['awipsId'] = basename($this->fileName, '.TXT');
            } else {
                $type = 'XXX';
                for ($i=0; $i<count($this->fileContents); $i++) {
                    if (preg_match('/THIS IS A COMMUNICATIONS TEST MESSAGE ORIGINATING FROM THE/', $this->fileContents[$i])) {
                        $type = 'TST';
                    }
                }
                $prodInfo['awipsId'] = $type . substr(strtoupper((explode('/', $this->fileName)[5])), 1, 3);
            }
        }
        // Obtain product type
        if ($prodInfo['awipsId'] !== 'n/a') {
            $prodInfo['productType'] = strtoupper(substr($prodInfo['awipsId'], 0, 3));
        } else {
            $prodInfo['productType'] = 'n/a';
        }
        // Return the $prodInfo array
        return $prodInfo;
    }

}
