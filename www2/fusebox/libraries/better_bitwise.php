<?php

	class Better_bitwise {
		
		public function HasFlag( $Bitwise, $Flag, $CharAt = 0 ) {
			if( $Flag > 7 ) {
				return HasFlag( $Bitwise, $Flag - 8, $CharAt + 1 );
			}
			
			$Byte = ord( substr( $Bitwise, $CharAt, 1 ) ) + 1;
			
			if( !empty( $Byte ) ) {
				return ( $Byte & ( pow( 2, $Flag ) ) ) == pow( 2, $Flag );
			} else {
				return false;
			}
		}
		
		public function AddFlag( $CurBit, $Flag, $CharAt = 0 ) {
			$NumBytes = strlen( $CurBit );
			$Byte = substr( $Bitwise, $CharAt, 1 );
			
			echo $CurBit;
			echo "TotalLen: " . strlen( $CurBit ) . "<br />";
			echo "Len: " . strlen( $Byte ) . "<br />";
			echo "CharAt: " . $CharAt . "<br />";
			
			if( empty( $Byte ) ) {
				$CurBit = $CurBit . chr( 0x00 );
				$Byte = 0x00;
			}else{
				$Byte = ord( $Byte ) + 1;
			}
			
			if( $Flag > 7 ) {
				return AddFlag( $CurBit, $Flag - 8, $CharAt + 1 );
			}
			
			echo $Byte . " : " . pow( 2, $Flag ) . "<br />";
			
			$Front = substr( $CurBit, 0, $CharAt );
			$NewByte = chr( ($Byte | pow( 2, $Flag )) - 1 );
			$End = substr( $CurBit, $CharAt + 1, strlen( $CurBit ) - ($CharAt + 1) );
			
			echo (ord( $NewByte ) + 1) . "<br />";
			
			return ($Front . $NewByte . $End);
		}
		
	}

?>