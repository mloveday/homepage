So I decided to write a blog post. The only problem was, whilst I had a platform for hosting them (i.e. this site), I didn't have an easy way of storing the data, nor displaying it. I smell a mini project! Here's the requirements:

1. Must be able to store text
* The text must be *rich* text - I don't want it to look really basic
* I must be able to include images
* I must be able to add code snippets, and preferably not screenshots, as I am likely to post code for my own future reference here, and want to be able to copy/paste
* I should be the only person who can write/edit posts
* I should be the only person who can see non-published posts

Additionally:
* I want to include my CV in this (but that is a very specific implementation and not really tied to the blog post funcitonality)

I was already using Symfony 4 (albeit a now unsupported version), but had no database - this was effectively a static site. Unsurprisingly, not having a database I also had no user verification, which is a bit of a blocker when it comes to preventing unauthorized access. I also needed to choose a format to store it in and a way of parsing it and getting it onto a web page. Lastly I needed to update the dev setup to include a database without having to install one directly on the machine, i.e. using vagrant, provisioning with ansible and ansible-galaxy.

## Dev tooling
I had recently updated the provisioning in a work project to use ansible-galaxy, and thought it a perfect opportunity to use this knowledge in my own project. If you've not already used it, it makes everything so, so simple. Firstly, the vagrant box setup. This is the entirety of the Vagrantfile for this setup:
```
Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/bionic64"
  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.provision "ansible" do |ansible|
    ansible.playbook = "provision/vagrant.yml"
  end
end
```
Note how all we're doing is choosing a box (Ubuntu in my case), forwarding port 80 on the VM to 8080 on the host (so I navigate to localhost:8080 to view my website) and then tell vagrant to provision the box with all the complex stuff using ansible and the playbook I specified. Pretty straightforward, no?

Next I had to actually load some stuff on it, like Apache (handling requests), PHP (running my code), Apache-PHP-FPM (telling Apache to run PHP), MySQL, XDebug (for local debugging), Composer (to allow installing dependencies). Being on the VM means none of this stuff needs to be done on the host machine, a *huge* time-saver, and a great way of documenting the setup required to run the project. I added a requirements.yml file to define the required  // TODO

## Updating Symfony, adding FOS UserBundle
The upgrade from Symfony 4.2 to 4.4 was dead easy, literally just a `composer update ...` command for the relevant dependencies. For user login, I chose fos/user-bundle, which I have already had some experience with. There were a few teething troubles related to me trying to only authenticate in a route(s), but then I realised I really didn't need to bother, and could just set the required role on said route(s), i.e. follow the docs, copy the config. I was a little disappointed by the installation of the bundle, as it is not as simple as running `composer install fos/user-bundle`, as the post-install cache clear falls over until you've added some config. This could have been made a little clearer in the docs (and maybe giving this as something to be done before running the install command may have helped). Barring this, it wasn't tough to get a working setup with a very basic User entity.