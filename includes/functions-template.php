<?php
/**
*
* @package reader
* @version $Id$
* @copyright Copyright (c) 2013, Firat Akandere
* @author Firat Akandere <f.akandere@gmail.com>
* @license http://opensource.org/licenses/GPL-3.0 GNU Public License, version 3
*
*/

/**
* @ignore
*/
if (!defined('IN_MANGAREADER'))
{
    exit;
}

function get_footer($name = null)
{
    if (isset($name))
    {
        locate_template("footer-{$name}.php", true);
    }
    else
    {
        locate_template('footer.php', true);
    }
    page_footer();
}

function get_header($name = null)
{
    page_header();
    if (isset($name))
    {
        locate_template("header-{$name}.php", true);
    }
    else
    {
        locate_template('header.php', true);
    }
}

function get_sidebar($name = null)
{
    if (isset($name))
    {
        locate_template("sidebar-{$name}.php", true);
    }
    else
    {
        locate_template('sidebar.php', true);
    }
}

function is_logged_in()
{
    global $user;
    return ($user->data['user_id'] != ANONYMOUS);
}

function get_user_data($data, $return = false)
{
    global $user;

    if (!isset($user->data[$data]))
    {
        if ($return)
        {
            return false;
        }

        echo '{ NONE }';
    }
    else
    {
        if ($return)
        {
            return $user->data[$data];
        }

        echo $user->data[$data];
    }
}

function get_current_template_path()
{
    global $user, $mangareader_root_path;
    return $mangareader_root_path . 'templates/' . $user->data['template_path'];
}

function locate_template($template_names, $load = false, $require_once = true)
{
    $current_template_path = get_current_template_path();

    $located = '';
    foreach ((array) $template_names as $template_name)
    {
        if (!$template_name)
        {
            continue;
        }
        if (file_exists($current_template_path . '/' . $template_name))
        {
            $located = $current_template_path . '/' . $template_name;
            break;
        }
    }

    if ($load && $located != '')
    {
        load_template($located, $require_once);
    }

    return $located;
}

function load_template($_template_file, $require_once = true)
{
    /**
    * @todo Lots of global variables come here
    */
    global $cache, $config, $data, $error, $user;

    if ($require_once)
    {
        require_once($_template_file);
    }
    else
    {
        require($_template_file);
    }
}

function get_timezonelist($selected_value = '', $return = false, $atts = array())
{
    $attributes = '';
    if (sizeof($atts))
    {
        foreach ($atts as $key => $value)
        {
            $attributes .= ' ' . $key . '="' . $value . '"';
        }
    }
    $output = '<select' . $attributes . ' name="tz">';
    $timezones = __('timezones');

    foreach ($timezones as $value => $timezone)
    {
        $selected = ($selected_value == $value) ? ' selected="selected"' : '';
        $output .= '<option title="' . $timezone . '" value="' . $value . '"' . $selected . '>' . $timezone . '</option>';
    }
    $output .= '</select>';

    if ($return)
    {
        return $output;
    }

    echo $output;
}

function get_charset($return = false)
{
    /**
    * @todo here
    */
    if ($return)
    {
        return __('CHARSET');
    }

    _e('CHARSET');
}

function get_template_directory_uri($return = false)
{
    global $user;
    $uri = generate_url('templates/' . $user->data['template_path']);
    if ($return)
    {
        return $uri;
    }
    echo $uri;
}

function get_home_uri($return = false)
{
    $url = generate_url('', '');

    if ($return)
    {
        return $url;
    }
    echo $url;
}

function get_login_uri($return = false)
{
    $url = generate_url('ucp.php?mode=login', 'user/login/');

    if ($return)
    {
        return $url;
    }

    echo $url;
}

function get_logout_uri($return = false)
{
    $url = generate_url('ucp.php?mode=logout', 'user/logout/');

    if ($return)
    {
        return $url;
    }

    echo $url;
}

function get_register_uri($return = false)
{
    $url = generate_url('ucp.php?mode=register', 'user/register/');

    if ($return)
    {
        return $url;
    }

    echo $url;
}

function language_attributes()
{
    echo '';
    /**
    * @todo here
    */
}

function mr_title()
{
    /**
    * @todo here
    */
    echo '';
}

function mr_head()
{
    do_action('mr_head');
}

function mr_footer()
{
    do_action('mr_footer');
}



// Admin Panel Functions
function get_admin_footer()
{
    locate_admin_template('footer.php', true);
    page_footer();
}

function get_admin_header()
{
    page_header();

    locate_admin_template('header.php', true);
}

function get_admin_sidebar()
{
    locate_admin_template('sidebar.php', true);
}

function get_admin_template_directory_uri($return = false)
{
    global $user;
    $uri = generate_url('adm/style');
    if ($return)
    {
        return $uri;
    }
    echo $uri;
}

function locate_admin_template($template_names, $load = false, $require_once = true)
{
    global $mangareader_root_path;
    $current_admin_template_path = $mangareader_root_path . 'adm/style';

    $located = '';

    foreach ((array) $template_names as $template_name)
    {
        if (!$template_name)
        {
            continue;
        }
        if (file_exists($current_admin_template_path . '/' . $template_name))
        {
            $located = $current_admin_template_path . '/' . $template_name;
            break;
        }
    }

    if ($load && $located != '')
    {
        load_template($located, $require_once);
    }

    return $located;
}
?>
