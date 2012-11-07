Installation
============

  1. Add this bundle to your project as Git submodules:

          $ git submodule add git://github.com/liip/LiipHelloBundle.git vendor/bundles/Liip/HelloBundle

  2. Add the Liip namespace to your autoloader:

          // app/autoload.php
          $loader->registerNamespaces(array(
                'Liip' => __DIR__.'/../vendor/bundles',
                // your other namespaces
          ));

  3. Add this bundle to your application's kernel:

          // application/ApplicationKernel.php
          public function registerBundles()
          {
              return array(
                  // ...
                  new Liip\HelloBundle\LiipHelloBundle(),
                  // ...
              );
          }

  Alternatively download and install the following [Symfony2 Standard Edition fork](https://github.com/liip-forks/symfony-standard/tree/techtalk):

        $ git clone https://github.com/liip-forks/symfony-standard.git
        $ git checkout -b techtalk origin/techtalk

What is this?
-------------

Just a very simple example bundle using services for controllers and the following Bundles:

- FOSRestBundle / JMSSerializerBundle
- FOSUserBundle
- FOSFacebookBundle
- DoctrinePHPCRBundle
- LiipContainerWrapperBundle
- LiipImagineBundle
- LiipDoctrineCacheBundle
- LiipThemeBundle
- LiipHyphenatorBundle
- NelmioApiDocBundle

Some example URL's to call
--------------------------

HTML output:
http://symfony-standard.lo/app_dev.php/liip/hello/foo

JSON output:
http://symfony-standard.lo/app_dev.php/liip/hello/foo.json

XML output:
http://symfony-standard.lo/app_dev.php/liip/hello/foo.xml

Redirect to the '_welcome' route:
http://symfony-standard.lo/app_dev.php/liip/hello

JSON (actually JSON-LD) output using a custom serialization handler:
http://symfony-standard.lo/app_dev.php/liip/serializer.json
XML output using a custom serialization handler:
http://symfony-standard.lo/app_dev.php/liip/serializer.xml

Requires PHPCR ODM and Jackrabbit to be installed:
http://symfony-standard.lo/app_dev.php/liip/phpcr/bar

Using a parameter converter (after calling the previous url):
http://symfony-standard.lo/app_dev.php/liip/phpcr/convert/bar

Facebook login button:
http://symfony-standard.lo/app_dev.php/liip/facebook

Check facebook login status:
http://symfony-standard.lo/app_dev.php/liip/facebook-check

Using the SensioFrameworkExtraBundle together with the RestBundle view layer:
http://symfony-standard.lo/app_dev.php/liip/extra/foo

Using the SensioFrameworkExtraBundle together with the RestBundle view layer outputting json:
http://symfony-standard.lo/app_dev.php/liip/extra/foo.json

Using the SensioFrameworkExtraBundle together with the RestBundle view layer to redirect to the '_welcome' route:
http://symfony-standard.lo/app_dev.php/liip/extra

Using the FOSRestBundle routing generation
http://symfony-standard.lo/app_dev.php/liip/hello/rest/articles
http://symfony-standard.lo/app_dev.php/liip/hello/rest/article
http://symfony-standard.lo/app_dev.php/liip/hello/rest/articles/new

Using the FOSRestBundle ExceptionController
http://symfony-standard.lo/app_dev.php/liip/exception.html

Using the FOSRestBundle to handle a failed validation
http://symfony-standard.lo/app_dev.php/liip/validation_failure.json

Using the LiipHyphenatorBundle
http://symfony-standard.lo/app_dev.php/liip/hyphenator

Using a custom handler with FOSRestBundle to generate RSS
http://symfony-standard.lo/app_dev.php/liip/customHandler.rss

Using the LiipImagineBundle
http://symfony-standard.lo/app_dev.php/liip/imagine

Using the LiipDoctrineCacheBundle with apc
http://symfony-standard.lo/app_dev.php/liip/apc

Using the NelmioApiDocBundle
http://symfony-standard.lo/app_dev.php/api/doc/
http://symfony-standard.lo/app_dev.php/liip/hello/rest/articles?_doc=1
