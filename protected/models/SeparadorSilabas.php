<?php

class SeparadorSilabas
{
	//$MAX_SILABAS = 20;
	//define("MAX_SILABAS", 20);
	public $lonPal;		      // Longitud de la palabra
	public $numSil;           // Número de silabas de la palabra
	public $tonica;           // Posición de la silaba tónica (empieza en 1)
	public $encTonica;       // Indica si se ha encontrado la silaba tónica
	public $letraTildada;     // Posición de la letra tildda, si la hay 
	public $posiciones; // Posiciones de inicio de las silabas
	public $ultPal = " ";        // Última palabra tratada, se guarda para
						  // no repetir el proceso si se pide la misma

	// En la mayoría de las lenguas, las palabras pueden dividirse en sílabas
	// que constan de un núcleo silábico, un ataque que antecede al núcleo
	// silábico y una coda que sigue al núcleo silábico
	// (http://es.wikipedia.org/wiki/Sílaba)   


	/// <summary>
	/// Constructor
	/// </summary>
	function __construct()
	{
		$this->ultPal = ""; 
		$this->posiciones = array();
	}

	/// <summary>
	/// Devuelve un array con las posiciones de inicio de las sílabas de palabra
	/// </summary>
	/// <param name="palabra"></param>
	/// <returns></returns>
	public function PosicionSilabas ($palabra)
	{
		$this->Calcular ($palabra);
		return $this->posiciones;
	}

	/// <summary>
	/// Devuelve el número de silabas de palabra
	/// </summary>
	/// <param name="palabra"></param>
	/// <returns></returns>
	public function NumeroSilabas ($palabra)
	{
		$this->Calcular ($palabra);
		return $this->numSil;
	}

	/// <summary>
	/// Devuelve la posición de la sílaba tónica de palabra
	/// </summary>
	/// <param name="palabra"></param>
	/// <returns></returns>
	public function SilabaTonica ($palabra)
	{
		$this->Calcular ($palabra);
		return $this->tonica;
	}
	/// <summary>
	/// Determina si una palabra está correctamente tildada
	/// </summary>
	/// <param name="silabeo"></param>
	/// <param name="palabra"></param>
	/// <returns>
	/// 0 - bien tildada
	/// 7 - varias tildes en la palabra
	/// 8 - aguda mal tildada
	/// 9 - llana mal tildada
	/// </returns>
	public function BienTildada($silabeo, $palabra)
	{
		$numSilabas = (int)$silabeo[0];

		// Comprueba si hay má de una tilde en la palabra
		$arrPalabra = str_split(strtolower(palabra));
		foreach($arrPalabra as $letra){
			if($this->TieneTilde($letra)>1){
				return 7;
			}
		}
		//if (strtolower(palabra).Count<char>(TieneTilde) > 1) return 7;
		$posTonica =  (int)$silabeo[$numSilabas + 1];

		if ($numSilabas - $posTonica < 2) // Si la palabra no es esdrújula
		{
			$ultCar = $arrPalabra[count($arrPalabra)-1];
			$final = ($posTonica < $numSilabas ? (int) $silabeo[$posTonica + 1]: count($arrPalabra)) - (int) $silabeo[$posTonica] ;
			//$silaba = palabra.Substring((int)silabeo[posTonica], final).ToLower();
			$silaba = substr($palabra, (int)$silabeo[$posTonica], $final);
			
			$i;

			// Se busca si hay tilde en la sílaba tónica
			$arrSilaba = str_split($silaba);
			for ($i= 0; $i < count($arrSilaba); $i++)
			{
				//if ("áéíóú".IndexOf($arrSilaba[i]) > -1)
				if(strrpos("áéíóú", $arrSilaba[i]) > -1)
					break;
			}

			if (i < count($arrSilaba)) // Hay tilde en la sílaba tónica
			{
				// La palabra es aguda y no termina en n, s, vocal -> error
				if (($posTonica == $numSilabas) && (strrpos("nsáéíióúu",$ultCar) == -1))
					return 8;

				// La palabra es llana y termina en n, s, vocal -> error
				if (($posTonica == $numSilabas - 1) && (strrpos("nsaeiou", $ultCar) != -1))
					return 9;
			}
		}

		return 0; // La palabra está correctamente tildada
	}

