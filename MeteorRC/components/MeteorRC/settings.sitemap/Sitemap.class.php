<?
class Sitemap {
  private $SiteUrl;
  //Приоритетность URL каждого объекта каталога
  public $priority = '0.9';
  //Периодичность посещения поисковой системой URL объектов каталога
  public $changefreq = 'weekly';
  //Нужно пинговать поисковики или нет.
  public $needPing = False;
  public $XMLsitemapTemplateName = 'sitemap_#IBLOCK#.#EXT#';
  public $iblock;
  // Флаг, существует ли файл sitemap.xml или нет
  private $XMLsitemapExist = false;
  // Полный путь до XML файла карты инфоблоков.
  public $XMLsitemapSaveFile;
  // Полный путь до XML файла полной карты сайта.
  public $XMLsitemapFull = '/sitemap.xml';
  // Флаг, существует ли файл sitemap.txt или нет
  private $TXTsitemapExist = false;
  // Полный путь до TXT файла карты сайта.
  public $TXTsitemapSaveFile;
  // Сюда будет происходить сохранение списка URL для
  // текстовой версии карты сайта
  private $TXTsitemapDump = '';
  // Сюда будем записывать массив объектов с URL для XML версии
  public $urlList;
  // Адрес, по которому пинговать Google, что карта сайта обновилась
  private $googlePingUrl;
  // Адрес, по которому пинговать Yahoo, что карта сайта обновилась
  private $yahooPingUrl;
  // Хранится полный URL до файла sitemap.xml
  private $sitemapFile;
  // Сюда будем создавать экземпляр класса DOMDocument
  private $dom;

  public function getIblockUrlList() {
    global $APPLICATION;
    // Данная функция получает из БД все ссылки объектов и пишет их в $this->urlList
    $arParams = $APPLICATION->GetComponentsParams($this->iblock["COMPONENT"], $this->iblock["IBLOCK"]);
    // Получаем все разделы
    $arResult["SECTIONS"] = $APPLICATION->GetElementForField("shop", 'sections', false, false);
    $arPatternElement =  array_filter(explode("/", $arParams["SEF_URL_TEMPLATES"]["SEF_URL_DETAIL"]));

    if(!isset($arParams["FILTER"]))
      $arParams["FILTER"] = array("ACTIVE" => "Y");
    $arElements = $APPLICATION->GetElementForField($this->iblock["COMPONENT"], $this->iblock["IBLOCK"], $arParams["FILTER"], false);
    // Генерируем ссылки на детальный просмотр товарам
    if(!empty($arElements)){
      foreach ($arElements as $key => $arElement) {
    foreach ($arPatternElement as $key => $value) {
        $otherParam = preg_replace ("/#(.*)#/" ,"", $value);
        $cleanParam = str_replace($otherParam, "", $value);
        $fulCleanParam = str_replace("#", "", $cleanParam);
        $fieldParams = explode("|", $fulCleanParam);
        if(count($fieldParams) > 1){
          $field = $fieldParams[0];
          $getField = $fieldParams[1];
          $arFieldParams = $arParams["FIELDS"][$field];
          $arComponentElements = $APPLICATION->GetElementForID($this->iblock["COMPONENT"], $arFieldParams["BD"], $arElement[$field]);
          $arUrlRewrite[$cleanParam] = $arComponentElements[$getField];
        }elseif(isset($arElement[$fulCleanParam]))
          $arUrlRewrite[$cleanParam] = $arElement[$fulCleanParam];
        }
        //p($arUrlRewrite);
        if($arUrlRewrite){
          $pageUrl = strtr($arParams["SEF_URL_TEMPLATES"]["SEF_URL_DETAIL"], $arUrlRewrite);
          $this->urlList[] = new SitemapUrl ($this->SiteUrl . $pageUrl,
          date('Y-m-dTH:i:sP', $arElement['ACTIVE_FROM']),
          $this->changefreq,
          $this->priority);
        }
      }
    }
    return count($this->urlList);
  }

