<?php

require_once 'model/Dato.php';

class Inventario extends Dato
{
	public $producto;
	public $cantidad;
	public $medida;
	public $precio;
	public $moneda;
	public $proveedor;


	function incluir()
	{
		$co = $this->conecta();
		$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		try {
			$co->query("Insert into inventario(
					producto,
					cantidad,
					medida,
					precio,
					moneda,
					proveedor
					)
					Values(
					'$this->producto',
					'$this->cantidad',
					'$this->medida',
					'$this->precio',
					'$this->moneda',
					'$this->proveedor'
					)");
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	function consultar()
	{
		$co = $this->conecta();
		$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		try {
			$resultado = $co->query("Select * from inventario");

			if ($resultado) {

				$respuesta = '';
				foreach ($resultado as $r) {
					$total = $r['cantidad'] * $r['precio'];

					$precio = 0;

					if ($r['moneda'] === 'dolares') {
						$precio = $r['precio'] . " $";
					} else {
						$precio = $r['precio'] . " BsS";
					}

					$cantidad = '';

					if ($r['medida'] === 'unidades') {
						$cantidad = $r['cantidad'];
					} elseif ($r['medida'] === 'litros') {
						$cantidad = $r['cantidad'] . " lts";
					} else {
						$cantidad = $r['cantidad'] . " Kg";
					}

					$respuesta = $respuesta . "<tr>";
					$respuesta = $respuesta . "<td>";
					$respuesta = $respuesta . $r['id'];
					$respuesta = $respuesta . "</td>";
					$respuesta = $respuesta . "<td>";
					$respuesta = $respuesta . $r['producto'];
					$respuesta = $respuesta . "</td>";
					$respuesta = $respuesta . "<td>";
					$respuesta = $respuesta . $r['proveedor'];
					$respuesta = $respuesta . "</td>";
					$respuesta = $respuesta . "<td>";
					$respuesta = $respuesta . $precio;
					$respuesta = $respuesta . "</td>";
					$respuesta = $respuesta . "<td>";
					$respuesta = $respuesta . $cantidad;
					$respuesta = $respuesta . "</td>";
					$respuesta = $respuesta . "<td>";
					$respuesta = $respuesta . $total;
					$respuesta = $respuesta . "</td>";
					$respuesta = $respuesta . "<td>";
					$respuesta = $respuesta . "<img src=\"sad\">";
					$respuesta = $respuesta . "</td>";
					$respuesta = $respuesta . "</tr>";
				}
				return $respuesta;
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	// function modificar(){
	// 	$co = $this->conecta();
	// 	$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// 	try {
	// 			$co->query("Update usuarios set 
	// 				usuario = '$this->usuario',
	//         clave = '$this->clave',
	//         correo = '$this->correo',
	//         telefono = '$this->telefono',
	//         direccion = '$this->direccion'
	//         where cedula = '$this->cedula'");
	// 				return "Registro modificado";
	// 	} catch(Exception $e) {
	// 		return $e->getMessage();
	// 	}
	// }
}
