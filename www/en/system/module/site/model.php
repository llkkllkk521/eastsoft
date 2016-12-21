<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php
class siteModel extends model
{
    public $savePath = '';
    public $webPath  = '';
    public $now      = 0;

    /**
     * [__construct description]
     * @AuthorName lzhan<lzhan@3ti.us>
     * @DateTime   2016-02-02T16:30:30+0800
     */
    public function __construct()
    {
        parent::__construct();
        $this->now = time();
        $this->setSavePath();
        $this->setWebPath();
    }

    /**
     * Set the site user visiting.
     *
     * @access public
     * @return void
     */
    public function setSite()
    {
        if(!isset($this->config->site))                $this->config->site                = new stdclass();
        if(!isset($this->config->site->name))          $this->config->site->name          = $this->lang->chanzhiEPS;
        if(!isset($this->config->site->keywords))      $this->config->site->keywords      = '';
        if(!isset($this->config->site->indexKeywords)) $this->config->site->indexKeywords = '';
        if(!isset($this->config->site->slogan))        $this->config->site->slogan        = '';
        if(!isset($this->config->site->copyright))     $this->config->site->copyright     = '';
        if(!isset($this->config->site->icpSN))         $this->config->site->icpSN         = '';
        if(!isset($this->config->site->meta))          $this->config->site->meta          = '';
        if(!isset($this->config->site->desc))          $this->config->site->desc          = '';
        if(!isset($this->config->site->theme))         $this->config->site->theme         = 'default';
        if(!isset($this->config->site->lang))          $this->config->site->lang          = 'zh-cn';
        if(!isset($this->config->site->menu))          $this->config->site->menu          = json_encode(array());

        if(!isset($this->config->company))             $this->config->company             = new stdclass();
        if(!isset($this->config->company->name))       $this->config->company->name       = '';
        if(!isset($this->config->company->desc))       $this->config->company->desc       = '';
        if(!isset($this->config->company->content))    $this->config->company->content    = '';
        if(!isset($this->config->company->contact))    $this->config->company->contact    = json_encode(array());

        if(!isset($this->config->product))             $this->config->product             = new stdclass();
    }

    public function setSavePath($objectType = '')
    {
        $savePath = $this->app->getDataRoot() . "upload/" . date('Ym/', $this->now);
        $this->savePath = dirname($savePath) . '/';

        if($objectType == 'source')
        {
            $device   = helper::getDevice();
            $template = $this->config->template->{$device}->name;
            $theme    = $this->config->template->{$device}->theme;
            $savePath = $this->app->getDataRoot() . "source/{$template}/{$theme}/";
            $this->savePath = $this->app->getDataRoot();
        }

        if(!file_exists($savePath)) 
        {
            @mkdir($savePath, 0777, true);
            if(is_writable($savePath) && !file_exists($savePath . DS . 'index.html'))
            {
                $fd = @fopen($savePath . DS . 'index.html', "a+");
                fclose($fd);
                chmod($savePath . DS . 'index.html' , 0755);
            }
        }
    }
    
    /**
     * Set the web path.
     * 
     * @access public
     * @return void
     */
    public function setWebPath()
    {
        $this->webPath = $this->app->getWebRoot() . "data/upload/";
    }


    /**
     * [checkSavePath description]
     * @AuthorName lzhan<lzhan@3ti.us>
     * @DateTime   2016-02-02T16:24:28+0800
     * @return     [type] [description]
     */
    public function checkSavePath()
    {
        return is_writable($this->savePath);
    }

    /**
     * [getByObject description]
     * @AuthorName lzhan<lzhan@3ti.us>
     * @DateTime   2016-02-02T16:25:08+0800
     * @param      [type] $objectType [description]
     * @param      [type] $objectID [description]
     * @param      [type] $isImage [description]
     * @return     [type] [description]
     */
    public function getByObject($objectType, $objectID, $isImage = null)
    {
        /* Get files group by objectID. */
        $files = $this->dao->setAutoLang(false)->select('*')
            ->from(TABLE_FILE)
            ->where('objectType')->eq($objectType)
            ->andWhere('objectID')->in($objectID)
            ->beginIf(isset($isImage) and $isImage)->andWhere('extension')->in($this->config->file->imageExtensions)->fi() 
            ->beginIf(isset($isImage) and !$isImage)->andWhere('extension')->notin($this->config->file->imageExtensions)->fi()
            ->orderBy('`id`, editor_desc')
            ->fetchGroup('objectID');

        /* Process these files. */
        foreach($files as $objectFiles) $this->batchProcessFile($objectFiles);

        /* If object is only an objectID, return it's files, else return all. */
        if(is_numeric($objectID) and !empty($files[$objectID])) return $files[$objectID];
        return $files;
    }

    /**
     * [batchProcessFile description]
     * @AuthorName lzhan<lzhan@3ti.us>
     * @DateTime   2016-02-02T17:01:55+0800
     * @param      [type] $files [description]
     * @return     [type] [description]
     */
    public function batchProcessFile($files)
    {
        foreach($files as &$file) $file = $this->processFile($file);
        return $files;
    }

    /**
     * [processFile description]
     * @AuthorName lzhan<lzhan@3ti.us>
     * @DateTime   2016-02-02T17:02:25+0800
     * @param      [type] $file [description]
     * @return     [type] [description]
     */
    public function processFile($file)
    {
        $file->fullURL   = $this->getWebPath($file->objectType) . $file->pathname;
        $file->middleURL = '';
        $file->smallURL  = '';
        $file->isImage   = false;
        $file->isVideo   = false;

        if(in_array(strtolower($file->extension), $this->config->file->imageExtensions, true) !== false)
        {
            $file->middleURL = $this->getWebPath($file->objectType) . str_replace('f_', 'm_', $file->pathname);
            $file->smallURL  = $this->getWebPath($file->objectType) . str_replace('f_', 's_', $file->pathname);
            $file->largeURL  = $this->getWebPath($file->objectType) . str_replace('f_', 'l_', $file->pathname);

            if(!file_exists(str_replace($this->getWebPath($file->objectType), $this->savePath, $file->middleURL))) $file->middleURL = $file->fullURL;
            if(!file_exists(str_replace($this->getWebPath($file->objectType), $this->savePath, $file->smallURL)))  $file->smallURL  = $file->fullURL;
            if(!file_exists(str_replace($this->getWebPath($file->objectType), $this->savePath, $file->largeURL)))  $file->largeURL  = $file->fullURL;

            $file->isImage = true;
        }

        if(in_array(strtolower($file->extension), $this->config->file->videoExtensions, true) !== false) $file->isVideo = true;

        return $file;
    }

    /**
     * [getWebPath description]
     * @AuthorName lzhan<lzhan@3ti.us>
     * @DateTime   2016-02-02T17:04:33+0800
     * @param      string $objectType [description]
     * @return     [type] [description]
     */
    public function getWebPath($objectType = '')
    {
        if(strpos(',slide,source,', ",$objectType,") !== false) return $this->app->getWebRoot() . "data/";
        return $this->app->getWebRoot() . "data/upload/";
    }


}
