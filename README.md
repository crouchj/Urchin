![Urchin](/img/logo.png)

Urchin contains the bulk of the business logic and data parsing functions that make up the core of our Drupal-based publishing platform. Helper classes for parsing nodes, getting lists of nodes and nids, and accessing fields are available, with the overall goal of providing a solid kick-start to any Drupal-based editorial site.

Installation
--

Urchin should be placed in your template's lib directory. Rather than copy the files manually, though, it's better to add Urchin as a git submodule. This allows for easy command-line updating in the future. From the base of your Drupal project, add Urchin as a git submodule by running the following commands from the project root:

    $ git submodule add git@github.com:AsheAvenue/Urchin.git drupal/sites/all/themes/<theme_name>/lib/Urchin

Urchin will then be included in your project. To reference it within your project, add the following line to the top of your template.php file, just after the opening PHP tag:

    require_once('lib/Urchin/Urchin.php');

Updating Urchin
--

To update Urchin, run the following commands from the project root:

    $ cd drupal/sites/all/themes/<theme_name>/lib/Urchin
    $ git pull origin master

Reference
--

Urchin contains the following chainable functions used for querying for articles:

- Base::exclude($exclude)
- Base::field($field_name, $field_value)
- Base::sort()
- Base::limit($limit)
- Base::pager($limit)
- Base::vocabularyTerm($vocabulary, $term)
- Base::execute()
- Article::get($type)

Examples:

    $video_articles = Article::get('video')
                        ->sort('recent')
                        ->limit(1)
                        ->execute();

    $gallery_articles = Article::get('gallery')
                          ->sort('recent')
                          ->limit(3)
                          ->exclude(Node::getNids(array_merge($video_articles, $news_articles)))
                          ->execute();

    $recent_articles  = Article::get()
                        ->sort('recent')
                        ->pager(10)
                        ->exclude(Node::getNids($entertainment_articles))
                        ->execute();

Urchin also contains a series of helper functions useful for rendering page components and getting site-specific parameters:

- Article::getCollection($nid)
- Gallery::get($node)
- Node::getAuthor($node = null)
- Node::getCategory($node = null)
- Node::getExcerpt($node = null)
- Node::getField($node, $field, $key = 'value', $id = 0, $strip_tags = false)
- Node::getNids( $nodes)
- Node::getNodeData($node)
- Node::getNodes($nids)
- Node::getThumbnail($node = null)
- Node::getRelated($node = null)
- Search::get($search_term = null)
- Site::getFallbackImgSrc()
- Site::getLibPath($lib_name)
- Site::getRequestURI()
- Site::getSharedPath($view_name)
- Site::isFirstPage()
- Taxonomy::getChildren($tid)
- Taxonomy::getFieldName($vid)
- Taxonomy::getSeriesInfo($node = null)
- Taxonomy::getTerm($tid)
- Taxonomy::getTermInfo($term = null)
- Taxonomy::getTids($field, $language)
- Utility::trimText($text, $length = 80, $append = '...')
- Utility::slugify($string)
- Video::renderYouTubeEmbed($id = null, $width = 640, $height = 390)
- Video::renderEmbed($embed = null)
- Video::getFeaturedVideo($field_article_video)
- Video::getYouTubeImageURL($node = null)

Finally, Urchin contains a file that contains globally-declared variables aimed at preventing the proliferation of specific category names, series names, and node IDs throughout the project. If you need to refer to a specific node ID or category ID in your template or helper, declare a global variable in globals.php and only reference the global variable. Example:

    // Article node types
    $GLOBALS['article_node_types'] = array('article_text', 'article_blog', 'article_video', 'article_gallery', 'poll');

    // Categories
    $GLOBALS['category_news']              = 1;
    $GLOBALS['category_entertainment']     = 3;
    $GLOBALS['category_oneohone']          = 25;
    $GLOBALS['category_grow']              = 21;

    // Collections
    $GLOBALS['sidebar_featured_gallery']    = 206;
    $GLOBALS['sidebar_whats_smokin']        = 205;
    $GLOBALS['sponsored_links']             = 19314;

Acknowledgements + Legal
--

© 2013 Ashe Avenue. Created by Heath Beckett and <a href="http://twitter.com/timboisvert">Tim Boisvert</a>.

<a href="http://thenounproject.com/noun/totoro/#icon-No3424" target="_blank">Totoro</a> designed by <a href="http://thenounproject.com/nithindavis" target="_blank">Nithin Davis Nanthikkara</a> from The Noun Project
