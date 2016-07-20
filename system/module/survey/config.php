<?php if(!defined("RUN_MODE")) die();?>
<?php
$config->survey = new stdclass();
$config->survey->apiRoot   = 'http://api.chanzhi.org/extension-';
$config->survey->extPathes = array('module', 'bin', 'www', 'library', 'config');

$config->survey->editor = new stdclass();
$config->survey->editor->addtheme = array('id' => 'content', 'tools' => 'full');
$config->survey->editor->edittheme   = array('id' => 'content', 'tools' => 'full');
$config->survey->editor->addsurvey   = array('id' => 'intro', 'tools' => 'full');
$config->survey->editor->editsurvey   = array('id' => 'intro', 'tools' => 'full');
$config->survey->editor->post   = array('id' => 'content', 'tools' => 'simple');
$config->survey->editor->modify = array('id' => 'content', 'tools' => 'simple');

/* Set the recPerPage of zhaopin. */
$config->survey->recPerPage = 10;
