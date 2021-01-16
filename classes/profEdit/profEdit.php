<?php
  namespace classes\profEdit;
  use classes\etc\etc;
  use classes\validate\validation;

  class profEdit extends validation{

    protected $userName;
    protected $age;
    protected $tel;
    protected $zip;
    protected $addr;
    protected $profImg;

    public function __construct($userName,$age,$tel,$zip,$addr,$profImg){
      $this->userName=$userName;
      $this->age=$age;
      $this->tel=$tel;
      $this->zip=$zip;
      $this->addr=$addr;
      $this->profImg=$profImg;
    }

    // =======setter関数=======

    // =======getter関数=======
    public function getUserName(){
      return $this->userName;
    }

    public function getAge(){
      return $this->age;
    }

    public function getTel(){
      return $this->tel;
    }

    public function getZip(){
      return $this->zip;
    }

    public function getAddr(){
      return $this->addr;
    }

    public function getProfImg(){
      return $this->profEdit;
    }
  }
?>