JAGA
==============
*JAGATAKUN FIGHTS FOR THE USER*

Jaga is a social sharing and networking platform built to facilitate community-building online. Jaga grew out of a hyperlocal classified advertising site that has served the [Niseko](http://niseko.jaga.io/) alpine resort area in Hokkaido since 2006. The Kutchannel remains the most popular Jaga channel but new channels come into existence daily. Registered users can create channels and assign categories to it. User can post to any channel; posts can include images, event info, and geolocation data. Users can comment on any post on any channel. Jaga is fully responsive and works beautifully on most devices. [Try Jaga](http://jaga.io/register/)!

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
    - users can **post** to any channel and any category on JAGA: `<channel>.jaga.io/k/<category>/<post/>`
    - posts can include **images** and an **outbound link**.
    - posts can be marked as **events**; date & time can be set.
    - posts can have **geographic coordinates**; latitude and longitude can be set.
    - posts can be edited and deleted by OP.
- COMMENTS
    - users can **comment** on any post in any category on any channel.
    - plaintext only and observe line breaks.
    - comments can be deleted.
- USERS
    - have individual profiles showing posts, comments, and more: `jaga.io/u/<username>/`
    - can subscribe to channels; this personalizes HOME
	- have a global RSS feed showing all of their posts: `jaga.io/rss/u/<username>/`
	- have a channel-specific RSS feed showing their posts on that channel: `<channel>.jaga.io/rss/u/<username>/`
- MESSAGING
    - users can send each other private messages `jaga.io/imo/`
	
**LICENSE**
 - JAGA's codebase powers [jaga.io](http://jaga.io/) and is available for use on your domain under the copyleft [GNU Affero General Public License](license.txt).
 - Licensing JAGA under the AGPL was intended to encourage participation in the project and assure that the code remains non-commercial and non-proprietary.
 - The AGPL allows anyone to use the code while mandating that, where the code is redistributed or run on a network, any modifications to the code must be shared.
 - If this applies to you or your project, we request that you make your code available via a public GitHub repository.
 - Please also consider submitting pull requests for inclusion in the master. JOIN TEAM JAGA.