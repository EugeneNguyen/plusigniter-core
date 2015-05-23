<?php
  	$language = array();

  	function LocalizedString($key, $screen = "default")
  	{
    	global $language;
		$CI = &get_instance();
		$CI->load->model('pluslocalization/pluslocalization_language');
    	if (count($language) == 0)
    	{
      		$lang = $CI->pluslocalization_language->get_by_attribute();
      		foreach ($lang as $l)
      		{
        		$language[] = $l;
      		}
    	}
    	
		// get primary language
		$CI->load->model('pluslocalization/pluslocalization_supported');
		$primary = $CI->pluslocalization_supported->get_by_attribute(array('is_primary' => 1));
		if ($primary === FALSE)
		{
			$primary = "en";
		}
		else
		{
			$primary = $primary[0]->name;
		}
		if (!is_array($language)) $language = array();
    	$l = ($lang = $CI->session->userdata('site_language')) ? $lang : $primary;
    	foreach ($language as $item)
    	{
      		if (strtolower($item->screen) == strtolower($screen))
      		{
        		if (strtolower($item->keyname) == strtolower($key))
        		{
          			return $item->$l;
        		}
      		}
    	}
		$CI->pluslocalization_language->add_new_word($key, $screen);
		// $CI->load->controller('pluslocalization/add_new_word', array('key'=>$key, 'screen'=>$screen));
    	return $key;
  	}

  	function html($tag, $content, $class = array())
  	{
    	$string = "";
    	$keys = array_keys($class);
    	foreach ($keys as $key)
    	{
      		$string.= " $key=\"$class[$key]\"";
    	}
    	return "<$tag $string>$content</$tag>";
  	}

  function highslide_anchor ($link, $title, $attribute = array())
  {
  	$attr = array(
            	"href" => base_url($link),
            	"data-toggle" => "modal",
            	"data-target" => "#modal",
            	"role"=>"button"
          	);
    $attr+= $attribute;
    return html("a", $title, $attr);
  }

  function bootstrap_anchor ($link, $title, $attribute = array())
  {
    $attr = array('href' => base_url($link));
    $attr+= $attribute;
    return html("a", $title, $attr);
  }

  function js_css_tag ($array = array(), $type = 0)
  {
    $html = "";
    foreach ($array as $a)
    {
      $html.= ($type == 0) ? link_tag($a) : html("script", "", array("src" => base_url($a),"type" => "text/javascript"));
    }
    return $html;
  }

  function load ($file, $params = null, $check = false)
  {
    return get_instance()->load->view($file, $params, $check);
  }

  function libre_form($data, $path = "libre_elements/form")
  {
    $CI =& get_instance();
    return $CI->load->view($path, $data, TRUE);
  }

  function libre_table($data, $path = "libre_elements/table")
  {
    $CI =& get_instance();
    return $CI->load->view($path, $data, TRUE);
  }

  function item ($type, $title = "", $name, $items = array(), $value = "", $id = null, $choice = null, $placeholder = "&nbsp;", $disabled = false, $listchecked = array(), $class = '')
  {
    return array(
      "type" => $type,
      "title"=> $title,
      "name" => $name,
      "items"=> $items,
      "value"=> $value,
      "id" => $id,
      "choice"=> $choice,
      "placeholder" => $placeholder,
      "disabled" => $disabled,
      "listchecked" => $listchecked,
      "class" => $class,
    );
  }

  function ats ($array)
  {
    $txt = "";
    foreach ($array as $key => $value)
    {
        $txt.= "$key=$value ";
    }
    return $txt;
  }
