<?php

/**
 * @version    1.0.0
 * @package    contentplugdemo (plugin)
 * @author     Kevin Olson - kevinsguides.com
 * @copyright  Copyright (c) 2022 Kevin Olson
 * @license    GNU/GPL license: https://www.gnu.org/copyleft/gpl.html
 */
//kill direct access
defined('_JEXEC') || die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;


class PlgContentUnoDemo extends CMSPlugin
{

    public function onContentPrepare($context, &$article, &$params, $page = 0)
    {
        //getters
        $doc = Factory::getApplication()->getDocument();
        $wa = $doc->getWebAssetManager();
        $pluginPath = 'plugins/content/' . $this->_name;
        $view = Factory::getApplication()->input->get('view');
        $hasChat = 0;
        $idChat = '';

        //find each card

        preg_match_all('/{chat.*?\/chat}/s', $article->text, $chats);
        $chatDrive = 'hXeepaZbByMA9KkxNaPCJ'; // Default Chat Drive
        //an array to store the new divs
        //an array to store the new divs
        foreach ($chats[0] as $value) {

            preg_match('/(?<={chat)(.*?})(.*?)(?={\/chat})/s', $value, $chatMatcher);

            preg_match('/(?<=id=").*?(?=")/s', $chatMatcher[1], $idMatch);


            if ($idMatch) {
                $idChat = $idMatch[0];
            }


            if($idChat=='') {

            //make a card div with a span title and a card body div, remember to close both divs.
            $output_chat = '<div class="card bg-dark text-light"><script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="'.$chatDrive.'";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script></div>';
            }else{
                $output_chat = '<div class="card bg-dark text-light"><script>
                (function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="'.$idChat.'";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
                </script></div>';

            }

            if($hasChat == 0){
            //replace the original card $value with the new $output
            $article->text = str_replace($value, $output_chat, $article->text);
            $hasChat == 1;
            }
        }
    }
}
