<?php

class palindrome{
	// Показать Подробнее
	public function getMorePalindrome($str){
		$sentence = mb_strtolower($str); // Приведение строки к нижнему регистру
		$sentence = str_replace(' ', '', $sentence); // убираем пробелы

		return 'Строка "'.$str.'" ('.'без пробелов '.$sentence.' - перевернутая - '.$this->str_rev($sentence).') выходит "'.$this->getPalindrome($str).'" <hr>';
	}


	// Получить полиндром
	public	function getPalindrome($str) {	
		$sentence = mb_strtolower($str);
		$sentence = str_replace(' ', '', $sentence);

		// если строка пуста
		if(!mb_strlen($sentence)){
			return '';
		}

		$revSentence = $this->str_rev($sentence);

		// Если строка идентична
		if($sentence == $revSentence){
			return $str;
		}

		$arrP = $this->searchAllP($sentence, $revSentence);

		for($i=0, $palindrome='', $l=0; $i<count($arrP); $i++){
			$strLength = iconv_strlen($arrP[$i], 'UTF-8');
			if($l<$strLength){
				$l = $strLength;
				$palindrome = $arrP[$i];
			}			
		}
		
		return $palindrome;
	}

	// Делает инвертирование строки
	public	function str_rev($str){
	    $str = iconv('utf-8', 'windows-1251', $str); //Преобразовываем кодировку строки на входе
	    $str = strrev($str); // переворачиваем строку
	    $str = iconv('windows-1251', 'utf-8', $str); //Преобразовываем кодировку строки на выходе
	    return $str; //возврат строки
	}

	// Поиск всех полиндромов
	protected function searchAllP($str, $rev){
		$arrP = array();
		$words = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);	

		for($i=0; $i<count($words); $i++){
			$reg = preg_quote($words[$i]);
			$arrP[] = $this->searchLengthP($reg, $rev, $i, $words);								
		}

		return $arrP;		
	}

	// Поиск Конкретного полиндрома
	protected function searchLengthP(&$reg, &$rev, $i, &$words, $sw = ''){
		if(preg_match('#'.$reg.'#u', $rev, $m)){
			$sw = $m[0];

			if($i+1<count($words)){
				$i++;
				$reg .= preg_quote($words[$i]);

				return $this->searchLengthP($reg, $rev, $i, $words, $sw);
			}
		}

		return $sw;
	}
}


$palindrome = new palindrome();
echo $palindrome->getMorePalindrome("Манархия — их рана");
echo $palindrome->getMorePalindrome("Не палиндром");
echo $palindrome->getMorePalindrome("Аргентина манит негра");
echo $palindrome->getMorePalindrome("Sum summus mus");
?>