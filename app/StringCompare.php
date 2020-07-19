<?php


namespace App;



use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class StringCompare
{
    private $name;
    /**
     * @var \Illuminate\Support\Collection
     */
    /**
     * @var array|\Illuminate\Support\Collection
     * Array de los posibles ordenes del nombre dado
     */
    public $name_array = [];

    /**
     * Letras que son simulares, para cuando se hace la validación los ve como iguales
     * @var \string[][]
     */
    public $similar_letters = [
        ['b', 'v'],
        ['s', 'z']
    ];

    /**
     * StringCompare constructor.
     * @param $name
     *
     */
    public function __construct($name)
    {
        $this->name = $name;
        // Pone cada nombre y appeliddo en un array
        $names_array = explode(" ", $name);
        // quitar doble espacios en blanco
        $names_array = array_filter($names_array, 'strlen');
        $this->name_array = collect([]);
        // obtiene el name array es sus diferentes ordenes
        $this->pc_permute(collect($names_array)->values()->toArray());
    }

    /**
     * @param $items
     * @param array $perms
     * Permuta todos los posibles opciones para un nombre
     */
    public function pc_permute($items, $perms = array()) {
        if (empty($items)) {
            // Agregamos la opción del nombre al array
            $this->name_array->push(join(' ', $perms));
        } else {
            for ($i = count($items) - 1; $i >= 0; --$i) {
                $newitems = $items;
                $newperms = $perms;
                list($foo) = array_splice($newitems, $i, 1);
                array_unshift($newperms, $foo);
                $this->pc_permute($newitems, $newperms);
            }
        }
    }

    // hace la comparación como hay opciones de ordenes en los nombres coge el que tenga mas similitud
    public function compare($string)
    {
        $max = 0;
        foreach ($this->name_array as $name) {
            $ranking = $this->simularity($name, $string);
            if($max <= $ranking) $max = $ranking;
        }
        return $max;
    }


    /**
     * @param $string1
     * @param $string2
     * @return mixed
     * Calcula la similaridad de los nombres y devuelve un porcentaje
     *
     */
    public function simularity($string1, $string2)
    {
        similar_text(
            $this->getSimularString(strtolower($string1)),
            $this->getSimularString(strtolower($string2)),
            $percent);
        return $percent;
    }

    /**
     * @param $string
     * @return string
     * Obtiene el string simular remplazando letras similares
     */
    public function getSimularString($string)
    {
        $string = Str::of($string);
        foreach ($this->similar_letters as $similar) {
            $string = $string->replace($similar[0], $similar[1]);
        }
        return $string . '';
    }

    /**
     * @param $public_figures Collection
     * @return mixed
     * Coge las figuras publicas y compare el nombre
     */
    public function withPublicFigures($public_figures)
    {
        return $public_figures->map(function ($figure) {
            $figure->raking = $this->compare($figure->nombre);
            return $figure;
        });
    }
}
