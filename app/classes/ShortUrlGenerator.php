<?php
/**
 * Created by PhpStorm.
 * User: felix_fox
 * Date: 2019-01-25
 * Time: 21:16
 */

namespace App\Classes;
use App\Model\Minimizer;
use Config;

class ShortUrlGenerator
{
    const DEFAULT_MIN_LEN_URL = 3;
    const DEFAULT_NAME = 'default';
    private $name;
    private $alphabet;
    private $characters;
    private $first;
    protected static $instances = [];

    protected function __construct(string $name, array $alphabet, int $minLenUrl = self::DEFAULT_MIN_LEN_URL, int $characters = 0)
    {
        $this->name       = $name ? $name : self::DEFAULT_NAME;
        $this->alphabet   = $alphabet;
        $this->first      = str_repeat($this->alphabet[0], $minLenUrl);
        $characters ? $this->characters = $characters : $this->characters = count($alphabet);
    }

    /**
     * @param string $name
     * @param int $minLenUrl
     * @param int $characters
     * @return ShortUrlGenerator
     */
    public static function forge(string $name = '', int $minLenUrl = self::DEFAULT_MIN_LEN_URL, int $characters = 0): ShortUrlGenerator //The forge returns a new event object.
    {
        if (array_key_exists($name, static::$instances)){
            throw new \DomainException('ShortUrlGenerator instance already exists, cannot be recreated. Use instance() instead of forge() to retrieve the existing instance.');
        }
        if($name == self::DEFAULT_NAME || !$name){
//            if($alphabet){
//                throw new \DomainException('If you use default instance and you must use default alphabet. Use empty array');
//            }
//            die();
            $alphabet = Config::get('alphabet.' . self::DEFAULT_NAME);
//            var_dump(Config::get('app.cipher'));
//die();
//            $alphabet = \Config::get('shorturlgenerator.alphabet');
//        }elseif(empty($alphabet)){
        }else{
            $alphabet = Config::get('alphabet.'.$name);
//            throw new \DomainException('ShortUrlGenerator must have alphabet');
        }
        return static::$instances[$name] = new static($name, $alphabet, $minLenUrl, $characters);
    }

    /**
     * @param string $name
     * @param int $minLenUrl
     * @param int $characters
     * @return ShortUrlGenerator
     */
    public static function instance(string $name = '', int $minLenUrl = self::DEFAULT_MIN_LEN_URL, int $characters = 0): ShortUrlGenerator //The instance returns a new event object singleton.
    {
        if (!array_key_exists($name, static::$instances)){
            self::forge($name, $minLenUrl, $characters);
        }
        return static::$instances[$name];
    }

    public function decimalToCharSystemCharacters(int $int): string
    {
        $start = $int;
        while($start >= $this->characters) {
            $result[] = $start % $this->characters;
            $start = intdiv($start,$this->characters);
        }
        $result[] = $start;
        $return = '';
        foreach (array_reverse($result) as $item) {
            $return .= $this->alphabet[$item];
        }
        return $return;
    }

    public function CharSystemCharactersToDecimal(string $str): int
    {
        $return = 0;
        foreach(array_reverse(str_split($str)) as $key => $item){
            $return += array_search($item, $this->alphabet) * pow($this->characters, $key);
        }
        return $return;
    }

    public function CharSystemCharactersIncrement(string $str): string
    {
        $return = '';
        foreach(array_reverse(str_split($str)) as $key => $item){
            if(array_search($item, $this->alphabet) < ($this->characters - 1)){
                $return .= $this->alphabet[array_search($item, $this->alphabet) + 1];
                break;
            }
            $return .= $this->alphabet[0];
        }
        if($return[$key] == $this->alphabet[0]){
            $return .= $this->alphabet[1];
        }
        return substr($str, 0, strlen($str) - ($key + 1)) . strrev($return);
    }

    public function getNext($generatedUrl)
    {
        $lastGeneratedUrl = $this->CharSystemCharactersIncrement($generatedUrl);
        while(Minimizer::checkNext($lastGeneratedUrl, $this->name)){
            $lastGeneratedUrl = $this->CharSystemCharactersIncrement($lastGeneratedUrl);
        }
        return $lastGeneratedUrl;
    }

    protected function checkGenerateUrlByRoutesPatterns($generateUrl, array $patterns): bool
    {
        foreach ($patterns as $pattern){
            if(preg_match($pattern, $generateUrl)){
                return true;
            }
        }
        return false;
    }

    public function addGetShortUrlByOriginalUrl(string $url, array $patterns = [])
    {
        $last = Minimizer::findMaxId($this->name);
//        var_dump($last); die();
        if(isset($last->generatedUrl)){
            if($exist = Minimizer::exist($url, $this->name)){
//                var_dump($exist);die();
                return $exist->generatedUrl;
            }
            $lastGeneratedUrl = $this->getNext($last->generatedUrl);
        }else{
            $lastGeneratedUrl = $this->first;
        }
        if($patterns){
            while($this->checkGenerateUrlByRoutesPatterns($lastGeneratedUrl, $patterns)){
                $lastGeneratedUrl = $this->getNext($lastGeneratedUrl);
            }
        }
        if(Minimizer::add($url, $lastGeneratedUrl, $this->name)){
            return $lastGeneratedUrl;
        }else{
            return false;
        }
    }

    public function getOriginUrl(string $generatedUrl)
    {
        $shortUrl = Minimizer::checkNext($generatedUrl, $this->name);
        Minimizer::updateUrl($shortUrl->id, ['viewed'=>$shortUrl->viewed+1]);
        return $shortUrl;
    }
}
