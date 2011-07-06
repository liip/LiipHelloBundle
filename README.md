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

  Alternatively download and install the following Symfony2 Standard Edition fork:

        $ git clone https://github.com/lsmith77/symfony-standard
        $ git checkout -b techtalk origin/techtalk

What is this?
-------------

Just a very simple example bundle using services for controllers and the following Bundles:

- FOSRestBundle
- FOSUserBundle
- FOSFacebookBundle
- DoctrinePHPCRBundle
- LiipContainerWrapperBundle
- LiipVie

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

XML output using a normalizer:
http://symfony-standard.lo/app_dev.php/liip/serializer.xml

Requires PHPCR ODM and Jackrabbit to be installed:
http://symfony-standard.lo/app_dev.php/liip/phpcr/bar

Facebook login button:
http://symfony-standard.lo/app_dev.php/liip/facebook

Check facebook login status:
http://symfony-standard.lo/app_dev.php/liip/facebook-check

Using the FrameworkExtraBundle together with the RestBundle view layer:
http://symfony-standard.lo/app_dev.php/liip/extra/foo

Using the FrameworkExtraBundle together with the RestBundle view layer outputting json:
http://symfony-standard.lo/app_dev.php/liip/extra/foo.json

Using the FrameworkExtraBundle together with the RestBundle view layer to redirect to the '_welcome' route:
http://symfony-standard.lo/app_dev.php/liip/extra

Using the RestBundle routing generation
http://symfony-standard.lo/app_dev.php/liip/hello/rest/articles
http://symfony-standard.lo/app_dev.php/liip/hello/rest/article
http://symfony-standard.lo/app_dev.php/liip/hello/rest/new/articles

Using the RestBundle ExceptionController
http://symfony-standard.lo/app_dev.php/liip/exception.html

Using the RestBundle to handle a failed validation
http://symfony-standard.lo/app_dev.php/liip/validation_failure.json

Using the RestBundle and VieBundle using RDFa
http://symfony-standard.lo/app_dev.php/liip/vie
