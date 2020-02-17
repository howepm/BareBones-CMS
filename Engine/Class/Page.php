<?php
  class Page
  {

    private $Config;

    private $Theme;
    private $Database;

    private $Module;

    public function __construct($config)
    {
      $this->Config = $config;

      $this->ConnectToDatabase();

      $this->DecodeURL();

      $this->Theme = new Theme($this->Config['Display']['Theme']);

      $this->Theme->SetVariable('SITE_ROOT', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/');
      $this->Theme->SetVariable('THEME_ROOT', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/Display/Themes/' . $this->Config['Display']['Theme'] . '/');
    }

    public function ConnectToDatabase()
    {
      $this->Database = new MySQLiDB(
          $this->Config['Database']['Host'],
          $this->Config['Database']['Username'],
          $this->Config['Database']['Password'],
          $this->Config['Database']['Database'],
          $this->Config['Database']['Port']
      );
    }

    public function GetOutput()
    {
      $pageSkeleton = $this->Theme->GetTemplate('skeleton');
      $pageSkeleton->SetVariable('pageContent', $this->Module->GetOutput());
      return $pageSkeleton->GetOutput();
    }

    private function DecodeURL()
    {
      if(isset($_GET['module']))
      {
        if(is_dir(GLOBAL_CWD . 'Engine/Modules/' . $_GET['module'] . '/'))
        {
          $this->Module = new Module($_GET['module'], $this->Database);
        }
        else 
        {
          $this->Module = new Module('ModuleNotFound', $this->Database);
        }
      }
      else 
      {
        $this->Module = new Module($this->Config['Modules']['HomeModule'], $this->Database);
      }
    }
  }
?>