#### Welcome to NewTrick Blogger ####

A Symfony blog site project utilising:

- Tailwindcss
- Encore Webpack
- Doctrine
- Ckeditor 5

### MVP/ TODO ###

- Front page with a brief intro and a list of blogs as card with tags
    - Admin has a + create new blog post link [x]
    - Front page has a Admin dashboard link for logged in users [x]
- login [x]
- Login leads to front if ROLE_USER, to Admin dashboard if ROLE_ADMIN [x]
- ROLE_USER can leave comments
- Admin dashoard: [x]
    - User management CRUD [x]
    - Blog post management CRUD [x]
        - Create blog post includes CKEDITOR5 [x]

TODO
- tags are not being posted (text->json?) [x]
- js should only fire on the pages it needs to
- Complete post crud operations  [x]
- Update links in twig for "show" posts  to <a href="{{ path('post', {'year': post.createdAt|date('Y'), 'slug': post.slug}) }}">{{ post.title }}</a> [x]
- Implement url of blog/[title] for posts [x]  
- change usrl from post/ to post/year/title [x]
- Remove registration link for MVP 
- Move any CRUD operation gateways to /admin [x]
- Create table listing for users show all and posts show all [x]
- Add link to admin to twig for index [x]
- Adjust order of form elements [x]
- Adjust styling of forms [x]
- Mobile first design [x]
- 400 and 500 default pages for production only
- Testing: 
    - Create a test page with CKeditor all styles
    - Logged in (create admin and non admin)
    - Logged out
    - Url direct into address bar
    - Through links
    - User journey 
- Update user admin page to include edit and delete [x]
- Search 
- About  
- Contact
- The user edit function should lock down fields for users. Currently admin can access. If you want to make the fields available for users, lock down roles, email. (Basially it should be a seperat change my password)


TODO:NTH

- Comments
    - Text
    - created at
- Are you sure to delete of posts [x]
- User profile
- User includes profile image
- Images in the ckeditor?


### Entities ###

- User (* = required)
    - Roles: ADMIN, USER * 
    - email *
    - pw *
    - created at *
    - modified at *
    - Username *
    - Image path (string)

NB: The FOSC Bundle will need to be installed before creating the Posts entity to allow for the textfield utilising CKEDITOR :check:

- Posts (* = required)
    - Title * string
    - Image path string
    - Text (whatever CKEDITOR needs) https://symfony.com/bundles/FOSCKEditorBundle/current/installation.html
    - Tags array



### Relationships ###

USERS have many posts (locked to admin)
USERS have many comments
POSTS have many comments

### IA/Security ###

-- / (public)
--- /contact (public)
--- /about (public) 
--- /posts (public) [x]
---- /posts/show/{year}/{slug} (public)
-- /admin (admin) [x]
--- /admin/posts/edit/{id} (admin) [x]
--- /admin/posts/create (admin) [x]
--- /admin/posts/delete (admin) [x]
--- /admin/users (admin) [x]
--- /admin/users/edit/{id} (admin) 
--- /admin/users/create (admin)
--- /admin/users/delete (admin)
--- /profile (public)
--- /profile/edit/{id} (public--their profile only)


### Set Up ###

See composer.json for composer packages and package.json for npm packages.

Should be enough to clone and get started. 

To start from scratch:

`docker compose up -d --build `

To start

`docker compose up`

(if the project has not been built):

`docker compose exec php composer create-project symfony/skeleton .`

(if it has, you'll need to composer files):

`docker compose exec php symfony composer install`

Then you'll need to ensure you have the  required npm packages used to compile assets. From /symfony run `npm i` and then `npm run watch` to fire up the encore webpack watcher.

Local prject should be available on port 8080

## Tailwind ##

See this for setup:

https://www.youtube.com/watch?v=qW8v75vMgfk&list=PLFHz2csJcgk-t8ErN1BHUUxTNj45dkSqS&index=16



## Stopping the project ##

To stop: 

`docker compose down`

To access the symfony cli once running

`docker compose exec php symfony`

To see active routes:

`docker compose exec php symfony console debug:route`

## Setting up the DB ##

Installing doctrine for the ORM:

`docker compose exec php symfony composer require symfony/orm-pack`

And the maker bundle:

`docker compose exec php symfony composer require --dev symfony/maker-bundle`

## Creating Entities (i.e tables) ##

Create with 

`docker compose exec php symfony console make:entity ENTITYNAME`

Migrate with 

`docker compose exec php symfony console make:migration`

and then 

`docker compose exec php symfony console doctrine:migrations:migrate`

to write to the DB

## Fixtures (Dummy Data) ##

Ensure that there are fixture files in the DataFixtures folder (MODEL.php)

Ru the following to load the fixture data

`docker compose exec php symfony console doctrine:fixtures:load`

## Creating forms with symfony/forms ##

You can use this module to create forms using 'make:from MODELFormType MODEL'. e.g:

`docker compose exec php symfony console make:form TeacherFormType Teacher`


## Start up for existing (cloned) project ##

If you are not re-creating this project from the gorund up, here are the more simple steps needed to get going for development. Make sure Docker is running.

TODO: Put these in a startup script
&& add in composer update

1. Start from root
2. docker compose up -d --build 
3. docker compose up
4. docker compose exec php symfony composer install
5. cd symfony/
6. docker compose exec php symfony console make:migration  (?)
7. docker compose exec php symfony console doctrine:migrations:migrate
8. docker compose exec php symfony console doctrine:fixtures:load
9. npm i
10. npm run watch
11. Project should be running at localhost:8080

## Deployment ##

1. Be sure that any fixtures have been removed, especially the users 
2. Set up digital oceon droplet
3. Follow these instructions for poiting to name server: https://docs.digitalocean.com/products/networking/dns/getting-started/dns-registrars/

## Topic Lists ##

- The bland dullness of AI writing
- How to add CKeditor5 to Symfony 5
- Drupal resources
- Encountering Drupal
- RTFM: In praise of good documentation

## Styling ##

blue-600
bg: #f0f0f0
