<?php

/**
* 
*/

class HTML
{
	
var $select;

	static function a($href, $content, $optional = []){

		$opt = null;

		foreach ($optional as $key => $val) {
			$opt .= " $key = '$val' ";
		}

            return "<a href='$href' $opt>$content</a>";

	}	



	static function br($length = 1){

		$x = 0;
		$br = null;
		while ($x <= $length) {
			$br .= "<br>\n";
			$x++;
		}
            return $br;

	}	



	static function open_div($attributes = []){

		$att = null;
		foreach ($attributes as $key => $val) {
				$att .=" $key = '$val' ";
		}

		return "<div $att>\n";

	}	



	static function close_div(){

		return "</div>\n";

	}




	static function open_form($attributes = []){

		$attr = null;
        if($attributes){
            $attr = null;
        }else{
            $attr = "method = 'post'";
        }

		foreach ($attributes as $key => $val) {
			$attr .= "$key = '$val' ";
		}
		return "<form $attr>\n";

	}	




	static function close_form($attributes = []){

		return "</form>\n";

	}




    public function textInput($model, $campo, $attributes = []){
        $attr = null;
        $x=0;
        $fields = $model->getColumns();
        
        $count_cols = count($fields);
        $string = "";

        foreach ($attributes as $key => $val) {
            $attr .= "$key = '$val' ";
        }
        $labels = $model->attributeLabels();
        foreach ($labels as $key => $value) {
           if($key == $campo ){
                 $label = "<br><label for ='$campo'> <b>$value</b> </label>\n";
           }
        }
        $removed = ArrayHelper::removeValue($fields, 'enviar');
        while ($x < $count_cols) {
            
            if($fields[$x]["name"] == $campo){

               
                $string = $label."<input id='$campo' type='text' name='$campo' $attr>";
                $x = $count_cols;
            }else{
                if($campo == "enviar"){
                    $string = "<input type='hidden' name='enviar' value='1'> ";
                }else{
                    $string = "Error, el atributo:<b>".$campo."</b> no se encuentra definido en la tabla";
                }
                $x++;
            }

        }

        return  $string;
    }

    public function passwordInput($model, $campo, $attributes = []){
        $attr = null;
        $x=0;
        $fields = $model->getColumns();
        $count_cols = count($fields);
        $string = "";
        $label = "";

        foreach ($attributes as $key => $val) {
            $attr .= "$key = '$val' ";
        }

        $labels = $model->attributeLabels();

        foreach ($labels as $key => $value) {
           if($key == $campo){
                 $label = "<label for ='$campo'> <b>$value</b> </label>\n";
           }
        }

        while ($x < $count_cols) {
            
            if($fields[$x]["name"] == $campo){

               
                $string = $label."<input type='password' name='$campo' $attr> ";
                $x = $count_cols;
            }else{
                $string = "Error, el atributo:<b>".$campo."</b> no se encuentra definido en la tabla<br>";
                $x++;
            }

        }

        return  $string;
    }    

    public function hiddenInput($model, $campo, $attributes = []){
        $attr = null;
        $x=0;
        $fields = $model->getColumns();
        $count_cols = count($fields);
        $string = "";
        $label = "";

        $string = $label."<input type='hidden' name='$campo' $attr> ";

        return  $string;
    }

    static function label($for, $content, $attributes = []){

        $attr = null;

        foreach ($attributes as $key => $val) {
            $attr .= "$key = '$val' ";
        }

        return "<label for ='$for' $attr > $content </label>\n";

    }



/*    static function button_HTML5($type, $content, $attributes = []){

        $attr = null;

        foreach ($attributes as $key => $val) {
            $attr .= "$key = '$val' ";
        }

        return "<button type = '$type' $attr>$content</button>\n";

    }	
*/
    static function submitButton($value, $attributes = []){

		$attr = null;

		foreach ($attributes as $key => $val) {
			$attr .= "$key = '$val' ";
		}

		return "<input type = 'submit' value='$value' $attr>\n";

	}



	static function radio($name, $value, $checked = false, $attributes = []){
		
		$attr = null;

		foreach ($attributes as $key => $val) {
			$attr .= "$key = '$val' ";
		}

		if($checked == true){
			$checked = "checked";
		}else{
			$checked = null;
		}


		return "<input type = 'radio' name='$name' value = '$value' $checked> ";
	}



	static function checkbox($name, $value, $checked = false, $attributes = []){
		
		$attr = null;

		foreach ($attributes as $key => $val) {
			$attr .= "$key = '$val' ";
		}

		if($checked == true){
			$checked = "checked";
		}else{
			$checked = null;
		}


		return "<input type = 'checkbox' name='$name' value = '$value' $checked> ";
	}




