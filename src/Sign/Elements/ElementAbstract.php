<?php

namespace Ilovepdf\Sign\Elements;
use Ilovepdf\File;


abstract class ElementAbstract
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $position = '0 0';

    /**
     * @var string
     */
    public $pages = '1';

    /**
     * @var integer
     */
    public $size = 40;

    /**
     * @var
     */
    public $content;

    protected $position_preg_match = '/(\d+\.?\d+) (-?\d+\.?\d+)/';
    
    /**
     * @var
     */
    public $info;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Element
     */
    protected function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function getInfo(){
        if(!is_null($this->info) && !empty($this->info)){
            return json_encode($this->info);
        }
        return $this->info;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $position
     * @return Element
     */
    public function setPosition(string $position)
    {
        list($left,$top) = explode(" ",$position);
        $left = floatval($left);
        $top = floatval($top);
        if(floatval($top) > 0){
            throw new \InvalidArgumentException("Invalid Top value, must be either negative or zero");
        }
        $this->position = $position;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param mixed $pages
     * @return Element
     */
    public function setPages($pages)
    {
        var_dump(explode(",",$pages));
         $pages = array_map(function($page){
            if(strpos($page,'-')){
                list($firstpage,$lastpage) = explode("-",$page);
                $firstpage = intval($firstpage);
                $lastpage = intval($lastpage);
                if($firstpage <=0 || $lastpage <=0 || ($lastpage < $firstpage)){
                    throw new \InvalidArgumentException("Invalid page range {$page}, page is 0 or less, or range is switched");
                }
                if($firstpage == $lastpage){
                    $page = $firstpage;
                }
                $page = "{$firstpage}-{$lastpage}";
            }else{
                if(intval($page) <=0){
                    throw new \InvalidArgumentException("Invalid page {$page}, is 0 or less than 0");
                }
                $page = intval($page);
            }
            return $page;
        },explode(",",$pages));
        $this->pages = implode(',',$pages);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     * @return Element
     */
    public function setSize(int $size)
    {
        if($size <= 0){
            throw new \InvalidArgumentException("Invalid size, must be greater than 0");
        }
        $this->size = $size;
        return $this;
    }

    public function getTop(){
        preg_match($this->position_preg_match,$this->position,$output_array);
        return $output_array[2];
    }

    public function getLeft(){
        preg_match($this->position_preg_match,$this->position,$output_array);
        return $output_array[1];
    }

    public function setTop(float $top){
        $this->setPosition($this->getLeft()." ".$top);
        return $this;
    }

    public function setLeft(float $left){
        $this->setPosition($left." ".$this->getTop());
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Element
     */
    protected function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }

    public function __toArray(): array
    {
        return [
            'type' => $this->getType(),
            'position' => $this->getPosition(),
            'pages' => $this->getPages(),
            'size' => $this->getSize(),
            'content' => $this->getContent(),
            'info' => $this->getInfo()
        ];
    }
}