	public function ReemplazaTilde($silaba1){
		$retorno='';
		if(strlen($silaba1) > 4)
		{
			$retorno = $silaba1;
		}
		else if(strlen($silaba1) == 4){
			//si la ultima silaba tiene 4 caracteres, significa que hay un hiato y se debe de reemplazar por la tilde
			//comparo que clase de hiato
			/*$replace = array('i', 'u'); 
			$change = array('_','_');
			$retorno = str_replace($replace,$change,$silaba1); */
			$replace;
			$change;
			//si la ultima silaba tiene 4 caracteres, significa que hay un hiato y se debe de reemplazar por la tilde
			//comparo que clase de hiato
			//busco la silaba ui, ya que no es ningun hiato y debe tildarse en la i
			$pos = strpos($silaba1, 'ui');
			/*if($pos === false){
				$replace = array('i', 'u'); 
				$change = array('_','_');
			}
			else{
				$replace = array('i'); 
				$change = array('_');
			}*/

			if($pos === false){
				//verifico si el hiato tiene la composicion ua, ya que a veces se tilda mal y por lo tanto se deben de sustituir las 2 vocales
				$pos1 = strpos($silaba1, 'ua');
				if($pos1 === false){
					$replace = array('i', 'u'); 
					$change = array('_','_');
				}
				else{
					$replace = array('a', 'u'); 
					$change = array('_','_');
				}
			}
			else{
				$replace = array('i'); 
				$change = array('_');
			}
			$retorno = str_replace($replace,$change,$silaba1); 
		}
		if(strlen($silaba1) == 3){
			//echo substr($silaba1,-2);
			/*$replace = array('i', 'u'); 
			$change = array('_','_');
			$retorno = str_replace($replace,$change,$silaba1); */
			
			//verifico la terminacion
			if(substr($silaba1, -1) == 'a' || substr($silaba1, -1) == 'e' || substr($silaba1, -1) == 'o' ){
				//es un hiato
				$replace = array('i', 'u'); 
				$change = array('_','_');
				$retorno = str_replace($replace,$change,$silaba1); 
			}
			else{
				$replace = array('a','e','i','o','u'); 
				$change = array('_','_', '_', '_', '_');
				$retorno = str_replace($replace,$change,$silaba1); 
			}
		}
		if(strlen($silaba1) == 2 || strlen($silaba1) == 1){
			//echo substr($silaba1,-1);
			$replace = array('a','e','i','o','u'); 
			$change = array('_','_', '_', '_', '_');
			$retorno = str_replace($replace,$change,$silaba1); 
		}
		
		return $retorno;
	}
	
	public function obtenerSilabas($arrPosicion, $spalabra){
		$resultado = array();
		for($i=0; $i<count($arrPosicion); $i++){
			if($i< count($arrPosicion) -1){
				//calculo la diferencia
				$dif = $arrPosicion[$i+1] - $arrPosicion[$i];
				$resultado[] = substr($spalabra, $arrPosicion[$i], $dif);
			}
			else{
				$resultado[] = substr($spalabra, $arrPosicion[$i]);
			}
		}
		return $resultado;
	}
	
