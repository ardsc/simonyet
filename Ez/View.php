<?php

namespace Ez;
/**
 * View sebagai render view untuk load template
 * @author prade.nugroho@gin.co.id, ardiansyah.sc@gin.co.id
 */
class View
{

    private static
        $layout = 'layout',
        $content = false,
        $css = [],
        $js = [],
        $render_variable = [];

    public static function layout($file)
    {

        static::$layout = $file;
    }

    public static function share($data = [])
    {

        static::$render_variable = array_merge(static::$render_variable, $data);
    }


    public static function registerCss($css)
    {
        if (is_array($css)){
            foreach ($css as $item_css){
                
                array_push(static::$css, $item_css);
            }

        } else {

            array_push(static::$css, $css);
        }
    }

    public static function registerJs($js)
    {
        if (is_array($js)){
            foreach ($js as $item_js){
                
                array_push(static::$js, $item_js);
            }

        } else {

            array_push(static::$js, $js);
        }
    }

    /**
     * view() digunakan untuk load seluruh template yang dipilih
     * @param string $template file yang akan diload
     * @param object $data data yang akan dikirimkan ke dalam view
     */
    public static function render($template, $data = [])
    {

        static::$render_variable = array_merge(static::$render_variable, $data);

        extract(static::$render_variable);


        
        if (isset($data['layout'])) {
            
            if (false != $data['layout']) {

            } else {

                self::layout($data['layout']);
            }
            
            unset($data['layout']);
        }


        if (isset($layout)) {

            if (false == $layout) {

                include baseDir(rdot($template) . '.php');
            
            } else {


                static::$content = baseDir(rdot($template).'.php');

                include baseDir(rdot($layout).'.php');

            }

        } else {

            static::$content = baseDir(rdot($template).'.php');

            include baseDir(rdot(static::$layout).'.php');
        }

    }

    // nggo nampilken content sek nganggo layout
    private static function content()
    {
        extract(static::$render_variable);

        include static::$content;
    }

    // podo ro js()
    private static function css()
    {

        $files = array_unique(static::$css);

        foreach ($files as $css){

            $css = url($css);

            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$css\">";
        }
    }
    // nggo load js sek ke include barengan karo content
    private static function js()
    {

        $files = array_unique(static::$js);

        foreach ($files as $js){

            $js = url($js);

            echo "<script type=\"text/javascript\" src=\"$js\"></script>";
        }
    }
}