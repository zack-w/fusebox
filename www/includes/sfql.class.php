<?php
/*
  Copyright Slidefuse Networks 2012
  Revised by: Patrick Hampson
  Author: Spencer Sharkey (spencer@sf-n.com)
*/

class SFQL {
  protected $sHost, $sUsername, $sPassword, $sDatabase;
  
  public $oCon;

  public static $VERSION = "1.0";
  
  private $bDebug = true;
  
  private $sBuffer = "";
  
  public $error = false;
  
  //A function called whent the Class is constructed.
  public function __construct($sHost, $sUser, $sPass, $sDB) {
    $this->sHost = $sHost;
    $this->sUsername = $sUser;
    $this->sPassword = $sPass;
    $this->sDatabase = $sDB;
    if (!$this->connect()) {
      $this->error = "Could not connect to database.";
      return false;
    }
  }
  
  //A function to return the version.
  public function getVersion() {
    return self::VERSION;
  }
  
  //A function called to set the debug on or off.
  public function setDebug($bToggle) {
    if ($bToggle === false or $bToggle === true) {
      $this->bDebug = $bToggle;
    } else {
      return false;
    }
  }
  
  //A function called to determine if debug mode is on.
  private function isDebug() {
    return $this->bDebug;
  }
  
  //A private function to connect to the database.
  private function connect() {
    $this->oCon = mysql_connect($this->sHost, $this->sUsername, $this->sPassword);
    if ($this->oCon) {
      return mysql_select_db($this->sDatabase, $this->oCon);
    } else {
      return false;
    }
  }
  
  //A function called to get the exception of the last MySQL call. If debug is on it'll automatically print it.
  public function getException() {
    $sError = mysql_error($this->oCon);
    if ($this->isDebug() AND $sError != "") { 
      echo '<div style="background: #C00; color: white; padding: 3px; margin: 5px; border: 2px solid #800;"><span style="color: #FCC; font-weight: bold;">SFQL Error!</span><br><span style="font-size: 10pt;">'.$sError.'</span><br><span style="color: #9F9">'.$this->sBuffer.'</span></div>';
    }
	$this->error = $sError;
    return $sError or null;
  }
  
  //A function to run a clean query.
  public function query($sQuery) {
    $this->sBuffer = $sQuery;
    $mQuery = mysql_query($sQuery, $this->oCon);
    if (!$mQuery) {
      if ($this->isDebug()) {
        $this->getException();
      }
      return false;
    }
    return $mQuery;
  }
  
  //A function to return the amount of rows from a mysql query.
  public function countRows($sQuery) {
    $mysqlQuery = $this->query($sQuery);
    if ($mysqlQuery) {
      return mysql_num_rows($mysqlQuery);
    } else {
      return false;
    }
  }
  
  //A function to take a query, and get all the results.
  public function queryArray($sQuery, $returnNumber = false, $assoc = false) {
    $mysqlQuery = $this->query($sQuery);
    if ($mysqlQuery) {
      $oList = array();
      $i = 0;
      if(!$assoc)
      {
        while ($rowData = mysql_fetch_array($mysqlQuery)) {
          $oList[$i] = $rowData;
          $i++;
        }
      } else {
        while ($rowData = mysql_fetch_assoc($mysqlQuery)) {
          $oList[$i] = $rowData;
          $i++;
        }
      }
      
      if (!$returnNumber) {
        return $oList;
      } else {
        return array($oList, $i);
      }
    } else {
      return false;
    }
  }
  
  //A function to take a query, and get the first result.
  public function queryRow($sQuery) {
    $mysqlQuery = $this->query($sQuery);
    if ($mysqlQuery) {
      $oList = array();
      $i = 0;
      while ($rowData = mysql_fetch_array($mysqlQuery)) {
        $oList[$i] = $rowData;
        $i++;
      }
      
      if ($i > 1) {
		$this->error = "More than one row.";
        if ($this->isDebug()) {
          echo "<br><b>SFQL Error!</b> More than one row!<br>";
        }
        return false;
      } else {
        if ($i > 0) {
          return $oList[0];
        } else {
          return false;
        }
      }
    } else {
      return false;
    }
  }
  
  public function escape($str, $strip = true) {
	if ($strip) { $str = strip_tags($str); }
	$str = mysql_real_escape_string($str);
	return $str;
  }
    
}