	public function dividePalabra($spalabra){
		$arrposicion = $this->PosicionSilabas($spalabra);
		$arrSilabas = $this->obtenerSilabas($arrposicion, $spalabra);
		$palabraAux1 = "";
		$palabraAux2 = "";
		$conteo = count($arrSilabas);
		$resultado = "";
		//se debe de dividir la palabra si mayor de 2 silabas
		if($conteo> 2){
			$mitad = (int)round($conteo/2, PHP_ROUND_HALF_DOWN);
			//ahora concateno las silabas, para obtener 2 palabras
			for($i=0; $i<$conteo;$i++){
				if($i< $mitad){
					$palabraAux1 .= $arrSilabas[$i];
				}
				else
				{
					$palabraAux2 .= $arrSilabas[$i];
				}
			}
			//ahora obtengo los resultados parciales
			//$resultadoAux1 = $this->obtenerAcentuacion($palabraAux1);
			$resultadoAux2 = $this->obtenerAcentuacion($palabraAux2);
			if(strlen($palabraAux1)> 2){
				$resultadoAux1 = $this->obtenerAcentuacion($palabraAux1);
			}
			else if(strlen($palabraAux1)==2 && (substr($palabraAux1, -1) == 'a' || substr($palabraAux1, -1) == 'e' || substr($palabraAux1, -1) == 'i' || substr($palabraAux1, -1) == 'o' ||
				substr($palabraAux1, -1) == 'u') && (substr($palabraAux1, 0,1) != 'a' && substr($palabraAux1, 0,1) != 'e' && substr($palabraAux1, 0,1) != 'i' && substr($palabraAux1, 0,1) != 'o' &&
				substr($palabraAux1, 0,1) != 'u')){
				$resultadoAux1 = $this->obtenerAcentuacion($palabraAux1);
			}
			else{
				$resultadoAux1 = $palabraAux1;
			}
			
			$resultado = $resultadoAux1.$resultadoAux2;
		}
		else{
			$resultado = $this->obtenerAcentuacion($spalabra);
		}
		
		return $resultado;
	}
	
	public function obtenerAcentuacion($spalabra){
		$arrposicion = $this->PosicionSilabas($spalabra);
		$arrSilabas = $this->obtenerSilabas($arrposicion, $spalabra);
		
		
		//ahora verifico que vocal debe de ser tildada, en base a la silaba tonica
		$silabaTonica = $this->SilabaTonica($spalabra);
		//verifico en que termina la palabra, si termina en vocal o n o s debe de tildarse en la ultima silaba aun si la silaba tonica 
		//esta en otra silaba
		//obtengo la ultima silaba
		$numeroSilabas = count($arrSilabas) -1;
		
		//se toma la ultima letra de la silaba
		if(substr($arrSilabas[$numeroSilabas], -1) == 'n' || substr($arrSilabas[$numeroSilabas], -1) == 's' ||substr($arrSilabas[$numeroSilabas], -1) == 'a' || substr($arrSilabas[$numeroSilabas], -1) == 'e'
			|| substr($arrSilabas[$numeroSilabas], -1) == 'i' || substr($arrSilabas[$numeroSilabas], -1) == 'o' || substr($arrSilabas[$numeroSilabas], -1) == 'u'){
			$arrSilabas[$numeroSilabas] = $this -> ReemplazaTilde($arrSilabas[$numeroSilabas]);
			//echo $resultado[$numeroSilabas];
		}
		else{ //puede ser una palabra esdrujula o una grave
			if($numeroSilabas > 3 && $silabaTonica-1 == $numeroSilabas){
				//echo $arrSilabas[$silabaTonica -2];
				$arrSilabas[$silabaTonica - 2] = $this->ReemplazaTilde($arrSilabas[$silabaTonica - 2]);
			}
			else{
				if(($silabaTonica - 1 )== 0){
					if(strlen($arrSilabas[$silabaTonica -1 ])>1)
						$arrSilabas[$silabaTonica - 1] = $this->ReemplazaTilde($arrSilabas[$silabaTonica - 1]);
				}
				else if($silabaTonica - 1 >= 1){
					if(strlen($arrSilabas[$silabaTonica -2 ])>1)
						$arrSilabas[$silabaTonica - 2] = $this->ReemplazaTilde($arrSilabas[$silabaTonica - 2]);
				}
				//echo $arrSilabas[$silabaTonica -2];
			}
		}
		
		//print_r($arrSilabas);
		
		//ahora obtengo la cadena resultante concatenando las silabas
		$resultado="";
		for($j=0;$j<count($arrSilabas);$j++){
			$resultado .= $arrSilabas[$j];
		}
		
		return $resultado;
	}
	
