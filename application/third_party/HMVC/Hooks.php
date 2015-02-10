<?php
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class HMVC_Hooks extends CI_Hooks 
{
    /**
     * Initialize the Hooks Preferences
     *
     * @access  private
     * @return  void
     */
    function _initialize()
    {
        $CFG =& load_class('Config', 'core');
        // If hooks are not enabled in the config file
        // there is nothing else to do
        if ($CFG->item('enable_hooks') == FALSE)
        {
            return;
        }
        // Grab the "hooks" definition file.
        // If there are no hooks, we're done.
       if (defined('ENVIRONMENT') AND is_file(APPPATH.'config/'.ENVIRONMENT.'/hooks.php'))
        {
            include(APPPATH.'config/'.ENVIRONMENT.'/hooks.php');
        }
        elseif (is_file(APPPATH.'config/hooks.php'))
        {
            include(APPPATH.'config/hooks.php');
       }
         $path = APPPATH . 'modules/';
         $modules = $this->directory_map($path, 3);
          foreach ($modules as $key => $value) {
                if (is_file(APPPATH."modules/{$key}/config/hooks.php")){
                    include(APPPATH."modules/{$key}/config/hooks.php");
                }

        }
        if ( ! isset($hook) OR ! is_array($hook))
        {
            return;
        }
   
        $this->hooks =& $hook;
        $this->enabled = TRUE;
  
    }
    public function directory_map($source_dir, $directory_depth = 0, $hidden = FALSE)
    {
        if ($fp = @opendir($source_dir))
        {
            $filedata   = array();
            $new_depth  = $directory_depth - 1;
            $source_dir = rtrim($source_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

            while (FALSE !== ($file = readdir($fp)))
            {
                // Remove '.', '..', and hidden files [optional]
                if ( ! trim($file, '.') OR ($hidden == FALSE && $file[0] == '.'))
                {
                    continue;
                }

                if (($directory_depth < 1 OR $new_depth > 0) && @is_dir($source_dir.$file))
                {
                    $filedata[$file] = $this->directory_map($source_dir.$file.DIRECTORY_SEPARATOR, $new_depth, $hidden);
                }
                else
                {
                    $filedata[] = $file;
                }
            }

            closedir($fp);
            return $filedata;
        }

        return FALSE;
    }
	
	function get_hook ($which)
	{
		return $this->hooks[$which];
	}
} 