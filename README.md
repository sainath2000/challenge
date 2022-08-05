## Problem Title:

### Email a random XKCD challenge

## Live Link

### (https://srxkcd.online/)

## Problem Statement:

Please create a simple PHP application that accepts a visitor’s email address and emails them random XKCD comics every five minutes.

- Your app should include email verification to avoid people using others’ email addresses.
- XKCD image should go as an email attachment as well as inline image content.
- You can visit https://c.xkcd.com/random/comic/ programmatically to return a random comic URL and then use JSON API for details https://xkcd.com/json.html
- Please make sure your emails contain an unsubscribe link so a user can stop getting emails.

Since this is a simple project it must be done in core PHP including API calls, recurring emails, including attachments should happen in core PHP. Please do not use any libraries.

## TODO

- [x] Email verification token based
- [x] Storing subscription
- [x] Random selection of comics
- [x] Sending emails
- [x] Email scheduling
- [x] Unsubscription token based
- [x] Updating README
- [x] Live demo

## Issues

- From address of all emails is : u225500725@srv784.main-hosting.eu
- From name would be : u225500725
- Email id with gmail domain is prefferred
- Rendering issues in any other domains provided by company due to security.
- Check emails in inbox/promotions/spam folders and wait one minute for email.
