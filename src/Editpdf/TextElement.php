<?php

namespace Ilovepdf\Editpdf;


class TextElement extends Element
{
    const TEXT_ALIGN_VALUES   = ['left', 'center', 'right'];
    const FONT_FAMILY_VALUES  = ['Arial', 'Arial Unicode MS', 'Verdana', 'Courier', 'Times New Roman', 'Comic Sans MS', 'WenQuanYi Zen Hei', 'Lohit Marathi'];
    
    /**
     * @var string
     */
    private $text = null;

    /**
     * @var string
     */
    private $text_align = "left";

    /**
     * @var string
     */
    private $font_family;

    /**
     * @var float
     */
    private $font_size;

    /**
     * @var string
     */
    private $font_color;

    /**
     * @var string
     */
    private $background_color;

    /**
     * @var float
     */
    private $letter_spacing;

    /**
     * @var float
     */
    private $line_height;

    /**
     * @var bool
     */
    private $is_bold = false;

    /**
     * @var bool
     */
    private $is_italic = false;

    /**
     * @var bool
     */
    private $is_underline;

    public function getText(){
      return $this->text;
    }

    public function setText(string $text){
      $this->text = $text;
      return $this;
    }

    public function getTextAlign(){
      return $this->text_align;
    }

    public function setTextAlign(string $textAlign){
      if(!in_array($textAlign, self::TEXT_ALIGN_VALUES)){
        throw new \InvalidArgumentException("Text align must be one of the following values: " . implode(',', self::TEXT_ALIGN_VALUES));
      }
      $this->text_align = $textAlign;
      return $this;
    }

    public function getFontFamily(){
      return $this->fontFamily;
    }

    public function setFontFamily(string $fontFamily){
      if(!in_array($fontFamily, self::FONT_FAMILY_VALUES)){
        throw new \InvalidArgumentException("Font family must be one of the following values: " . implode(',', self::FONT_FAMILY_VALUES));
      }
      $this->fontFamily = $fontFamily;
      return $this;
    }

    // public function getFontColor(){
    //   return $this->font_color;
    // }

    // public function setFontColor(string $fontColor){
    //   $isValid = (is_int($fontSize) && $fontSize > 0);
    //   if(!$isValid){
    //     throw new \InvalidArgumentException("Font color must be a hex value (e.g '#ABCDEF') or 'transparent'");
    //   }
    //   $this->font_color = $fontColor;
    //   return $this;
    // }

    public function setFontSize(float $fontSize){
      $isValid = (is_int($fontSize) && $fontSize > 0);
      if(!$isValid){
        throw new \InvalidArgumentException("Font size must be a float greather than 0");
      }
      $this->fontSize = $fontSize;
      return $this;
    }

    public function getFontSize(){
      return $this->fontSize;
    }

    public function setBold(){
      $this->is_bold = true;
      return $this;
    }

    public function unsetBold(){
      $this->is_bold = false;
      return $this;
    }

    public function isBold(){
      return $this->is_bold;
    }

    public function setItalic(){
      $this->is_italic = true;
      return $this;
    }

    public function unsetItalic(){
      $this->is_italic = false;
      return $this;
    }

    public function isItalic(){
      return $this->is_italic;
    }

    public function setUnderline(){
      $this->is_underline = true;
      return $this;
    }

    public function unsetUnderline(){
      $this->is_underline = false;
      return $this;
    }

    public function isUnderline(){
      return $this->is_underline;
    }

    private function computeFontStyle(){
      if($this->is_bold && $this->is_italic){
        return "Bold Italic";
      }else if($this->is_bold){
        return "Bold";
      }else if($this->is_italic){
        return "Italic"
      }
      
      return "Regular";
    }

    // public function validate(){
    //   $parentIsValid = parent::validate();
      
    //   if($this->coordinates === null) $this->addError('coordinates', 'required');
    //   if($this->pages === null) $this->addError('pages', 'required');

    //   return empty($this->errors);
    // }

    public function __toArray()
    {
      $data = array_merge(
        parent::__toArray(),
        [
          'font_style' => $this->computeFontStyle()
        ]
      );
      return $data;
    }

}