	/*********************************************************/
	/*********************************************************/
	/**             OPERACIONES PRIVADAS                    **/
	/*********************************************************/
	/*********************************************************/

	/// <summary>
	/// Determina si un caracter está tildado.
	/// </summary>
	/// <param name="c"></param>
	/// <returns></returns>
	private function TieneTilde($c) 
	{
		if (strrpos("áéíóú",$c) != -1)
			return true;
		else
			return false;
	}

	/// <summary>
	/// Determina si hay que llamar a PosicionSilabas (si palabra
	/// es la misma que la última consultada, no hace falta)
	/// </summary>
	/// <param name="palabra"></param>
	public function  Calcular ($palabra)
	{
		if ($palabra != $this->ultPal) {
			$this->ultPal = strtolower($palabra);
			$this->PosicionSilabas1();
		}
	}

	/// <summary>
	/// Determina si c es una vocal fuerte o débil acentuada
	/// </summary>
	/// <param name="c"></param>
	/// <returns></returns>
	function VocalFuerte ($c) {
		switch ($c) {
		case 'a': case 'á': case 'A': case 'Á': case 'à': case 'À':
		case 'e': case 'é': case 'E': case 'É': case 'è': case 'È':
		case 'í': case 'Í': case 'ì': case 'Ì':
		case 'o': case 'ó': case 'O': case 'Ó': case 'ò': case 'Ò':
		case 'ú': case 'Ú': case 'ù': case 'Ù':
			return true;
		}
		return false;
	}

	/// <summary>
	/// Determina si c no es una vocal
	/// </summary>
	/// <param name="c"></param>
	/// <returns></returns>
	function esConsonante ($c) {

		if (!$this->VocalFuerte($c))
		{
			switch ($c)
			{
				// Vocal débil
				case 'i': case 'I': 
				case 'u': case 'U': case 'ü': case 'Ü':
					return false;
			}

			return true;
		}
		
		return false;
	}

	/// <summary>
	/// Determina si se forma un hiato
	/// </summary>
	/// <returns></returns>
	function Hiato () {
		$tildado = $this->ultPal [$this->letraTildada];
		//echo $this->ultPal [$this->letraTildada];
		$arrUltPal = str_split($this->ultPal);
		if (($this->letraTildada > 1) &&  // Sólo es posible que haya hiato si hay tilde
			($arrUltPal [$this->letraTildada - 1] == 'u') && 
			($arrUltPal [$this->letraTildada - 2] == 'q'))
			return false; // La 'u' de "qu" no forma hiato

		// El caracter central de un hiato debe ser una vocal cerrada con tilde

		if (($tildado == 'í') || ($tildado == 'ì') || ($tildado == 'ú') || ($tildado == 'ù')) {

			if (($this->letraTildada > 0) && $this->VocalFuerte ($arrUltPal [$this->letraTildada - 1])) return true;

			if (($this->letraTildada < ($this->lonPal - 1)) && $this->VocalFuerte ($arrUltPal [$this->letraTildada + 1])) return true;		
		}

		return false;
	}

	/// <summary>
	/// Determina el ataque de la silaba de pal que empieza
	/// en pos y avanza pos hasta la posición siguiente al
	/// final de dicho ataque
	/// </summary>
	/// <param name="pal"></param>
	/// <param name="pos"></param>
	function Ataque ($pal, $pos) {
		// Se considera que todas las consonantes iniciales forman parte del ataque

		$ultimaConsonante = 'a';
		while (($pos < $this->lonPal) && (($this->esConsonante ($pal [$pos])) && ($pal [$pos] != 'y'))) {
			$ultimaConsonante = $pal [$pos];
			$pos++;
		}

		// (q | g) + u (ejemplo: queso, gueto)

		if ($pos < $this->lonPal - 1)
			if ($pal [$pos] == 'u') {
				if ($ultimaConsonante == 'q') $pos++;
				else
					if ($ultimaConsonante == 'g') {
						$letra = $pal [$pos + 1];
						if (($letra == 'e') || ($letra == 'é') || ($letra == 'i') || ($letra == 'í')) $pos ++;
					}
			}
			else { // La u con diéresis se añade a la consonante
				if (( $pal [$pos] == 'ü') || ( $pal [$pos] == 'Ü'))
					if ($ultimaConsonante == 'g') $pos++;
			}

		return $pos;
	}

