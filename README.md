Installation
============

  1. Add this bundle to your composer.json:

          $ php composer.phar require liip/hello-bundle:dev-master

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
