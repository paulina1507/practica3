<?php
	header("Content-Type: image/png");
	require_once './vendor/autoload.php';
	require_once 'Punto.php';
	use Laminas\Soap\Client;

	$url = "http://localhost/producto3/Servidor.php";
	
	$ac = array(
		'location' => $url,
		'uri' => "http://localhost/producto3"
	);
	$cliente = new Client(null, $ac);

	$p1x = $_GET['x1']; 
	$p1y = $_GET['y1']; 
	$p2x = $_GET['x2']; 
	$p2y = $_GET['y2']; 
	$p3x = $_GET['x3']; 
	$p3y = $_GET['y3'];
	$n = $_GET['n']; 
	$ancho = 800;
	$alto = 1200;
	$img = imagecreate($alto, $ancho);
	
	$blanco = imagecolorallocate($img, 255, 255, 255);
	$negro = imagecolorallocate($img, 0, 0, 0);	
	
	imagefilledrectangle($img, 0, 0, $ancho, $alto, $blanco);

	$p1 = new Punto($p1x, $p1y);
	$p2 = new Punto($p2x, $p2y);
	$p3 = new Punto($p3x, $p3y);

	if($n == 1){
		imagestring($img, 3, 400, 400, "xO=" . $p1x . " yO=" . $p1y, $negro);
		imagestring($img, 3, 400, 360, "x1=" . $p2x . " y1=" . $p2y, $negro);
		imagestring($img, 3, 400, 380, "x2=" . $p3x . " y2=" . $p3y, $negro);
	}else if($n == 1){
		imagestring($img, 3, 400, 400, "xO=" . $p2x . " yO=" . $p2y, $negro);
		imagestring($img, 3, 400, 360, "x1=" . $p1x . " y1=" . $p1y, $negro);
		imagestring($img, 3, 400, 380, "x2=" . $p3x . " y2=" . $p3y, $negro);
	}else{
		imagestring($img, 3, 400, 400, "xO=" . $p3x . " yO=" . $p3y, $negro);
		imagestring($img, 3, 400, 360, "x1=" . $p1x . " y1=" . $p1y, $negro);
		imagestring($img, 3, 400, 380, "x2=" . $p2x . " y2=" . $p2y, $negro);
	}

	imagestring($img, 1, $p1x, $p1y - 15, "P1", $negro);
	imagestring($img, 1, $p2x, $p2y - 15, "P2", $negro);
	imagestring($img, 1, $p3x - 15, $p3y, "P3", $negro);

	$arrptos = array(
		$p1x, $p1y,
		$p2x, $p2y,
		$p3x, $p3y,
	);
	imagepolygon($img, $arrptos, 3, $negro);

	if($n==1){
		$EP = $cliente->Pendiente($p2x, $p2y, $p3x ,$p3y);
		imagestring($img, 3, 400, 440, "Pendiente es " . $EP[0], $negro);
		imagestring($img, 3, 400, 460, "Pendiente 2 es " . $EP[1], $negro);
		$EL1 = $cliente->PrimeraE($p2x, $p2y, $EP[0]);
		imagestring($img, 3, 700, 460, "a: " . $EL1[0] . " b: " . $EL1[1] . " c: " . $EL1[2] , $negro);
		$EL2 = $cliente->SegundaE($p1x, $p1y, $EP[1]);	
		imagestring($img, 3, 700, 480, "d: " . $EL2[0] . " e: " . $EL2[1] . " f: " . round($EL2[2],2) , $negro);
		$E = $cliente->S2Ecu($EL1[0], $EL1[1], $EL1[2], $EL2[0], $EL2[1], $EL2[2]);
		$ph = new Punto($E[0], $E[1]);
		imagestring($img, 3, 200, 420, "xF=" . round($E[0], 2). " yF=" . round($E[1],2), $negro);
		imagestring($img, 3, $E[0], $E[1], "PF", $negro);
	}else if($n==2){
		$EP = $cliente->Pendiente($p3x, $p3y, $p1x ,$p1y);
		imagestring($img, 3, 400, 440, "Pendiente es " . $EP[0], $negro);
		imagestring($img, 3, 400, 460, "Pendiente 2 es " . $EP[1], $negro);
		$EL1 = $cliente->PrimeraE($p1x, $p1y, $EP[0]);
		imagestring($img, 3, 700, 460, "a: " . $EL1[0] . " b: " . $EL1[1] . " c: " . $EL1[2] , $negro);
		$EL2 = $cliente->SegundaE($p2x, $p2y, $EP[1]);	
		imagestring($img, 3, 700, 480, "d: " . $EL2[0] . " e: " . $EL2[1] . " f: " . round($EL2[2],2) , $negro);
		$E = $cliente->S2Ecu($EL1[0], $EL1[1], $EL1[2], $EL2[0], $EL2[1], $EL2[2]);
		$ph = new Punto($E[0], $E[1]);
		imagestring($img, 3, 200, 420, "xF=" . round($E[0], 2). " yF=" . round($E[1],2), $negro);
		imagestring($img, 3, $E[0], $E[1], "PF", $negro);
	}else{
		$EP = $cliente->Pendiente($p1x, $p1y, $p2x ,$p2y);
		imagestring($img, 3, 400, 440, "Pendiente es " . $EP[0], $negro);
		imagestring($img, 3, 400, 460, "Pendiente 2 es " . $EP[1], $negro);
		$EL1 = $cliente->PrimeraE($p1x, $p1y, $EP[0]);
		imagestring($img, 3, 700, 460, "a: " . $EL1[0] . " b: " . $EL1[1] . " c: " . $EL1[2] , $negro);
		$EL2 = $cliente->SegundaE($p3x, $p3y, $EP[1]);	
		imagestring($img, 3, 700, 480, "d: " . $EL2[0] . " e: " . $EL2[1] . " f: " . round($EL2[2],2) , $negro);
		$E = $cliente->S2Ecu($EL1[0], $EL1[1], $EL1[2], $EL2[0], $EL2[1], $EL2[2]);
		$ph = new Punto($E[0], $E[1]);
		imagestring($img, 3, 200, 420, "xF=" . round($E[0], 2). " yF=" . round($E[1],2), $negro);
		imagestring($img, 3, $E[0], $E[1], "PF", $negro);
	}

	imagestring($img, 3, 400, 480, "L1=" . $cliente->dist($p1,$p2), $negro);
	imagestring($img, 3, 400, 500, "L2=" . $cliente->dist($p2,$p3), $negro);
	imagestring($img, 3, 400, 520, "L3=" . $cliente->dist($p3,$p1), $negro);

	if($n==1){
		imageline($img, $p1x, $p1y, $E[0],$E[1], $negro);
	}else if($n==2){
		imageline($img, $p2x, $p2y, $E[0],$E[1], $negro);
	}else{
		imageline($img, $p3x, $p3y, $E[0],$E[1], $negro);
	}


	imagepng($img);
	imagedestroy($img);
	
?>