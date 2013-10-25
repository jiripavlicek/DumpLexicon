<?php
/**
* @package = DumpLexicon
*
* dump MODX Revolution 2.x lexicon content from database do files
*
* This script dumps any MODX Revolution 2.x lexicon content from 
* database to include files.
*
<<<<<<< HEAD
* Note: If you are running this outside of MODx and testing it
* in the Manager, it will log you out when it runs, even though
* the Manager screen will still be visible. Actions taken in the
* Manager (e.g., saving a snippet) will not be successful. After
* running the script, reload the Manager page in your browser
* and you will be prompted to log back in.
=======
* This script runs outside of MODx, but uses its config and xPDO
* objects.
>>>>>>> undated description and readme
*
*
*/

define('NAMESPACE_', 'hotpointclub');
// define('ORDERBY', 'name'); // optional - order by name
<<<<<<< HEAD

define('PATH', './core/components/' . NAMESPACE_ . '/lexicon/');

define(MODX_CORE_PATH, dirname(__FILE__) . '/../core/');
=======
define('PATH', './core/components/' . NAMESPACE_ . '/lexicon/');
define(MODX_CORE_PATH, dirname(__FILE__) . '/../core/');

>>>>>>> undated description and readme
include_once MODX_CORE_PATH . '/model/modx/modx.class.php';
$modx= new modX();
$modx->initialize('mgr');

// collect lexicon items
$lexicon = array();

$query = $modx->newQuery('modLexiconEntry');
$query->where(array('namespace' => NAMESPACE_));
if (defined('ORDERBY')) {
    // if is defined sorting
    if (ORDERBY) {
        // if sort fieldname isn't empty
        $query->sortby(ORDERBY, 'asc');
    }
}
$entries = $modx->getCollection('modLexiconEntry', $query);
foreach ($entries as $entry) {
    $data = $entry->toArray();
    $lexicon[$data['language']][$data['topic']][$data['name']] = $data['value'];
}

// create directories and files
foreach ($lexicon as $language => $data) {
    $dir = PATH . $language . '/';
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    foreach ($data as $topic => $data2) {
        $handle = fopen($dir . '/' . $topic . '.inc.php', 'w');
        fwrite($handle, '<?php' . "\n");
        fwrite($handle, '/**' . "\n");
        fwrite($handle, ' * ' . $topic . ' ' . $language . ' lexicon topic' . "\n");
        fwrite($handle, ' *' . "\n");
        fwrite($handle, ' * @language ' . $language . '' . "\n");
        fwrite($handle, ' * @package ' . NAMESPACE_ . "\n");
        fwrite($handle, ' * @subpackage lexicon' . "\n");
        fwrite($handle, ' *' . "\n");
        fwrite($handle, ' * @updated ' . date('Y-m-d') . "\n");
        fwrite($handle, ' */' . "\n");
        fwrite($handle, "\n");
        
        foreach ($data2 as $name => $value) {
            fwrite($handle, "\$_lang['" . $name . "'] = '" . $value . "';\n");
        }        
        fwrite($handle, '>' . "\n");
        fclose($handle);
    }
}

?>
