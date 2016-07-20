<?php if(!defined("RUN_MODE")) die();?>
<?php
$config->zhaopin->require = new stdclass();
$config->article->require->create         = 'categories, title, content';
$config->zhaopin->require->page           = 'title, content';
$config->zhaopin->require->link           = 'categories, title, link';
$config->zhaopin->require->pageLink       = 'title, link';
$config->zhaopin->require->edit           = 'categories, title, content';
$config->zhaopin->require->forward2Blog   = 'categories';
$config->zhaopin->require->forward2Forum  = 'board';
$config->zhaopin->require->post           = 'title, content';
$config->zhaopin->require->modify         = 'title, content';

$config->zhaopin->editor = new stdclass();
$config->zhaopin->editor->create = array('id' => 'content,summary', 'tools' => 'full');
$config->zhaopin->editor->edit   = array('id' => 'content,summary', 'tools' => 'full');
$config->zhaopin->editor->post   = array('id' => 'content', 'tools' => 'simple');
$config->zhaopin->editor->modify = array('id' => 'content', 'tools' => 'simple');

/* Set the recPerPage of zhaopin. */
$config->zhaopin->recPerPage = 20;
