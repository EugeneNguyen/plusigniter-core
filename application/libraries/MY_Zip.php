<?php
class MY_Zip extends CI_Zip {
	function is_dir_empty($dir) {
		if (!is_readable($dir))
			return NULL;
		$handle = opendir($dir);
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				return FALSE;
			}
		}
		return TRUE;
	}
	
	function read_dir($path, $preserve_filepath = TRUE, $root_path = NULL)
	{
		if ( ! $fp = @opendir($path))
		{
			return FALSE;
		}

		// Set the original directory root for child dir's to use as relative
		if ($root_path === NULL)
		{
			$root_path = dirname($path).'/';
		}

		while (FALSE !== ($file = readdir($fp)))
		{
			if (substr($file, 0, 1) == '.')
			{
				if ($this->is_dir_empty($path))
				{
					$this->add_dir(str_replace("/libre_assets/modulemanagement/credential", "", $path));
				}
				continue;
			}

			if (@is_dir($path.$file))
			{
				$this->read_dir($path.$file."/", $preserve_filepath, $root_path);
			}
			else
			{
				if (FALSE !== ($data = file_get_contents($path.$file)))
				{
					$name = str_replace("\\", "/", $path);

					if ($preserve_filepath === FALSE)
					{
						$name = str_replace($root_path, '', $name);
					}

					$this->add_data($name.$file, $data);
				}
			}
		}

		return TRUE;
	}
}
