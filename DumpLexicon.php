<?php
/**
* @package = DumpLexicon
*
* dump MODX Revolution 2.x lexicon content from database do files
*
* This script dumps any MODX Revolution 2.x lexicon content from 
* database to include files.
*
* This script runs outside of MODx, but uses its config and xPDO
* objects.
*
*/

define('NAMESPACE_', 'hotpointclub');
// define('ORDERBY', 'name'); // optional - order by name
define('PATH', './core/components/' . NAMESPACE_ . '/lexicon/');
define(MODX_CORE_PATH, dirname(__FILE__) . '/../core/');

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
        fwrite($handle, '?>' . "\n");
        fclose($handle);
    }
}

if (count($lexicon)) {
	echo 'MODX lexicon ' . NAMESPACE_ . ' exported to directory ' . PATH;
} else {
	echo 'MODX lexicon ' . NAMESPACE_ . ' is empty!';
}

?>
