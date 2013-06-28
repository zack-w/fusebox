<?php

	class Better_bitwise {
		
		public function HasFlag( $Bitwise, $Flag, $CharAt = 0 ) {
			if( $Flag > 7 ) {
				return HasFlag( $Bitwise, $Flag - 8, $CharAt + 1 );
			}
			
			$Byte = ord( substr( $Bitwise, $CharAt, 1 ) );
			
			if( !empty( $Byte ) ) {
				return ( $Byte & ( pow( 2, $Flag ) ) ) == pow( 2, $Flag );
			} else {
				return false;
			}
		}
		
		public function AddFlag( $CurBit, $Flag, $CharAt = 0 ) {
			$NumBytes = strlen( $CurBit );
			$Byte = ord( substr( $Bitwise, $CharAt, 1 ) );
			
			if( empty( $Byte ) ) {
				$CurBit = $CurBit . chr( 0x00 );
				$Byte = 0x00;
			}
			
			if( $Flag > 7 ) {
				return AddFlag( $CurBit, $Flag - 8, $CharAt + 1 );
			}
			
			$Front = substr( $CurBit, 0, $CharAt );
			$NewByte = chr( $Byte | pow( 2, $Flag ) );
			$End = substr( $CurBit, $CharAt + 1, strlen( $CurBit ) - ($CharAt + 1) );
			
			return ($Front . $NewByte . $End);
		}
		
	}

?>