    function dropDownList($name, $values, $label='', $id= false, $multiple=0, $selected=false){
        
        $this->values=$values;
        $this->name=$name;
        $this->label=$label;
        
        if($multiple==1){
            $this->select = "<label>".$this->label."</label><br><select id='$id' name='".$this->name."[]' multiple='multiple'>";
        }
        else{
            $this->select = "<label>".$this->label."</label><br><select id='$id' name='".$this->name."'>";
        }


        $this->select .= "<option value='0'>Seleccione...</option>";
        while(list($values, $text)=each($this->values))
        {  

        if($values == $selected){
        	$p = "selected";
        }else{
        	$p ="";
        }



            $this->select .= "<option value='".$values."'".$p.">".$this->values[$values]."</option>";
        }
            $this->select  .= "</select>";
 
        return $this->select;
    }

/*
	function addInput($type, $name, $label='',$value=''){
        $this->type = $type;
        $this->name = $name;
        $this->label= $label;
        $this->value = $value;
 
        if($this->type == "submit" || $this->type=="reset"){
            $this->input = "<label></label>";
        }
        else{
            $this->input= "<label>".$this->label."</label><br>";
        }
        
        $this->input .= "<input type='".$this->type."' name='".$this->name."' value='".$this->value."' id='".$this->name."'/>";
        
        return $this->input;
    }
*/


    public static function array2table(
        $array,
        $nombre_tabla,
        $campo_clave,
        $transpose = false,
        $recursive = false,
        $typeHint = true,
        $tableOptions = ['class' => 'table table-bordered table-striped'],
        $keyOptions = [],
        $valueOptions = ['style' => 'cursor: default; border-bottom: 1px #aaa dashed;'],
        $null = '<span class="not-set">(not set)</span>'
    ) {
        // Sanity check
        if (empty($array) || !is_array($array)) {
            return false;
        }
        // Start the table
        $table = "<table>" . "\n";
        // The header
        $table .= "\t<tr>";
        if ($transpose) {
            foreach ($array as $key => $value) {
                if ($typeHint) {
                    $valueOptions['title'] = self::getType(strtoupper($value));
                }
                if (is_array($value)) {
                    $value = '<pre>' . print_r($value, true) . '</pre>';
                } else {
                    $value = "<span>".$value."</span>";
                }
                $table .= "\t\t<th>" . "<span>".$key."</span>" . "</th>" .
                    "<td>" . $value . "</td>\n\t</tr>\n";
            }
            $table .= "</table>";
            return $table;
        }
        if (!isset($array[0]) || !is_array($array[0])) {
            $array = array($array);
        }
        // Take the keys from the first row as the headings
        foreach (array_keys($array[0]) as $heading) {
            $table .= '<th>' . "<span>".$heading."</span>" . '</th>';
        }
        $table .= "<th><span>Acciones</span></th> </tr>\n";
        $table .= "</tr>\n";
        // The body
        foreach ($array as $row) {
            $table .= "\t<tr>";
            foreach ($row as $cell) {
                $table .= '<td>';
                // Cast objects
                if (is_object($cell)) {
                    $cell = (array)$cell;
                }
                if ($recursive === true && is_array($cell) && !empty($cell)) {
                    // Recursive mode
                    $table .= "\n" . static::array2table($cell, true, true) . "\n";
                } else {
                    if (!is_null($cell) && is_bool($cell)) {
                        $val = $cell ? 'true' : 'false';
                        $type = 'boolean';
                    } else {
                        $chk = (strlen($cell) > 0);
                        $type ='NULL';
                        $val = $chk ? htmlspecialchars((string)$cell) : $null;
                    }
                    if ($typeHint) {
                        $valueOptions['title'] = $type;
                    }
                    $table .= "<span>".$val."</span>";
                }
                $table .= '</td>';
            }
            //armar botones dinamicamente
            
            $table .= "
                <td>

                    <a href=". ROUTER::create_action_url("".$nombre_tabla."/editar", [$row[$campo_clave]])."> <button class='btn'><i class='icon-edit'></i><b>Editar</b></button></a>

                    <a href=". ROUTER::create_action_url("".$nombre_tabla."/eliminar", [$row[$campo_clave]])."> <button class='btn-danger'><i class='icon-edit'></i><b>Eliminar</b></button> </a>
                </td>";

            $table .= "</tr>";
        }
        $table .= '</table>';
        return $table;
    }



}









?>