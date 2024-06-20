<?php

namespace Ilovepdf;
/**
 * Class PdfjpgTask
 *
 * @package Ilovepdf
 */
class PdfocrTask extends Task
{
    /**
     * @var string[] OCR languages
     */
    public $ocr_languages = ['eng'];

    /**
     * @var string[]
     */
    private $ocrLanguageValues = ['eng','afr','amh','ara','asm','aze','aze_cyrl','bel','ben','bod','bos','bre','bul','cat','ceb','ces','chi_sim','chi_tra','chr','cos','cym','dan','deu','deu_latf','dzo','ell','enm','epo','equ','est','eus','fao','fas','fil','fin','fra','frm','fry','gla','gle','glg','grc','guj','hat','heb','hin','hrv','hun','hye','iku','ind','isl','ita','ita_old','jav','jpn','kan','kat','kat_old','kaz','khm','kir','kmr','kor','kor_vert','lao','lat','lav','lit','ltz','mal','mar','mkd','mlt','mon','mri','msa','mya','nep','nld','nor','oci','ori','pan','pol','por','pus','que','ron','rus','san','sin','slk','slv','snd','spa','spa_old','sqi','srp','srp_latn','sun','swa','swe','syr','tam','tat','tel','tgk','tgl','tha','tir','ton','tur','uig','ukr','urd','uzb','uzb_cyrl','vie','yid','yor'];

    /**
     * PdfjpgTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     */
    function __construct(?string $publicKey, ?string $secretKey, bool $makeStart = false)
    {
        $this->tool = 'pdfocr';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }

    /**
     * Add a language to ocr
     *
     * @param string $lang values:['eng','afr','amh','ara','asm','aze','aze_cyrl','bel','ben','bod','bos','bre','bul','cat','ceb','ces','chi_sim','chi_tra','chr','cos','cym','dan','deu','deu_latf','dzo','ell','enm','epo','equ','est','eus','fao','fas','fil','fin','fra','frm','fry','gla','gle','glg','grc','guj','hat','heb','hin','hrv','hun','hye','iku','ind','isl','ita','ita_old','jav','jpn','kan','kat','kat_old','kaz','khm','kir','kmr','kor','kor_vert','lao','lat','lav','lit','ltz','mal','mar','mkd','mlt','mon','mri','msa','mya','nep','nld','nor','oci','ori','pan','pol','por','pus','que','ron','rus','san','sin','slk','slv','snd','spa','spa_old','sqi','srp','srp_latn','sun','swa','swe','syr','tam','tat','tel','tgk','tgl','tha','tir','ton','tur','uig','ukr','urd','uzb','uzb_cyrl','vie','yid','yor'] default: "pages"
     * @return $this
     */
    public function addLanguage($lang): self
    {
        if($lang == null || ! in_array($lang, $this->ocrLanguageValues)){
            throw new \InvalidArgumentException();
        }
        if(!in_array($lang, $this->ocr_languages)){
            $this->ocr_languages[] = $lang;
        }

        return $this;
    }



    /**
     * Add a language to ocr
     *
     * @param string[] $langs values:['eng','afr','amh','ara','asm','aze','aze_cyrl','bel','ben','bod','bos','bre','bul','cat','ceb','ces','chi_sim','chi_tra','chr','cos','cym','dan','deu','deu_latf','dzo','ell','enm','epo','equ','est','eus','fao','fas','fil','fin','fra','frm','fry','gla','gle','glg','grc','guj','hat','heb','hin','hrv','hun','hye','iku','ind','isl','ita','ita_old','jav','jpn','kan','kat','kat_old','kaz','khm','kir','kmr','kor','kor_vert','lao','lat','lav','lit','ltz','mal','mar','mkd','mlt','mon','mri','msa','mya','nep','nld','nor','oci','ori','pan','pol','por','pus','que','ron','rus','san','sin','slk','slv','snd','spa','spa_old','sqi','srp','srp_latn','sun','swa','swe','syr','tam','tat','tel','tgk','tgl','tha','tir','ton','tur','uig','ukr','urd','uzb','uzb_cyrl','vie','yid','yor'] default: "pages"
     * @return $this
     */
    public function setLanguages($langs): self
    {
        if($langs == null || ! is_array($langs)){
            throw new \InvalidArgumentException();
        }
        foreach($langs as $lang){
            if(!in_array($lang, $this->ocrLanguageValues)){
                throw new \InvalidArgumentException();
            }
        }
        $this->ocr_languages = $langs;

        return $this;
    }
}
