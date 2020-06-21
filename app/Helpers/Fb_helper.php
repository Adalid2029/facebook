<?php

use App\Models\AuthModel;

if (!function_exists('authenticated')) {
    function authenticated()
    {
        $id_user = (new AuthModel())->find(array('id_user' => (\Config\Services::session())->get('id_user')));
        return (is_null($id_user) ? FALSE : $id_user);
    }
}



if (!function_exists('css_tag')) {
    function css_tag($src = '', $type = 'text/css')
    {
        $css = '<st' . 'yle type="' . $type . '">';
        if (is_file(FCPATH . 'css/' . $src . '.css')) {
            if (strpos($src, '://') === FALSE) {
                ob_start();
                require(FCPATH . 'assets/css/' . $src . '.' . 'css');
                $css .= ob_get_clean();
            }
        }
        $css .= '</st' . 'yle>';
        return $css;
    }
}

if (!function_exists('script_tag')) {
    function script_tag($src = '', $flashdata = NULL, $type = 'text/javascript')
    {
        $script = '<scr' . 'ipt type="' . $type . '">';
        if (is_file(FCPATH . 'js/' . $src . '.js')) {
            if (strpos($src, '://') === FALSE) {
                ob_start();
                require(FCPATH . 'js/' . $src . '.' . 'js');
                $script .= ob_get_clean();
            }
        }
        if (is_array($flashdata)) {
            foreach ($flashdata as $kmsg => $msg) {
                $script .= "$.toast({
                                icon: `<?php echo ((is_numeric({$kmsg}) || empty({$kmsg})) ? 'error' : {$kmsg}); ?>`,
                                heading: `<?php echo ((is_numeric({$kmsg}) || empty({$kmsg})) ? 'ERROR [' . {$kmsg} . ']' : 'INFORMACIÓN'); ?>`,
                                text: `<?php echo {$msg} ?>`,
                                position: `top-center`,
                                showHideTransition: `plain`,
                                allowToastClose: true,
                                loaderBg: `#FFF`,
                                hideAfter: 5000,
                                stack: 5 });";
            }
        }
        $script .= '</scr' . 'ipt>';
        return $script;
    }
}

if (!function_exists('mes_literal')) {
    function mes_literal($mes = 0)
    {
        switch (intval($mes)) {
            case 1:
                return 'ENERO';
                break;
            case 2:
                return 'FEBRERO';
                break;
            case 3:
                return 'MARZO';
                break;
            case 4:
                return 'ABRIL';
                break;
            case 5:
                return 'MAYO';
                break;
            case 6:
                return 'JUNIO';
                break;
            case 7:
                return 'JULIO';
                break;
            case 8:
                return 'AGOSTO';
                break;
            case 9:
                return 'SEPTIEMBRE';
                break;
            case 10:
                return 'OCTUBRE';
                break;
            case 11:
                return 'NOVIEMBRE';
                break;
            case 12:
                return 'DICIEMBRE';
                break;
            default:
                return '';
                break;
        }
    }
}

if (!function_exists('fecha_literal')) {
    function fecha_literal($fecha, $formato = 0)
    {
        $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
        $meses = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $infofecha = getdate(strtotime($fecha));
        if (empty($fecha)) {
            return ('');
        } else {
            switch ($formato) {
                case 1:
                    return ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . ' de ' . $meses[$infofecha['mon']] . ' de ' . $infofecha['year'];
                    break;
                case 2:
                    return $dias[$infofecha['wday']] . ', ' . ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . ' de ' . $meses[$infofecha['mon']] . ' de ' . $infofecha['year'];
                    break;
                case 3:
                    return $dias[$infofecha['wday']] . ', ' . ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . ' de ' . $meses[$infofecha['mon']] . ' de ' . $infofecha['year'] . ' [Hrs. ' . ($infofecha['hours'] < 10 ? '0' : '') . $infofecha['hours'] . ':' . ($infofecha['minutes'] < 10 ? '0' : '') . $infofecha['minutes'] . ']';
                    break;
                case 5:
                    return ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . ' de ' . $meses[$infofecha['mon']] . ' de ' . $infofecha['year'] . ' [Hrs. ' . ($infofecha['hours'] < 10 ? '0' : '') . $infofecha['hours'] . ':' . ($infofecha['minutes'] < 10 ? '0' : '') . $infofecha['minutes'] . ']';
                    break;
                case 9:
                    return ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . '/' . substr(strtolower($meses[$infofecha['mon']]), 0, 3);
                    break;
                case 10:
                    return $infofecha['year'];
                    break;
                case 20:
                    return $infofecha['mon'];
                    break;
                case 30:
                    return $infofecha['mday'];
                    break;
                default:
                    return date('Y-m-d H:i:s', strtotime($fecha));
                    break;
            }
        }
    }
}

if (!function_exists('mayusculas')) {
    function mayusculas($cadena = NULL)
    {
        $resultado = NULL;
        if (!is_null($cadena)) {
            $resultado = mb_strtoupper($cadena);
        }
        return $resultado;
    }
}
if (!function_exists('minusculas')) {
    function minusculas($cadena = NULL)
    {
        $resultado = NULL;
        if (!is_null($cadena)) {
            $resultado = mb_strtolower($cadena);
        }
        return $resultado;
    }
}

if (!function_exists('numero_romano')) {
    function numero_romano($integer, $upcase = true)
    {
        $table = array(
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100,
            'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9,
            'V' => 5, 'IV' => 4, 'I' => 1
        );
        $return = '';
        while ($integer > 0) {
            foreach ($table as $rom => $arb) {
                if ($integer >= $arb) {
                    $integer -= $arb;
                    $return .= ($upcase ? $rom : strtolower($rom));
                    break;
                }
            }
        }
        return $return;
    }
}
