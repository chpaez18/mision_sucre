<?php

/*
Modelo con metodo para redireccionamiento en url
*/
class ROUTER 
{
	

	//arma una url hasta una direccion en especifica, con o sin parametros
	static function create_action_url($r, $params = null){

		$p = null;

		if(is_array($params)){

			foreach ($params as $param => $value) {
				$p .= "/$value";
			}

		}

		if(!empty($params)){

			return "index.php?url=".$r."".$p."";

		}else{

			return "index.php?url=".$r;
		}
	}	


	static public function pathTo($context=false, $params = []){
		foreach ($params as $key => $value) {
			$$key = $value;   //instanciamos una variable con el valor, para instanciar variables se usa 2 veces el $, $$key
		}
		return VIEWS . $context . ".php";
	}

	static public function renderPDF($context, $model =[], $name = false){

		//con ob_start guardamos en un buffer la pagina que queremos incluir que contendra el contenido del reporte, con el fin de poder usar codigo php en la pagina del reporte
		ob_start();

		if(isset($model)){
			include Router::pathTo($context,["model"=>$model]);
		}else{
			include Router::pathTo($context);
		}
		$content = ob_get_clean(); //guardamos en una variable lo que esta en el buffer,  ob_get_clean  captura todo lo que esta dentro de ob_start

		$mpdf = new mPDF('c', 'A4', '','', '15','15','28','18');
		$css = file_get_contents(LIB."bootstrap.min.css");

		$cabecera = "<img  src=".VIEWS."layouts/default/img/banner.png width='100%'>";
		$mpdf->SetHTMLHeader($cabecera);


		$mpdf->SetHTMLFooter("<div style='text-align:right; '><b><i>Página:</i></b> {PAGENO}/{nbpg}</div><hr style = 'color:black'>");
		
		$mpdf->writeHTML($css,1);

		$mpdf->writeHTML($content);

		if(isset($name)){
			return $mpdf->Output($name.".pdf", "I");
		}else{
			return $mpdf->Output("reporte.pdf", "I");
		}
		
	}
}
















?>