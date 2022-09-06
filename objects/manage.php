<?php
	 class Format{
		
		public static function getFormat($i){
			return sprintf('%02s',$i);
		}

		public static function getLengthFormat($i,$l){
			return sprintf('%0'.$l.'s',$i);
		}

		public static function getTextDate($date){
			$d = date_parse_from_format("Y-m-d", $date);
		    return self::getFormat($d["day"])."-".self::getFormat($d["month"])."-".$d["year"];
		}

		public static function getSystemDate($date){
			$d = date_parse_from_format("Y-m-d", $date);
		    return $d["year"]."-".self::getFormat($d["month"])."-".self::getFormat($d["day"]);
		}

		public static function randColor() {
    		return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
		}



		
	}

?>