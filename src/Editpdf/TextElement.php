<?php

namespace Ilovepdf\Editpdf;

use \Ilovepdf\Lib\Helper;


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
    private $text_align;

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
     * @var float
     */
    private $letter_spacing;

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

    public function setFontFamily(string $font_family){
      if(!in_array($font_family, self::FONT_FAMILY_VALUES)){
        throw new \InvalidArgumentException("Font family must be one of the following values: " . implode(',', self::FONT_FAMILY_VALUES));
      }
      $this->font_family = $font_family;
      return $this;
    }

    public function getFontColor(){
      return $this->font_color;
    }

    public function setFontColor(string $font_color){
      if(!Helper::isValidColor($font_color)){
        throw new \InvalidArgumentException("Font color must be a 6-character hex value (e.g '#ABCDEF') or 'transparent'");
      }
      $this->font_color = $font_color;
      return $this;
    }

    public function setFontSize(float $font_size){
      $isValid = (is_numeric($font_size) && $font_size > 0);
      if(!$isValid){
        throw new \InvalidArgumentException("Font size must be a float greater than 0");
      }
      $this->font_size = $font_size;
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
        return "Italic";
      }
      
      return "Regular";
    }

    public function getLetterSpacing(){
      return $this->letter_spacing;
    }

    public function setLetterSpacing(float $num){
      $isValid = (is_numeric($num) && $num >= -20);
      if(!$isValid){
        throw new \InvalidArgumentException("Letter spacing must be a number greater or equal to 0");
      }
      $this->letter_spacing = $num;
      return $this;
    }

    public function validate(){
      $parentIsValid = parent::validate();
      
      if($this->text === null) $this->addError('text', 'required');

      return empty($this->errors);
    }

    public function __toArray()
    {
      $data = array_merge(
        parent::__toArray(),
        [
          'text'              => $this->text,
          'text_align'        => $this->text_align,
          'font_family'       => $this->font_family,
          'font_size'         => $this->font_size,
          'font_style'        => $this->computeFontStyle(),
          'font_color'        => $this->font_color,
          'letter_spacing'    => $this->letter_spacing,
          'underline_text'    => $this->is_underline,
        ]
      );
      return $data;
    }

}