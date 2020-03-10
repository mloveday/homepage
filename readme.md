Prism config: https://prismjs.com/download.html#themes=prism-coy&languages=markup+css+clike+javascript+apacheconf+bash+css-extras+gherkin+javadoclike+json+markup-templating+php+phpdoc+php-extras+jsx+tsx+regex+ruby+scss+sql+typescript+yaml&plugins=line-numbers+show-language+toolbar
Deploy:
```shell script
bash ./milesloveday.com/deploy.sh

ssh milehpsv@server187.web-hosting.com
cd milesloveday.com
php composer.phar install
bin/console doctrine:migrations:migrate
```
