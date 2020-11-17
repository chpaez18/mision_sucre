<?php
/**
* 
*/
class TableComponent extends Model
{
    //public $tittles = [];
    
    public static function buildTable($arr)
    {
        $html = '';
        $html2 = self::buildData($arr["model"], $arr["data"]);

        $html .= '<table>';

        $html .= '<thead>';
        $html .=    '<tr>';
                        foreach ($arr["tittles"] as $key) {
                            $html .= '<th>'.$key.'</th>';
                        }
                        $html .= '<th>Acciones</th>';
        $html .=    '</tr>';
        $html .= '</thead>';
        //var_dump($arr["model"]);die();
        $html .= '<tbody>';
                    $html .= $html2;
        $html .= '</tbody>';

        $html .= '</table>';
        return html_entity_decode ($html);
    }

    public static function buildData($model,$data){
        $a = 0;
        $html = '';

        while ($a < count($model)) {

            $html .= '<tr>';
            foreach ($data as $key => $value) {
                $html .= '<td>'.$model[$a][$data[$key]].'</td>' ;
            }
            $html .= '</tr>';
            $a++;
        }
        return html_entity_decode ($html);
        
    }



}

?>