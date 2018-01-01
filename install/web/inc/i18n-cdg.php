***REMOVED***
// Functions for internationalization

/**
 * Translates string to given language in first parameter, key given in second parameter (dynamically loads required language). Works like spritf from second parameter
 * @global array $LANG Associative array of language pharses
 * @return string Translated string
 */
function _translate() {
    global $LANG;

    $args = func_get_args();

    $l = $args[0];
    if (empty($l)) return 'NO LANGUAGE DEFINED';

    $key = $args[1];
    if (empty($key)) return '';

    // No translation needed
    if (!preg_match('/[a-z]/i', $key)) {
        return $key;
    ***REMOVED***

    // Load language file (if not loaded yet)
    if (!isset($LANG[$l])) {
        require_once($_SERVER['DOCUMENT_ROOT']."/inc/i18n-cdg/$l.php");
    ***REMOVED***

    //if (!isset($LANG[$l][$key])) file_put_contents('/somewhere/something.log', "$key\n", FILE_APPEND);
    $text = isset($LANG[$l][$key]) ? $LANG[$l][$key] : $key;

    array_shift($args);
    if (count($args) > 1) {
        $args[0] = $text;
        return call_user_func_array('sprintf', $args);
    ***REMOVED*** else {
        return $text;
    ***REMOVED***
***REMOVED***

/**
 * Translates string by a given key in first parameter to current session language. Works like sprintf
 * @global array $LANG Associative array of language pharses
 * @return string Translated string
 * @see _translate()
 */
function __() {
    $args = func_get_args();
    array_unshift($args, $_SESSION['language']);
    return call_user_func_array('_translate', $args);
***REMOVED***

/**
 * Detects user language from Accept-Language HTTP header.
 * @param string Fallback language (default: 'en')
 * @return string Language code (such as 'en' and 'ja')
 */
function detect_user_language($fallback='en') {
    static $user_lang = '';

    // Already detected
    if (!empty($user_lang)) return $user_lang;

    // Check if Accept-Language header is available
    if (!isset($_SERVER) ||
        !isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ||
        !is_string($_SERVER['HTTP_ACCEPT_LANGUAGE'])
    ) {
        // Store result for reusing
        $user_lang = $fallback;
        return $user_lang;
    ***REMOVED***


    // Sort Accept-Language by `q` value
    $accept_langs = explode(',', preg_replace('/\s/', '', strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE'])));
    $accept_langs_sorted = array() ;
    foreach ($accept_langs as $lang) {
        $div = explode(';q=', $lang, 2);
        if (count($div) < 2) {
            // `q` value was not specfied
            // -> Set default `q` value (1)
            $div[] = '1';
        ***REMOVED***
        list($code, $q) = $div;
        if (preg_match('/^[\w\-]+$/', $code)) {
            // Acceptable language code
            $accept_langs_sorted[$code] = (double)$q;
        ***REMOVED***
    ***REMOVED***
    arsort($accept_langs_sorted);

    // List languages
    exec (VESTA_CMD."v-list-sys-languages json", $output, $return_var);
    $languages = json_decode(implode('', $output), true);
    unset($output);

    // Find best matching language
    foreach ($accept_langs_sorted as $user_lang => $dummy) {
        $decision = '';
        foreach ($languages as $prov_lang) {
            if (strlen($decision) > strlen($prov_lang)) continue;
            if (strpos($user_lang, $prov_lang) !== false) {
                $decision = $prov_lang;
            ***REMOVED***
        ***REMOVED***
        if (!empty($decision)) {
            // Store result for reusing
            $user_lang = $decision;
            return $user_lang;
        ***REMOVED***
    ***REMOVED***

    // Store result for reusing
    $user_lang = $fallback;
    return $user_lang;
***REMOVED***

/**
 * Detects user language .
 * @param string Fallback language (default: 'en')
 * @return string Language code (such as 'en' and 'ja')
 */

function detect_login_language(){

***REMOVED***
