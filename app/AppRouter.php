<?php
//use Nette\Application\Route;

class AppRouter {
	
	static function initialize($application) {
		$return = $application->getRouter();
                
                $return[] = new Route('robots.txt', array('presenter' => 'Feed', 'action' => 'robots'));
                $return[] = new Route('sitemap.xml', array('presenter' => 'Feed', 'action' => 'sitemap'));
                
                $return[] =$adminRouter = new MultiRouter('Admin');
                $adminRouter[] = new Route('admin/<presenter>/<action>', 'Default:default');

                $return[] = $frontRouter = new MultiRouter('Front');
                $frontRouter[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
                
		return $return;
	}
	
}
