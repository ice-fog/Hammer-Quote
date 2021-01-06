<?php

/**
 * Класс Template - Шаблонизатор
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

//error_reporting(0);

class Template {

    /**
     * Путь к директории с шаблонами
     * @var string
     */
    protected $dir;

    /**
     * Расширение шаблонов
     * @var string
     */
    protected $ext;

    /**
     * Строка для хранения вывода
     * @var string
     */
    protected $out;

    /**
     * Массив с путями к файлом шаблонов
     * @var array
     */
    protected $bloc = array();

    /**
     * Массив с собранами блоками
     * @var array
     */
    protected $var = array();

    /**
     * Конструктор
     * @param $dir - путь к директории с шаблонами
     * @param $ext - расширение файлов шаблонов
     */
    public function __construct($dir, $ext) {
        $this->dir = $dir;
        $this->ext = $ext;
    }

    /**
     * Установка базового шаблона
     * @param string $file - путь к файлу шаблона
     */
    public function main($file) {
        $this->out = file_get_contents($this->dir . $file . $this->ext);
    }

    /**
     * Возвращает массив для поиска
     * @return array
     */
    protected function getPatterns() {
        return array(
            '#%\s*function\s*(.*?)\s*%#',
            '#%\s*endfunction\s*%#',
            '#%\s*for\s*(.*?)\s*%#',
            '#%\s*endfor\s*%#',
            '#%\s*loop\s*(.*?)\s*%#',
            '#%\s*endloop\s*%#',
            '#%%\s*(.*?)\s*%%#',
            '#%\s*if\s*(.*?)\s*%#',
            '#%\s*elseif\s*(.*?)\s*%#',
            '#%\s*endif\s*%#',
            '#%\s*else\s*%#',
            '#%\s*php\s*(.*?)\s*%#'
        );
    }

    /**
     * Возвращает массив для замены
     * @return array
     */
    protected function getReplace() {
        return array(
            '<?php function \\1{?>' . PHP_EOL,
            '<?php } ?>' . PHP_EOL,
            '<?php for \\1{?>' . PHP_EOL,
            '<?php } ?>' . PHP_EOL,
            '<?php foreach(\\1):?>' . PHP_EOL,
            '<?php endforeach;?>' . PHP_EOL,
            '<?php echo \\1;?>' . PHP_EOL,
            '<?php if(\\1):?>' . PHP_EOL,
            '<?php elseif(\\1):?>' . PHP_EOL,
            '<?php endif;?>' . PHP_EOL,
            '<?php else:?>' . PHP_EOL,
            '<?php \\1;?>' . PHP_EOL
        );
    }

    /**
     * Выполняет поиск и замену по регулярному выражению
     * @param string $source - cтрока для замены
     * @return string
     */
    protected function replace($source) {
        return preg_replace($this->getPatterns(), $this->getReplace(), $source);
    }

    /**
     * Выполняет сборку шаблона
     * @param string $source - cтрока для замены
     * @param string $file - путь к файлу шаблона выводится при ошибки
     * @param array $data - массив с данными для подстановки
     * @return string
     */
    protected function compile($source, $file, $data = array()) {
        ob_start();
        if(!is_null(eval('?>' . $this->replace($source) . '<?'))) {
            $error = error_get_last();
            echo $file . $this->ext . ':  ' . $error['message'] . ' line:' . $error['line'];
        }
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    /**
     * Возвращает содержимое файла шаблона
     * @param string $file - путь к файлу шаблона
     * @return string
     */
    public function get($file) {
        return file_get_contents($this->dir . $file . $this->ext);
    }

    /**
     * Собирает и помещает блок в массив с собранными блоками
     * @param string $bloc - строка с именем блока
     * @param string $file - путь к файлу шаблона
     * @param array $data - массив с данными для подстановки
     */
    public function bloc($bloc, $file, $data = array()) {
        $this->var[$bloc] = $this->compile($this->get($file), $file, $data);
    }

    /**
     * Собирает и возвращает блок
     * @param string $file - путь к файлу шаблона
     * @param array $data - массив с данными для подстановки
     * @return string
     */
    public function compileBloc($file, $data = array()) {
        return $this->compile($this->get($file), $file, $data);
    }

    /**
     * Собирает и возвращает шаблон из строки
     * @param string $str шаблон
     * @param array $data - массив с данными для подстановки
     * @return string
     */
    public function compileStr($str, $data = array()) {
        return $this->compile($str, 'str', $data);
    }

    /**
     * Устанавливает пути к блокам
     * @param string $find - строка с именем блока
     * @param string $replace - путь к файлу шаблона
     */
    public function set($find, $replace) {
        $this->var[$find] = $replace;
    }

    /**
     * Собирает все воедино и выводит
     */
    public function out() {
        foreach($this->var as $find => $replace) {
            $this->out = str_replace($find, $replace, $this->out);
        }
        echo $this->out;
    }

}