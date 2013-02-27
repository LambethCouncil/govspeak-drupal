<?php

    require_once('markdown.php');

    function govspeak($text){
        $text = render_external_links($text);
        $text = render_steps($text);
        $text = render_basic($text, '<h3 class="advisory"><span>{{CONTENT}}</span></h3>', '@');
        $text = render_basic($text, '<div class="application-notice help-notice"><p>{{CONTENT}}</p></div>', '%', NULL, true, false);
        $text = render_basic($text, '<div class="application-notice info-notice"><p>{{CONTENT}}</p></div>', '^', NULL, true, false);
        $text = render_basic($text, '<div class="summary"><p>{{CONTENT}}</p></div>', '$!', NULL, true, false);
        $text = render_basic($text, '<div class="example"><p>{{CONTENT}}</p></div>', '$E', NULL, true, false);
        $text = render_basic($text, '<div class="call-to-action"><p>{{CONTENT}}</p></div>', '$CTA', NULL, true, false);
        $text = render_basic($text, '<div class="contact"><p>{{CONTENT}}</p></div>', '$C', NULL, true, true);
        $text = render_basic($text, '<div class="additional-information"><p>{{CONTENT}}</p></div>', '$AI', NULL, true, false);
        $text = render_basic($text, '<div class="information"><p>{{CONTENT}}</p></div>', '$I', NULL, true, false);
        $text = render_basic($text, '<div class="address"><div class="adr org fn"><p>{{CONTENT}}</p></div></div>', '$A', NULL, true, true);
        $text = render_basic($text, '<div class="place"><p>{{CONTENT}}</p></div>', '$P', NULL, true, false);
        $text = render_basic($text, '<div class="form-download"><p>{{CONTENT}}</p></div>', '$D', NULL, true, false);
        $text = render_basic($text, '<div class="highlight-answer"><p>{{CONTENT}}</p></div>', '{::highlight-answer}', '{:/highlight-answer}', true, false);
        return Markdown($text);
    }

    function render_basic($text, $template, $open, $close=NULL, $markup_contents=false, $line_breaks=false){
        $matches = match_elements($text, $open, $close);
        for ($i=0; $i < count($matches[1]); $i++) {
            $contents = $matches[1][$i][0];
            if ($markup_contents){
                $contents = trim(markup_element($contents));
            }
            if ($line_breaks){
                $contents = str_replace("\n", '<br>', $contents);
            }
            $html = str_replace('{{CONTENT}}', $contents, $template);
            $text = str_replace($matches[0][$i][0], $html, $text);
        }
        return $text;
    }

    function render_external_links($text){
        $matches = match_external_links($text);
        for ($i=0; $i < count($matches[1]); $i++) {
            $html = markup_element(trim($matches[2][$i][0]));
            $html = str_replace('<a' , '<a class="external-link" rel="external"', $html);
            $text = str_replace($matches[0][$i][0], $html, $text);
        }
        return $text;
    }

    function render_steps($text){
        $list_matches = match_steps_lists($text);
        foreach ($list_matches as $list_match) {
            $list_text = $list_match[0];
            $item_matches = match_steps_items($list_text);
            $html = '<ol class="steps">';
            foreach ($item_matches[2] as $item_match) {
                $html = $html . "<li>" . Markdown($item_match[0]) . "</li>";
            }
            $html .= '</ol>';
            $text = str_replace($list_text, $html, $text);
        }
        return $text;
    }

    function match_elements($text, $open, $close=NULL){
        $pattern = get_pattern($open, $close);
        preg_match_all($pattern, $text, $matches, PREG_OFFSET_CAPTURE);
        return $matches;
    }

    function match_external_links($text){
        $pattern = '#(^|\s)x(\[(.*?)\]\(.*?\))x(\s|$|\.|\,)#';
        preg_match_all($pattern, $text, $matches, PREG_OFFSET_CAPTURE);
        return $matches;
    }

    function match_steps_lists($text){
        $pattern = '#((s\d+\.\s.*(?:\n|$))+)#';
        preg_match_all($pattern, $text, $matches, PREG_OFFSET_CAPTURE);
        return $matches[0];
    }

    function match_steps_items($text){
        $pattern = '#s(\d+)\.\s(.*)(?:\n|$)#';
        preg_match_all($pattern, $text, $matches, PREG_OFFSET_CAPTURE);
        return $matches;
    }

    function get_pattern($open, $close=NULL){
        $pattern = '';
        $open = preg_quote($open);
        if ($close == NULL){
            $pattern = '#(?:\r|\n|^)' . $open . '(.*?)' . $open . '(\r|\n|$)?+#s';
        }else{
            $close = preg_quote($close);
            $pattern = '#(?:\r|\n|^)' . $open . '(.*?)' . $close . '(\r|\n|$)?+#s';
        }
      return $pattern;
    }

    function markup_element($part){
        $html = Markdown($part);
        //remove the surrounding p tags
        return trim(preg_replace('#^\<p>|<\/p>$#s', '', $html));
    }

    function vardump($var){
        print('<pre>');
        var_dump($var);
        print('</pre>');
    }
?>
