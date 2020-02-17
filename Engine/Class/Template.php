<?php
  class Template 
  {

    private $Name;
    private $Path;

    private $RawData;
    private $CompiledData;
    private $Variables;


    public function __construct($name, $themeName = '')
    {
      $this->Name = $name;
      if($themeName == '')
      {
        $this->ThemeName = 'Default';
      }
      else 
      {
        $this->ThemeName = $themeName;
      }
      $this->SetVariable('template[Name]', $this->Name);
      $this->SetVariable('template[Theme]', $this->ThemeName);
      $this->GetPath();
      $this->LoadRawData();
    }

    public function GetPath()
    {
      if(!isset($this->Path)|$this->Path == '')
      {
        $possiblePaths = [
          GLOBAL_CWD . 'Display/Themes/' . $this->ThemeName . '/' . $this->Name . '.html',
          GLOBAL_CWD . 'Display/Themes/Default/' . $this->Name . '.html',
          GLOBAL_CWD . 'Display/Themes/' . $this->ThemeName . '/templateNotFound.html',
          GLOBAL_CWD . 'Display/Themes/Default/templateNotFound.html',
        ];

        $templateFound = false;
        foreach($possiblePaths as $path)
        {
          if($templateFound == false && file_exists($path))
          {
            $this->Path = $path;
            $templateFound = true;
          }
        }
      }
      return $this->Path;
    }

    public function SetVariable($find, $replace, $tier = 1000)
    {
      $this->Variables[$tier][$find] = $replace;
    }
    public function SetVariables($array)
    {
      $this->Variables = array_merge($this->Variables, $array);
    }

    public function LoadRawData()
    {
      if(!isset($this->RawData)||$this->RawData == '')
      {
        $this->RefreshRawData();
      }
      return $this->RawData;
    }
    public function RefreshRawData()
    {
      $this->RawData = file_get_contents($this->Path);
      return $this->RawData;
    }

    public function GetOutput()
    {
      if(!isset($this->CompiledData)||$this->CompiledData == '')
      {
        $this->RefreshOutput();
      }
      return $this->CompiledData;
    }
    public function RefreshOutput()
    {
      $this->CompiledData = $this->LoadRawData();

      $findAndReplace = [];
      if(isset($this->Variables) && is_array($this->Variables))
      {
        foreach($this->Variables as $tier)
        {
          $findAndReplace = array_merge($findAndReplace, $tier);
        }
        foreach($findAndReplace as $key => $value)
        {
          $this->CompiledData = str_replace('{{$' . $key . '}}', $value, $this->CompiledData);
        }
      }

      return $this->CompiledData;
    }
  }
?>