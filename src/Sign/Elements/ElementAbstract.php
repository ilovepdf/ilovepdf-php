<?php

namespace Ilovepdf\Sign\Elements;
use Ilovepdf\File;


abstract class ElementAbstract
{
    const VALID_X_GRAVITY_POSITIONS = ['left','center','right'];
    const VALID_Y_GRAVITY_POSITIONS = ['top','middle','bottom'];
    /**
     * @var string
     */
    public $type;

    /**
     * @var array
     */
    public $position = ['x' => null, 'y' => null];

    /**
     * @var int
     */
    public $horizontal_adjustment = 0;

    /**
     * @var int
     */
    public $vertical_adjustment = 0;

    /**
     * @var string
     */
    public $pages;

    /**
     * @var integer
     */
    public $size = 18;

    /**
     * @var
     */
    public $content;
    
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
     * @return ElementAbstract
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
     * @param string $positionX
     * @param string $positionY
     * @param int $horizontal_adjustment
     * @param int $vertical_adjustment
     * @return ElementAbstract
     */
    public function setGravityPosition(string $positionX, string $positionY, int $horizontal_adjustment = 0, int $vertical_adjustment = 0)
    {
        if(!in_array($positionX,self::VALID_X_GRAVITY_POSITIONS)){
            throw new \InvalidArgumentException("Invalid X value, valid positions are: ".implode(", ",self::VALID_X_GRAVITY_POSITIONS));
        }
        
        if(!in_array($positionY,self::VALID_Y_GRAVITY_POSITIONS)){
            throw new \InvalidArgumentException("Invalid Y value, valid positions are: ".implode(", ",self::VALID_Y_GRAVITY_POSITIONS));
        }
        $this->position = ['x' => $positionX, 'y' => $positionY];
        $this->horizontal_adjustment = $horizontal_adjustment;
        $this->vertical_adjustment = $vertical_adjustment;
        return $this;
    }

    /**
     * @return int
     */
    public function getVerticalAdjustment()
    {
        return $this->vertical_adjustment;
    }

    /**
     * @return int
     */
    public function getHorizontalAdjustment()
    {
        return $this->horizontal_adjustment;
    }

    /**
     * @param string $position
     * @return ElementAbstract
     */
    public function setPosition(float $x, float $y)
    {   
        if($y > 0){
            throw new \InvalidArgumentException("Invalid Y value: it must be a number lower or equal to 0");
        }
        
        if($x < 0){
            throw new \InvalidArgumentException("Invalid X value: it must be a number greater or equal to 0");
        }

        $this->position = ['x' => $x, 'y' => $y];
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
     * @return ElementAbstract
     */
    public function setPages($pages)
    {
         $pages = array_map(function($page){
            if(strpos($page,'-')){
                list($firstpage,$lastpage) = explode("-",$page);
                $firstpage = intval($firstpage);
                $lastpage = intval($lastpage);
                if($firstpage <=0 || $lastpage <=0 || ($lastpage < $firstpage)){
                    throw new \InvalidArgumentException("Invalid page range '{$page}'");
                }

                $page = ($firstpage == $lastpage) ? $firstpage : "{$firstpage}-{$lastpage}";
            }else{
                if(intval($page) <=0){
                    throw new \InvalidArgumentException("Invalid page '{$page}': it should be a value greater than 0");
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
     * @return ElementAbstract
     */
    public function setSize(int $size)
    {
        if($size <= 0){
            throw new \InvalidArgumentException("Invalid size: must be a number greater than 0");
        }
        $this->size = $size;
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
     * @return ElementAbstract
     */
    protected function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }

    public function __toArray(): array
    {
        $pos = $this->getPosition();
        $pos = trim($pos['x'] . ' ' . $pos['y']);
        return [
            'type' => $this->getType(),
            'position' => $pos,
            'horizontal_position_adjustment' => $this->getHorizontalAdjustment(),
            'vertical_position_adjustment' => $this->getVerticalAdjustment(),
            'pages' => $this->getPages(),
            'size' => $this->getSize(),
            'content' => $this->getContent(),
            'info' => $this->getInfo()
        ];
    }
}