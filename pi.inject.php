<?php

/*
Inject
============

Description
-----------

Inject allows you to place content inside the opening and closing tags 
of a wysiwyg-generated output block.


Usage
-----

{exp:inject start='{stuff_to_inject}' end='{other_stuff_to_inject}' spacer=' '}{content}{/exp:inject}


Bugs
----

To file bug reports please send email to: <dan.drinkard@gmail.com>

*/

$plugin_info = array(
  'pi_name' => 'Inject',
  'pi_version' => '0.1',
  'pi_author' => 'Dan Drinkard',
  'pi_author_url' => 'http://displayawesome.com/',
  'pi_description' => 'Injects markup or template tags into the first opening and last closing tags of a block\'s output',
  'pi_usage' => Inject::usage()
  );


class Inject
{

    var $return_data = "";

    function Inject()
    {
        global $TMPL;
        $content = $TMPL->tagdata;
        $inject_start = $TMPL->fetch_param('start');
        $inject_end = $TMPL->fetch_param('end');
        $spc = $TMPL->fetch_param('spacer');
        $pos_start = strpos($content, '>')+1;
        $pos_end = strrpos($content, '<');
        $start = substr($content, 0, $pos_start);
        $middle = substr($content, $pos_start, ($pos_end-$pos_start));
        $end = substr($content, $pos_end);
        $this->return_data = $start.$inject_start.$spc.$middle.$spc.$inject_end.$end;
    }
    
    function usage()
    {
        ob_start(); 
        ?>
        WYSIWYG-generated template tags are wrapped in a block-level html tag
        (<p>, <ul>, <div>, etc) by default, which can be annoying in cases
        where some other output (date, title, etc) should be in the same container as well.
        Inject lets you add markup or evaluated data inside the first <tag>, as well as the
        last </tag> in the wysiwyg block's output.

        {exp:inject start='{stuff_to_inject}' end='{other_stuff_to_inject}'}{content}{/exp:inject}

        Cannot wrap logical statements, such as conditionals.

        <?php
        $buffer = ob_get_contents();

        ob_end_clean(); 

        return $buffer;
    }

}

?>