	/// <summary>
	/// Determina el núcleo de la silaba de pal cuyo ataque
	/// termina en pos - 1 y avanza pos hasta la posición
	/// siguiente al final de dicho núcleo
	/// </summary>
	/// <param name="pal"></param>
	/// <param name="pos"></param>
	function Nucleo ($pal, $pos) {
		$anterior = 0;	// Sirve para saber el tipo de vocal anterior cuando hay dos seguidas
							// 0 = fuerte
							// 1 = débil acentuada
							// 2 = débil
		if ($pos >= $this->lonPal) return $pos; // ¡¿No tiene núcleo?!

		// Se salta una 'y' al principio del núcleo, considerándola consonante

		if ($pal [$pos] == 'y') $pos++;
 
		// Primera vocal

		if ($pos < $this->lonPal) {
			$c = $pal [$pos];
			switch ($c) {
			// Vocal fuerte o débil acentuada		
			case 'á': case 'Á': case 'à': case 'À':
			case 'é': case 'É': case 'è': case 'È':
			case 'ó':case 'Ó': case 'ò': case 'Ò':
				$this->letraTildada = pos;
				$this->encTonica    = true;
				$anterior = 0;
				$pos++;
				break;
			// Vocal fuerte
			case 'a': case 'A':
			case 'e': case 'E':
			case 'o': case 'O':
				$anterior = 0;
				$pos++;
				break;
			// Vocal débil acentuada, rompe cualquier posible diptongo
			case 'í': case 'Í': case 'ì': case 'Ì':
			case 'ú': case 'Ú': case 'ù': case 'Ù': case 'ü': case 'Ü':
				$this->letraTildada = $pos;
				$anterior = 1;
				$pos++;
				$this->encTonica = true;
				return $pos; 
			// Vocal débil
			case 'i': case 'I':
			case 'u': case 'U':
				$anterior = 2;
				$pos++;
				break;
			}
		}

		// 'h' intercalada en el núcleo, no condiciona diptongos o hiatos

		$hache = false;
		if ($pos < $this->lonPal) {
			if ($pal [$pos] == 'h') {
				$pos++;
				$hache = true;
			}
		}

		// Segunda vocal

		if ($pos < $this->lonPal) {
			$c = $pal [$pos];
			switch ($c) {
			// Vocal fuerte o débil acentuada
			case 'á': case 'Á': case 'à': case 'À':
			case 'é': case 'É': case 'è': case 'È':
			case 'ó':case 'Ó': case 'ò': case 'Ò':
				$this->letraTildada = $pos;
				if ($anterior != 0) {
					$this->encTonica    = true;
				}
				if ($anterior == 0)
				{    // Dos vocales fuertes no forman silaba
					if ($hache) $pos--;
					return $pos;
				}
				else
				{
					$pos++;
				}

				break;
			// Vocal fuerte 
			case 'a': case 'A':
			case 'e': case 'E':
			case 'o': case 'O':	
				if ($anterior == 0) {    // Dos vocales fuertes no forman silaba
					if ($hache) $pos--;
					return $pos;
				}
				else {
					$pos++;
				}
			
				break;

			// Vocal débil acentuada, no puede haber triptongo, pero si diptongo
			case 'í': case 'Í': case 'ì': case 'Ì':
			case 'ú': case 'Ú': case 'ù': case 'Ù':
				$this->letraTildada = $pos;
		
				if ($anterior != 0) {  // Se forma diptongo
					$this->encTonica    = true;
					$pos++;
				}
				else
					if ($hache) $pos--;

				return $pos;
			// Vocal débil
			case 'i': case 'I':
			case 'u': case 'U': case 'ü': case 'Ü':
				if ($pos < $this->lonPal - 1) { // ¿Hay tercera vocal?
					$siguiente = $pal [$pos + 1];
					if (!$this->esConsonante ($siguiente)) {
						$letraAnterior = $pal [$pos - 1];
						if ($letraAnterior == 'h') $pos--;
						return $pos;
					}
				}

				// dos vocales débiles iguales no forman diptongo
				if ($pal [$pos] != $pal [$pos - 1]) $pos++;

				return $pos;  // Es un diptongo plano o descendente	
			}
		}

		// ¿tercera vocal?

		if ($pos < $this->lonPal) {
			$c = $pal [$pos];
			if (($c == 'i') || ($c == 'u')) { // Vocal débil
				$pos++;
				return $pos;  // Es un triptongo	
			}
		}

		return $pos;
	}

