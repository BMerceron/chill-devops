CHILL - DEVOPS - SAASPASSBIEN

A Symfony project created on May 15, 2017, 11:17 am.

SETUP

SSH: git clonegit@github.com:Bastoon01/chill-devops.git
HTTPS: git clone https://github.com/Bastoon01/chill-devops.git

APP UPDATE

    Install composer : https://getcomposer.org/download/
    Open a CLI : Type the command : composer update (for update all the application)

After, your application is up to date.

FRONT UPDATE

    Install node.js (choose LTS): https://nodejs.org/en/download/ Open a CLI :
        Then install all the require package : 
            npm install and after, npm install -g gulp (https://github.com/gulpjs/gulp/blob/master/docs/getting-started.md)
        To update the front type this command : 
            gulp build
        To watch updates on the front, type this command :
            gulp watch

RUN

In your CLI :
    php bin/console server:run  
    
    
VERSIONNING -GITHUB

BRANCHS

    SPB-N° US*-Name-Function
    *US = User Storie (cf taiga)

        ex : SPB-1-Login-Page
        ex : SPB-2-Forms-Page
COMMITS
    FEAT : Créer d'une nouvelle fonctionnalité.
    FIX : Régler un problème/bug sur une fonctionnalité.
    UPDATE : Améliorer une fonctionnalité.

        Ex : FEAT : Login page

        Ex : FIX : Form username on login page

        Ex : UPDATE : Form lastanme on login page
        
ARCHITECTURE

    MyBranch -> Dev -> Preprod (test) -> Prod


