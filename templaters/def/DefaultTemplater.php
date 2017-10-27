<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 24.10.2017
 * Time: 16:44
 */

namespace webivan\seomodule\templaters\def;

use webivan\seomodule\templaters\Templater;
use webivan\seomodule\templaters\ITemplater;
use webivan\seomodule\helpers\Text;

class DefaultTemplater extends Templater implements ITemplater
{
    /**
     * @property string
     */
    protected $regex = '@\{\{\s?([A-z]+)(\sdec=\[([A-zА-я0-9\,\_\-\s]+)\])?(\selse=\[([A-zА-я0-9\,\_\-\s]*)\])?(\smask=\[([^\]]*)\])?[^\}]*\}\}@isu';

    /**
     * @inheritdoc
     */
    public function parseText($text, $key)
    {
        return preg_replace_callback($this->regex, function($matches) use ($key) {

            if (array_key_exists($matches[1], $this->data)) {

                if (empty($this->data[$matches[1]]) && !empty($matches[4])) {
                    return empty($matches[5]) ? '' : $matches[5];
                } else {
                    $result = $this->data[$matches[1]]. (!empty($matches[3])
                        ? ' ' . Text::declensionWords($this->data[$matches[1]], explode(',', $matches[3]))
                        : null);

                    $text = !empty($matches[7]) ? str_replace('$$', $result, $matches[7]) : $result;

                    if (preg_match($this->regex, $text)) {
                        $text = $this->parseText($text, $key);
                    }

                    return $text;
                }
            }

            return null;
        }, $text);
    }
}