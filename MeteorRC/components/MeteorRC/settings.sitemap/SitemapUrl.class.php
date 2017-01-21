<?
class SitemapUrl{
  private $loc;
  private $lastmod;
  private $changefreq;
  private $priority;

  final function __construct($loc,$lastmod,$changefreq,$priority){

    $this->loc = $loc;
    unset ($loc);

    // Допустим функция algoritm($lastmod) производит преобразование
    // даты из формата БД в нужный нам формат.
    $this->lastmod = $lastmod;	
    unset ($lastmod);
    // Теперь значение даты будет храниться в таком виде, в каком нам нужно.

    $this->changefreq = $changefreq;
    unset ($changefreq);

    $this->priority = $priority;
    unset ($priority);
		
  }
	
  final function getLoc(){
    return $this->loc;
  }

  final function getLastmod(){
    return $this->lastmod;
  }

  final function getChangefreq(){
    return $this->changefreq;
  }

  final function getPriority(){
    return $this->priority;
  }
}