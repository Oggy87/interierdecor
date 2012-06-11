<?php
//use Nette\Application\Route;

class AppRouter {
	
	static function initialize($application) {
		$return = $application->getRouter();
                
                $return[] = new Route('robots.txt', array('presenter' => 'Feed', 'action' => 'robots'));
                $return[] = new Route('sitemap.xml', array('presenter' => 'Feed', 'action' => 'sitemap'));

                //ADMIN
                $return[] = $adminRouter = new MultiRouter('Admin');
                $adminRouter[] = new Route('admin/<presenter>/<action>', 'Default:default');

                //FRONT
                $return[] = $frontRouter = new MultiRouter('Front');

                //categories
                Route::addStyle('#categoryId');
                Route::setStyleProperty('#categoryId', Route::FILTER_IN, callback('CategoryModel::getIdByUrl'));
                Route::setStyleProperty('#categoryId', Route::FILTER_OUT, callback('CategoryModel::getUrlById'));

                //products
                Route::addStyle('#productId');
                Route::setStyleProperty('#productId', Route::FILTER_IN, callback('ProductModel::getIdByUrl'));
                Route::setStyleProperty('#productId', Route::FILTER_OUT, callback('ProductModel::getUrlById'));

                Route::setStyleProperty('presenter', Route::FILTER_TABLE, array(
                        'produkt' => 'Product',
                        'vizualizace' => 'Visualisation',
                        'kosik' => 'Basket',
                        'kontakt' => 'Contact',
                        'hledat' => 'Search',
                        'zakaznicky-ucet' => 'Customer',
                        'inspirace' => 'Inspiration'
                ));
                
                Route::setStyleProperty('action', Route::FILTER_TABLE, array(
                        'doporucujeme' => 'recommended',
                        'v-akci' => 'actions',
                        'novinky' => 'new',
                        'dodaci-udaje' => 'address',
                        'shrnuti-objednavky' => 'preview',
                        'objednano' => 'order',
                        'prihlaseni' => 'signin',
                        'registrace' => 'register',
                        'zapomenute-heslo' => 'forgottenPassword',
                        'objednavka' => 'sale',
                        'moje-udaje' => 'account'
                ));

                $frontRouter[] = new Route('<id #categoryId>/<action doporucujeme|v-akci|novinky>/[<tags .*?>]', array(
                        'presenter' => 'Category',
                        'tags' => array(
                            Route::VALUE => NULL,
                            Route::FILTER_IN => callback('TagModel::getIdsByUrl'),
                            Route::FILTER_OUT => callback('TagModel::getUrlsById'),
                            )
                    ));
                
                $frontRouter[] = new Route('<id #categoryId>[/<tags .*?>]', array(
                        'presenter' => 'Category',
                        'action' => 'default',
                        'tags' => array(
                            Route::VALUE => NULL,
                            Route::FILTER_IN => callback('TagModel::getIdsByUrl'),
                            Route::FILTER_OUT => callback('TagModel::getUrlsById'),
                            )
                    ));
                

                $frontRouter[] = new Route('inspirace/<category_id #categoryId>[/<tagGroup_id>[/<tag_id>]]', array(
                        'presenter' => 'Inspiration',
                        'action' => 'default',

                        'tagGroup_id' => array(
                            Route::VALUE => NULL,
                            Route::FILTER_IN => callback('TagGroupModel::getIdByUrl'),
                            Route::FILTER_OUT => callback('TagGroupModel::getUrlById'),
                        ),
                        'tag_id' => array(
                            Route::VALUE => NULL,
                            Route::FILTER_IN => callback('TagModel::getIdByUrl'),
                            Route::FILTER_OUT => callback('TagModel::getUrlById'),
                        )
                    ));

                $frontRouter[] = new Route('produkt/<id #productId>', array(
                        'presenter' => 'Product',
                        'action' => 'default'
                    ));

                $frontRouter[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
                
		return $return;
	}
	
}
