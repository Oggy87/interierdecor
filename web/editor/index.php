<?php

include dirname(__FILE__) . "/../libs/Nette/Nette/loader.php";

Debug::enable(Debug::DETECT,'../log');

$dir = dirname(__FILE__) . "/../libs/Adminer/plugins/";


function adminer_object() {

    // required to run any plugin
    include_once dirname(__FILE__) . "/../libs/Adminer/plugins/plugin.php";

    $dir = dirname(__FILE__) . "/../libs/Adminer/plugins/";

    foreach (Finder::findFiles('*.php')->in($dir) as $key => $file) {
        include_once $key;
    }

    return new AdminerPlugin(array(
        // specify enabled plugins here
        //new AdminerDumpXml,
        new AdminerTinymce,
        //new AdminerFileUpload("data/"),
        new AdminerSlugify,
        //new AdminerTranslation,
        //new AdminerForeignSystem,
        new AdminerEditCalendar,
        new AdminerEditTextarea,
        new AdminerEnumOption,
        new AdminerLoginTable,
        new AdminerCredentials
    ));
}

// include original Adminer or Adminer Editor
include dirname(__FILE__)  . "/../libs/Adminer/editor.php";
?>
