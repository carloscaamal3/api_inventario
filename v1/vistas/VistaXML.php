<?php

require_once "VistaApi.php";

/**
 * Clase para imprimir en la salida respuestas con formato XML
 */
class VistaXML extends VistaApi
{

    /**
     * Imprime el cuerpo de la respuesta y setea el código de respuesta
     * @param mixed $cuerpo de la respuesta a enviar
     */
    public function imprimir($cuerpo)
    {
        if ($this->estado) {
            http_response_code($this->estado);
        }

        header('Content-Type: text/xml');

        $xml = new SimpleXMLElement('<respuesta/>');
        self::parsearArreglo($cuerpo, $xml);
        print $xml->asXML();

        return;
    }

    /**
     * Convierte un array a XML
     * @param array $data arreglo a convertir
     * @param SimpleXMLElement $xml_data elemento raíz
     */
    public function parsearArreglo($data, &$xmlData)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item' . $key;
                }
                $subnode = $xmlData->addChild($key);
                self::parsearArreglo($value, $subnode);
                return;
            }
            $xmlData->addChild("$key", htmlspecialchars("$value"));
        }
    }
}
