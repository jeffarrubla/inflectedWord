<?php
/**
* Inflected Word
*
* Copyright (c) 2018 Jefferson Arrubla H
* 
* @copyright Copyright 2018 (c) Jefferson Arrubla H
* @link https://github.com/jeffarrubla/inflectedWord
* @version 0.1
*/
include 'finediff.php'; // used to find differences between 2 words (https://github.com/gorhill/PHP-FineDiff)

class inflectedWord{	
	
	private $vowels =  array(
					0 => array('a','e','i','o','u') , // Latin
					1 => array('а','и','о','у','ы','э','е','ё','ю','я') // Cyrillic
				);
	private $consonants = array(
	 				0 =>array('b','c','d','f','g','h','j','k','l','m','n','p','q','r','s','t','v','w','x','y','z'),// Latin
	 				1 =>array('б','в','г','д','ж','з','й','к','л','м','н','п','р','с','т','ф','х','ц','ч','ш','щ')// Cyrillic
				);	 
		
	/**	 
	 * 
	 * checks if a inflected word is regular, it has changes or it's irregular.
	 * 
	 * @param string $stem 	  Stem word.
	 * @param string $ending  Ending word.
	 * @param string $word    Inflected word.
	 * @return string $result the inflected word marked with tags, in lowercase.
	 * 
	 */
	public function check($stem='',$ending='',$word='')
    {
    	
    	$result = ''; // store the result of the check
    	$deleted_char = 0; // to count deleted characters in Inflected Word
    	$changed_char = 0; // to count changed characters in Inflected Word
    	$count_ending = strlen($ending); // get the lenght of the ending
    	$word_ending = substr($word, -$count_ending); // get the ending of the  Inflected word accouding to the lenght of ending given.
    	$is_inserted_one_char = true; // to match the case (Appears a letter)
    	
    	if( $ending != $word_ending && $ending != '' ){ // ending not empty and different from inflected word? then it's irregular.
    		$result = '<irreg>'.$word.'</irreg>';
    	}elseif($stem.$ending == $word ){ // is Regular Inflected Word?
    		// assign the inflected word marked
    		$result = $stem.'<reg>'.$ending.'</reg>';
    	}else{ // is Inflected Word with Changes or irregular?
    		
    		// ensure input is suitable for diff
    		/*$from_text = mb_convert_encoding($stem.$ending, 'HTML-ENTITIES', 'UTF-8');
			$to_text = mb_convert_encoding($word, 'HTML-ENTITIES', 'UTF-8');*/
			
			$from_text = $stem.$ending;
			$to_text = $word;
			/*$opcodes = FineDiff::getDiffOpcodes($stem.$ending, $word );
			// get the differences			
			$temp = FineDiff::renderDiffToHTMLFromOpcodes($stem.$ending, $opcodes); */
		
			// compare the stem+ending with the inflected word
			$opcodes = FineDiff::getDiffOpcodes($from_text, $to_text );
			// get the differences			
			$temp = FineDiff::renderDiffToHTMLFromOpcodes($from_text, $opcodes); 
			// get deleted characters
			preg_match("/<del>.+?<\/del>/i", $temp, $deleted_char);
			// get replaced characters
			preg_match("/<del>.+?<\/del><ins>.+?<\/ins>/i", $temp, $changed_char);						
			// has inserted characters?
			if(count( $changed_char) == 0){
				// get inserted characters
				preg_match("/<ins>.+?<\/ins>/i", $temp, $inserted_char);
				if(count($inserted_char)==1){
					$inserted_char[0] =  strip_tags($inserted_char[0]);
					if(strlen($inserted_char[0])>1 ){
						$is_inserted_one_char = false;
					}
				}
			}
			// are there more than 1 deleted or 1 changed character? it's irregular
			if(count($deleted_char)>1 || count($changed_char)>1 || !$is_inserted_one_char){				
				$result = '<irreg>'.$word.'</irreg>';
			}else{			
				// check if the changed character(s), match the rules for Inflected Word with Changes			
				if( count($changed_char) == 1){
					// to know if it has changed a vowel to vowel(s)
					$is_vowel_case = false;
					// to know if it has changed a consonant to consonant
					$is_consonant_case = false;

					preg_match("/<del>.+?<\/del>/i", $temp, $del_char);
					$del_char[0] = strip_tags($del_char[0]);

					preg_match("/<ins>.+?<\/ins>/i", $temp, $cha);
					$cha[0] = strip_tags($cha[0]);

					// changed a vowel(s)?
					// iterate through both alphabets
					for ($j=0; $j < 1 ; $j++) {				
						if(in_array($del_char[$j], $this->vowels[$j])){							
							$is_vowel_case = false;
							// to get each letter changed
							$letters = str_split($cha[0]);
							// has it changed to 1 or 2 vowels? it's still on the rule
							if(count($letters)<=2){
								// check if the vowels match to the alphabeth
								for ($i=0; $i < count($letters); $i++) { 
									if(in_array($letters[$i], $this->vowels[$j]))
										$is_vowel_case = true;
									else
										$is_vowel_case = false;
								}
							}
							// is a vowel changed to vowel(s)?
							if($is_vowel_case){
								$result = $this->format_result($temp,$count_ending,$ending);
								break;  // case found break the loop
							}
						}
					}
					// changed a consonant?
					if(!$is_vowel_case){
						// iterate through both alphabets
						for ($j=0; $j < 1 ; $j++) {	
							$is_consonant_case = false;
							// is a consonant?
							if(in_array($del_char[$j], $this->consonants[$j])){
								// has it changed to a consonant?
								if(in_array($cha[$j], $this->consonants[$j])){
									$is_consonant_case = true;
									break;
								}
							}
						}
					}
					// has consonant changed a consonant?
					if($is_consonant_case){						
						$result = $this->format_result($temp,$count_ending,$ending);
					}else if(!$is_vowel_case){ // not vowel or consonant case, it' irregular
						$result = '<irreg>'.$word.'</irreg>';
					}
				}else if(count( $deleted_char) == 1){ // deleted a character (Disappears a letter)
					// remove the <del> tags and it content to show					
					$temp = preg_replace("/<del>.+?<\/del>/i", '', $temp);
					// formating the ending
					$result = substr($temp, 0, -$count_ending).'<reg>'.$ending.'</reg>' ;
				}elseif(count( $changed_char) == 0){ // check if it has added a character (Appears a letter)
					$result = $this->format_result($temp,$count_ending,$ending);
				}else{
					$result = '<irreg>'.$word.'</irreg>';	
				}
			}
    	}

    	return htmlspecialchars( $result) ;
    }

    /**	 
	 * 
	 * format a string to change the tags <del> and  <ins>, for the requeted one <change>
	 * besides format the HTML entities to manage them as 1 character
	 * 
	 * @param string  $temp 	  	 word with the not desired tags.
	 * @param integer $count_ending  count letters of the ending.
	 * @param string  $ending        Ending word.	 
	 * @return string $result        the formatted string with the desired tags
	 * 
	 */
    private function format_result($temp='', $count_ending=0, $ending=''){
    	// remove the deleted character
    	$temp = preg_replace("/<del>.+?<\/del>/i", '', $temp);
		// change the </ins> tag to </change>
		$temp = preg_replace("/<\/ins>/i", '</change>', $temp);
		// change the <ins> tag to <change>
		$temp = preg_replace("/<ins>/i", '<change>', $temp);
		// formating the ending
		$temp = preg_replace("/&/i", '', $temp); // for the HTML entities (hack to manage the HTML entities as 1 character, this is not the best way)
		$temp = preg_replace("/cute;/i", '', $temp);  // for the HTML entities (hack to manage the HTML entities as 1 character, this is not the best way)
		return substr($temp, 0, -$count_ending).'<reg>'.$ending.'</reg>' ;		
    }

}
