JAGA
==============

Jaga is a social sharing and networking platform built to facilitate community-building online. Registered users can create channels and create categories for them. Users can post text, images, event info, and geolocation data to any channel, and comment on any post on any channel. Jaga is fully responsive and works pretty darn good on most any device. [TRY JAGA](http://jaga.io/register/)

**FEATURES**
- INDEX
    - main domain: aggregate site showing recent posts from all **channels and categories**.
	- subdomain: shows channel-specific recent posts 
- HOME 
    - personalized; only available when logged in
    - shows posts from channels that the user is subscribed to
- CHANNELS
    - users can **create channels**: `<channel>.jaga.io`
    - a **theme** must be selected for the channel.
    - at least one **category** must be assigned to the channel: `<channel>.jaga.io/k/<category>/`
	- have an RSS feed showing all posts: `<channel>.jaga.io/rss/`
	- have a channel-specific sitemap `<channel>.jaga.io/sitemap.xml`
- CATEGORIES
    - users can select existing categories for their channels, or create new ones
	- have a global RSS feed showing all corresponding posts: `jaga.io/rss/k/<category>/`
	- have channel-specific RSS feeds showing all corresponding posts: `<channel>.jaga.io/rss/k/<category>/`
- POSTS
    - users can **post** to any channel and any category on JAGA: `<channel>.jaga.io/k/<category>/<post>/`
    - posts can include **images** and an **outbound link**.
    - posts can be marked as **events**; date & time can be set.
    - posts can have **geographic coordinates**; latitude and longitude can be set.
    - posts can be edited and deleted by OP.
- CALENDAR
	- posts mapped as being an event
	- all events on `jaga.io/calendar/`
	- each channel's own events on `<channel>.jaga.io/calendar/`
- MAP
	- posts mapped by geographic coordinates
	- all geotagged posts at `jaga.io/map/`
	- each channel's own geotagged content map at `<channel>.jaga.io/map/`
- COMMENTS
    - users can **comment** on any post in any category on any channel.
    - plaintext only and observe line breaks.
    - comments can be deleted.
- USERS
    - have individual profiles showing posts, comments, and more: `jaga.io/u/<username>/`
    - can create channels and create categories for them: `<yourchannel>.jaga.io/`
	- have a global RSS feed showing all of their posts: `jaga.io/rss/u/<username>/`
	- have a channel-specific RSS feed showing their posts on that channel: `<channel>.jaga.io/rss/u/<username>/`
- MESSAGING
    - users can send each other private messages `jaga.io/imo/`
	
**LICENSE**
- JAGA's codebase powers [jaga.io](http://jaga.io/) and is available for use on your domain(s) under the [MIT License](license.txt).

**HISTORY**
- Jaga was originally built to power [The Kutchannel](http://niseko.jaga.io/), a hyperlocal social networking and information website that has served the Niseko and Kutchan communities in Hokkaido since 2006.
 
**TEAM**
- Creator: [Christopher Webb](http://github.com/chishiki/)

**FUNDING**
- Primary Sponsor: [kagi.io](http://kagi.io/)