	/// <summary>
	/// Determina la coda de la silaba de pal cuyo núcleo
	/// termina en pos - 1 y avanza pos hasta la posición
	/// siguiente al final de dicha coda
	/// </summary>
	/// <param name="pal"></param>
	/// <param name="pos"></param>
	function Coda ($pal, $pos) {	
		if (($pos >= $this->lonPal) || (!$this->esConsonante ($pal [$pos])))
			return $pos; // No hay coda
		else {
			if ($pos == $this->lonPal - 1) // Final de palabra
			{
				$pos++;
				return $pos;
			}

			// Si sólo hay una consonante entre vocales, pertenece a la siguiente silaba

			if (!$this->esConsonante ($pal [$pos + 1])) return $pos;

			$c1 = $pal [$pos];
			$c2 = $pal [$pos + 1];
	
			// ¿Existe posibilidad de una tercera consonante consecutina?
	
			if (($pos < $this->lonPal - 2)) {
				$c3 = $pal [$pos + 2];
		
				if (!$this->esConsonante ($c3)) { // No hay tercera consonante
					// Los grupos ll, lh, ph, ch y rr comienzan silaba
			
					if (($c1 == 'l') && ($c2 == 'l')) return $pos;
					if (($c1 == 'c') && ($c2 == 'h')) return $pos;
					if (($c1 == 'r') && ($c2 == 'r')) return $pos;

					///////// grupos nh, sh, rh, hl son ajenos al español(DPD)
					if (($c1 != 's') && ($c1 != 'r') &&
						($c2 == 'h'))
						return $pos;

					// Si la y está precedida por s, l, r, n o c (consonantes alveolares),
					// una nueva silaba empieza en la consonante previa, si no, empieza en la y
			
					if (($c2 == 'y')) {
						if (($c1 == 's') || ($c1 == 'l') || ($c1 == 'r') || ($c1 == 'n') || ($c1 == 'c'))
							return $pos;

						$pos++;
						return $pos;
					}

					// gkbvpft + l

					if (((($c1 == 'b')||($c1 == 'v')||($c1 == 'c')||($c1 == 'k')||
						   ($c1 == 'f')||($c1 == 'g')||($c1 == 'p')||($c1 == 't')) && 
						  ($c2 == 'l')
						 )
						) {
						return $pos;
					}

					// gkdtbvpf + r

					if (((($c1 == 'b')||($c1 == 'v')||($c1 == 'c')||($c1 == 'd')||($c1 == 'k')||
						   ($c1 == 'f')||($c1 == 'g')||($c1 == 'p')||($c1 == 't')) && 
						  ($c2 == 'r')
						 )
					   ) {
						return $pos;
					}

					$pos++;
					return $pos;
				}
				else { // Hay tercera consonante
					if (($pos + 3) == $this->lonPal) { // Tres consonantes al final ¿palabras extranjeras?
						if (($c2 == 'y')) { // 'y' funciona como vocal
							if (($c1 == 's') || ($c1 == 'l') || ($c1 == 'r') || ($c1 == 'n') || ($c1 == 'c'))
								return $pos;
						}
				
						if ($c3 == 'y') { // 'y' final funciona como vocal con c2
							$pos++;
						}
						else {	// Tres consonantes al final ¿palabras extranjeras?
							$pos += 3;
						}
						return $pos;
					}

					if (($c2 == 'y')) { // 'y' funciona como vocal
						if (($c1 == 's') || ($c1 == 'l') || ($c1 == 'r') || ($c1 == 'n') || ($c1 == 'c'))
							return $pos;
					
						$pos++;
						return $pos;
					}

					// Los grupos pt, ct, cn, ps, mn, gn, ft, pn, cz, tz, ts comienzan silaba (Bezos)
			
					if (($c2 == 'p') && ($c3 == 't') ||
						($c2 == 'c') && ($c3 == 't') ||
						($c2 == 'c') && ($c3 == 'n') ||
						($c2 == 'p') && ($c3 == 's') ||
						($c2 == 'm') && ($c3 == 'n') ||
						($c2 == 'g') && ($c3 == 'n') ||
						($c2 == 'f') && ($c3 == 't') ||
						($c2 == 'p') && ($c3 == 'n') ||
						($c2 == 'c') && ($c3 == 'z') ||
						($c2 == 't') && ($c3 == 's') ||
						($c2 == 't') && ($c3 == 's'))
					{
						$pos++;
						return $pos;
					}

					if (($c3 == 'l') || ($c3 == 'r') ||    // Los grupos consonánticos formados por una consonante
														 // seguida de 'l' o 'r' no pueden separarse y siempre inician
														 // sílaba 
						(($c2 == 'c') && ($c3 == 'h')) ||  // 'ch'
						($c3 == 'y')) {                   // 'y' funciona como vocal
						$pos++;  // Siguiente sílaba empieza en c2
					}
					else 
						$pos += 2; // c3 inicia la siguiente sílaba
				}
			}
			else {
				if (($c2 == 'y')) return $pos;

				$pos +=2; // La palabra acaba con dos consonantes
			}
		}
		return $pos;
	}

