<?php
	require_once "./vendor/autoload.php";
	use Laminas\Soap\Server;
	function Pendiente($x1, $y1, $x2, $y2){
		$m = (($y2 - $y1)/($x2 - $x1));
		$m2 = (-1/$m);
		return array ($m, $m2);
	}
	function PrimeraE($Bx1, $By1, $m){
		$a = round($m, 2) * -1;
		$b = 1;
		$c = (-1 * $m * $Bx1) + $By1;
		return array ($a, $b, $c);
	}
	function SegundaE($Bx1, $By1, $m){
		$d = round($m, 2)* -1;
		$e = 1;
		$f = (-1 * $m * $Bx1) + $By1;
		return array ($d, $e, $f);
	}
	function S2Ecu($a, $b, $c, $d, $e, $f){
		$Y = ($f-(($d*$c)/$a))/(((-$d*$b)/$a)+$e);
		$X = ($c-($b*$Y))/$a;
		return array ($X, $Y);
	}
	function dist($punto1, $punto2){
		return round($lado1 = sqrt( pow($punto1->x-$punto2->x, 2) + pow($punto1->y-$punto2->y, 2) ),2); 
	}
	$ac = array('uri' => "http://localhost/producto3"); 
	$server = new Server(null, $ac);
	$server->addFunction("Pendiente");
	$server->addFunction("PrimeraE");
	$server->addFunction("SegundaE");
	$server->addFunction("S2Ecu");
	$server->addFunction("dist");
	$server->handle();
?>