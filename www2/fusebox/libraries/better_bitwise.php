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
		
		public function RemoveFlag( $CurBit, $Flag, $CharAt = 0 ) {
			if( $this->HasFlag( $CurBit, $Flag ) == false ) return $CurBit;
			
			if( $Flag > 7 ) {
				return RemoveFlag( $CurBit, $Flag - 8, $CharAt + 1 );
			}
			
			$Byte = ord( substr( $CurBit, $CharAt, 1 ) ) + 1;
			
			$Front = substr( $CurBit, 0, $CharAt );
			$NewByte = chr( ($Byte & ~(pow( 2, $Flag ))) - 1 );
			$End = substr( $CurBit, $CharAt + 1, strlen( $CurBit ) - ($CharAt + 1) );
			
			return ($Front . $NewByte . $End);
		}
		
		public function AddFlag( $CurBit, $Flag, $CharAt = 0 ) {
			$NumBytes = strlen( $CurBit );
			$Byte = substr( $CurBit, $CharAt, 1 );
			
			if( strlen( $Byte ) == 0 ) {
				$Byte = 0;
				$CurBit .= chr( 0x00 );
			} else {
				$Byte = ord( $Byte ) + 1;
			}
			
			if( $Flag > 7 ) {
				return AddFlag( $CurBit, $Flag - 8, $CharAt + 1 );
			}
			
			$Front = substr( $CurBit, 0, $CharAt );
			$NewByte = chr( ($Byte | pow( 2, $Flag )) - 1 );
			$End = substr( $CurBit, $CharAt + 1, strlen( $CurBit ) - ($CharAt + 1) );
			
			return ($Front . $NewByte . $End);
		}
		
	}

?>