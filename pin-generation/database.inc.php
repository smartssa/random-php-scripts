<?php
// database functions & stuff
// dclarke / created june 12, 2004
// edited many times.

// normally these would come from the main application:
define("DBSERV", "some server");
define("DBUSER", "some user");
define("DBPASS", "some password");
define("DBNAME", "some database");
// ** end

function db_connect() {
    // reusable database connection for non-persistant usage
    $db = @mysql_connect(DBSERV, DBUSER, DBPASS)
        or die("Cannot connect to the database; So we can't do anything.");
    @mysql_select_db (DBNAME, $db);

    return $db;

}

function db_query($query) {
    // these globals come in handy after queries.
    global $db_lastid, $db_affected, $db_rows;
    // execute a query, set some variables, and return the result.
        $db = db_connect();
        $result =  @mysql_query($query,$db)
        or die("Failed to exec Query: " . $query . mysql_error());

    // last id from an INSERT
        $db_lastid = @mysql_insert_id($db);
    // number of rows affected by an UPDATE
        $db_affected = @mysql_affected_rows();
    // number of rows returned by a SELECT
    $db_rows = @mysql_num_rows($result);

        return $result;

}

function db_recordpager ($SQL,$maxrows,$maxpages=0) {

    // this function takes a query and limit parameters,
    // sets globals $pageLink, $TotalPages, $TotalRows
    // and returns the mysql link resource to do
    // post processing.

    // lets have some nice globals, yo.
    global $page, $pageLink, $QUERY_STRING;
    global $TotalPages, $TotalRows;
    if ($QUERY_STRING) {
        // fix up the query string to remove any
        // old page= artifacts and preserve it for usage on next/previous links.
        $Query = preg_replace("/page=[0-9]*/i","",$QUERY_STRING);
        if ($Query != "") {
            if (substr($Query,0,1) != "&") {
                $Query = "&". $Query; }
        }
    }

    // We need to execute the bare query before limiting
    // so we can get the maximum rows.
    $selectQuery = $SQL;

    $result =  db_query($selectQuery);
    $TotalRows = mysql_num_rows($result);

    // set Max Pages and Max Rows, why?
    // if the number of records expands past max pages
    // then max rows is expanded to make max pages stick
    // if you want no max pages, pass 0 along then maxrows
    // will stay as you say

    $MaxPages = $maxpages;
    $MaxRows = $maxrows;

    if ($MaxPages > 0) {
        $pageCheck = ceil($TotalRows / $MaxRows);
        if ($pageCheck > $MaxPages) {
            $MaxRows = ceil($TotalRows / $MaxPages);
        }
    }

    // determine the maximum pages
    $TotalPages = ceil($TotalRows/$MaxRows);

    // basic page number checking for invalid page values.
    if ($page > $TotalPages) { $page = $TotalPages; }
    if ($page < 0 || !$page ) { $page = 1; }

    // set the LIMIT portion of the query.
    if ($page > 1){
        $base = ($page-1) * $MaxRows;
        $LIMIT = "LIMIT ".$base.",".$MaxRows;
    } else {
        $LIMIT = "LIMIT ".$MaxRows;
    }

    // Build the new query with the determined LIMITs
    $selectQuery = $SQL . " " . $LIMIT;

    $result =  db_query($selectQuery);
    $rows = mysql_num_rows($result);

    if ($rows <= 0) {
        // there's not really anything to do or show.
        // could issue a warning or notice saying nothing was returned.
    }
    else {

        // Generate next/previous page links based on current page.
        $prev = $page - 1;
        $next = $page + 1;
        // have next/previous page links with preserved query strings.
        $strNext = "<a href=\"?page=$next" . htmlentities($Query) . "\">next</a>";
        $strPrev = "<a href=\"?page=$prev" . htmlentities($Query) . "\">prev</a>";
        if ($next > $TotalPages) {
            $strNext = "next";
        }
        if ($prev < 1) {
            $strPrev = "prev";
        }
        // pagebar will be the string containing all the links for
        // page jumping.  When pages exceed a certain amount, show '...' in place.
        // first page, last page are always visible.
        $pagebar = "";
        for( $i = 1; $i <= $TotalPages; $i++) {
            // if we are within 10 pages prev and 10 pages next show the numbers
            // if not, show '...' to represent the gap of pages +/- 10 to the first
            // and last pages.  All links preserve query strings.
            if (($i < ($page - 10)) || ($i > ($page + 10))) {
                if (!$oink) {
                    if ($i < ($page - 10)) {
                        $pagebar .= " <a href=\"?page=1" . htmlentities($Query) . "\">1</a>";
                        $pagebar .= " ... ";
                    }
                    if ($i > ($page + 10)) {
                        $pagebar .= " ... ";
                        $pagebar .= " <a href=\"?page=$TotalPages" . htmlentities($Query) . "\">$TotalPages</a>";
                    }
                    // dummy flag to represent we're doing the '...' thing.
                    $oink = true;
                }
            }
            else if ($i != $page) {
                // display the page number with preserved query string.
                $pagebar = $pagebar." <a href=\"?page=$i" . htmlentities($Query) . "\">$i</a>";
                $oink =  false;
            }
            else {
                // display the active page without a link.
                $pagebar = $pagebar." <span style=\"border-bottom: 1px dashed green;\">$i</span> ";
            }
        }
        // put all the links together.
        $pageLink = $strPrev." . ".$pagebar." . ".$strNext;
    }
    // return the query resource.
    return $result;
}
?>
