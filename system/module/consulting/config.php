<?php if(!defined("RUN_MODE")) die();?>
<?php
$config->consulting->require = new stdclass();
$config->consulting->require->create         = 'categories, title, content';
$config->consulting->require->page           = 'title, content';
$config->consulting->require->link           = 'categories, title, link';
$config->consulting->require->pageLink       = 'title, link';
$config->consulting->require->edit           = 'categories, title, content';
$config->consulting->require->forward2Blog   = 'categories';
$config->consulting->require->forward2Forum  = 'board';
$config->consulting->require->post           = 'title, content';
$config->consulting->require->modify         = 'title, content';

$config->consulting->editor = new stdclass();
$config->consulting->editor->create = array('id' => 'content,summary', 'tools' => 'full');
$config->consulting->editor->edit   = array('id' => 'content,summary', 'tools' => 'full');
$config->consulting->editor->post   = array('id' => 'content', 'tools' => 'simple');
$config->consulting->editor->modify = array('id' => 'content', 'tools' => 'simple');

/* Set the recPerPage of consulting. */
$config->consulting->recPerPage = 10;
