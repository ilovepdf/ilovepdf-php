<?php

namespace Ilovepdf;

/**
 * Class TranslateTask
 *
 * @package Ilovepdf
 */
class TranslateTask extends Task
{
    /**
     * @var string Output format of the translation. PDF tries to keeps the format as the original.
     */
    public $translate_mode = 'layout';

    /**
     * @var string[]
     */
    private $translateModeValues = ["layout", "text"];

    /**
     * @var null Language of the input document.
     */
    public $language_input = null;

    private $languageInputValues = [
        "eng", "afr", "amh", "ara", "asm", "aze", "aze_cyrl", "bel", "ben",
        "bod", "bos", "bre", "bul", "cat", "ceb", "ces", "chi_sim", "chi_tra",
        "chr", "cos", "cym", "dan", "deu", "deu_latf", "dzo", "ell", "enm",
        "epo", "equ", "est", "eus", "fao", "fas", "fil", "fin", "fra", "frm",
        "fry", "gla", "gle", "glg", "grc", "guj", "hat", "heb", "hin", "hrv",
        "hun", "hye", "iku", "ind", "isl", "ita", "ita_old", "jav", "jpn",
        "kan", "kat", "kat_old", "kaz", "khm", "kir", "kmr", "kor", "kor_vert",
        "lao", "lat", "lav", "lit", "ltz", "mal", "mar", "mkd", "mlt", "mon",
        "mri", "msa", "mya", "nep", "nld", "nor", "oci", "ori", "pan", "pol",
        "por", "pus", "que", "ron", "rus", "san", "sin", "slk", "slv", "snd",
        "spa", "spa_old", "sqi", "srp", "srp_latn", "sun", "swa", "swe", "syr",
        "tam", "tat", "tel", "tgk", "tgl", "tha", "tir", "ton", "tur", "uig",
        "ukr", "urd", "uzb", "uzb_cyrl", "vie", "yid", "yor"
    ];

    /**
     * @var null Language of the document to be translated to
     */
    public $language_output = null;

    private $languageOutputValues = [
        "eng", "afr", "amh", "ara", "asm", "aze", "aze_cyrl", "bel", "ben",
        "bod", "bos", "bre", "bul", "cat", "ceb", "ces", "chi_sim", "chi_tra",
        "chr", "cos", "cym", "dan", "deu", "deu_latf", "dzo", "ell", "enm",
        "epo", "equ", "est", "eus", "fao", "fas", "fil", "fin", "fra", "frm",
        "fry", "gla", "gle", "glg", "grc", "guj", "hat", "heb", "hin", "hrv",
        "hun", "hye", "iku", "ind", "isl", "ita", "ita_old", "jav", "jpn",
        "kan", "kat", "kat_old", "kaz", "khm", "kir", "kmr", "kor", "kor_vert",
        "lao", "lat", "lav", "lit", "ltz", "mal", "mar", "mkd", "mlt", "mon",
        "mri", "msa", "mya", "nep", "nld", "nor", "oci", "ori", "pan", "pol",
        "por", "pus", "que", "ron", "rus", "san", "sin", "slk", "slv", "snd",
        "spa", "spa_old", "sqi", "srp", "srp_latn", "sun", "swa", "swe", "syr",
        "tam", "tat", "tel", "tgk", "tgl", "tha", "tir", "ton", "tur", "uig",
        "ukr", "urd", "uzb", "uzb_cyrl", "vie", "yid", "yor"
    ];


    /**
     * CompressTask constructor.
     *
     * @param null|string $publicKey Your public key
     * @param null|string $secretKey Your secret key
     * @param null|string $region API region
     */
    function __construct($publicKey, $secretKey, ?string $region = null, bool $makeStart = true)
    {
        $this->tool = 'translate';
        parent::__construct($publicKey, $secretKey, $region, $makeStart);
    }

    /**
     * @param string $format
     *
     *  values: ["pdf", "txt"]
     *  default: "pdf"
     *
     * @return $this
     */
    public function setTranslateMode(string $mode): self
    {
        $this->checkValues($mode, $this->translateModeValues);
        $this->translate_mode = $mode;
        return $this;
    }

    /**
     * @param string $language
     *
     *  values: ["eng", "afr", "amh", "ara", "asm", "aze", "aze_cyrl", "bel", "ben",
     * "bod", "bos", "bre", "bul", "cat", "ceb", "ces", "chi_sim", "chi_tra",
     * "chr", "cos", "cym", "dan", "deu", "deu_latf", "dzo", "ell", "enm",
     * "epo", "equ", "est", "eus", "fao", "fas", "fil", "fin", "fra", "frm",
     * "fry", "gla", "gle", "glg", "grc", "guj", "hat", "heb", "hin", "hrv",
     * "hun", "hye", "iku", "ind", "isl", "ita", "ita_old", "jav", "jpn",
     * "kan", "kat", "kat_old", "kaz", "khm", "kir", "kmr", "kor", "kor_vert",
     * "lao", "lat", "lav", "lit", "ltz", "mal", "mar", "mkd", "mlt", "mon",
     * "mri", "msa", "mya", "nep", "nld", "nor", "oci", "ori", "pan", "pol",
     * "por", "pus", "que", "ron", "rus", "san", "sin", "slk", "slv", "snd",
     * "spa", "spa_old", "sqi", "srp", "srp_latn", "sun", "swa", "swe", "syr",
     * "tam", "tat", "tel", "tgk", "tgl", "tha", "tir", "ton", "tur", "uig",
     * "ukr", "urd", "uzb", "uzb_cyrl", "vie", "yid", "yor"]
     *  default: null
     *
     * @return $this
     */
    function setInputLanguage(string $language): self
    {
        $this->checkValues($language, $this->languageInputValues);
        $this->language_input = $language;
        return $this;
    }

    function setLanguageInput(string $language): self
    {
        return $this->setInputLanguage($language);
    }

    /**
     * @param string $language
     *
     *  values: ["eng", "afr", "amh", "ara", "asm", "aze", "aze_cyrl", "bel", "ben",
     * "bod", "bos", "bre", "bul", "cat", "ceb", "ces", "chi_sim", "chi_tra",
     * "chr", "cos", "cym", "dan", "deu", "deu_latf", "dzo", "ell", "enm",
     * "epo", "equ", "est", "eus", "fao", "fas", "fil", "fin", "fra", "frm",
     * "fry", "gla", "gle", "glg", "grc", "guj", "hat", "heb", "hin", "hrv",
     * "hun", "hye", "iku", "ind", "isl", "ita", "ita_old", "jav", "jpn",
     * "kan", "kat", "kat_old", "kaz", "khm", "kir", "kmr", "kor", "kor_vert",
     * "lao", "lat", "lav", "lit", "ltz", "mal", "mar", "mkd", "mlt", "mon",
     * "mri", "msa", "mya", "nep", "nld", "nor", "oci", "ori", "pan", "pol",
     * "por", "pus", "que", "ron", "rus", "san", "sin", "slk", "slv", "snd",
     * "spa", "spa_old", "sqi", "srp", "srp_latn", "sun", "swa", "swe", "syr",
     * "tam", "tat", "tel", "tgk", "tgl", "tha", "tir", "ton", "tur", "uig",
     * "ukr", "urd", "uzb", "uzb_cyrl", "vie", "yid", "yor"]
     *  default: null
     *
     * @return $this
     */
    function setOutputLanguage(string $language): self
    {
        $this->checkValues($language, $this->languageOutputValues);
        $this->language_output = $language;
        return $this;
    }

    function setLanguageOutput(string $language): self
    {
        return $this->setOutputLanguage($language);
    }

}
