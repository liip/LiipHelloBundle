Installation
============

  1. Add this bundle to your project as Git submodules:

          $ git submodule add git://github.com/liip/HelloBundle.git vendor/bundles/Liip/HelloBundle

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

What is this?
-------------

Just a very simple example bundle using services for controllers and the following Bundles:
- FOSRestBundle
- FOSUserBundle
- FOSFacebookBundle
- DoctrinePHPCRBundle

There is also an example of how to use the ContainerWrapper, which is disabled by default
https://github.com/lsmith77/Symfony2-Container-service-wrapper

Some example URL's to call
--------------------------

HTML output:
http://symfony-sandbox.lo/app_dev.php/liip/hello/foo

JSON output:
http://symfony-sandbox.lo/app_dev.php/liip/hello/foo.json

XML output:
http://symfony-sandbox.lo/app_dev.php/liip/hello/foo.xml

Redirect to homepage:
http://symfony-sandbox.lo/app_dev.php/liip/hello

XML output using a normalizer:
http://symfony-sandbox.lo/app_dev.php/liip/serializer.xml

Requires PHPCR ODM and Jackrabbit to be installed:
http://symfony-sandbox.lo/app_dev.php/liip/phpcr/bar

Facebook login button:
http://symfony-sandbox.lo/app_dev.php/liip/facebook

Check facebook login status:
http://symfony-sandbox.lo/app_dev.php/liip/facebook-check

Using the FrameworkExtraBundle together with the ViewBundle:
http://symfony-sandbox.lo/app_dev.php/liip/extra/foo

Using the FrameworkExtraBundle together with the ViewBundle outputting json:
http://symfony-sandbox.lo/app_dev.php/liip/extra/foo.json

Using the FrameworkExtraBundle together with the ViewBundle to redirect to the homepage:
http://symfony-sandbox.lo/app_dev.php/liip/extra/_
