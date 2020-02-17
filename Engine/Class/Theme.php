<?php
  class Theme
  {
    private $Name;
    private $Path;

    private $Variables;
    private $Templates;

    public function __construct($name)
    {
      $this->Name = $name;
      $this->GetPath();
    }

    public function GetPath()
    {
      if(!isset($this->Path)|$this->Path == '')
      {
        $possiblePaths = [
          GLOBAL_CWD . 'Display/Themes/' . $this->Name . '/',
          GLOBAL_CWD . 'Display/Themes/Default/'
        ];

        $templateFound = false;
        foreach($possiblePaths as $path)
        {
          if($templateFound == false && is_dir($path))
          {
            $this->Path = $path;
          }
        }
      }
      return $this->Path;
    }

    public function GetTemplate($name)
    {
      if(!isset($this->Templates[$name]))
      {
        $this->Templates[$name] = new Template($name, $this->Name);
        if(isset($this->Variables) && is_array($this->Variables))
        {
          $this->Templates[$name]->SetVariables($this->Variables);
        }
      }
      return $this->Templates[$name];
    }

    //higher tier (lower number) for theme variables
    public function SetVariable($find, $replace, $tier = 100)
    {
      if(isset($this->Templates) && is_array($this->Templates))
      {
        foreach($this->Templates as $template)
        {
          $template->SetVariable($find, $replace, $tier);
        }
      }
      $this->Variables[$tier][$find] = $replace;
    }
  }
?>