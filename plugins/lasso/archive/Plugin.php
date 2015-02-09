<?php namespace Lasso\Archive;
/**
 * Created by PhpStorm.
 * User: schad_000
 * Date: 1/25/2015
 * Time: 10:59 PM
 */

use System\Classes\PluginBase;

Class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name'        => 'Archive',
            'description' => 'Provides ability to view archived newsletters that have been emailed out.',
            'author'      => 'Team Lasso - Casey Schadewitz',
            'icon'        => 'icon-rss'
        ];
    }
    public function registerComponents()
    {
        return [
            '\Lasso\Archive\Components\Posts'       => 'posts',
            '\Lasso\Archive\Components\Post'        => 'post',
            '\Lasso\Archive\Components\HomeView'    => 'homeView'
        ];
    }
}