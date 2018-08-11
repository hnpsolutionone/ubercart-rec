<?php
/**
 * This class compares two strings and outputs the similarities  as percentage
 *
 * @author Phuong Nguyen
 */
class StringCompare
{
	private $_str1 = '';
	private $_str2 = '';
	private $_words1 = array();
	private $_words2 = array();
	private $_percent = null;

	// remove extra spaces, tabs and new lines
	private $_remove_extra_spaces = true;

	// remove html tags
	private $_remove_html_tags = true;

	// remove punctuation symbols
	private $_remove_punctuation = true;

	// punctuation symbols
	private $_punctuation_symbols = array('.', ',', '/', '-', '$', '*', ':', ';', '!', '?', '|', '\\', '_', '<', '>', '#', '~', '"', '\'', '^', '(', ')', '=', '+');


	/**
	 *Contructor function
	 *
	 *@param string $str1
	 *@param string $str2
	 *@return string
	 */
	public function __construct($str1, $str2, $params = array())
	{
		if (!empty($params['remove_html_tags'])) {
			$this->_remove_html_tags = $params['remove_html_tags'];
		}

		if (!empty($params['remove_extra_spaces'])) {
			$this->_remove_extra_spaces = $params['remove_html_tags'];
		}

		if (!empty($params['remove_punctuation'])) {
			$this->_remove_punctuation = $params['remove_punctuation'];
		}

		if (!empty($params['punctuation_symbols'])) {
			$this->_punctuation_symbols = $params['punctuation_symbols'];
		}



		if ($this->_remove_html_tags) {
			$str1 = strip_tags($str1);
			$str2 = strip_tags($str2);
		}


		if ($this->_remove_punctuation && count($this->_punctuation_symbols)) {
			$str1 = str_replace($this->_punctuation_symbols, '', $str1);
			$str2 = str_replace($this->_punctuation_symbols, '', $str2);
		}

		if ($this->_remove_extra_spaces) {
			$str1 = preg_replace('#\s+#u', ' ', $str1);
			$str2 = preg_replace('#\s+#u', ' ', $str2);
		}

		$this->_str1 = $str1 = trim($str1);
		$this->_str2 = $str2 = trim($str2);
	}

    /**
     * Levenshtein algorithm to compare two strings and return the similarity in percentage
     *
     *@access public
     *@return object
     */
    function customLevenshtein($s1,$s2) {
        $n = strlen($s1);
        $m = strlen($s2);
        if($n == 0) return $m;
        if($m == 0) return $n;
        for($i=0;$i<=$n;$i++) $d[$i][0] = $i;
        for($j=0;$j<=$m;$j++) $d[0][$j] = $j;

        for($i=1;$i<=$n;$i++) {
            for($j=1;$j<=$m;$j++) {
                $cost = ($s1[$i-1] == $s2[$j-1]) ? 0 : 1;
                $d[$i][$j] = min($d[$i-1][$j]+1,$d[$i][$j-1]+1,$d[$i-1][$j-1]+$cost);
            }
        }
        $length = $n > $m ? $n : $m;
        $this->_percent = (1 - $d[$n][$m]/$length) * 100;
        return $this;
    }

	/**
	 *Function to compare two strings and return the similarity in percentage
	 *
	 *@access public
	 *@return object
	 */
	public function process()
	{
		if (!is_null($this->_percent)) {
			return false;
		}

		$str1 = $this->_str1;
		$str2 = $this->_str2;

		if ($str1 == '') {
			trigger_error('First string can not be blank', E_USER_ERROR);
			return false;
		} else if ($str2 == '') {
			trigger_error('Second string can not be blank', E_USER_ERROR);
			return false;
		}

		$this->customLevenshtein($str1, $str2);
	}


	/**
	 *Function to compare two strings and return the similarity in percentage
	 *
	 *@access public
	 *@return float
	 */
	public function getSimilarityPercentage()
	{
		$this->process();
		return $this->_percent;
	}


	/**
	 *Function to compare two strings and return the difference in percentage
	 *
	 *@access public
	 *@return float
	 */
	public function getDifferencePercentage()
	{
		$this->process();
		return 100 - $this->_percent;
	}
}
