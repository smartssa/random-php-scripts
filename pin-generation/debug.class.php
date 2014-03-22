<?php
// a simple debugging class
// dclarke
// track a list for output

class Debug {
    // output variable
    var $debug_out = "";
    // debug status (on by default)
    var $debug_status = "1";
    var $debug_count = "0"; // track the debug messages.

    function Toggle ( $status = 1 ) {
        // toggle debug status to what is passed (on if you forget)
        // this allows to temporarily suspend debugging.
        $this->debug_status = $status;
    }

    function Append ( $str ) {
        // append the debug string with newline.
        // only if it's enabled to do so.
        if ($this->debug_status == 1) {
            $this->debug_count++;
            $this->debug_out .= $this->debug_count . " : " . $str . "\n";
        }
    }

    function Output ( $html = 0 ){
        // output the debugging info on demand.
        // default to no html. (useful for cli applications)
        // only output if debugging is actually enabled.
        if ($this->debug_status) {
            if ($html) {
                $this->debug_out = "<div id=\"debug\"><h4>Debug:</h4><p>" . nl2br($this->debug_out) . "</p></div>";
            }
            return $this->debug_out;
        }
    }
}


function debug_append( $str ) {
    global $debug;

    // append the string.
    $debug->Append($str);
    return true;

}

// instantiationize the class
$debug = new Debug();


?>