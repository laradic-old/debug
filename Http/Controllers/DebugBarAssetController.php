<?php namespace Laradic\Debug\Http\Controllers;

use Barryvdh\Debugbar\Controllers\AssetController;
use Illuminate\Http\Response;

class DebugBarAssetController extends AssetController
{
    /**
     * Return the javascript for the Debugbar
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function js()
    {
        $renderer = $this->debugbar->getJavascriptRenderer();

        $content = <<<'EOT'
define(['jquery'], function($){
    if(typeof(jQuery) === 'undefined') {
        var jQuery = $;
    }

EOT;

        $content .= $renderer->dumpAssetsToString('js');

        $content .= <<<'EOT'

console.log(PhpDebugBar);
return PhpDebugBar;

});
EOT;


        $response = new Response(
            $content, 200, array(
                'Content-Type' => 'text/javascript',
            )
        );

        return $this->cacheResponse($response);
    }

    /**
     * Return the stylesheets for the Debugbar
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function css()
    {
        $renderer = $this->debugbar->getJavascriptRenderer();

        $content = $renderer->dumpAssetsToString('css');

        $response = new Response(
            $content, 200, array(
                'Content-Type' => 'text/css',
            )
        );

        return $this->cacheResponse($response);
    }

    /**
     * Cache the response 1 year (31536000 sec)
     */
    protected function cacheResponse(Response $response)
    {
        $response->setSharedMaxAge(31536000);
        $response->setMaxAge(31536000);
        $response->setExpires(new \DateTime('+1 year'));

        return $response;
    }
}
