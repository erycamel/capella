<?php

class XmlMenu extends CComponent
{
	private $data_raw;
	private $data;

	public function __construct($filename)
	{
      $this->load($filename);
	}

	private function getDataArray($val)
	{
      $url = array();
      $label = '';
      $visible = true;

      foreach($val as $key=>$raw)
      {
          switch($key)
          {
              case 'items':
                  foreach($raw as $dd)
                  {
                      $items[] = $this->getDataArray($dd);
                  }
                  break;
              case 'url':
                  eval('$url='.$raw);
                  break;
              case 'label':
                  eval('$label='.$raw);
                  break;
              case 'visible':
                  eval('$visible='.$raw);
                  break;
          }
      }
//      $menuaccess = Menuaccess::model()->findbysql("select * from menuaccess where upper(description) = upper('". $label."')");
//      if ($menuaccess != null)
//      {
//        $label = $menuaccess->description.' - '.$menuaccess->menucode;
//        $url = $menuaccess->menuurl;
//      }
      $res = array('label' => $label, 'url' => $url, 'visible' => $visible);
      if (isset($items)) $res['items'] = $items;
      return $res;
	}
	public function load($filename)
	{
      try
      {
        $this->data_raw = simplexml_load_file($filename);
      }
      catch(Exception $e)
      {
          echo $e;
          die();
      }
      foreach($this->data_raw as $data)
      {
          $this->data[] = $this->getDataArray($data);
      }
	}

	public function getData()
	{
		return $this->data;
	}
}