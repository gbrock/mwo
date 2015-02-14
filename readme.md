# Middleware Organizer
A [Laravel](http://laravel.com) project intended to be used as a sample when
building applications.  Once complete, it should include the basics for getting
apps launched quickly.

**This branch is for developing Wordpress-like blog software.**

## Sample Usage

## Capabilities

### Users

We're using Laravel's default user implementation, since it got a turbocharge (oAuth and included authentication views) in L5.  Each user has a:

- [Display] Name
- E-mail address
- Password
- Avatar

Users can register individually or through third-party service:

- Google
- Facebook
- Twitter

### Posts

Posts need to operate as simply as possible, detailing all the essentials of an HTML page including:

- Title
- Description
- Thumbnail
- Author
- Date
- Content (actual post body)
- Publish Settings

### Comments

Comments should be toggleable site-wide or on a per-post basis, and should be
submittable by logged-in and guest users.

Comments can be posted in reply to other comments, and should be arranged in a tree view (sortable by user).  Comments need to be reportable, and each should show:

- Name
- User Avatar
- Date posted
- Last edited
- Comment

### Dashboard

## Code

## Third-party
MWO is built on [Laravel](http://laravel.com) and could not have been possible
without a lot of packages.  While we develop, just check out
[composer.json](https://github.com/gbrock/mwo/blob/master/composer.json)
to see who gets all the credit.

## License

This software is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
