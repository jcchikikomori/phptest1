<?php

/**
* View Class
*/
class View
{

    /** render views (beta) **/
    public function render($view, $data = null, $type = null)
    {
        include_once ( empty($type) ? 'view/header.php' : 'view/' . $this->type . '.php' );
        include_once $view;
        include_once ( empty($type) ? 'view/header.php' : 'view/' . $this->type . '.php' );
    }

    public static function loadFeedback($feedback)
    {
        foreach ($feedback as $fb) {
            echo '<p class="no-print">'.$fb.'</p>';
        }
    }
}