	/// <summary>
	/// Devuelve un array con las posiciones de inicio de las sílabas de ultPal
	/// </summary>
	function PosicionSilabas1() {
		//posiciones.Clear();
		$this->posiciones = array();
		$arrUltPal = str_split($this->ultPal);
		$this->lonPal       = count($arrUltPal);
		$this->encTonica    = false;
		$this->tonica       = 0;
		$this->numSil       = 0;
		$this->letraTildada = -1;

		// Se recorre la palabra buscando las sílabas

		for ($actPos = 0; $actPos < $this->lonPal; )
		{
			$this->numSil++;
			//posiciones.Add(actPos);  // Marca el principio de la silaba actual
			$this->posiciones[] = $actPos;
			// Las sílabas constan de tres partes: ataque, núcleo y coda

			$actPos = $this->Ataque($arrUltPal, $actPos);
			$actPos = $this->Nucleo($arrUltPal, $actPos);
			$actPos = $this->Coda($arrUltPal, $actPos);
	
			if (($this->encTonica) && ($this->tonica == 0)) $this->tonica = $this->numSil; // Marca la silaba tónica
		}

		// Si no se ha encontrado la sílaba tónica (no hay tilde), se determina en base a
		// las reglas de acentuación

		if (!$this->encTonica) {
			if ($this->numSil < 2) $this->tonica = $this->numSil;  // Monosílabos
			else {                            // Polisílabos
				$letraFinal    = $arrUltPal [$this->lonPal - 1];
				$letraAnterior = $arrUltPal [$this->lonPal - 2];
		
				if ((!$this->esConsonante ($letraFinal) || ($letraFinal == 'y')) ||
					((($letraFinal == 'n') || ($letraFinal == 's') && !$this->esConsonante ($letraAnterior))))
					$this->tonica = $this->numSil - 1;	// Palabra llana
				else
					$this->tonica = $this->numSil;		// Palabra aguda
			}
		}
	}
}

?>