  final function generate() {
    /*
    Главный метод класса Sitemap. Собвственно он и
    выполняет генерацию карты сайта с помощью DOMDocument.
    */
    // элемент <xml>, то создаем дочерний элемент <urlset>
    $root = $this->dom->appendChild($this->dom->createElement('urlset'));
    // Добавляем необходимые атрибуты.
    $root->setAttribute('xmlns','http://www.sitemaps.org/schemas/sitemap/0.9');
    $root->setAttribute('xmlns:xsi','http://www.w3.org/2001/XMLSchema-instance');
    $root->setAttribute('xsi:schemaLocation',
              'http://www.sitemaps.org/schemas/sitemap/0.9'.' '.
              'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');
    // Перебираем значения полученного массива и формируем XML
    for($i=0;$i<sizeof($this->urlList);$i++) {
     // Создаем узел <url>
      $url = $root->appendChild($this->dom->createElement('url'));
      // Создаем дочерний узел <loc> и заполняем его информацией.
      $url->appendChild($this->dom->createElement('loc', $this->urlList[$i]->getLoc()));
      // Создаем дочерний узел <lastmod> и заполняем его информацией.
      $url->appendChild($this->dom->createElement('lastmod', $this->urlList[$i]->getLastmod()));
      // Создаем дочерний узел <changefreq> и заполняем его информацией.
      $url->appendChild($this->dom->createElement('changefreq',
                                    $this->urlList[$i]->getChangefreq()));
      // Создаем дочерний узел <priority> и заполняем его информацией.
      $url->appendChild($this->dom->createElement('priority', $this->urlList[$i]->getPriority()));
      // Так же создаем список URL для текстовой версии карты сайта.
      $this->TXTsitemapDump .= $this->urlList[$i]->getLoc()."\n";
 
    }
    // Если файл sitemap.xml существует, то удаляем его.
    if($this->XMLsitemapExist) {
      unlink($this->XMLsitemapSaveFile);
    }
    // Сохраняем сгенерированные XML данные в файл sitemap.xml
    $this->dom->save($this->XMLsitemapSaveFile);
    // Сохраняем сгенерированные TXT данные в файл sitemap.txt
    // Если файл sitemap.txt существует, он будет удален и создан новый.
    fwrite(fopen($this->TXTsitemapSaveFile,"w-"), $this->TXTsitemapDump);
    // Если требуется пинговка поисковиков, то выполняем.
    if($this->needPing) {
      $this->pingGoogle();
      $this->pingYahoo();
    }
  }
  final function GenerateSitemapIndex($iblockList) {
    unset($root);
    $root = $this->dom->appendChild($this->dom->createElement('sitemapindex'));
    // Добавляем необходимые атрибуты.
    $root->setAttribute('xmlns','http://www.sitemaps.org/schemas/sitemap/0.9');
    $sitemap = $root->appendChild($this->dom->createElement('sitemap'));
      foreach ($iblockList as $id => $iblock) {
      $XMLsitemapFile = strtr(
        $this->XMLsitemapTemplateName, 
        array(
          "#IBLOCK#" => $iblock["IBLOCK"],
          "#EXT#" => "xml",
        )
      );
      $sitemap->appendChild($this->dom->createElement('loc', $this->SiteUrl . $XMLsitemapFile));
      $sitemap->appendChild($this->dom->createElement('lastmod', date('Y-m-dTH:i:sP', time())));
      $sitemap = $root->appendChild($this->dom->createElement('sitemap'));
    }
    $this->dom->save($_SERVER["DOCUMENT_ROOT"] . $this->XMLsitemapFull);
    return $this->SiteUrl . $this->XMLsitemapFull;
  }
  final function pingGoogle() {
    //Метод, выполняющий пинг Google, о том, что карта сайта обновилась
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->googlePingUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
  }

  final function pingYahoo() {
    //Метод, выполняющий пинг Yahoo, о том, что карта сайта обновилась
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->yahooPingUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
 }
  final function CheckSitemapExist(){
    $this->XMLsitemapSaveFile = $_SERVER["DOCUMENT_ROOT"] . strtr(
      $this->XMLsitemapTemplateName, 
      array(
        "#IBLOCK#" => $this->iblock["IBLOCK"],
        "#EXT#" => "xml",
      )
    );
    $this->TXTsitemapSaveFile = $_SERVER["DOCUMENT_ROOT"] . strtr(
      $this->XMLsitemapTemplateName, 
      array(
        "#IBLOCK#" => $this->iblock["IBLOCK"],
        "#EXT#" => "txt",
      )
    );
    // Проверяем, существует ли уже файл sitemap.xml
    $this->XMLsitemapExist = file_exists($this->XMLsitemapFile);

    // Проверяем, существует ли уже файл sitemap.txt
    $this->TXTsitemapExist = file_exists($this->TXTsitemapSaveFile);
  }

  final function __construct() {

    $this->SiteUrl = 'http://'.$_SERVER['HTTP_HOST'];
    // Производим инициализацию объектов. Объявляем переменные окружения класса.
    // Объявляем URL до файла sitemap.xml
    $this->XMLsitemapFile = 'http://'.$_SERVER['HTTP_HOST'].'/sitemap.xml';
    // Объявляем URL по которому пинговать Google
    $this->googlePingUrl = 'http://www.google.com/webmasters/sitemaps/'. 'ping?sitemap=';
    $this->googlePingUrl .= urlencode($this->XMLsitemapFile);
    // Объявляем URL по которому пинговать Yahoo
    $this->yahooPingUrl = 'http://search.yahooapis.com/SiteExplorerService/V1/' . 'ping?sitemap=';
    $this->yahooPingUrl .= urlencode($this->XMLsitemapFile);
    // Создаем объект класса DOMDocument
    $this->dom = new DOMDocument('1.0','UTF-8');
    $this->dom->formatOutput = true;
  }

}